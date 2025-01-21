import helper from '@/common/helper'
var socketOpen = false;
var emitMsg,onMsg

let mySocket

function sendSocketMessage(msg) {
  if (socketOpen) {
	console.log(msg);
	for(var i in msg){
		mySocket.send({
		  data: JSON.stringify(msg[i])
		});
	}
  }
}

function reciveSocketMessage(callback){
	if (socketOpen) {
		mySocket.onMessage(function (res) {
		  // console.log('收到服务器内容：' + res.data);
		  callback&&callback(res.data);
		});
	}
}
function listenFun(sendMsg=[],callback){
	if(!socketOpen){
		mySocket = uni.connectSocket({
		  url: `wss://${helper._DOMAIN.replace(/^https?\:\/\//i, "")}/ws`,
		  success() {} 
		});

		mySocket.onOpen(function (res) {
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
	mySocket.close()
	mySocket = undefined
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