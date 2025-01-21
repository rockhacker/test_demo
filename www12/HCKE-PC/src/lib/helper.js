import Vue from 'vue'
import Axios from 'axios'
import qs from 'qs'
import router from '../router/index'
import { Loading } from 'element-ui';
import i18n from '../lang/lang'
Axios.defaults.timeout = 20000;
let _DOMAIN = '', _API='', _SHUNT='';
if (process.env.NODE_ENV == 'development') {
	_SHUNT = 'nhbtcc';
	_DOMAIN = `https://api.${_SHUNT}.com`;
} else {
	_SHUNT = window.location.host.split('.')[2];
	_DOMAIN = window.location.origin.replace(/\/\/[a-zA-Z0-9]+\./g, "//api.");
}
_API = `${_DOMAIN}/api/`; 
// Axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8';
Axios.defaults.baseURL = _API;   //配置接口地址

// POST传参序列化(添加请求拦截器)
Axios.interceptors.request.use((config) => {
    var token = localStorage.getItem('token');
    // var token='60bd1a6002f2aa1c2f0e6db12d30ff2c';
    var lang = localStorage.getItem('lang') || 'zh';
    config.headers.lang = lang;
    if (token) {
        config.headers.Authorization = token;
    }
    if (config.method == 'POST') {
        // config.data=qs.stringify(config.data);
        // config.data = qs.stringify(config.data,{ indices: false })
    }
    return config;
}, (error) => {
    console.log('参数错误');
    return Promise.reject(error);
})
//返回状态判断(添加响应拦截器)
Axios.interceptors.response.use((res) => {
    //对响应数据做些事
    if (res.data.code == 0&&(!res.data.data || res.data.data.length==0) ) {
        Vue.prototype.$notify.error({
            // showClose:false,
            customClass: 'gobal_tip gobal_tip_error',
            message: res.data.msg
          });
        // Vue.prototype.$message.error(res.data.msg);
        return '';
    }
    if (res.data.code == '999') {
        // 跳转登录
        if(router.currentRoute.name!='login'){
            console.log(router.currentRoute.fullPath)
            sessionStorage.setItem('path',router.currentRoute.fullPath)
        }
        // if(!localStorage.getItem('token')){
        //     router.replace({
        //         name: "login",
        //         query: { page: router.currentRoute.fullPath }
        //     })
        //     return;
        // }else{
        //     localStorage.removeItem('token');
        // }
        Vue.prototype.$notify.error({
            // showClose:false,
            customClass: 'gobal_tip gobal_tip_error',
            message: i18n.t('header.logined')
          });
        // Vue.prototype.$message.error(i18n.t('header.logined'));
        router.replace({
            name: "login",
            query: { page: router.currentRoute.fullPath }
        })
        return ''
    }
    if (res.data.code == '996') {
        return '';
    }
    return { data: res.data.data, msg: res.data.msg };
}, (error) => {
    console.log('网络异常')
    return Promise.reject(error);
});
const initDataToken = (params, isshowmsg = true, isloading = true,contentType=false,options={},loading=false) => {
    var urls = params.url;
    var mytype = params.type || 'GET';
    var datas = params.data || {};
    var axiosData = {
        baseURL: _DOMAIN + '/api/',
        url: urls,
        method: mytype,
        ...options
    };
    // 图片上传头部
    if(contentType){
        axiosData.headers = { 'Content-Type': 'multipart/form-data','X-Requested-With': 'XMLHttpRequest' };
    }else{
        axiosData.headers = { 'Content-Type': 'application/json','X-Requested-With': 'XMLHttpRequest'  };
    }
    if (params.type == 'POST' || params.type == 'post') {
        axiosData.data = datas;
    }else{
        axiosData.params = datas;
    }
    let loadingInstance;
    console.log('loading',loading);
    if(loading){
        loadingInstance=Loading.service({
            lock: true,
            text: i18n.t('home.loading'),
            spinner: 'el-icon-loading',
            background: 'rgba(0, 0, 0, 0.6)'
        });
    }
    return new Promise((resolve, reject) => {
        Axios(axiosData).then(res => {
            loading && loadingInstance.close();
            if (res) {
                if (isshowmsg && res.msg) {
                    Vue.prototype.$notify.success({
                        // showClose:false,
                        customClass: 'gobal_tip gobal_tip_success',
                        message: res.msg
                      });
                    // Vue.prototype.$message({
                    //     message: res.msg,
                    //     type: 'success',
                    //     offset:500
                    // });
                }
                resolve(res.data);
            }
        }).catch(err => {
            loading && loadingInstance.close();
            Vue.prototype.$notify.error({
                // showClose:false,
                customClass: 'gobal_tip gobal_tip_error',
                message: i18n.t('header.error')
              });
            // Vue.prototype.$message.error(i18n.t('header.error'));
        })
    })
}
// 冲提币中间件请求
const initDataNoapi= (params, isshowmsg = true, isloading = true,contentType=false) => {
    var urls = params.url;
    var mytype = params.type || 'GET';
    var datas = params.data || {};
    var axiosData = {
        baseURL: _DOMAIN + '/walletMiddle/',
        url: urls,
        method: mytype,
    };
    // 图片上传头部
    if(contentType){
        // axiosData.headers = { 'Content-Type': 'application/x-www-form-urlencoded' };
        axiosData.headers = { 'Content-Type': 'multipart/form-data' };
    }else{
        axiosData.headers = { 'Content-Type': 'application/json'  };
    }
    if (params.type == 'POST' || params.type == 'post') {
        axiosData.data = datas;
    }else{
        axiosData.params = datas;
    }
    console.log(axiosData);
    let loadingInstance;
    // if(isloading){
    //     loadingInstance=Loading.service({
    //         lock: true,
    //         text: i18n.t('home.loading'),
    //         spinner: 'el-icon-loading',
    //         background: 'rgba(0, 0, 0, 0.6)'
    //     });
    // }
    return new Promise((resolve, reject) => {
        Axios(axiosData).then(res => {
            loadingInstance && loadingInstance.close();
            console.log(res)
            if (res) {
                if (isshowmsg && res.msg) {
                    Vue.prototype.$message({
                        message: res.msg,
                        type: 'success',
                        offset:500
                    });
                }
                resolve(res.data);
            }
        }).catch(err => {
            // reject(err);
            loadingInstance && loadingInstance.close();
            Vue.prototype.$notify.error({
                // showClose:false,
                customClass: 'gobal_tip gobal_tip_error',
                message: i18n.t('home.error')
              });
            // Vue.prototype.$message.error(i18n.t('home.error'));
        })
    })
}
Axios.initDataToken = initDataToken;
Axios.initDataNoapi = initDataNoapi;
Axios._SHUNT = _SHUNT;
Axios._DOMAIN = _DOMAIN;
export default Axios;
