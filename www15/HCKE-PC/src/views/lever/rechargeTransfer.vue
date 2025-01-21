<template>
		
	<div class="minh100 ft16">
		<div class="mauto wt1200 ptb20">
			<el-card class="box-card mb20" style="border:0">
				<el-breadcrumb>
					<el-breadcrumb-item :to="{ path: '/recharge' }">{{ $t('new.choz') }}</el-breadcrumb-item>
					<el-breadcrumb-item>{{$t('rechargeTransfer.cardTranster')}}</el-breadcrumb-item>
				</el-breadcrumb>
			</el-card>
			
			<el-card class="box-card mb20" style="border:0">
				<div class="flex column alcenter pt20 baselight plr70">
					 <div class="w100 mt20 plr20 ptb20">
						<div class="w70 flex column mtb20 mauto">
							<div class="flex alcenter between mb30">
								<div class="gray7">{{$t('rechargeTransfer.coinType')}}</div>
								<!-- <div class="ml10">{{wireInfo.bank_coin}}</div> -->
								<el-select v-model="coin.active" class="wt200 green" @change="getWireInfo">
								   <el-option
								     v-for="item,index in coin.list"
								     :key="index"
								     :label="item.name"
								     :value="index">
								   </el-option>
								 </el-select>
							</div>
							<div v-for="item,index in wireInfo" :key="index" @click="checkedId = item.id" >
								<el-card class="mtb10">
									<div class="flex alcenter jsend mb30">
										<el-checkbox v-model="checkedId == item.id"></el-checkbox>
									</div>
									<div class="flex alcenter between mb30">
										<span class="gray7">{{$t('rechargeTransfer.bankName')}}</span>
										<span class="ml10">{{item.bank_name}}</span>
									</div>
									<div class="flex alcenter between mb30">
										<span class="gray7">{{$t('rechargeTransfer.bankAddress')}}</span>
										<span class="ml10">{{item.bank_address}}</span>
									</div>
									<div class="flex alcenter between mb30">
										<span class="gray7">SWIFT</span>
										<span class="ml10">{{item.bank_swift || 0}}</span>
									</div>
									<div class="flex alcenter between mb30">
										<span class="gray7">{{$t('rechargeTransfer.rName')}}</span>
										<span class="ml10">{{item.payee_name || 0}}</span>
									</div>
									<div class="flex alcenter between mb30">
										<span class="gray7">{{$t('rechargeTransfer.rAccount')}}</span>
										<span class="ml10">{{item.payee_account || 0}}</span>
									</div>
									<div class="flex alcenter between mb30">
										<span class="gray7">{{$t('rechargeTransfer.remark')}}</span>
										<span class="ml10">{{item.bank_remark || 0}}</span>
									</div>
								</el-card>
							</div>
							
							<div class="flex mb30">
								<span class="gray7">{{$t('feed.upload')}}</span>
							</div>
							
							<div v-if="!proofImg" class="posRelt ht100 wt100 flex jscenter mb30" >
								<img class="wt100 ht100"
								  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAK0AAACtCAYAAADCr/9DAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDozQzkxN0E1Q0JBNEMxMUU4QjU4M0RFMzUzQTYyMjgxNCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDozQzkxN0E1REJBNEMxMUU4QjU4M0RFMzUzQTYyMjgxNCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjNDOTE3QTVBQkE0QzExRThCNTgzREUzNTNBNjIyODE0IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjNDOTE3QTVCQkE0QzExRThCNTgzREUzNTNBNjIyODE0Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+TTeP4gAAAu1JREFUeNrs3T9IlHEcx/G7vHKJcO3PIEUlNDhFSw1Bo1tbQ2sNEQSRQ1gQFLQGgbQ6RuRUe7g4Cg1GDQ7SUpNL0KHX50IhIg86PO73PM/rBV/T+zU8fp8313URtnvRggrp7P76IrNiHRTucubuXrSrmdd2QuEO9z8csgeqRrSIFkQLokW0IFoQLaIF0YJoES2IFkSLaEG0IFpEC6KF0emM+wLW1jfquNd7mbnMTmY587LUC52dmRYtrSeZhT++vpaZyjy1Gi8PSnTmr2D3PM6csh7Rluj0Po/3/+vzWesRbYm2B5x1rUe0JeoNeYZoES2IFkSLaEG0IFpEC6IF0YJoES2IFkSLaEG0IFpEC6IF0SJaEC2IFtGCaEG0IFpEC6IF0SJaEC2IFtGCaEG0iBZEC6JFtCBaEC2iBdGCaEG0o/J9wNk36zkYnUKu41zmeOZnhXe5nbk44PxqZiozUdJFr61v/M9vn8xszs5Mf2lstFlY/5n+eeZ25mjNnyAWa/J9bOW+LSbc+aa+PFjI3G9AsHVyLPMg4T5sarQ3NFBZN5sa7aR7X1lHmhrtO/e+st43NdpnmRX3v3I+7N675r17kL+BbuYF/ZV8er1V2FtBQ7qQebTPWf/xTzX4Hru5b2/HeQGlvE/7pibPQOcHRLuU2SjtghNg5ZbsX8QO1okBZyetR7SIFkQLogXRIloQLYgW0YJoQbSIFkQLokW0IFoQLaIF0YJoES2IFkQLokW0IFoQLaIF0YJoES2IFkSLaEG0IFpEC6IF0YJoES2IFkSLaEG0INoxaA95hmjHpjPgbMJ6RFuir0OeIdqx+ZhZ+sfjrzKfrWf0f5wxnFuZrcxcZieznJm3lhpFOzszXbed/sjc2R28PADRIloQLYgW0YJoQbSIFkQLokW0IFoQLaIF0YJoES2IFkQLokW0IFoQLaIF0YJoES2IFkSLaEG0IFpEC6IF0cJvez8o5FKmax0Urt9pq90Lu6BKfgkwAM2UTk/yuaHfAAAAAElFTkSuQmCC"
								/>
								<input style="opacity: 0;" type="file" class="wt100 ht100 abstort lf0 btm0" accept="image/*" name="file" @change="upload()" />
							</div>
							<img v-if="proofImg" class="wt200 ht200 mb20 mlr20" :src="proofImg"/>
							
							<div class="flex mb60">
								<el-input v-model="number" :placeholder="$t('trade.p_num')" class="w100 white"></el-input>
							 </div>
							 
							 <div type="warning" class="bgblue ht40 flex alcenter jscenter mt20 white radius6 ft16 pointer" @click="submit">{{$t('feed.upload')}}</div>
						</div>
					</div>
						 
				</div>
			</el-card>
		</div>
	</div>
