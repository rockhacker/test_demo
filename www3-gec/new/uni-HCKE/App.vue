<script>
	import {domain} from '@/common/domain.js'
	import { mapState } from 'vuex';
	export default {
		onLaunch: function() {
			console.log('App Launch');
			// #ifdef APP-PLUS  
			var osname=plus.os.name;
			var apptype = osname=='iOS'?2:1;
			console.log(osname,apptype)
			plus.runtime.getProperty(plus.runtime.appid, function(widgetInfo) {  
				// console.log(widgetInfo.version,apptype)
			    uni.request({  
			        url: domain+'/api/default/check_update',  
			        data: {  
			            version_number: widgetInfo.version,  
			            type:apptype
			        }, 
			        success: (result) => {  
						var res=result.data;
						console.log(JSON.stringify(res))
						 if(res.code==1){
							let resData=res.data;
							console.log(resData)
							if(resData.update&&resData.download_url){
								console.log(11111111111111)
								// 大包更新
								if(osname=='Android'){
									uni.showModal({
									    title: '更新提示',
										// showCancel:false,
									    content: res.msg ? res.msg: '是否选择整包更新?',
									    success: (showResult) => {
									        if (showResult.confirm) {
												uni.showLoading({
													title:'APP整包更新中'
												}) 
									            // plus.runtime.openURL(openUrl);
												uni.downloadFile({
												    url: resData.download_url,  
												    success: (downloadResult) => { 
														console.log(downloadResult);
												        if (downloadResult.statusCode === 200) { 
												            plus.runtime.install(downloadResult.tempFilePath, {  
												                force: true  
												            }, function() {  
																uni.hideLoading();
												                plus.runtime.restart();  
												            }, function(e) { 
																uni.hideLoading();
												                uni.showToast({
												                    title: '整包更新失败',
												                    duration: 2000
												                }); 
												            });  
												        }  
												    }  
												}); 
									        }
									    }
									})
								}else{
									uni.showModal({
										title:'IOS更新提示',
										content:'APP变动，请及时更新',
										success: (showResult) => {
										    if (showResult.confirm) {
												plus.runtime.openURL(resData.download_url);
											}
										}
									})
								}
							}
							if (resData.update && resData.wgt_url) {
								console.log(2222222222)
								// 小包提醒用户更新
								uni.showModal({
								    title: '更新提示',
									// showCancel:false,
								    content: res.msg ? res.msg : '是否选择更新?',
								    success: (showResult) => {
								        if (showResult.confirm) {
											uni.showLoading({
												title:'APP更新中'
											}) 
								            // plus.runtime.openURL(openUrl);
											uni.downloadFile({
											    url: resData.wgt_url ||resData.pkg_url,  
											    success: (downloadResult) => { 
													console.log(downloadResult);
											        if (downloadResult.statusCode === 200) { 
											            plus.runtime.install(downloadResult.tempFilePath, {  
											                force: true  
											            }, function() {  
															uni.hideLoading();
											                plus.runtime.restart();  
											            }, function(e) { 
															uni.hideLoading();
											                uni.showToast({
											                    title: '更新失败',
											                    duration: 2000
											                }); 
											            });  
											        }  
											    }  
											}); 
								        }
								    }
								})
							}  
						}
			            
			        }  
			    });  
			});  
			// #endif  
		},
		onShow: function() {
			console.log('App Show')
			var ui='dark'//uni.getStorageSync('theme') || 'dark'
			this.setTheme(ui);
			this.setIcon()
			this.changeFooter()
			this.changeFavicon('/h5/static/wewe.ico');
			if(ui == 'light'){
				document.body.style.backgroundColor="#fff"
			}else{
				document.body.style.backgroundColor="#111111"
			}
		},
		onHide: function() {
			console.log('App Hide')
		},
	
		methods:{
			changeFavicon(link){
			   let $favicon = document.querySelector('link[rel="icon"]');
			   // If a <link rel="icon"> element already exists,
			   // change its href to the given link.
			   if ($favicon !== null) {
			     $favicon.href = link;
			     // Otherwise, create a new element and append it to <head>.
			   } else {
			     $favicon = document.createElement("link");
			     $favicon.rel = "icon";
			     $favicon.href = link;
			     document.head.appendChild($favicon);
			   }
			},
			setTheme(ui){
				console.log(ui);
				this.$store.dispatch("changeTheme",ui);
			},
			changeFooter() {
				uni.setTabBarItem({
					index: 0,
					text: this.$t('market.home')
				});
				uni.setTabBarItem({
					index: 1,
					text: this.$t('market.market')
				});
				// uni.setTabBarItem({
				// 	index: 2,
				// 	text: this.$t('new.tran')
				// });
				uni.setTabBarItem({
					index: 2,
					text: this.$t('trade.bibi')
				});
				uni.setTabBarItem({
					index: 3,
					text: this.$t('new.tran')
				});
				// uni.setTabBarItem({
				// 	index: 3,
				// 	text: this.$t('assets.lever')
				// });
				// uni.setTabBarItem({
				// 	index: 3,
				// 	text: '期权'
				// });
				uni.setTabBarItem({
					index: 4,
					// text: this.$t('new.mi')
					text: this.$t('bigTrade.bigTrade')
				});
				uni.setTabBarItem({
					index: 5,
					text: this.$t('new.mi')
				});
		},
			setIcon(){
				var ui=uni.getStorageSync('theme') || 'dark'
				if(ui=='light'){
					uni.setTabBarItem({
						index: 0,
					    iconPath : "static/footer/index2.png",
					});
					uni.setTabBarItem({
						index: 1,
					    iconPath : "static/footer/hang2.png",
					});
					uni.setTabBarItem({
						index: 2,
					    iconPath :"static/footer/trade2.png",
					});
					uni.setTabBarItem({
						index: 3,
					    iconPath : "static/footer/gang2.png",
					});
					// uni.setTabBarItem({
					// 	index: 3,
					//     iconPath :  "static/footer/gang2.png",
					// });
					uni.setTabBarItem({
						index: 4,
						iconPath :  "static/footer/lc1.png",
					});
					uni.setTabBarItem({
						index: 5,
					    iconPath :  "static/footer/mine2.png",
					});
					}else{
							uni.setTabBarItem({
								index: 0,
								iconPath : "static/footer/index0.png",
							});
							uni.setTabBarItem({
								index: 1,
								iconPath : "static/footer/hang0.png",
							});
							uni.setTabBarItem({
								index: 2,
								iconPath : "static/footer/gang0.png",
							});
							uni.setTabBarItem({
								index: 3,
							    iconPath :"static/footer/trade0.png",
							});
							// uni.setTabBarItem({
							// 	index: 3,
							// 	iconPath :  "static/footer/gang0.png",
							// });
							uni.setTabBarItem({
								index: 4,
								iconPath :  "static/footer/lc0.png",
							});
							uni.setTabBarItem({
								index: 5,
								iconPath :  "static/footer/mine0.png",
							});
						}
						}
		}
	}
