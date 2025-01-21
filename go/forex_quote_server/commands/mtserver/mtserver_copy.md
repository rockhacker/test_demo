package mtserver

import (
	"bufio"
	"encoding/json"
	"fmt"
	"forex/commands/mtQuote"
	"forex/conf"
	apiws "forex/services/api/ws"
	"forex/services/model"
	log "github.com/sirupsen/logrus"
	basicRand "math/rand"
	"net"
	"strconv"
	"strings"
	"time"
)

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

func NewSyncMTConnect() *MTConn {
	getConf := conf.Config.Get("MT4Server").(map[string]interface{})

	m := new(MTConn)
	var err error
	tcpAddr, _ = net.ResolveTCPAddr(getConf["network"].(string), getConf["network_addr"].(string))

	conn, err := net.DialTCP(getConf["network"].(string), nil, tcpAddr)

	if err != nil {

		log.Warning("连接MT失败")
	}

	m.conn = conn
	m.sendData = make(chan []byte, 1)
	m.readData = make(chan string, 1)
	m.reconnect = make(chan bool, 1)
	m.config = getConf

	//处理断线没网重连
	go m.checkReConnect()

	//发送消息
	go m.send()

	//发送心跳
	go m.sendHeartbeat()

	//处理消息
	go m.excMessage()

	//接消息
	go m.onMessage()

	//开启任务
	go m.RunJob()

	//处理断线没网重连
	go m.checkLastMsg()

	return m
}

func (m *MTConn) checkLastMsg() {

	for {

		if lastMsgTime.Unix()+10 < time.Now().Unix() {

			m.reconnect <- true
			log.Info("断线重连中2")
		} else {

			log.Info("返回消息正常,当前时间:" + time.Now().Format("2006-01-02 15:04:05") + " 返回时间:" + lastMsgTime.Format("2006-01-02 15:04:05"))
		}

		time.Sleep(10 * time.Second)

	}

}

func (m *MTConn) SubMtQuote() {

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
	m.sendData <- BuildData(requestData)
	log.Info("MT订阅：", symbols)
}

func (m *MTConn) sendHeartbeat() {

	requestData := map[string]interface{}{
		"Cmd":             "ServerTime_get",
		"ReceiveServer":   "",
		"ReceiveDatetype": 0,
	}

	for {

		m.sendData <- BuildData(requestData)

		time.Sleep(5 * time.Second)
	}
}

func (m *MTConn) send() {

	for {
		v, ok := <-m.sendData

		if m.conn == nil {

			m.reconnect <- true
			time.Sleep(1 * time.Second)
			continue
		}
		if ok {
			_, err := m.conn.Write(v)

			if err != nil {

				m.reconnect <- true
			}

		}
	}

}

func (m *MTConn) onMessage() {

	if m.conn != nil {

		reader := bufio.NewReader(m.conn)

		//repStr := ""
		for {
			msg, _ := reader.ReadString('\n')

			//fmt.Println(msg)
			//fmt.Println(len(msg))
			//fmt.Println(msg[:len(msg)-0])
			//fmt.Println(strings.HasSuffix(msg, "\n"))
			//fmt.Println("-------------------")
			//repStr += msg

			if strings.HasSuffix(msg, "\n") {
				if len(msg) > 10 {

					m.readData <- strings.Trim(msg, "\n")

				}
				//
				//	m.readData <- repStr[:len(repStr)-5]
				//	repStr = ""
				//	continue
			}

			//fmt.Println(repStr)
			//if strings.HasSuffix(msg, "and\r") {
			//
			//	m.readData <- repStr[:len(repStr)-5]
			//	repStr = ""
			//}
		}
	}

	return
}

func (m *MTConn) excMessage() {

	for {
		v, ok := <-m.readData

		if ok {

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
						log.Info("收到MT行情返回")

						info := data.RspInfo["Quote"].(map[string]interface{})

						nowPrice, _ := strconv.ParseFloat(info["ask"].(string), 64)
						//High, _ := strconv.ParseFloat(info["high"].(string), 64)
						//Low, _ := strconv.ParseFloat(info["low"].(string), 64)
						//Open, _ := strconv.ParseFloat(info["bid"].(string), 64)

						basicRand.Seed(time.Now().UnixNano())
						fmt.Println(nowPrice)
						quote := apiws.QuoteData{
							Close:  nowPrice,
							High:   0, //不记录高开低，程序自动完成
							Low:    0,
							Open:   0,
							Amount: float64(basicRand.Intn(200)+1) / 100,
						}

						mtQuote.NewPrice(info["Symbol"].(string), quote)
					}
					break
				}

			}

		}
	}
}

func (m *MTConn) checkReConnect() {

	for {

		ok := <-m.reconnect
		if ok {
			//重新连接
			var err error
			tcpAddr, _ = net.ResolveTCPAddr(m.config["network"].(string), m.config["network_addr"].(string))

			m.conn, err = net.DialTCP(m.config["network"].(string), nil, tcpAddr)

			if err != nil {

				log.Warning("连接MT失败")
			} else {

				//连接成功重新读取通道内容
				log.Info("MT重连成功")
				go m.onMessage()
				go m.RunJob()
			}

		}
	}

}

func (m *MTConn) RunJob() {

	go m.SubMtQuote()
}
