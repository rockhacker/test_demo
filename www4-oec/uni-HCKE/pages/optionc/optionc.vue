<template>
  <view :class="{ light: theme == 'light' }" class="optionc">
    <view class="header ww">
      <view class="item" v-for="(item, index) in list" :key="index">
        <text
          class="text blue4"
          :class="item.id == active ? 'active' : ''"
          @click="setActive(item)"
          >{{ item.symbol }}</text
        >
      </view>
    </view>
    <view class="select ww">
      <img
        @click="leftStatus = true"
        class="select-icon wt20"
        src="../../static/image/list.png"
        alt=""
      />
      <view v-if="symbol" class="text">{{ symbol }}</view>
      <view v-else class="text">BTC/USDT</view>
    </view>
    <view class="tarningview">
      <web-view :src="url" class="webview"></web-view>
    </view>
    <view class="cont">
      <view class="loading" v-if="isLoading">{{ $t("new.settlement") }}</view>
      <view class="gress ww">
        <view class="text"
          >{{ $t("new.frist") }}{{ working.period
          }}{{ $t("new.schedule") }}</view
        >
        <progress
          class="progress"
          activeColor="#4fe6ff"
          backgroundColor="#5D491F"
          :percent="timePer"
          show-info
          stroke-width="3"
        />
      </view>
      <view class="ww flex between alcenter" v-if="working.open_price && price">
        <view>
          <view
            >{{ $t("new.opprice") }} :
            <text class="price ac">{{
              Number(working.open_price).toFixed(4)
            }}</text></view
          >
          <!-- <view>当前价 : <text class="price" :class="price>working.open_price?'zhang':'die'"> {{price.toFixed(4)}}</text></view> -->
        </view>
        <view>
          <text class="ft14" :class="percent > 0 ? 'zhang' : 'die'"
            >{{ percent }}%</text
          >
        </view>
      </view>
      <view class="text ww mtborder"
        >{{ $t("new.frist") }}{{ not.period }}{{ $t("new.qi") }}</view
      >
      <view class="number ww">
        <view
          class="items"
          :class="timeItem.id == item.id ? 'active' : ''"
          v-for="(item, index) in timeList"
          :key="index"
          @click="setTime(item)"
          >{{ secondsFormat(item.seconds) }}</view
        >
      </view>
      <view class="number ww">
        <view
          class="items"
          :class="amount.currency_id == item.currency_id ? 'active' : ''"
          v-for="(item, index) in amountList"
          :key="index"
          @click="setBala(item)"
          >{{ parseFloat(item.number) }} {{ item.currency_code }}</view
        >
      </view>
      <view class="balance ww shw">
        <!-- <img class="bala-img" src="../../static/image/moy.png" alt=""> -->
        <text>{{ $t("new.available") }} {{ parseFloat(balance) }} USDT</text>
      </view>
      <view class="btn ww">
        <button class="buy button" @click="submit(1)">
          {{ $t("new.bullish") }}
        </button>
        <button class="cell button" @click="submit(2)">
          {{ $t("new.bearish") }}
        </button>
      </view>
    </view>
    <view class="tabs ww">
      <view class="tab-text">
        <view
          class="tab-item"
          :class="textAc == 1 ? 'active' : ''"
          @click="setText(1)"
          >{{ $t("new.current") }}</view
        >
        <view
          class="tab-item"
          :class="textAc == 3 ? 'active' : ''"
          @click="setText(3)"
          >{{ $t("store.orderlist") }}</view
        >
      </view>
      <view class="lishi">
        <view class="head">
          <text class="flex15 item-text blue4">{{ $t("new.period") }}</text>
          <text class="item-text blue4 left">{{ $t("new.amount") }}</text>
          <text class="item-text blue4 left">{{ $t("new.direction") }}</text>
          <text class="item-text blue4">{{ $t("new.forecast") }}</text>
        </view>
        <view
          class="item"
          v-for="(item, index) in historyList"
          :key="index"
          v-if="historyList.length > 0"
        >
          <view class="item-head" @click="setShow(index)">
            <view class="flex15 item-text">
              <text
                >{{ $t("new.frist") }}{{ item.period.period
                }}{{ $t("new.qi") }}</text
              >
              <text class="min">{{ item.currency_match.symbol }}</text>
            </view>
            <text class="item-text left">{{ parseFloat(item.number) }}</text>
            <text class="item-text left zhang" v-if="item.type == 1">{{
              $t("new.bullish")
            }}</text>
            <text class="item-text left die" v-else>{{
              $t("new.bearish")
            }}</text>
            <view class="item-text zhang bet">
              <text class="zhang" v-if="item.type == item.result">{{
                $t("new.success")
              }}</text>
              <text
                class="die"
                v-else-if="item.type != item.result && item.result"
                >{{ $t("new.failure") }}</text
              >
              <text v-else-if="item.status == 0">{{ $t("new.started") }}</text>
              <text v-else-if="item.status == 1">{{ $t("new.running") }}</text>
              <text v-else-if="item.status == 2">{{ $t("new.ement") }}</text>
              <text :class="!item.show ? 'iconb' : 'icont'"></text>
            </view>
          </view>
          <view class="item-content" v-show="item.show">
            <view class="item-cont blue4" v-if="textAc == 3"
              >{{ $t("new.loss") }}: {{ parseFloat(item.result_amount) }}</view
            >
            <view class="item-cont blue4"
              >{{ $t("new.openfee") }}: {{ parseFloat(item.fee) }}</view
            >
            <view class="item-cont blue4"
              >{{ $t("store.orderstatus") }}:
              {{
                item.status == 1
                  ? $t("lever.dealing")
                  : item.status == 2
                  ? $t("lever.pingcanging")
                  : item.status == 3
                  ? $t("lever.hasping")
                  : ""
              }}</view
            >
            <view class="item-cont blue4 flex1"
              >{{ $t("new.cretime") }}: {{ item.period.created_time }}</view
            >
          </view>
        </view>

        <view class="not" v-if="historyList.length <= 0">{{
          $t("home.norecord")
        }}</view>
      </view>
    </view>
    <view class="header-left">
      <uni-drawer
        :visible="leftStatus"
        @close="leftStatus = false"
        v-if="list.length > 0"
      >
        <view class="tr mt10 mr10"
          ><uni-icon
            size="30"
            type="arrowthinright"
            @tap="leftStatus = false"
          ></uni-icon
        ></view>
        <view v-if="list.length > 0">
          <scroll-view scroll-y="true" class="scroll-Y">
            <view
              class="bdb_1e"
              v-for="(item, index) in list"
              :key="index"
              v-if="item.open_lever == 1"
            >
              <view
                class="flex between plr10 ptb20"
                :class="
                  quoteCurrencyId == item.quote_currency_id &&
                  baseCurrencyId == item.base_currency_id
                    ? 'bggray'
                    : ''
                "
                @tap="selectCurrency(item)"
              >
                <view class="">
                  <text class="ft14">{{ item.base_currency_code }}</text>
                  <text class="gray7">/{{ item.quote_currency_code }}</text>
                </view>
                <view :class="item.change < 0 ? 'red' : 'green'">{{
                  item.currency_quotation.close || "0.00"
                }}</view>
                <!-- <view :class="item.change < 0 ? 'red' : 'green'">{{ item.currency_quotation.change || '0.00' }}</view> -->
              </view>
            </view>
          </scroll-view>
        </view>
      </uni-drawer>
    </view>
  </view>
