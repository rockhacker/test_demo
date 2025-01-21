# cc-defineKeyboard


#### 使用方法 
```使用方法	
<!-- ref:唯一ref  passwrdType：密码样式pay keyInfo：密码输入监测事件 -->
<cc-defineKeyboard ref="CodeKeyboard" passwrdType="pay" @KeyInfo="KeyInfo"></cc-defineKeyboard>
						
/** * 唤起键盘 */
onPayUp() {
	this.$refs.CodeKeyboard.show();
},

/*** 支付键盘回调* @param {Object} val */

KeyInfo(val) {

				if (val.index >= 6) {
					return;
				}
				// 判断是否输入的是删除键
				if (val.keyCode === 8) {
					// 删除最后一位
					this.passwordArr.splice(val.index + 1, 1)
				}
				// 判断是否输入的是.
				else if (val.keyCode == 190) {
					// 输入.无效
				} else {
					this.passwordArr.push(val.key);
				}

				uni.showModal({
					title: '温馨提示',
					content: '输入密码是 = ' + JSON.stringify(this.passwordArr)
				})
}


```

#### HTML代码实现部分
```html

<template>
	<view class="page">
		<view>
			<view class="pay-title">
				<text v-show="AffirmStatus === 1">请输入6位支付密码</text>
				<text v-show="AffirmStatus === 2">请设置6位支付密码</text>
				<text v-show="AffirmStatus === 3">请确认6位支付密码</text>
			</view>
			<view class="pay-password" @click="onPayUp">
				<view class="list">
					<text v-show="passwordArr.length >= 1">●</text>
				</view>
				<view class="list">
					<text v-show="passwordArr.length >= 2">●</text>
				</view>
				<view class="list">
					<text v-show="passwordArr.length >= 3">●</text>
				</view>
				<view class="list">
					<text v-show="passwordArr.length >= 4">●</text>
				</view>
				<view class="list">
					<text v-show="passwordArr.length >= 5">●</text>
				</view>
				<view class="list">
					<text v-show="passwordArr.length >= 6">●</text>
				</view>
			</view>
			<view class="hint">
				<text>忘记支付密码？</text>
			</view>
		</view>
		<!-- ref:唯一ref  passwrdType：密码样式pay keyInfo：密码输入返回事件 -->
		<cc-defineKeyboard ref="CodeKeyboard" passwrdType="pay" @KeyInfo="KeyInfo"></cc-defineKeyboard>
	
	</view>
</template>

<script>
	export default {
		components: {

		},
		data() {
			return {
				AffirmStatus: 1,
				passwordArr: [],
				oldPasswordArr: [],
				newPasswordArr: [],
				afPasswordArr: [],
			};
		},
		onLoad() {

		},
		methods: {
			/**
			 * 唤起键盘
			 */
			onPayUp() {
				this.$refs.CodeKeyboard.show();
			},
			/**
			 * 支付键盘回调
			 * @param {Object} val
			 */
			KeyInfo(val) {


				if (val.index >= 6) {
					return;
				}
				// 判断是否输入的是删除键
				if (val.keyCode === 8) {
					// 删除最后一位
					this.passwordArr.splice(val.index + 1, 1)
				}
				// 判断是否输入的是.
				else if (val.keyCode == 190) {
					// 输入.无效
				} else {
					this.passwordArr.push(val.key);
				}

				uni.showModal({
					title: '温馨提示',
					content: '输入密码是 = ' + JSON.stringify(this.passwordArr)
				})


				// 判断是否等于6
				if (this.passwordArr.length === 6) {
					this.passwordArr = [];
					this.AffirmStatus = this.AffirmStatus + 1;
				}
				// 判断到哪一步了
				if (this.AffirmStatus === 1) {
					this.oldPasswordArr = this.passwordArr;
				} else if (this.AffirmStatus === 2) {
					this.newPasswordArr = this.passwordArr;
				} else if (this.AffirmStatus === 3) {
					this.afPasswordArr = this.passwordArr;
				} else if (this.AffirmStatus === 4) {
					console.log(this.oldPasswordArr.join(''));
					console.log(this.newPasswordArr.join(''));
					console.log(this.afPasswordArr.join(''));
					uni.showToast({
						title: '修改成功',
						icon: 'none'
					})
					setTimeout(() => {
						uni.navigateBack();
					}, 2000)
				}
				this.$forceUpdate();
			}

		}
	}
</script>

<style scoped lang="scss">
	$base: orangered; // 基础颜色

	.page {
		position: absolute;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		background-color: #FFFFFF;
	}

	.pay-title {
		display: flex;
		align-items: center;
		justify-content: center;
		width: 100%;
		height: 200rpx;

		text {
			font-size: 28rpx;
			color: #555555;
		}
	}

	.pay-password {
		display: flex;
		align-items: center;
		width: 90%;
		height: 80rpx;
		margin: 20rpx auto;
		border: 2rpx solid $base;

		.list {
			display: flex;
			align-items: center;
			justify-content: center;
			width: 16.666%;
			height: 100%;
			border-right: 2rpx solid #EEEEEE;

			text {
				font-size: 32rpx;
			}
		}

		.list:nth-child(6) {
			border-right: none;
		}
	}

	.hint {
		display: flex;
		align-items: center;
		justify-content: center;
		width: 100%;
		height: 100rpx;

		text {
			font-size: 28rpx;
			color: $base;
		}
	}
</style>


```
