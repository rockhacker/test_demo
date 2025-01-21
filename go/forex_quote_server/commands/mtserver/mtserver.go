package mtserver

import (
	"bufio"
	"encoding/json"
	"fmt"
	"forex_quote_server/conf"
	apiws "forex_quote_server/services/api/ws"
	"forex_quote_server/services/model"
	"forex_quote_server/services/redisDB"
	"github.com/panjf2000/ants/v2"
	log "github.com/sirupsen/logrus"
	basicRand "math/rand"
	"net"
	"strconv"
	"strings"
	"time"
)

//机器人浮点数据
var symbolPoint = make(map[string]float64)

type MtMsg struct {
	RspStatus  int                    `json:"Rsp_status"`
	RspData    map[string]interface{} `json:"Rsp_Data"`
	RspTime    int                    `json:"Rsp_Time"`
	RspDesc    string                 `json:"Rsp_Desc"`
	RspInfo    map[string]interface{} `json:"Rsp_Info"`
	RspVersion string                 `json:"Rsp_Version"`
}

var lastMsgTime = time.Now()

func BuildData(requestData map[string]interface{}) []byte {
	getConf := conf.Config.Get("MT4Server").(map[string]interface{})

	data, _ := json.Marshal(map[string]interface{}{
		"CstData": map[string]string{
			"CstId":  "CstId",
			"CstPwd": "RXXpXOq9l+ZfNg+H4AM8ZLJDr8d8//CquPwe7dvv5e45tatllMJjC6O5Jj7jcwAu4FXsc6ufyhSgwx2OL31o1YVY4yPvpDhekhXS3G/TGR3wy0nOCLuEAaIwjF8GNBui1HVVTNIGoO1sAyqM0i85YYP1ukJLZRr8wjTed6CLJ58=",
		},
		"Request_Serial":  strconv.FormatInt(time.Now().Unix()+int64(basicRand.Intn(999)), 10),
		"Request_Time":    time.Now().Unix(),
		"Request_Version": "1.0.1",
		"MT4Server": map[string]interface{}{
			"Addr":            getConf["addr"],
			"Port":            conf.Config.GetInt("MT4Server.port"),
			"ManagerUser":     conf.Config.GetInt("MT4Server.user"),
			"ManagerPassword": getConf["password"],
			"TimeOut":         20,
		},
		"Request_Data": requestData,
	})

	write := "W" + string(data) + "QUIT\n"

	return []byte(write)
}

var tcpAddr *net.TCPAddr

type MTConn struct {
	conn      *net.TCPConn
	sendData  chan []byte
	readData  chan string
	reconnect chan bool
	config    map[string]interface{}
}

func RunMt() {
	//
	//defer func() {
	//	if err := recover(); err != nil {
	//
	//		time.Sleep(3 * time.Second)
	//		log.Warning("请求连接MT")
	//		//RunMt()
	//	}
	//
	//}()
	//log.Warning("重新连接MT")
	NewSyncMTConnect()
}

var isConn chan bool

func sendHeartbeat(conn net.Conn) {

	requestData := map[string]interface{}{
		"Cmd":             "ServerTime_get",
		"ReceiveServer":   "",
		"ReceiveDatetype": 0,
	}

	for {

		_, err := conn.Write(BuildData(requestData))
		if err != nil {
			isConn <- false
			return
		}
		//log.Info("发送心跳")
		time.Sleep(3 * time.Second)
	}
}

