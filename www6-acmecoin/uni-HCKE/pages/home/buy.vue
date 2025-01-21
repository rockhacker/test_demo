<template>
	<view class="blue" :class="{ light: theme == 'light' }">
		<view class="plr20 ptb15 mt10 bgPart" style="min-height: 80vh;">
			<view class="pb20">
				<view class="mb10 ft16 pt10">{{title}}</view>
				<view v-html="news"></view>
				<view class="flex alcenter between bdBlue ptb10 plr10 radius4 w150 mt10" @click="word">
					<image src="/static/image/shu.png" class="wt20 h20" alt="">
					<p class="blue21 ft16">white paper</p>
				</view>
				<view class="flex alcenter between mt10">
					<picker class="bd_input ptb10 plr10 tc flex1 radius4" :value="index" :range="list" @change="pickChange" range-key="code">
						<view class="flex between">
							<text>{{ $t('legal.coin') }}</text>
							<text>{{ list[index].code }}</text>
						</view>
					</picker>
				</view>
				<view class="flex alcenter mt10">
					<text>{{ $t('trade.num') }}：</text>
					<input type="number" value="" v-model="number"  @input="inputnum"  class="flex1 plr15 h40 bdb1f" />
				</view>
				<view class="mt10">
					{{ $t('assets.zhehe') }}: {{price}} {{Company}}
				</view>
				<view class="flex alcenter mt10">
					<text>{{ $t('login.p_invitecode') }}：</text>
					<input type="text" value="" v-model="invite_code"  class="flex1 plr15 h40 bdb1f" />
				</view>
				<view class="mt20 bgBlue radius4 ptb10 white ft14 tc mb10" @tap="sumbit">{{ $t('legal.buy') }}</view>
			</view>
		</view>
		
		<view class="h50">	
		</view>
	</view>
</template>

<script>
	import uniPopup from '@/components/uni-popup.vue';
	import { mapState } from 'vuex';
	export default{
		components: {
			uniPopup
		},
		data(){
			return {
				index:0,
				number: "",
				coinprice:'',
				price:'0.00',
				list:[],
				coin:'',
				votid:'',
				news:'',
				title:'',
				Company:'',
				link:'',
				invite_code:''
			}
		},
		onLoad() {
			this.getlist();
			this.getDetail();
			uni.setNavigationBarTitle({
				title:this.$t('login').subscribe
			})
		},
		filters: {
			toFixed4: function(value, options) {
				value = Number(value);
				return value.toFixed(4);
			}
		},
		methods:{
		
			word(){
				var url =  this.link;
				window.open(url,'_blank');
				// uni.navigateTo({
				//     url: 'word'
				// });
			},
			getDetail(){
				this.$utils.initData({ url: 'news/list', data: { category_id: 50 }}, (res, msg) => {
					this.news = res.data[0].content;
					this.title = res.data[0].title;
					this.link = res.data[0].white_paper;

				});
			},
			getlist(){
				var that = this;
				that.$utils.initDataToken({url:'new_tx/in_currency',type:'get', data:{}},res=>{
					uni.stopPullDownRefresh()
					console.log(res)
					that.list = res;
					that.id = that.list[0].id;
					that.coin = that.list[0].code;
					that.coinprice = that.list[0].pb_price;
					that.list.map((item,index)=>{
					
						if(item.is_pb==1){
							that.votid = item.id;
							that.Company = item.code;
						}
					})
				})
			},
			pickChange(e) {
				console.log(e.target.value);
				var that = this;
				that.index = e.target.value;
				that.id = that.list[that.index].id;
				that.coin = that.list[that.index].code;
				that.coinprice = that.list[that.index].pb_price;
			    that.number = '';
			    that.price = '0.00';
			},
		    inputnum(){
				this.price = this.coinprice*this.number;
			},
			sumbit() {
				let that = this;
				if (!that.number) {
					that.$utils.showLayer(this.$t('trade.p_num'));
					return false;
				}
				if (!that.invite_code) {
					that.$utils.showLayer(this.$t('login.p_inviteInput'));
					return false;
				}
				this.$utils.initDataToken({
					url:'new_tx/in',
					type:'POST', 
					data: {
						pb_currency_id: that.votid,
						number: that.number,
						base_currency_id: that.id,
						invite_code:that.invite_code
					},
				},(res,msg) =>{
					this.$utils.showLayer(msg);
					that.index = 0;
					that.number = '';
					that.price = '0.00';
					setTimeout(() => {
						that.getlist();
					}, 1500);
				})
				
			},
			
		},
		onPullDownRefresh() {

		},
		computed: {
			...mapState(['theme'])
		},
		onShow() {
			this.$utils.setThemeTop(this.theme);
		},
		onReachBottom() {
		
		},
	}
</script>

<style>
	page {
		background-color: #102030;
		width: 100.0vw;
		height: 100.0vh;
		overflow-y: scroll;
	}
</style>