</script>
<style>
	/*每个页面公共css */
	@import url("./common/uni.css");
	@import url('./common/common.css');
	@import url("./common/common_light.css");
	
	@import '@/static/styles/style.css';
	/* @font-face {
	  font-family: "POP";
	  src: url('./static/font/PingFangTC.ttf');    
	}
	html {
		width: 100%;
		-webkit-text-size-adjust: 100%;
		-ms-text-size-adjust: 100%;
	}
	
	html * {
		outline: 0;
		-webkit-text-size-adjust: none;
		-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
	}
	
	body,
	div,
	dl,
	dt,
	dd,
	ul,
	ol,
	li,
	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	pre,
	code,
	form,
	fieldset,
	legend,
	input,
	textarea,
	p,
	blockquote,
	th,
	td,
	hr,
	button,
	article,
	aside,
	details,
	figcaption,
	figure,
	footer,
	header,
	hgroup,
	menu,
	nav,
	section {
		margin: 0;
		padding: 0;
	}
	
	* {
		box-sizing: border-box !important;
	}
	
	body {
		font-size: 28upx;
		background: #171e26;
		color: #F2F5FF;
		overflow-x: hidden;
	}
	.hbg{
		background: #171e26 ;
	}
	input,
	select,
	textarea {
		font-size: 100%;
		-webkit-appearance: none;
		background: transparent;
	}
	
	textarea {
		border: none;
		outline: none;
	}
	
	button {
		border: 0;
	}
	
	table {
		border-collapse: collapse;
		border-spacing: 0;
	}
	
	input {
		border: 0;
		outline: 0;
		color: #ffffff;
	} */
	
	body, uni-page-body{
		color: #F2F5FF !important;
	}
	body,html{
	  /* font-family: "POP" !important; */
	  font-size: 24upx;
	}
	button {
		padding: 0 !important;
		margin: 0 !important;
	}

	button::after {
		border: 0 !important;
	}

	page{
		/* background: #061623 ; */
		height: 100%;
	}
	
	.pt-bar {
		padding-top: var(--status-bar-height);
	}
	
	.status_bar {  
		height: var(--status-bar-height);  
		width: 100%;  
		background-color: #102030;
	} 
	.top_view {  
		height: var(--status-bar-height);  
		width: 100%;  
		position: fixed;  
		background-color: #102030;  
		top: 0;  
		z-index: 999;
	} 
	
	view{
		box-sizing: border-box!important;
		font-size:24upx; 
		line-height:1.2;
	}
	uni-view{
		box-sizing: border-box;
		font-size: 24upx;
		line-height: 1.2;
	}
	.uni-padding-wrap{
		width: 100%;
	}
	.uni-toast{
		z-index: 10000!important;
	}
	.uni-modal__btn{
		/* color: red!important; */
	}
	.uni-input {
		height: 50upx;
		padding: 15upx 25upx;
		line-height:50upx;
		font-size:24upx;
		background:#FFF;
		flex: 1;
	}
	.uni-modal__title{
		color:#000000;
	}
</style>
