var _API = '';
var _DOMAIN = '';
var _SHUNT = window.location.origin.split('.')[1];
if (process.env.NODE_ENV === 'development') {
	/**
	 * 开发环境
	 */
	_SHUNT = 'coinsultra';
	_DOMAIN = `https://api.${_SHUNT}.com`;
} else { 
	/**
	 * 正式环境
	 */
	// _DOMAIN = `https://api.${_SHUNT}.com`;
	_DOMAIN = window.location.origin.replace(/\/\/[a-zA-Z0-9]+\./g, "//api.");
}
_API = `${_DOMAIN}/api/`;
var middle_api = `${_DOMAIN}/walletMiddle/`;
function checkMobile(phone){
	// var reg=/^[1][0-9]{10}$/;
	// var reg=/^[+,0-9]{11,12}$/;
	var reg=/^[+,0-9]+$/;
	return reg.test(phone);
}
function checkEmail(emial){
	var reg = /^(.*?)+@+(.*?)+$/;
	// var reg = /^(.*?)+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
	return reg.test(emial);
}
function showLayer(con,icon){
	uni.showToast({
		icon: icon ||'none',
		title: con,
		// duration:10000
	});
}
function initData(params,callback){
	var url=_API+params.url;
	var mytype=params.type||'GET';
	var data=params.data || {};
	var lang=uni.getStorageSync('lang') || 'zh';
	// uni.showLoading();
	uni.request({
		url,
		method: mytype,
		data,
		header: {
			'content-type': 'application/x-www-form-urlencoded' ,//自定义请求头信息
			'X-Requested-With': 'XMLHttpRequest',
			'lang':lang
		},
		success: res => {
			// uni.hideLoading();
			var resdata=res.data;
			// console.log(resdata);
			if(resdata.code==1){
			    callback&&callback(resdata.data,resdata.msg);
			}else if(resdata.code=='999'){
			    uni.navigateTo({
			    	url:'/pages/mine/login'
			    })
			}else{
				// uni.hideLoading();
				showLayer(resdata.msg);
			}
		},
		fail: (err) => {
			console.log(err)
		},
		complete: () => {
			setTimeout(function() {
				uni.hideLoading();
			}, 1000);
		}
	});
}
function initDataToken(params,callback,bool){
	var token=uni.getStorageSync('token');
	var lang=uni.getStorageSync('lang') || 'zh';
	var url=_API+params.url;
	var mytype=params.type||'GET';
	var data=params.data || {};
	if(bool){
		uni.showLoading({
			mask:true
		});
	}
	uni.request({
		url,
		method: mytype,
		data,
		header: {
			'X-Requested-With': 'XMLHttpRequest',
			'AUTHORIZATION':token,
			'lang':lang
		},
		
		success: res => {
			// uni.hideLoading();
			var resdata=res.data;
			console.log(resdata.code)
			if(resdata.code==999){
				uni.navigateTo({
					url:'/pages/mine/login'
				})
			}else if(resdata.code=='998'){
			    uni.navigateTo({
			    	url:'/pages/mine/real_authentication'
			    })
			}else if(resdata.code=='997'){
			    uni.navigateTo({
			    	url:'/pages/mine/collect_money'
			    })
			}else if(resdata.code==1){
			    callback&&callback(resdata.data,resdata.msg)
			}else if(params.msg){
				callback&&callback(resdata.code,resdata.msg)
			}
			else{
				showLayer(resdata.msg);
			}
		},
		fail: () => {
		},
		complete: (err) => {
			bool && uni.hideLoading();
			if(err.statusCode == 500){
				showLayer('The server has a problem and is being repaired, please be patient');
			}
			if(err.statusCode == 401){
				uni.showModal({
					title: '',
					content: 'No transaction password, whether to set it now',
					showCancel: true,
					cancelText: 'cancel',
					confirmText: 'determine',
					success: res => {
						console.log(res)
						if(res.confirm){
							uni.navigateTo({
								url:'/pages/mine/resetLegalPwd'
							})
						}
						
					},
					fail: () => {},
					complete: () => {}
				});
				
				
			}
			
		}
	});
}
function noshowToken(params,callback){
	var token=uni.getStorageSync('token');
	var lang=uni.getStorageSync('lang') || 'zh';
	var url=_API+params.url;
	var mytype=params.type||'GET';
	var data=params.data || {};
	uni.request({
		url,
		method: mytype,
		data,
		header: {
			'X-Requested-With': 'XMLHttpRequest',
			'AUTHORIZATION':token,
			'lang':lang
		},
		
		success: res => {
			var resdata=res.data;
			if(resdata.code==999){
				uni.navigateTo({
					url:'/pages/mine/login'
				})
			}else if(resdata.code=='998'){
			    uni.navigateTo({
			    	url:'/pages/mine/real_authentication'
			    })
			}else if(resdata.code=='997'){
			    uni.navigateTo({
			    	url:'/pages/mine/collect_money'
			    })
			}else if(resdata.code==1){
			    callback&&callback(resdata.data,resdata.msg)
			}
			else{
				showLayer(resdata.msg);
			}
		},
		fail: () => {
		},
		complete: (err) => {
			if(err.statusCode == 500){
				showLayer('The server has a problem and is being repaired, please be patient');
			}
		}
	});
}

