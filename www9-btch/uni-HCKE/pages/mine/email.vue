<template>
	<view :class="theme">
		 <view class="px-40 bg-white flex between wraps mt30" v-if="!verified">
			
			<view class="w-full flex items-center border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700">
				  <view class="flex items-center flex1">
					<input type="text" v-model="user_string" class="h-100 flex-1" :placeholder="$t('login').p_email" />
				  </view>
				</view>
				<view class="flex w-full items-center border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700 mb-20">
				  <input type="text" v-model="code" class="h-100 flex-1" :placeholder="$t('login').p_vcode"/>
				  <button size="mini" type="primary" class="px-40 bg-main-linear text-white"  :disabled="disable" :loading="load" @click="send">{{ codeText }}</button>
				</view>
				<view  class="w-full mt20 h-80 flex justify-center items-center text-center bg-main-linear text-white text-lg rounded-10" @click="submit">{{ $t("login.e_confrim") }}</view>
		</view>
		<view class="min-h-screen pb20 pt20 bg-white dark:bg-1C2532 px-40" v-else>
			<view class="flex items-center jscenter">
			<image src="../../static/image/yx1.png" style="width: 200rpx;height: 200rpx;"  mode="widthFix"></image>
			</view>
			<view class="tc mt20 ft14 color1">{{$t('add.yxtt')}}</view>
		</view>
		<uni-popup ref="popup" background-color="#fff" @change="change">
			<view class="uni-padding-wrap">
				  <view class="ft14 text-black" @click="cancel">{{$t('trade.cancel')}}</view>
				  <view>
					 <input @input="oninput" type="text" v-model="search" class="tc h40 lh40  text-black flex1 search"  :placeholder="$t('add.qh_ss')">
				  </view>
				  <view class="ft14 text-black" @click="sub">{{$t('login.e_confrim')}}</view>
			</view>
			<picker-view :indicator-style="indicatorStyle" :value="value" @change="bindChange" class="picker-view">
				<picker-view-column>
					<view class="item text-black" v-for="(item,index) in searchArray" :key="index">{{item.trans_name}}+({{item.global_code}})</view>
				</picker-view-column>
			</picker-view>
		</uni-popup>
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return {
				indicatorStyle: `height: 50px;`,
				codeText:this.$t('login.r_send'),
				disable:false,
                load:false,
				value:[0],
				search:'',
				searchArray:[],
				codeIndex:0,
				item:{},
				showRight:false,
				loginActive:2,
				user_string:'',
				password:'',
				re_password:'',
				code:'',
				array: [],
				index: 0,
				area_code:'',
				hasSend:false,
				second:60,
				isRemember:false,
				verifyPwd:false,
				isShowCode:false,
				timeInterval:'',
				lang:'',
				isshowlang: false,
				loginActive:1,
				verified:false
			}
		},
		onLoad(e) {
			this.verified =  JSON.parse(e.verified)
			uni.setNavigationBarTitle({
				title:this.$t('add').yxyz
			})
		},
		computed:{
		   ...mapState(['theme']),
		},
		onShow() {
		    this.$utils.setThemeTop(this.theme)
			this.getCountry()
		},
		methods:{
			submit(){
                if(!this.$utils.checkEmail(this.user_string)){
                    return this.$utils.showLayer(this.$t('login').p_temail)
                }
				if(!this.code){
					this.$utils.showLayer(this.$t('login.p_vcode'))
                    return;
				}
				this.$utils.initDataToken({url:'user/bind_verify_method',type:'POST',data:{
					type:'email',
					code:this.code,
					account: this.user_string
				}},(res,msg)=>{
					this.$utils.showLayer(msg);
					setTimeout(()=>{
						uni.navigateBack();
					},1500)
				})
			},
			// 获取验证码
			send(){
				if(!this.$utils.checkEmail(this.user_string)){
                    return this.$utils.showLayer(this.$t('login').p_temail)
                }
				var url;
				if(this.loginActive==0){
					url='notify/send_sms';
				}else{
					url='notify/send_email';
				}
				var datas = {
					to: this.user_string,
					area_id: this.area_code,
					type: 1
				};
				if(this.loginActive == 0){
					
					datas.to = this.item.global_code + this.user_string
				}
				this.$utils.initDataToken({ url: url, data: datas, type: 'post' }, (res, msg) => {
					this.$utils.showLayer(msg);
					this.disable = true;
					// this.load = true;
					var times = 60;
					var timer = setInterval(() => {
						times--;
						if (times < 10) {
							times = '0' + times;
						}
						this.codeText = times + 's';
						if (times <= 0) {
							clearInterval(timer);
							this.disable = false;
							this.load = false;
							this.codeText = this.$t('login.r_send');
						}
					}, 1000);
				},true);
			},
			path(url,bool){
                if(bool){
                    uni.switchTab({url: url })
                }else{
                    uni.navigateTo({url: url })
                }
            },
			cancel(){
				this.search= ''
				this.codeIndex = 0
				this.searchArray = this.array
				this.$refs.popup.close()
			},
			sub(){
				this.item = this.searchArray[this.codeIndex]
				this.area_code= this.item.id;
				this.search= ''
				this.codeIndex = 0
				this.searchArray = this.array
				this.$refs.popup.close()
			},
			oninput(e){
			 let val = e.detail.value
			 this.searchArray = this.array.filter((item)=>{
				if(item.global_code.search(val) != -1 || item.trans_name.search(val) != -1){
                    return item
				}
			 })
			},
			bindChange(e){
              this.codeIndex = e.detail.value[0]
			},
			change(){},
			showpopup(){
				this.$refs.popup.open('bottom')
			},
			//获取国家列表
			getCountry(){
				this.$utils.initData({url:'default/area_list'},(res,msg)=>{
					// console.log(res)
					this.array = res;
					this.searchArray = res
					this.area_code = res[0].id;
					this.item = res[0]
				})
			},
			// 区号选择
			bindPickerChange(e){
				this.index=e.target.value;
				let item=this.array[this.index];
				this.area_code=item.id;
			},
		}
	}
</script>

<style>
	.light{
		min-height: initial;
	}
	.picker-view {
		width: 750rpx;
		height: 600rpx;
		margin-top: 20rpx;
	}
	.item {
		line-height: 100rpx;
		text-align: center;
	}
	.uni-padding-wrap{
		display: flex;
		justify-content: space-between;
		padding-top:30rpx;
		align-items: center;
	}
	.search{
        background: #F5F5F5 !important;
		padding:20rpx;
		height: 60rpx;
	}
</style>