</template>

<script>
	import uniDrawer from '@/components/uni-drawer.vue';
	import {mapState} from 'vuex'
	export default {
		components: {
			uniDrawer,
			
		},
		data(){
			return{
			   active:0,
			   balaActive:0,
			   textAc:1,
			   show:false,
			   url:'',
			   list:[],
			   quoteCurrencyId:'',
			   baseCurrencyId:'',
			   baseCurrencyCode:'',
			   quoteCurrencyCode:'',
			   currencyMatchId:'',
			   quotationList:[],
			   leftStatus:false,
			   symbol:'',
			   amountList:[],
			   amount:{},
			   balance:'',
			   timeList:[],
			   timeItem:{},
			   num:0,
			   not:{},
			   limit:10,
			   page:1,
			   historyList:[],
			   working:{},
			   price:0,
			   percent:0,
			   timePer:0,
			   isLoading:false,
			   isScroll:false,
			   total:0
			}
		},
	
		onLoad() {
			
		},
		watch:{
			num(val){
				if(val==2){
					this.getChoosePeriods(0)
					this.getChoosePeriods(1)
				}
			},
			timePer(val){
				console.log(val)
			}
		},
		computed:{
		   ...mapState(['theme']),
		},
		onShow() {
		    this.$utils.setThemeTop(this.theme)
			this.getInit()
			this.getAmount()
			this.getTime()
		},
		created(){
			this.setScroll()
		},
		onHide() {
			this.$socket.closeSocket();
			this.url=''
		},
		methods: {
		
			setShow(index){
			    let obj = this.historyList[index]
				obj.show = obj.show ? false : true
				this.$set(this.historyList,index,obj)
			},
			getcyList(status,bool,push){
				let data={
                    limit:this.limit,
                    page:this.page,
					second_id:this.timeItem.id,
					status:status||1
                }
				this.$utils.initDataToken({ url: 'optionTrade/history',type:'POST',data},(res,msg) => {
					     if(push){
                              for(let key in res.data){
								this.historyList.push(res.data[key])
							  }
						 }else{
							this.historyList=res.data
						 }
						
						 for(let key in this.historyList){
							 this.historyList[key].show=false
						 }
						
						 this.isScroll=true
						 if(this.historyList.length>=res.total){
							this.isScroll=false
						 }
						
					 
				},bool)
			},
			submit(type){
				let that=this
                let data={
					    type:type,
                        match_id:that.not.currency_match_id,
                        currency_id:that.amount.currency_id,
                        period_id:that.not.id,
                        number_id:that.amount.id
				}
				this.$utils.initDataToken({ url: 'optionTrade/submit',type:'POST',data}, (res,msg) => {
				       this.$utils.showLayer(msg)
					   let time = setTimeout(()=>{
							this.page=1
							this.getcyList()
							this.getSupportBalance(this.amount.currency_id)
							clearTimeout(time)
						},1500)
				})
			},
			getChoosePeriods(status,bool){
				console.log(status)
				let data={
					match_id : this.active,
                    sec_id : this.timeItem.id,
                    status:status //0未开始  1运作中
				}
				this.$utils.initDataToken({ url: 'option/getChoosePeriods',type:'POST',data}, res => {
					if(status==0){
						this.not=res
					}else{
						this.working=res
					}
				    
				},bool)
			},
			setTime(val){
			  this.page=1
              this.timeItem=val
			  this.working.start_time=new Date()
			  this.getChoosePeriods(0)
			  this.getChoosePeriods(1)
			  this.getcyList(this.textAc)
			},
			 secondsFormat(s) { 
                var day = Math.floor( s/ (24*3600) ); // Math.floor()向下取整 
                var hour = Math.floor( (s - day*24*3600) / 3600); 
                var minute = Math.floor( (s - day*24*3600 - hour*3600) /60 ); 
                var second = s - day*24*3600 - hour*3600 - minute*60; 
                return day > 0 ? day + '日' : hour > 0 ? hour + '小时' : minute > 0 ? minute + '分钟' :second + '秒'
            },
			 sortTime(a,b){  
                return a.seconds-b.seconds  
            },
			getTime(){
				this.$utils.initDataToken({ url: 'option/getOrderTime',type:'POST' }, res => {
				      this.timeList=res.sort(this.sortTime)
					  this.timeItem=this.timeList[0]
					  this.getcyList()
					  this.num+=1
				})
			},
			getAmount(){
				this.$utils.initDataToken({ url: 'option/getAmount',type:'POST' }, res => {
					this.amountList=res
					this.amount=res[0]
					this.getSupportBalance(res[0].currency_id)

				})
			},
			getSupportBalance(id,bool){
				this.$utils.initDataToken({ url: 'optionTrade/getSupportBalance',type:'POST',data:{currency_id:id} }, res => {
					 this.balance=res.balance
				},bool)
			},
			setLink(){
				let that = this
				that.url=`/hybrid/html/optionc.html?legal_id=${that.quoteCurrencyId}&currency_id=${that.baseCurrencyId}&symbol=${that.baseCurrencyCode + '/' + that.quoteCurrencyCode}&currency_match_id=${that.currencyMatchId}`
			},
			selectCurrency(item){
				let that = this
				that.baseCurrencyId = item.base_currency_id;
				that.baseCurrencyCode = item.base_currency_code;
				that.currencyMatchId = item.id;
				that.symbol=item.symbol
				that.active=item.id
				that.leftStatus=false
				that.setLink()
			
			},
			getList(){
				let that=this
				this.$utils.initData({url:'option/getOptionMatches',type:'POST'},res=>{
				     if(res.length>0){
						that.list=res
						that.active=res[0].id
						that.num+=1
						var list = res.filter(function(item, index) {
							return item.open_lever == 1;
						});
                        console.log(list[0].base_currency_code)
						that.baseCurrencyId = list[0].base_currency_id;
						that.baseCurrencyCode = list[0].base_currency_code;
						that.currencyMatchId = list[0].id;
						that.symbol=list[0].symbol
						that.setLink()
						that.handicap()
					 }
				})
			},
			getInit(){
				let that=this
				that.$utils.initDataToken({ url: 'market/currency_matches' }, res => {
					if(res.length>0){
						var datas = res.filter(function(item, index) {
							return item.is_quote == 1;
						});
						that.quoteCurrencyId = datas[0].id;
						that.quoteCurrencyCode = datas[0].code;
						that.getList()
					}
				})
			},
			setText(val){
				this.page=1
                this.textAc=val
				this.getcyList(val)
			},
			setActive(item){
				let that = this
				that.active=item.id
				that.baseCurrencyId = item.base_currency_id;
				that.baseCurrencyCode = item.base_currency_code;
				that.currencyMatchId = item.id;
				that.symbol=item.symbol
				that.leftStatus=false
				that.setLink()
			},
			setBala(val){
				this.amount=val
			},
			// 盘口socket
			handicap() {
				var that = this;
				var tokens = uni.getStorageSync('token');
				var symbols = that.baseCurrencyCode + '/' + that.quoteCurrencyCode;
				var type = localStorage.getItem('type')
				var datas = {};
				that.$socket.listenFun([{ type: 'login', params: tokens },{type: 'sub',params: 'DAY_MARKET',},{ type: 'sub', params: 'MICRO_CLOSED' },{
                    type: 'sub',
                    params: 'GLOBAL_TX.' + that.symbol,
                  },{
                    type: 'sub',
                    params: 'KLINE.' + that.symbol,
                  }], res => {
					var msg = JSON.parse(res)
                    let type = localStorage.getItem('type')
                    var resmsg = msg
                if (resmsg.type == 'KLINE') {
                  // console.log(resmsg.symbol)
                  if (that.symbol == resmsg.symbol) {
                     let data = resmsg.kline
                    // console.log(JSON.stringify(data))
                    // console.log(type,data.period)
                   if(type == "1hour"){
                      type = "60min"
                   }
                    if (data.period == type) {
						console.log(that.working)
						//当前价格
						that.price=Number(data.close)
						//百分比
						that.percent = ((that.price-that.working.open_price)/that.working.open_price*100).toFixed(4)
                        //时间进度
						let time = new Date().getTime()
						let newTime =new Date(that.working.start_time).getTime()
						
						let t = time - newTime
						that.timePer = parseInt(t/(that.timeItem.seconds*1000)*100)||0
						if(that.timePer>=100){
							that.page=1
							    that.timePer = 100
								that.isLoading=true
								let time = setTimeout(()=>{
									that.isLoading=false
									that.getChoosePeriods(1,true)//1  正在运作
									that.getChoosePeriods(0,true)//0  未开始
									that.getcyList(that.textAc,true)
									that.getSupportBalance(that.amount.currency_id,true)
									clearTimeout(time)
								},3000)
						}
                    }
                  }
                }
				});
			},
			// 获取当前可视范围的高度
			getClientHeight() {
				let clientHeight =
				document.documentElement.clientHeight || document.body.clientHeight
				return clientHeight
			},
			// 获取文档完整的高度
			getScrollHeight() {
				let scrollHeight =
				document.documentElement.scrollHeight || document.body.scrollHeight
				return scrollHeight
			},
			// 获取滚动条当前的位置
			getScrollTop() {
				let scrollTop =
				document.documentElement.scrollTop || document.body.scrollTop
				return scrollTop
			}, 
             // 添加上拉事件触发
			setScroll() {
				//距离底部50px触发上拉事件
				
				window.onscroll = () => {
					
				if (
					this.getScrollTop() + this.getClientHeight() ===
					this.getScrollHeight() &&
					this.isScroll
				) {
				
					// 发起ajax请求
					 this.page++
					 this.getcyList(this.textAc,false,true)
					// this.getList(this.active)
				}
				}
			},
 		},
	
	}
