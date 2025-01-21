import helper from '@/common/helper'
var socketOpen = false;
var emitMsg,onMsg

let socketTask = null

function sendSocketMessage(msg) {
  if (socketOpen) {
	console.log(msg);
	for(var i in msg){
		socketTask.send({
		  data: JSON.stringify(msg[i])
		});
	}
  }
}

function reciveSocketMessage(callback){
	if (socketOpen) {
		socketTask.onMessage(function (res) {
		  // console.log('收到服务器内容：' + res.data);
		  callback&&callback(res.data);
		});
	}
}
function listenFun(sendMsg=[],callback){
	console.log('234234');
	if(!socketOpen){
		 socketTask = uni.connectSocket({
		  url: `wss://${helper._DOMAIN.replace(/^https?\:\/\//i, "")}/v1/ws`,
		  complete: ()=> {}
		});
	}
	socketTask.onOpen(function (res) {
	 console.log(1234,'aaa');
	  socketOpen = true;
	  console.log(socketOpen);
	  if(sendMsg.length>0){
		  sendSocketMessage(sendMsg);
	  }
	  reciveSocketMessage(callback);
	});
}
function closeSocket(){
	socketTask.close();
	socketOpen=false;
	socketTask.onClose(function (res) {
	  console.log('WebSocket 已关闭！');
	  socketOpen=false;
	});
}
export default {
	listenFun,
	closeSocket,
}