<template>
	<view class="rechargeTransfer" :class="theme">
		<view class="bgPart dark:text-white min-h-screen pb-10">
			<view class="flex between transfer-item bdb_blue3">
				<text>{{$t('rechargeTransfer.coinType')}}</text>
				<view class="wt100 flex jscenter alcenter">
					<picker :value="coin.active" :range="coin.list" class="wt100" @change="changeCoin" range-key="name">
						<view class="text-xl text-center" v-if="coin.list.length">{{ coin.list[coin.active].name }}</view>
					</picker>
					<uni-icons class="text-black dark:text-white ml-10" type="arrowdown" size="18" ></uni-icons>
				</view>
			</view>
			<view class="bg-gray-100 dark:bg-gray-900 p-20">
				<view v-for="item,index in wireInfo" :key="index" class="mb-20 bgPart rounded-10" @click="checkedId = item.id" >
					<view class="flex jsend transfer-item bdb_blue3">
						<radio :value="`r${index}`" :checked="checkedId == item.id" color="rgba(1, 101, 252, 1)" />
					</view>
					<view class="flex between transfer-item bdb_blue3">
						<text>{{$t('rechargeTransfer.bankName')}}</text>
						<text>{{ item.bank_name }}</text>
					</view>
					<view class="flex between transfer-item bdb_blue3">
						<text>{{$t('rechargeTransfer.bankAddress')}}</text>
						<text>{{ item.bank_address }}</text>
					</view>
					<view class="flex between transfer-item bdb_blue3">
						<text>SWIFT</text>
						<text>{{ item.bank_swift }}</text>
					</view>
					<view class="flex between transfer-item bdb_blue3">
						<text>{{$t('rechargeTransfer.rName')}}</text>
						<text>{{ item.payee_name }}</text>
					</view>
					<view class="flex between transfer-item bdb_blue3">
						<!-- <text>{{$t('rechargeTransfer.rAccount')}}</text> -->
						<text>{{$t('rechargeTransfer.rAccount')}}</text>
						<text>{{ item.payee_account }}</text>
					</view>
					<view class="flex between transfer-item bdb_blue3">
						<text>{{$t('rechargeTransfer.remark')}}</text>
						<text>{{ item.remark }}</text>
					</view>
				</view>
			</view>
			<view class="open-form">
				<text class="text">{{$t('legal.amount')}}</text>
				<input class="uni-input" v-model="number" :placeholder="$t('legal.p_amout')" />
				<text class="text">{{$t('feed.upload')}}</text>
				<view class="w48 ptb5 plr5 bd_dashed radius4 tc mb10" @tap="uploadImg">
					<view class="" v-if="!hasUp1">
						<image :src="img" class="wt80 h80"></image>
					</view>
					<image :src="proofImg" class="w95" mode="widthFix" v-else style="max-height: 100px;"></image>
				</view>
				<!-- <text class="upload-text">{{$t('feed.pictures')}}</text> -->
			</view>
			<button class="bg-main-linear text-white w-10_12 m-auto my-80" @click="submit">{{$t('feed.upload')}}</button>
		</view>
	</view>
</template>

<script>
	import { mapState } from 'vuex';
	export default {
		data() {
			return {
				wireInfo: [],
				checkedId: null,
				img: '/static/image/addImg.png',
				hasUp1: false,
				proofImg: '',
				coin:{
					list:[],
					active:0
				},
				number: "",
			}
		},
		computed: {
			...mapState(['theme'])
		},
		onLoad() {
			uni.setNavigationBarTitle({
				title: this.$t('rechargeTransfer.cardTranster')
			})
			this.$utils.setThemeTop(this.theme)//改变导航栏背景色
			this.getSymbols()
		},
		methods: {
			// 修改支付币种
			changeCoin(e){
				this.$set(this.coin,'active',e.detail.value);
				this.getWireInfo();
			},
			getSymbols(){
				const that = this;
				that.$utils.initDataToken({
					url: 'quickCharge/symbols',
					type: 'GET'
				}, (res) => {
					// console.log(res)
					if (res.length) {
						that.$set(that.coin, 'list', res);
						this.getWireInfo();
					}
				});
			},
			getWireInfo() {
				const that = this
				this.$utils.initDataToken({
					url: 'quickCharge/wire_info',
					data:{
						bank_coin:that.coin.list[that.coin.active].id
					}
				}, (res) => {
					that.wireInfo = res;
					that.checkedId = that.wireInfo[0].id;
					// console.log(that.wireInfo)
				});
			},
			submit() {
				this.$utils.initDataToken({
					url: 'quickCharge/wire_submit',
					data: {
						number: this.number,
						proofImg: this.proofImg,
						wire_id: this.checkedId
					}
				}, (res, msg) => {
					if (res) {
						this.$utils.showLayer(msg)
						this.number = ''
						this.proofImg = ''
						this.hasUp1 = false
					}
				});
			},
			uploadImg() {
				var that = this;
				uni.chooseImage({
					count: 1,
					sizeType: ['compressed'],
					success: (chooseImageRes) => {
						// console.log(chooseImageRes.tempFiles[0])
						this.ossFileUpload(chooseImageRes.tempFiles[0], res => {
							this.proofImg = res.url
							this.hasUp1 = true
						})
					}
				});
			}
		}
	}
</script>

<style lang="scss" scoped>
	.rechargeTransfer {
		.transfer-item {
			padding: 20rpx;
		}

		.open-form {
			padding: 30upx 20upx 0;

			.uni-input {
				background: #f7f6fb;
				border-radius: 16upx;
				height: 80upx;
				margin-top: 10upx;
				color: #000;
			}

			.text {
				display: block;
				margin: 20upx 0;
				font-size: 28upx;
			}

			.items {
				display: flex;
				justify-content: space-between;

				.item {
					width: 200upx;
					height: 80upx;
					line-height: 80upx;
					text-align: center;
					background: #f8f8fb;
					border-radius: 5px;
					color: #8d9fae;
					font-size: 28upx;

					&.active {
						border: 1px solid #588bf8;
						color: #588bf8;
					}
				}
			}
		}
		
		.sub-btn{
		    width:90%;
		    border-radius:40upx;
		    height:80upx;
		    line-height:80upx;
		    padding:0;
		    margin:0 auto;
		    background:#588bf7;
		    color:#fff;
		    margin-top:50upx;
		}
	}
</style>
