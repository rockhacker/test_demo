<template>
	<view class="step-info">
		<view class="step-number">
			<block v-for="(item,index) in stepList" :key="index">
				<view @click.stop="openItem(item)" class="item-state">
					<view class="bg-ra"  :style="{background:getLine(index) || (item.unCheckedLine || unCheckedLine)}">{{index+1}}</view>
					<view class="step-name">
						<view class="name" >
							{{item.name}}
						</view>
					</view>
				</view>
				<view class="line" :style="{background:getLine(index+1) || (item.unCheckedLine || unCheckedLine)}"
					v-if="index < stepList.length-1"></view>
			</block>
		</view>
	</view>
</template>

<script>
	import checkedImg from '../../static/checkedImg.png'
	import unCheckedImg from '../../static/unCheckedImg.png'
	export default {
		props: {
			//当前步骤
			step: {
				type: Number,
				default: 1
			},
			//步骤列表
			stepList: {
				type: Array,
				default: null
			},
			//已完成的图片路径
			checkedImg: {
				type: String,
				default: checkedImg
			},
			//未完成的图片路径
			unCheckedImg: {
				type: String,
				default: unCheckedImg
			},
			//已完成的字体颜色
			checkedColor: {
				type: String,
				default: '#287BF8'
			},
			//未完成的字体颜色
			unCheckedColor: {
				type: String,
				default: '#333333'
			},
			//已完成的线条颜色
			checkedLine: {
				type: String,
				default: '#2ebd85'
			},
			//未完成的线条颜色
			unCheckedLine: {
				type: String,
				default: '#e5e9f0'
			}
		},
		data() {
			return {}
		},
		methods: {
			//获取图片
			getImg(e) {
				let index = Number(e)
				if (this.step > index) return this?.stepList?.[index].checkedImg || this.checkedImg
			},
			//获取线
			getLine(e) {
				let index = Number(e)
				if (this.step >= index) return this?.stepList?.[index].checkedLine || this.checkedLine
			},
			//获取颜色
			getColor(e) {
				let index = Number(e)
				if (this.step > index) return this?.stepList?.[index].checkedColor || this.checkedColor
			},
			openItem(item) {
				this.$emit('clickStep', item)
			}
		}
	}
</script>

<style>
	.step-info {
		width: 100%;
		height: auto;
	}

	.step-number {
		width: 100%;
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.item-state {
		height: 76rpx;
		display: flex;
		flex-direction: column;
		align-items: center;	
		width: 76rpx;
	}

	.state-img {
		width: 64rpx;
		height: 64rpx;
		display: flex;
		margin: auto;
	}

	.line {
		width: 100%;
		height: 6rpx;
		
	}


	.step-name {
		margin-top: 16rpx;
		width: 120rpx;
		align-items: center;
		justify-content: space-between;
		font-weight: bold;
		text-align: center
	}

	.name {
		font-size: 28rpx;
		line-height: 28rpx;
		color: #333333;
		font-weight: initial;
	}

	.bg-ra{
		width: 76rpx;
		height: 76rpx;
		line-height: 76rpx;
		text-align: center;
		font-size: 16rpx;
		color: #fff;
		background: #fff;
		border-radius: 50%;
		font-size: 32rpx;
	}
</style>