</template>

<script>
export default {
  data() {
    return {
		wireInfo: [],
		checkedId:null,
		number: '',
		coin:{
			list:[],
			active:0
		},
		proofImg: ''
    }
  },
  created() {
		this.getSymbols()
  },
  methods: {
		getSymbols(){
			const that = this;
			that.$http.initDataToken({
				url: 'quickCharge/symbols',
				type: 'GET'
			},false).then((res) => {
				// console.log(res)
				if (res.length) {
					that.$set(that.coin, 'list', res);
					this.getWireInfo();
				}
			});
		},
		getWireInfo() {
		  this.$http.initDataToken({ 
				url: '/quickCharge/wire_info', 
				data:{
					bank_coin:this.coin.list[this.coin.active].id
				},
			}, false).then((res) => {
				this.wireInfo = res;
				this.checkedId = this.wireInfo[0].id;
				// console.log(this.checkedId)
			})
		},
		//   上传图片
		upload(options) {
		  let that = this
		  this.ossFileUpload(event.target.files[0], (res) => {
			// console.log(res)
				this.proofImg = res.url
			// console.log(this.proofImg)
		  })
		},
		submit() {
		  this.$http
			.initDataToken(
			  {
				url: '/quickCharge/wire_submit',
				data: {
				  number: this.number,
				  proofImg: this.proofImg,
				  wire_id: this.checkedId
				}
			  },
			  false
			)
			.then((res) => {
			  if (res) {
				this.number = ''
				this.proofImg = null
				this.$utils.layerMsg(this.$t('feed.ok'), 'success')
			  }
			})
		}
  }
}
</script>