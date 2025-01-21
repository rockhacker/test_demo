// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import Axios from './lib/helper.js'
import App from './App'
import router from './router'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import locale from 'element-ui/lib/locale/lang/en'
Vue.use(ElementUI,{ locale })
import '@/assets/style/common.scss'
import utils from './lib/utils.js'
import socket from './lib/socket.js'
import store from './store/store.js'
import md5 from 'js-md5';
import i18n from './lang/lang'
import ossInfo from '@/oss'
import {
  Message
} from 'element-ui'
Vue.prototype.$ossIconPath = 'MetaUniverseGlobalcoin/upload'

Vue.prototype.ossFileUpload=function(file, callback) { // file->文件流, callback->回调
  
  let files = file,
      point = files.name.lastIndexOf('.'),
      suffix = files.name.substr(point),
      str = this.randomRange(3, 4),
      date = Date.parse(new Date()),
      fileNames = `${this.$ossIconPath}/${str}_${date}${suffix}`
      

  ossInfo.client().put(fileNames, file).then(res => {
     // const index = res.url.indexOf(':') + 1
    //  res.url = res.url.substr(index)
      callback && callback(res)
  }).catch(err => {
      Message.error({
        message:err
      });
  })
}

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


Vue.prototype.resetSetItem = function (key, newVal) {
  if (key === 'watchStorage') {

      // 创建一个StorageEvent事件
      var newStorageEvent = document.createEvent('StorageEvent');
      const storage = {
          setItem: function (k, val) {
              sessionStorage.setItem(k, val);

              // 初始化创建的事件
              newStorageEvent.initStorageEvent('setItem', false, false, k, null, val, null, null);

              // 派发对象
              window.dispatchEvent(newStorageEvent)
          }
      }
      return storage.setItem(key, newVal);
  }
}

Vue.prototype.API = Axios._DOMAIN;
Vue.prototype.$http = Axios;
Vue.config.productionTip = false;
Vue.prototype.$utils = utils;
Vue.prototype.$socket=socket;
Vue.prototype.$md5 = md5;
Vue.filter('filterDecimals',(value,number=2)=>{
	let val=value-0;
	let num=number-0;
	let base='1';
	let decimal=base.padEnd(num+1,0)-0;
	let result=utils.accMul(val,decimal);
	return (Math.floor(result)/decimal).toFixed(num);
})
window.eventBus = new Vue()

sessionStorage.removeItem('arr')


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


/* eslint-disable no-new */
 let vue = new Vue({
  el: '#app',
  i18n,
  router,
  store,
  components: { App },
  template: '<App/>'
})

export default vue