### liu-step-bar适用于uni-app项目的步骤条组件
### 本组件目前兼容微信小程序、H5
### 本组件支持自定义步骤内容、步骤回显、点击
# --- 扫码预览、关注我们 ---

## 扫码关注公众号，查看更多插件信息，预览插件效果！ 

![](https://uni.ckapi.pro/uniapp/publicize.png)

### 使用示例
```
<template>
	<view class="page-main">
		<view class="step">
			<liu-step-bar :stepList="stepList" @clickStep="clickStep"></liu-step-bar>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				stepList: [{
					name: '第一步',
					id: 1
				}, {
					name: '第二步',
					id: 2
				}, {
					name: '第三步',
					id: 3
				}], //步骤列表
			}
		},
		onLoad() {

		},
		methods: {
			//点击步骤
			clickStep(e) {
				console.log('所点击步骤信息:', e)
			}
		}
	}
</script>

<style lang="scss">
	.page-main {
		height: auto;

		.step {
			margin-top: 30rpx;
			padding: 0 30rpx;
		}
	}
</style>
```


### 属性说明
| 名称                         | 类型            | 默认值                | 描述             |
| ----------------------------|--------------- | ---------------------- | ---------------|
| step                        | Number         | 1                     | 当前步骤
| stepList                    | Array          | []                    | 步骤信息
| checkedImg                  | String         |                       | 已完成的图片路径
| unCheckedImg                | String         |                       | 未完成的图片路径
| checkedColor                | String         | #287BF8               | 已完成的字体颜色
| unCheckedColor              | String         | #333333               | 未完成的字体颜色
| checkedLine                 | String         |  #287BF8              | 已完成的线条颜色
| unCheckedLine               | String         | #bebebe               | 未完成的线条颜色
| @clickStep                   | Function      |                       | 点击步骤回调事件