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
		uni.showLoading({
			title: '',
			mask:true
		});
	// ossInfo.client().put(fileNames, file).then(res => {
	//    // const index = res.url.indexOf(':') + 1
	//   //  res.url = res.url.substr(index)
	// 	callback && callback(res)
	// }).catch(err => {
	// 	Message.error({
	// 	  message:err
	// 	});
	// }).finally(()=>{
	// 	uni.hideLoading()
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

/**
 * 加法
 * @param arg1
 * @param arg2
 * @returns
 */
Vue.prototype.accAdd = (arg1, arg2) => {
	var r1, r2, m, n;
	try {
		r1 = arg1.toString().split(".")[1].length
	} catch (e) {
		r1 = 0
	};
	try {
		r2 = arg2.toString().split(".")[1].length
	} catch (e) {
		r2 = 0
	};
	m = Math.pow(10, Math.max(r1, r2));
	//动态控制精度长度
	n = (r1 >= r2) ? r1 : r2;
	return ((arg1 * m + arg2 * m) / m).toFixed(n);
}

/**
 * 减法
 * @param arg1
 * @param arg2
 * @returns
 */
Vue.prototype.accSub= (arg1, arg2) => {
	var r1, r2, m, n;
	try {
		r1 = arg1.toString().split(".")[1].length;
	} catch (e) {
		r1 = 0;
	}
	try {
		r2 = arg2.toString().split(".")[1].length;
	} catch (e) {
		r2 = 0;
	}
	m = Math.pow(10, Math.max(r1, r2));
	//动态控制精度长度
	n = (r1 >= r2) ? r1 : r2;
	return ((arg1 * m - arg2 * m) / m).toFixed(n);
}

/***
 * 乘法，获取精确乘法的结果值
 * @param arg1
 * @param arg2
 * @returns
 */
Vue.prototype.accMul = (arg1, arg2)=> {
	var m = 0,
		s1 = arg1.toString(),
		s2 = arg2.toString();
	try {
		m += s1.split(".")[1].length
	} catch (e) {};
	try {
		m += s2.split(".")[1].length
	} catch (e) {};
	return Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m);
}

/***
 * 除法，获取精确乘法的结果值
 * @param arg1
 * @param arg2
 * @returns
 */
Vue.prototype.accDiv= (arg1, arg2) => {
	var t1 = 0,
		t2 = 0,
		r1, r2;
	try {
		t1 = arg1.toString().split(".")[1].length;
	} catch (e) {}
	try {
		t2 = arg2.toString().split(".")[1].length;
	} catch (e) {}

	r1 = Number(arg1.toString().replace(".", ""));
	r2 = Number(arg2.toString().replace(".", ""));
	return (r1 / r2) * Math.pow(10, t2 - t1);

}

const app = new Vue({
    ...App,
	i18n,
	store,
})

Vue.prototype.$utils.initDataToken({ url: 'check_login'},(res)=>{
	if(res.status==0){
		uni.removeStorageSync('token');
	}
	app.$mount()
})