</script>

<style lang="scss" scoped>
.ww {
  width: 92% !important;
  margin: 0 auto;
  color: #fff;
}
.optionc {
  padding-top: 20upx;
  background: #131f30 !important;
}
.header {
  width: 100%;
  height: 72upx;
  border: 1px solid #626262;
  border-radius: 10upx;
  display: flex;
  align-items: center;
  overflow: auto;
}
.header::-webkit-scrollbar {
  /*滚动条整体样式*/
  width: 0; /*高宽分别对应横竖滚动条的尺寸*/
  height: 0;
}
.header .item {
  min-width: 33.33%;
  text-align: center;
}
.header .item .text {
  display: inline-block;
  border-radius: 10upx;
  height: 64upx;
  line-height: 64upx;
  font-size: 26upx;
  padding: 0 10upx;
}
.active {
  background: #3f4b57;
  color: #fff !important;
}
.select {
  margin-top: 30upx;
  display: flex;
  align-items: center;
}
.select .text {
  font-size: 32upx;
  color: #fff;
}
.select-icon {
  margin-right: 20upx;
}
.tarningview {
  height: 700upx;
}
.balance {
  font-size: 24upx;
  text-align: right;
  margin-top: 20upx;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}
.shw {
  color: #b0b8db;
}
.balance .bala-img {
  width: 40upx;
  height: 40upx;
}
.number {
  display: flex;
  overflow: auto;
  margin-top: 30upx;
}
.number::-webkit-scrollbar {
  /*滚动条整体样式*/
  width: 0; /*高宽分别对应横竖滚动条的尺寸*/
  height: 0;
}
.items {
  border: 1px solid #3f4b57;
  color: #fff;
  min-width: 22%;
  height: 70upx;
  line-height: 70upx;
  text-align: center;
  margin-right: 4%;
  border-radius: 15upx;
}
.btn {
  display: flex;
  justify-content: space-between;
  margin-top: 22upx;
}
.btn button {
  width: 48%;
  height: 84upx;
  line-height: 84upx;
  border-radius: 4upx;
  font-size: 24upx;
  color: #fff;
}
.btn .buy {
  background: #00ab86;
}
.btn .cell {
  background: #e95463;
}
.zhang {
  color: #00ab86;
}
.die {
  color: #e95463;
}
.tabs {
  margin-top: 51upx;
}
.tab-text {
  display: flex;
}
.tab-text .tab-item {
  margin-right: 40upx;
  border-bottom: 4upx solid transparent;
  padding: 0 10upx 15upx;
  font-size: 28upx;
}
.tab-item.active {
  background: none;
  color: #4fe6ff !important;
  border-bottom: 6upx solid #4fe6ff;
}
.lishi .head {
  padding: 32upx 0 22upx;
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid #838b99;
}
.item-text {
  width: max-content;
}
.flex15 {
  width: 34%;
}
.item-head {
  display: flex;
  justify-content: space-between;
  height: 80upx;
  align-items: center;
}
.iconb {
  display: inline-block;
  border-top: 12upx solid #838b99;
  border-bottom: 12upx solid transparent;
  border-left: 12upx solid transparent;
  border-right: 12upx solid transparent;
  margin-left: 10upx;
  position: relative;
  top: 10upx;
}
.icont {
  display: inline-block;
  border-top: 12upx solid transparent;
  border-bottom: 12upx solid #838b99;
  border-left: 12upx solid transparent;
  border-right: 12upx solid transparent;
  margin-left: 10upx;
  position: relative;
}
.item-content {
  background: #22252c;
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  border-radius: 10upx;
  padding: 10px 20upx;
}
.item-cont {
  line-height: 40upx;
}
.flex1 {
  min-width: 100%;
}
.min {
  padding-left: 10upx;
}
.tarningview {
  position: relative;
  margin-top: 30upx;
}
.item-text {
  width: 20%;
  text-align: right;
}
.flex15 {
  width: 40%;
  text-align: left;
}
.left {
  text-align: center !important;
}
.bet {
  display: flex;
  justify-content: flex-end;
}
.webview {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}
.not {
  padding: 40upx 0;
  text-align: center;
  color: #999;
}
.gress {
  display: flex;
  align-items: center;
  padding: 20upx 0 10upx;
  color: #fff;
}
.gress .text {
  flex: 1;
}
.gress .progress {
  flex: 1;
}
.gress >>> .uni-progress-info {
  font-size: 24upx !important;
}
.pan {
}
.price {
  padding-left: 10upx;
}
.price.ac {
  color: #4fe6ff !important;
}
.mtborder {
  margin-top: 20upx;
  padding-top: 20upx;
  border-top: 1px solid #838b99;
}
.cont {
  position: relative;
}
.cont .loading {
  position: absolute;
  z-index: 100;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 32upx;
}
</style>
