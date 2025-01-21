import helper from '@/common/helper'
var socketOpen = false;
var emitMsg,onMsg

let newSocket

function sendSocketMessage(msg) {
  if (socketOpen) {
	console.log(msg);
	for(var i in msg){
		newSocket.send({
		  data: JSON.stringify(msg[i])
		});
	}
  }
}

function reciveSocketMessage(callback){
	if (socketOpen) {
		newSocket.onMessage(function (res) {
		  // console.log('收到服务器内容：' + res.data);
		  callback&&callback(res.data);
		});
	}
}
function listenFun(sendMsg=[],callback){
	if(!socketOpen){
		newSocket = uni.connectSocket({
		  url: `wss://${helper._DOMAIN.replace(/^https?\:\/\//i, "")}/v1/ws`,
		  success() {} 
		});

		newSocket.onOpen(function (res) {
			socketOpen = true;
			console.log(socketOpen);
			if(sendMsg.length>0){
				sendSocketMessage(sendMsg);
			}
			reciveSocketMessage(callback);
		  })
	}else{
		sendSocketMessage(sendMsg);
		reciveSocketMessage(callback);
	}
}
function closeSocket(){
	newSocket.close()
	newSocket = undefined
	socketOpen=false;
	// uni.onSocketClose(function (res) {
	//   console.log('WebSocket 已关闭！');
	//   socketOpen=false;
	// });
}
export default {
	listenFun,
	closeSocket,
}