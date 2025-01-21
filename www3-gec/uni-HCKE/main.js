import Vue from 'vue'
import App from './App'
import utils from '@/common/helper'
import MD5 from '@/common/md5.js'
import store from '@/store/store.js'
import i18n from '@/common/lang/lang.js'
import Socket from '@/common/socket.js'
// import ossInfo from '@/common/oss.js'
Vue.config.productionTip = false
App.mpType = 'app'
Vue.prototype.$store = store
Vue.prototype.$utils=utils;
Vue.prototype.$MD5=MD5;
Vue.prototype._i18n = i18n;
Vue.prototype.host = ''; //utils.domain;
Vue.prototype.$socket=Socket;
Vue.prototype.$ossIconPath = 'MetaUniverseGlobalcoin/upload'

Vue.prototype.randomRange=function(min, max){
	let returnStr = "",
		range = (max ? Math.round(Math.random() * (max - min)) + min : min),
		arr = [
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd',
			'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
			't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
			'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
		];
  
	for (let i = 0; i < range; i++) {
		let index = Math.round(Math.random() * (arr.length - 1));
		returnStr += arr[index];
	}
	return returnStr;
  }
  Vue.prototype.ossFileUpload=function(file, callback) { // file->文件流, callback->回调
	console.log(file)
	let files = file,
		point = files.name.lastIndexOf('.'),
		suffix = files.name.substr(point),
		str = this.randomRange(3, 4),
		date = Date.parse(new Date()),
		fileNames = `${this.$ossIconPath}/${str}_${date}${suffix}`
		console.log(fileNames)
  
	// ossInfo.client().put(fileNames, file).then(res => {
	//    // const index = res.url.indexOf(':') + 1
	//   //  res.url = res.url.substr(index)
	// 	callback && callback(res)
	// }).catch(err => {
	// 	Message.error({
	// 	  message:err
	// 	});
	// })
  }
Vue.filter('filterDecimals',(value,number=2)=>{
	let val=value-0;
	let num=number-0;
	let base='1';
	let decimal=base.padEnd(num+1,0)-0;
	let result=utils.accMul(val,decimal);
	return (Math.floor(result)/decimal).toFixed(num);
})

//禁止双击放大
var lastTouchEnd = 0;
document.documentElement.addEventListener('touchend', function (event) {
  var now = Date.now();
  if (now - lastTouchEnd <= 300) {
	event.preventDefault();
  }
  lastTouchEnd = now;
}, false);

const app = new Vue({
    ...App,
	i18n,
	store,
})
app.$mount()