func doTask(conn net.Conn) {

	//订阅品种
	SubMtQuote(conn)

	for {
		select {

		case <-isConn:
			return
		default:
			msg, err := bufio.NewReader(conn).ReadString('\n')
			fmt.Println(msg)

			if err != nil {
				fmt.Println("读取MT行情失败")
				return

			} else {

				if strings.HasSuffix(msg, "\n") {
					if len(msg) > 10 {

						v := strings.Trim(msg, "\n")

						var data MtMsg

						err := json.Unmarshal([]byte(v), &data)

						if err != nil {
							log.Warning("MT收到未知消息，JSON解析失败:" + err.Error())

						} else {

							lastMsgTime = time.Now()
							//断言出消息类型
							cmd := data.RspData["Rep_Cmd"]

							switch cmd {

							case "ServerTime_get":
								log.Info("收到MT程序返回心跳Rsp_Desc:" + data.RspDesc)
								break

							case "Quote_Request":

								if data.RspDesc == "O.K." {
									//log.Info("收到MT行情返回,连接句柄:", &conn)

									info := data.RspInfo["Quote"].(map[string]interface{})

									nowPrice, _ := strconv.ParseFloat(info["ask"].(string), 64)
									//High, _ := strconv.ParseFloat(info["high"].(string), 64)
									//Low, _ := strconv.ParseFloat(info["low"].(string), 64)
									//Open, _ := strconv.ParseFloat(info["bid"].(string), 64)

									basicRand.Seed(time.Now().UnixNano())
									//当前价格+浮点价格
									nowPrice = nowPrice + symbolPoint[info["Symbol"].(string)]
									//fmt.Println("收到行情:", info["Symbol"], nowPrice)
									quote := apiws.QuoteData{
										Close:  nowPrice,
										High:   0, //不记录高开低，程序自动完成
										Low:    0,
										Open:   0,
										Amount: float64(basicRand.Intn(200)+1) / 100,
									}

									//加go异步 不加go同步
									//需要加入降速，行情推送太快mysql无法顺序处理
									//go mtQuote.NewPrice(info["Symbol"].(string), quote)
									QuoteBytes, err := json.Marshal(quote)
									if err != nil {
										fmt.Println(err)
										continue
									}
									fmt.Println("slowDownQuoteVale|"+info["Symbol"].(string), quote)
									redisDB.Set("slowDownQuoteVale|"+info["Symbol"].(string), QuoteBytes, 300*time.Second)

									//go_cache.GoCache.Set("slowDownQuoteVale|"+info["Symbol"].(string), quote, 300*time.Second)

									//
									//slowDownQuoteVale.Lock()
									//slowDownQuoteVale.Items[info["Symbol"].(string)] = quote
									//slowDownQuoteVale.Unlock()

									//slowDownQuote[info["Symbol"].(string)] = quote
								}
								break
							}

						}
					}
				}
			}

		}
	}

}

var pool *ants.Pool

func NewSyncMTConnect() *MTConn {

	//池
	pool, _ = ants.NewPool(20)
	defer pool.Release()

	//读取浮点数据
	//先读取一遍以防开始太快导致上次浮点失败
	var robots []model.ForexQuotationRobots

	model.DB.Select([]string{"point", "virtual"}).Find(&robots)

	for _, v := range robots {
		symbolPoint[v.Virtual] = v.Point
	}
	go GetFloatPoint()

	getConf := conf.Config.Get("MT4Server").(map[string]interface{})

	for {
		//m := new(MTConn)
		var err error
		tcpAddr, _ = net.ResolveTCPAddr(getConf["network"].(string), getConf["network_addr"].(string))

		conn, err := net.DialTCP(getConf["network"].(string), nil, tcpAddr)

		if err != nil {

			log.Warning("连接MT失败")
		} else {
			go sendHeartbeat(conn)

			doTask(conn)

		}
		log.Warning("MT尝试重连")
		time.Sleep(3 * time.Second)
	}
}

func GetFloatPoint() {

	for {
		var robots []model.ForexQuotationRobots

		model.DB.Select([]string{"point", "virtual"}).Find(&robots)

		for _, v := range robots {
			symbolPoint[v.Virtual] = v.Point
		}

		time.Sleep(1 * time.Second)
	}
}

func SubMtQuote(conn net.Conn) {

	var robot []model.ForexQuotationRobots

	model.DB.Where("status = ?", 1).Preload("ForexTradeLists").Find(&robot)

	var symbols []string

	for _, v := range robot {

		symbols = append(symbols, v.ForexTradeLists.Code)
	}

	requestData := map[string]interface{}{
		"Cmd":     "Market_Request_Quote",
		"Symbols": symbols,
	}
	fmt.Println(string(BuildData(requestData)))
	_, err := conn.Write(BuildData(requestData))
	if err != nil {
		log.Info("MT订阅失败")
	} else {

		log.Info("MT订阅：", symbols)
	}

	return
}
