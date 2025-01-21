package apiws

import (
	"encoding/json"
	"forex/services/model"
	"forex/services/websocket"
	log "github.com/sirupsen/logrus"
	"sync"
)

var Ws *websocket.Server

type RdType struct {
	Type   string `json:"type"`
	Params string `json:"params"`
}
type SdType struct {
	Type string `json:"type"`
	Msg  string `json:"msg"`
	Code int    `json:"code"`
}

type userBindWs struct {
	UserBindId map[int64]string
	sync.Mutex
}

var NewUserBindWs *userBindWs

func init() {

	NewUserBindWs = &userBindWs{
		make(map[int64]string),
		sync.Mutex{},
	}

	Ws = websocket.New(websocket.Config{
		ReadBufferSize:  1024,
		WriteBufferSize: 1024,
	})
	Ws.OnConnection(handleConnection)
}

func RunJobs() {

	//JobPushDayMarket 推送日行情价格
	go JobPushDayMarket()

	//JobPushDepth 推送指定币种深度
	go JobPushDepth()

	//JobPushDepth 推送指定币种
	go JobPushKline()

	//JobPushDepth 全站交易推送
	go JobPushKlineInGlobalTx()

	go JobPushForexTradeDetail()
	//todo test
	//go SendDayMarket()
	//go SendDepth()
	select {}
}

func handleConnection(c websocket.Connection) {
	log.Info("WS新连接Id:", c.ID())
	c.OnMessage(func(msg []byte) {

		if string(msg) == "ping" {

			c.Write(1, []byte("pong"))
		} else {

			rd := RdType{}
			err := json.Unmarshal(msg, &rd)
			if err == nil {
				switch rd.Type {

				case "sub":
					switch rd.Params {

					case "FOREX_TRADE":
						//userId := c.GetValue("user_id")
						SubTradeDetailChan <- SubTradeDetail{
							ConnId: c.ID(),
						}
						break
					default:
						if !c.IsJoined(rd.Params) {

							c.Join(rd.Params)
						}
					}

					sendData, err := json.Marshal(SdType{
						Msg:  "订阅成功" + rd.Params,
						Type: "sub_result",
					})
					if err == nil {

						_ = c.Write(1, sendData)
					}
					break
				case "login":

					token := model.Tokens{}

					model.DB.Where("token = ?", rd.Params).First(&token)
					var sendData []byte
					if token.Id == 0 {

						sendData, _ = json.Marshal(SdType{
							Msg:  "登陆失败",
							Type: "login_result",
						})
					} else {
						NewUserBindWs.Lock()
						NewUserBindWs.UserBindId[token.UserId] = c.ID()
						NewUserBindWs.Unlock()
						c.SetValue("user_id", token.UserId)
						sendData, _ = json.Marshal(SdType{
							Msg:  "登陆成功",
							Type: "login_result",
							Code: 1,
						})
					}
					_ = c.Write(1, sendData)
					break
				case "unsub":
					c.Leave(rd.Params)
					sendData, err := json.Marshal(SdType{
						Msg:  "取消订阅" + rd.Params,
						Type: "unsub_result",
					})
					if err == nil {

						_ = c.Write(1, sendData)
					}
					break
				}

			}
		}
		//log.Info("WS收到消息:", string(msg))
	})

	c.OnDisconnect(func() {

		c.SetValue("is_leave", true)

		//log.Info("WS客户端关闭 Id:", c.ID())
	})
}
