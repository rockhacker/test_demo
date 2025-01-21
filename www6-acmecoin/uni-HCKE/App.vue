<script>
	import {domain} from '@/common/domain.js'
	import { mapState } from 'vuex';
	export default {
		onLaunch: function() {
			console.log('App Launch');
			var lang=uni.getStorageSync('lang') || 'hk';
			if(lang=='hk'){
					uni.setLocale('zh-Hant')
				}else{
					uni.setLocale('en')
				}
		},
		onShow: function() {
			uni.preloadPage(
				{
					url: "/pages/market/market",
					complete:function(){
						console.log('预加载完成')
					},
					fail:function(){
						console.log('预加载失败')
					}
				},
				{
						url: "/pages/trade/trade",
						complete:function(){
							console.log('预加载完成')
						},
						fail:function(){
							console.log('预加载失败')
						}
					},
				
				{
						url: "/pages/contract/lever",
						complete:function(){
							console.log('预加载完成')
						},
						fail:function(){
							console.log('预加载失败')
						}
					},
				
				{
						url: "/pages/mine/login",
						complete:function(){
							console.log('预加载完成')
						},
						fail:function(){
							console.log('预加载失败')
						}
					},
				
				{
						url: "/pages/mine/mine",
						complete:function(){
							console.log('预加载完成')
						},
						fail:function(){
							console.log('预加载失败')
						}
					},
				
			);
			console.log('App Show')
			// var ui=uni.getStorageSync('theme') || 'dark'
			var ui = 'dark'
			this.setTheme(ui);
			this.setIcon()
			this.changeFooter()
			this.changeFavicon('/h5/static/wewe.ico');
			if(ui == 'light'){
				document.body.style.backgroundColor="#fff"
			}else{
				document.body.style.backgroundColor="#111727"
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
				// 	text: '期权'
				// });
				uni.setTabBarItem({
					index: 4,
					text: this.$t('assets.assets')
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
					    iconPath :  "static/footer/mine2.png",
					});
					uni.setTabBarItem({
						index: 5,
						iconPath :  "static/footer/me2.png",
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
							    iconPath :"static/footer/trade0.png",
							});
							uni.setTabBarItem({
								index: 3,
								iconPath : "static/footer/gang0.png",
							});
							// uni.setTabBarItem({
							// 	index: 3,
							// 	iconPath :  "static/footer/gang0.png",
							// });
							uni.setTabBarItem({
								index: 4,
								iconPath :  "static/footer/mine0.png",
							});
							uni.setTabBarItem({
								index: 5,
								iconPath :  "static/footer/me1.png",
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

	@font-face {
	  font-family: "BinancePlex";
	  src: url('./static/font/bPlex-Regular.woff');    
	}
	body,html{
	  font-family: "BinancePlex" !important;
	  font-size: 24upx;
	  --UI-FG-0: white;
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

	uni-switch .uni-switch-input.uni-switch-input-checked{
		border-color: transparent !important;
	}

	uni-switch .uni-switch-input.uni-switch-input-checked{
		background: linear-gradient(138deg, #56D59D, #28C2C8);
	}
</style>