function getGlobalSettting(params,callback){
	var url=_API+params.url;
	var mytype=params.type||'GET';
	var data=params.data || {};
	var lang=uni.getStorageSync('lang') || 'zh';
	uni.request({
		url,
		method: mytype,
		data,
		header: {
			'content-type': 'application/x-www-form-urlencoded' ,//自定义请求头信息
			'X-Requested-With': 'XMLHttpRequest',
			'lang':lang
		},
		success: res => {
			// uni.hideLoading();
			var resdata=res.data;
			console.log(res);
			callback&&callback(resdata);
		},
		fail: (err) => {
			console.log(err)
		},
		complete: () => {
			setTimeout(function() {
				uni.hideLoading();
			}, 1000);
		}
	});
}
function getAddressOnline(params,callback){
	var token=uni.getStorageSync('token');
	var lang=uni.getStorageSync('lang') || 'zh';
	// var url=domain+'/'+params.url;
	var url = middle_api+params.url;
	var mytype=params.type||'GET';
	var data=params.data || {};
	
	uni.request({
		url,
		method: mytype,
		data,
		header: {
			'content-type':'application/x-www-form-urlencoded',
			'X-Requested-With': 'XMLHttpRequest',
			'lang':lang,
		},
		success: res => {
			
			// uni.hideLoading();
			var resdata=res.data;
			// console.log(JSON.stringify(res));
			callback&&callback(resdata);
		},
		fail: (err) => {
			
			console.log(err)
		},
		complete: () => {
			
		}
	});
}

const accMul=(arg1, arg2) =>{
     var m = 0, s1 = arg1.toString(), s2 = arg2.toString();
     try {
         m += s1.split(".")[1].length;
     }
     catch (e) {
     }
     try {
         m += s2.split(".")[1].length;
     }
     catch (e) {
     }
     return Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m);
 }
 const filterDecimals=(value,number=2)=>{
 	let val=value-0;
 	let num=number-0;
 	let base='1';
 	let decimal=base.padEnd(num+1,0)-0;
	let result=accMul(val,decimal);
 	return (Math.floor(result)/decimal).toFixed(num);
 }
 const setThemeTop=(theme)=>{
	if(theme=='dark'){
		uni.setNavigationBarColor({
			frontColor:"#ffffff",
			backgroundColor:"#100F15"
		})
	}else{
		uni.setNavigationBarColor({
			frontColor:"#000000",
			backgroundColor:"#ffffff"
		})
	}
}
const setThemeBottom=(theme)=>{
	 if(theme=='dark'){
		 uni.setTabBarStyle({
			 color: '#838B99',
			 selectedColor: '#FFCE1C',
			 backgroundColor: '#171E26',
			 borderStyle: 'black'
		 })
	 }else{
		 uni.setTabBarStyle({
			 color: '#838B99',
			 selectedColor: '#0166FC',
			 backgroundColor: '#ffffff',
			 borderStyle: 'black'
		 })
	 }
}

function httpDataToken(params,callback,bool){
	var token=uni.getStorageSync('token');
	var lang=uni.getStorageSync('lang') || 'zh';
	var url=_DOMAIN+ '/v1/api/' + params.url;
	var mytype=params.type||'GET';
	var data=params.data || {};
	// if(!bool){
	// 	uni.showLoading({
	// 		// title: '请求中...'
	// 	});
	// }
	uni.request({
		url,
		method: mytype,
		data,
		header: {
			'X-Requested-With': 'XMLHttpRequest',
			'AUTHORIZATION':token,
			'lang':lang
		},
		
		success: res => {
			uni.hideLoading();
			var resdata=res.data;
			console.log(resdata.code)
			if(resdata.code==999){
				uni.navigateTo({
					url:'/pages/mine/login'
				})
			}else if(resdata.code=='998'){
			    uni.navigateTo({
			    	url:'/pages/mine/real_authentication'
			    })
			}else if(resdata.code=='997'){
			    uni.navigateTo({
			    	url:'/pages/mine/collect_money'
			    })
			}else if(resdata.code==1){
			    callback&&callback(resdata.data,resdata.msg)
			}else if(params.msg){
				callback&&callback(resdata.code,resdata.msg)
			}
			else{
				showLayer(resdata.msg);
			}
		},
		fail: () => {
		},
		complete: (err) => {
			setTimeout(()=>{
				uni.hideLoading();
			},1000)
			if(err.statusCode == 500){
				showLayer('The server has a problem and is being repaired, please be patient');
			}
			if(err.statusCode == 401){
				uni.showModal({
					title: '',
					content: 'No transaction password, whether to set it now',
					showCancel: true,
					cancelText: 'cancel',
					confirmText: 'determine',
					success: res => {
						console.log(res)
						if(res.confirm){
							uni.navigateTo({
								url:'/pages/mine/resetLegalPwd'
							})
						}
						
					},
					fail: () => {},
					complete: () => {}
				});
				
				
			}
			
		}
	});
}
export default{
	_SHUNT,
	_API,
	_DOMAIN,
	checkMobile,
	checkEmail,
	showLayer,
	initData,
	initDataToken,
	filterDecimals,
	noshowToken,
	getGlobalSettting,
	getAddressOnline,
	accMul,
	setThemeTop,
	setThemeBottom,
	httpDataToken
	
}