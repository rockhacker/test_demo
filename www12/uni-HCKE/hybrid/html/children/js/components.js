
Vue.component('page-footer',{
    data(){
        return {
            show:true,
            num:0,
            currencyList:[],
            openTimeList:[],
            currencyItem:{},
            microItem:{},
            openTimeTtem:{},
            type:'',
            isSubmit:true,
            isPopup:false,
            show:false,
            toastShow:false,
            isNumber:false,
            lang:'',
            isShownum:false,
            text:'',
            transwords: {
                zh: {
                    tranMode:'交易模式',
                    numOpen:'开仓数量',
                    openTime:'开仓时间',
                    Profitability:'盈利率',
                    buy:'买涨',
                    sell:'买跌',
                    quantity:'数量',
                    time:'时间',
                    cancel:'取消',
                    determine:'确定',
                    ordered:'下单成功',
                    income:'盈利率',
                    openNumber:'缺少开仓数量',
                    contract:'秒合约账户',
                    seleteNum:'请输入或选择开仓数量',
                    tian:'天',
                    shi:'小时',
                    fenz:'分钟',
                    miao:'秒',
                    p_login:'请登录',
                },
                en: {
                    tranMode:'Transaction mode',
                    numOpen:'Number of positions opened',
                    openTime:'Opening time',
                    Profitability:'Profitability',
                    buy:'Buy up',
                    sell:'Buy or fall',
                    quantity:'Quantity',
                    time:'time',
                    cancel:'cancel',
                    determine:'determine',
                    ordered:'successfully ordered',
                    income:'income',
                    openNumber:'The number of open positions is missing',
                    contract:'Contract account',
                    seleteNum:'Please enter or select the opening quantity',
                    tian:'day',
                    shi:'hour',
                    fenz:'minute',
                    miao:'second',
                    p_login:'Please log in',
                },
                hk: {
                    tranMode:'交易模式',
                    numOpen:'開倉數量',
                    openTime:'開倉時間',
                    Profitability:'盈利率',
                    buy:'買漲',
                    sell:'買跌',
                    quantity:'數量',
                    time:'時間',
                    cancel:'取消',
                    determine:'確定',
                    ordered:'下單成功',
                    income:'盈利率',
                    openNumber:'缺少開倉數量',
                    contract:'秒合約賬戶',
                    seleteNum:'請輸入或選擇開倉數量',
                    tian:'天',
                    shi:'小時',
                    fenz:'分鐘',
                    miao:'秒',
                    p_login: '請登入',
                },
                jp: {
                    tranMode:'トランザクションモード',
                    numOpen:'オープンしたポジションの数',
                    openTime:'開始時間',
                    Profitability:'収益性',
                    buy:'買い占めます',
                    sell:'購入する',
                    quantity:'数量',
                    time:'時間',
                    cancel:'キャンセル',
                    determine:'決定する',
                    ordered:'正常に注文されました',
                    income:'収益性',
                    openNumber:'オープンポジションの数が不足しています',
                    contract:'秒契約アカウント',
                    seleteNum:'開始数量を入力または選択してください',
                    tian:'日',
                    shi:'時間',
                    fenz:'分',
                    miao:'秒',
                    p_login:'ログインしてください',
                },
                kr: {
                    tranMode:'거래 모드',
                    numOpen:'개설 된 포지션 수',
                    openTime:'영업 시간',
                    Profitability:'수익성',
                    buy:'구매',
                    sell:'구매 또는 판매',
                    quantity:'수량',
                    time:'시각',
                    cancel:'취소',
                    determine:'결정',
                    ordered:'성공적으로 주문',
                    income:'수익성',
                    openNumber:'오픈 포지션 수가 누락되었습니다',
                    contract:'두 번째 계약 계정',
                    seleteNum:'개시 수량을 입력하거나 선택하십시오',
                    tian:'일',
                    shi:'시',
                    fenz:'분',
                    miao:'둘째',
                    p_login:'로그인 해주세요',
                },
                th: {
                    tranMode:'โหมดการทำธุรกรรม',
                    numOpen:'จำนวนตำแหน่งที่เปิด',
                    openTime:'เปิดเวลา',
                    Profitability:'การทำกำไร',
                    buy:'ซื้อ',
                    sell:'ซื้อหรือขาย',
                    quantity:'ปริมาณ',
                    time:'เวลา',
                    cancel:'ยกเลิก',
                    determine:'กำหนด',
                    ordered:'สั่งซื้อเรียบร้อยแล้ว',
                    income:'การทำกำไร',
                    openNumber:'จำนวนตำแหน่งที่เปิดหายไป',
                    contract:'บัญชีสัญญาที่สอง',
                    seleteNum:'โปรดป้อนหรือเลือกปริมาณการเปิด',
                    tian:'วัน',
                    shi:'ชั่วโมง',
                    fenz:'นาที',
                    miao:'วินาที',
                    p_login:'กรุณาเข้าสู่ระบบ',
                },
                vn: {
                    tranMode:'Chế độ giao dịch',
                    numOpen:'Số lượng vị trí đã mở',
                    openTime:'Giờ mở cửa',
                    Profitability:'Khả năng sinh lời',
                    buy:'Mua lên',
                    sell:'Mua hoặc bán',
                    quantity:'Định lượng',
                    time:'thời gian',
                    cancel:'hủy bỏ',
                    determine:'mục đích',
                    ordered:'đặt hàng thành công',
                    income:'Khả năng sinh lời',
                    openNumber:'Số lượng vị trí mở bị thiếu',
                    contract:'Tài khoản hợp đồng thứ hai',
                    seleteNum:'Vui lòng nhập hoặc chọn số lượng mở',
                    tian:'ngày',
                    shi:'giờ',
                    fenz:'phút',
                    miao:'thứ hai',
                    p_login:'Vui lòng hãy đăng nhập',
                },
                ar: {
                    tranMode:'وضع المعاملة',
                    numOpen:'عدد المراكز المفتوحة',
                    openTime:'وقت متاح',
                    Profitability:'الربحية',
                    buy:'يشتري',
                    sell:'شراء أو بيع',
                    quantity:'كمية',
                    time:'الوقت',
                    cancel:'إلغاء',
                    determine:'تحديد',
                    ordered:'أمرت بنجاح',
                    income:'الربحية',
                    openNumber:'عدد المناصب المفتوحة مفقود',
                    contract:'حساب العقد الثاني',
                    seleteNum:'الرجاء إدخال أو تحديد الكمية الافتتاحية',
                    tian:'يوم',
                    shi:'ساعة',
                    fenz:'دقيقة',
                    miao:'ثانيا',
                    p_login:'الرجاء تسجيل الدخول',
                },
				it: {
				    tranMode:'Modalità di transazione',
				    numOpen:'Numero di posizioni aperte',
				    openTime:'Orario di apertura',
				    Profitability:'Redditività',
				    buy:'Acquista',
				    sell:'Compra o cadi',
				    quantity:'Quantità',
				    time:'Tempo',
				    cancel:'Annulla',
				    determine:'determinare',
				    ordered:'ordinato con successo',
				    income:'Redditività',
				    openNumber:'Manca il numero di posizioni aperte',
				    contract:'Secondo contratto di conto',
				    seleteNum:'Si prega di inserire o selezionare la quantità di posizioni aperte',
				    tian:'giorno',
				    shi:'ora',
				    fenz:'minuto',
				    miao:'secondo',
            p_login:'Accendere',
				},
				// de: {
				//     tranMode:'Transaktionsmodus',
				//     numOpen:'Anzahl der geöffneten Positionen',
				//     openTime:'Öffnungszeit',
				//     Profitability:'Rentabilität',
				//     buy:'Aufkaufen',
				//     sell:'Kaufen oder fallen',
				//     quantity:'Menge',
				//     time:'Zeit',
				//     cancel:'stornieren',
				//     determine:'bestimmen',
				//     ordered:'erfolgreich bestellt',
				//     income:'Rentabilität',
				//     openNumber:'Die Anzahl der offenen Stellen fehlt',
				//     contract:'Zweites Vertragskonto',
				//     seleteNum:'Bitte geben Sie die Anzahl der offenen Positionen ein oder wählen Sie sie aus',
				//     tian:'Tag',
				//     shi:'Stunde',
				//     fenz:'Minute',
				//     miao:'zweite'
				// },
				de: {
				    tranMode:'Mode de transaction',
				    numOpen:'Nombre de postes ouverts',
				    openTime:"Horaire d'ouverture",
				    Profitability:'Rentabilité',
				    buy:'Acheter',
				    sell:'Acheter ou tomber',
				    quantity:'Quantité',
				    time:'Temps',
				    cancel:'Annuler',
				    determine:'déterminer',
				    ordered:'commandé avec succès',
				    income:'Rentabilité',
				    openNumber:'Le nombre de postes ouverts est manquant',
				    contract:'Deuxième compte de contrat',
				    seleteNum:'Veuillez saisir ou sélectionner la quantité de position ouverte',
				    tian:'Journée',
				    shi:'Heure',
				    fenz:'Minute',
				    miao:'Deuxième',
            p_login:'einloggen',
				},
            },
            token:''
        }
    },
    computed:{
        balance(){
			//console.log(this.currencyItem.micro_account.balance)
            let num=this.currencyItem.micro_account ? this.currencyItem.micro_account.balance : 0
            if(num<=0){
                return num
            }else{
                return parseFloat(num)
            }
        }
    },
		props: ['by','currency_id'],
	watch:{
		by(val){
			console.log(val)
			this.getCurrency()
			
		}
	},
    methods:{
        secondsFormat(s) { 
            var day = Math.floor( s/ (24*3600) ); // Math.floor()向下取整 
            var hour = Math.floor( (s - day*24*3600) / 3600); 
            var minute = Math.floor( (s - day*24*3600 - hour*3600) /60 ); 
            var second = s - day*24*3600 - hour*3600 - minute*60; 
            return day > 0 ? day + this.transwords[this.lang].tian : hour > 0 ? hour + this.transwords[this.lang].shi : minute > 0 ? minute + this.transwords[this.lang].fenz :second + this.transwords[this.lang].miao
         },
        hideBtn(){},
        getOpenTime(){
            initDataToken(
                 {
                 url: 'microtrade/seconds'
                 },
                 res=>{
                    if(res.length>0){
                         this.openTimeList=res;
                         this.openTimeTtem=this.openTimeList[0]
                    }
                 }
            )
        },
        getCurrency(){
          if (window.plus) {
            if (!plus.storage.getItem('token')) {
              return
            }
          } else {
            if (
              !localStorage.getItem('token')
            ) {
             return
            }
          }
                initDataToken(
                    {
                    url: 'microtrade/payable_currencies'
                    },
                    res=>{
                        if(res.length>0){
							console.log(res)
                            this.currencyList=res
                            const index = this.currencyList.findIndex(item=>item.id == this.currency_id) || 0
                            this.currencyItem=this.currencyList[index]
							this.setMicroItem(this.currencyItem.micro_numbers[0])
                            this.microItem=this.currencyList[index].micro_numbers[0]
                        }
                    }
                )
        },
        setCurrency(val){
            this.currencyItem=val
			this.setMicroItem(this.currencyItem.micro_numbers[0])
            if(val.micro_numbers.length<1){
                this.microItem={}
            }else{
                let obj=this.microItem||{}
                for(let key in val.micro_numbers){
                    if(val.micro_numbers[key].number==obj.number){
                        this.microItem=val.micro_numbers[key]||{}
                    }else{
                        this.microItem=val.micro_numbers[0]
                    }
                }
            }
        },
        setMicroItem(val){
			    console.log(val)
                this.microItem=val
                this.num=parseFloat(val.number)
                this.isShownum=false
        },
        setTimeTtem(val){
            console.log(val)
                    this.openTimeTtem=val
        },
        submit(val){
          if(!this.token){
                 uni.navigateTo({
                  url: '/pages/mine/login',
                })
                return
          }
            if(this.num<=0){
                this.text=this.transwords[this.lang].seleteNum
                this.toastShow=true
                setTimeout(()=>{
                    this.toastShow=false
                },2000)
                return
            }
            this.type=val
           // this.isPopup=true
            this.determine()
        },
        determine () {
           
                this.show=true
                let obj=get_all_params()
                  initDataToken(
                        {
                        url: 'microtrade/submit',
                        type:'post',
                        data:{
                            type:this.type=='buy' ? 1 : 2,
                            currency_id: this.currencyItem.id,
                            match_id: obj.currency_match_id,
                            number: this.num,
                            seconds: this.openTimeTtem.seconds
                        }
                        },
                        res=>{
                            this.show=false
                            if(res!=-1){
                                    console.log(111)
							                    	this.getCurrency()
                                    this.text=this.transwords[this.lang].ordered
                                    this.isPopup=false
                                    this.toastShow=true
                                    setTimeout(()=>{
                                    this.toastShow=false
                                    },2000)
                                    this.$emit('welcome')
                            }
                        }
                    )
            
           
        }
    },
    created(){
        this.getCurrency()
        this.getOpenTime()
        let that = this;
        if (window.plus) {
            that.lang = plus.storage.getItem('lang') || 'zh';
            that.token = plus.storage.getItem('token');
        } else {
            that.lang = localStorage.getItem('lang') || 'zh';
            that.token = localStorage.getItem('token');
        }

        if(!this.transwords[this.lang]){
          this.lang = 'en'
        }
    },
    template:`  <div  class="footer" v-cloak>
                        <!--<div class="overlay" @click="isSubmit=false" v-show="isSubmit"></div>-->
                        <div class="children dark:children">
                            <div v-show="isSubmit" class="sub-select">
                               <!-- <div class="icon-text">
                                        <img src="children/image/btn-active.png" alt="">
                                        <span>{{transwords[lang].openTime}}</span>
                                </div>-->
                                <div class="footer-btn time slide-box">
                                    <div class="btn-item slide-item dark:btn-item" :class="item.seconds==openTimeTtem.seconds?'active':''" v-for="(item,index) in openTimeList" :key="index" @click="setTimeTtem(item)">
                                        <span class="max">{{item.seconds}}{{transwords[lang].miao}}</span><span class="min"></span>
                                        <img v-show="item.seconds==openTimeTtem.seconds" class="icon" src="children/image/icon.png" alt="" >
                                        <p>{{transwords[lang].income}}{{item.profit_ratio*100}}%</p>
                                    </div>
                                </div>
                                <div class="icon-text">
                                    <!--<img src="children/image/btn-active.png" alt="">-->
                                    <span @click="isNumber=false">{{transwords[lang].tranMode}}</span>
                                    <!--<img src="children/image/btn-active.png" alt="">-->
                                </div>
                                <div class="footer-btn slide-box" >
                                    <div v-show="item.id == currency_id" class="btn-item slide-item dark:btn-item" :class="item.code==currencyItem.code?'active':''" v-for="(item,index) in currencyList" :key="index">
                                            <span>{{item.code}}</span>
                                            <img v-show="item.code==currencyItem.code" class="icon" src="children/image/icon.png" alt="" >
                                    </div>
                                </div>    
                                <div class="icon-text">
                                    <!--<img src="children/image/btn-active.png" alt="">-->
                                  
                                    <!--<img src="children/image/btn-active.png" alt="">-->
                                    <span @click="isNumber=true" >{{transwords[lang].numOpen}}</span>
                                </div>      
                                <div class="foot-btn" >
									<div class="numinput dark:numinput">
                                        <input class="flex1" type="number" placeholder="" v-model="num">
										<div class="sel-all flex alcenter jscenter" @click="isShownum=true">
											<img src="children/image/trade_arrow_down.png" class="move">
										</div>
                                        <!--<div class="btn-item slide-item" :class="item.id==microItem.id?'active':''" v-for="(item,index) in currencyItem.micro_numbers" :key="index" @click="setMicroItem(item)">
                                            <span>{{parseFloat(item.number)}}</span>
                                            <img v-show="item.id==microItem.id" class="icon" src="children/image/icon.png" alt="" >
                                        </div>-->
									</div>
                                </div>
								<div class="foot-btn balance"> 
								    <div class="text">
								        <img src="../../static/image/moy.png" alt="">
								        <span>{{transwords[lang].contract}}</span>
								    </div>
								    <div>
								        <span>{{balance}}</span>
								        <span>{{currencyItem.code}}</span>
								    </div>
								</div> 
                                <!--<div class="percentage"> 
                                        <div class="text">
                                                <img src="children/image/logo.png" alt="">
                                                <span>{{transwords[lang].Profitability}}</span>
                                        </div>
                                        <span class="percent">{{openTimeTtem.profit_ratio*100}}%</span>
                                </div>-->
                                </div>
								
								<div class="foot-btn">
								    <div class="sub-btn">
								        <button v-if="token" class="bottom" @click="submit('sell')">{{transwords[lang].sell}}</button>
								        <button v-if="token" class="top" @click="submit('buy')">{{transwords[lang].buy}}</button>
                        <button class="top"  style="width:100%;" @click="submit()" v-if="!token">{{transwords[lang].p_login}}</button>
								    </div>
								</div>
                            </div>  
                            <div class="popup" v-show="isPopup"> 
                                <div class="popup-item">
                                    <div class="popup-title">
                                            <span>{{type=='buy' ? transwords[lang].buy : transwords[lang].sell}}</span>
                                            <img src="../../static/image/plus.png" alt="" @click="()=>{isPopup=false;show=false}">
                                    </div>
                                    <div class="popup-content">
                                            <div>
                                                <span>{{transwords[lang].quantity}}</span> 
                                                <span>{{num}}</span>
                                            </div>
                                            <div>
                                                <span>{{transwords[lang].time}}</span>
                                                <span>{{secondsFormat(openTimeTtem.seconds)}}</span>
                                            </div>
                                            <div>
                                                <span>{{transwords[lang].Profitability}}</span>
                                                <span>{{openTimeTtem.profit_ratio*100}}%</span>
                                            </div>
                                    </div>
                                    <div class="popup-footer">
                                            <button @click="()=>{isPopup=false;show=false}">{{transwords[lang].cancel}}</button>
                                            <button>
                                              <span v-if="!show" @click="determine">{{transwords[lang].determine}}</span>
                                              <img  v-else src="children/image/loading.gif" alt="">
                                            </button>
                                            
                                    </div>
                                </div>
                             </div>  
                             <div class="bt-popup" v-show="isShownum">
                                 <div class="items">
                                      <p v-for="(item,index) in currencyItem.micro_numbers" :key="index" @click="setMicroItem(item)">{{parseFloat(item.number)}}</p>
                                      
                                      <p class="coni" @click="isShownum=false">{{transwords[lang].cancel}}</p>
                                 </div>
                                 <div class="zhou"></div>
                             </div>
                             <transition name="fade">
                                 <div class="toast" v-if="toastShow">
                                    <div>
                                        <span>{{text}}</span>
                                    </div>
                                </div>
                             </transition>
                             <img v-if="show" class="loadings"  src="children/image/loading.gif" alt="">
                        </div>      
                        
                </div>`
})




Vue.component('page-list',{
    props:['showe'],
    watch:{
        showe(val){
            console.log(val)
            this.list=[]
            this.getList()
        },
        // close(val){
        //   let that=this
        //   let data= val
        //   if (data.type == 'MICRO_CLOSED') {
        //     for (let i = 0; i < that.list.length; i++) {
        //       if (that.list[i].id == data.order.id) {
        //         that.list[i] = data.order
        //         setTimeout(function () {
        //           let arr = that.list
        //           arr.splice(i, 1)
        //           that.list = arr
        //         }, 500)
        //         return false
        //       }
        //     }
        //   }
        //   //计算预计盈亏
        
        //   for (var i = 0; i < that.list.length; i++) {
        //     let buy = that.list[i].open_price //购买价
        //     let current = that.price //当前价
        //     if (current > buy) {
        //       that.list[i].ploss =
        //         that.list[i].number * that.list[i].profit_ratio
        //     } else if (current < buy) {
        //       that.list[i].ploss = that.list[i].number * -1
        //     } else {
        //       that.list[i].ploss = 0
        //     }
        //   }
         
        // }
    },
     filters: {
        tofixedFour: function (val) {
          if (val >= 0) {
            val = val.toFixed(4)
          } else if (val < 0) {
            val = '-' + (val * -1).toFixed(4)
          }
          return val
        },
      },
    data(){
        return {
            token:"",
            active: 1,
            isWs: true,
            list: [],
            show: false,
            set: null,
			websockUrl: `wss://${_DOMAIN.replace(/^https?\:\/\//i, "")}/ws`,
            socket: '',
            heartbeat: null,
            currentIndex: 0,
            currencyList: [],
            currencyObj: {},
            price: '',
            lang: '',
            symbol: '',
            isScroll: true,
            pageSize: {
              limit: 10,
              page: 1,
            },
            transwords: {
              zh: {
                order: '交易订单',
                inTransaction: '交易中',
                closed: '已平仓',
                quantity: '数量',
                puprice: '购买价',
                cuPrice: '当前价',
                profitLoss: '预计盈亏',
                Countdown: '倒计时',
                fiprice: '成交价',
                fee: '手续费',
                loss: '盈亏',
                loading: '正在加载...',
                nodata: '暂无数据',
                noMore: '没有更多了',
                tian:'天',
                shi:'小时',
                fenz:'分钟',
                miao:'秒'
              },
              en: {
                order: 'Trading order',
                inTransaction: 'In transaction',
                closed: 'Closed position',
                quantity: 'Quantity',
                puprice: 'Purchase Price',
                cuPrice: 'Current price',
                profitLoss: 'Expected profit and loss',
                Countdown: 'Countdown',
                fiprice: 'Transaction price',
                fee: 'Handling fee',
                loss: 'Profit and loss',
                loading: 'Loading...',
                nodata: 'No data',
                noMore: 'No more',
                tian:'day',
                shi:'hour',
                fenz:'minute',
                miao:'second'
              },
              hk: {
                order: '交易訂單',
                inTransaction: '交易中',
                closed: '已平倉',
                quantity: '數量',
                puprice: '購買價',
                cuPrice: '當前價',
                profitLoss: '預計盈虧',
                Countdown: '倒計時',
                fiprice: '成交價',
                fee: '手續費',
                loss: '盈虧',
                loading: '正在加載...',
                nodata: '暫無數據',
                noMore: '沒有更多了',
                tian:'天',
                shi:'小時',
                fenz:'分鐘',
                miao:'秒'
              },
              jp: {
                order: '取引順序',
                inTransaction: 'トランザクション中',
                closed: '閉まっている',
                quantity: '数量',
                puprice: '購入金額',
                cuPrice: '現在の価格',
                profitLoss: '推定損益',
                Countdown: '秒読み',
                fiprice: '最終価格',
                fee: '手数料',
                loss: '利益と損失',
                loading: '読み込み中...',
                nodata: 'データなし',
                noMore: 'もういや',
                tian:'日',
                shi:'時間',
                fenz:'分',
                miao:'秒'
              },
              kr: {
                order : '거래 주문',
                 inTransaction : '거래 중',
                 closed : '폐쇄 포지션',
                 quantity : '수량',
                 puprice : '구매 가격',
                 cuPrice : '현재 가격',
                 profitLoss : '예상 손익',
                 Countdown : '카운트 다운',
                 fiprice : '거래 가격',
                 fee : '취급 수수료',
                 loss : '이익과 손실',
                 loading : '로드 중 ...',
                 nodata : '일시적으로 데이터 없음',
                 noMore : '더 이상',
                tian:'일',
                shi:'시',
                fenz:'분',
                miao:'둘째'
              },
              vn: {
                order: 'Lệnh giao dịch',
                inTransaction: 'trong giao dịch',
                closed: 'Đã đóng cửa',
                quantity: 'Định lượng',
                puprice: 'Giá mua',
                cuPrice: 'Giá hiện tại',
                profitLoss: 'Lợi nhuận và lỗ ước tính',
                Countdown: 'Đếm ngược',
                fiprice: 'giá niêm yết',
                fee: 'Phí xử lý',
                loss: 'Lợi nhuận và thua lỗ',
                loading: 'Đang tải...',
                nodata: 'Không có dữ liệu',
                noMore: 'Không còn nữa',
                tian:'ngày',
                shi:'giờ',
                fenz:'phút',
                miao:'thứ hai'
              },
			  fr: {
			    order: 'Ordres',
			    inTransaction: 'en transaction',
			    closed: 'Fermé',
			    quantity: 'Quantité',
			    puprice: "Prix ​​d'achat",
			    cuPrice: 'Prix ​​actuel',
			    profitLoss: 'Profits et pertes estimés',
			    Countdown: 'Compte à rebours',
			    fiprice: 'prix final',
			    fee: 'Frais de gestion',
			    loss: 'Profit et perte',
			    loading: 'Chargement en cours...',
			    nodata: 'Pas de données',
			    noMore: 'Pas plus',
			    tian:'journée',
			    shi:'heure',
			    fenz:'minute',
			    miao:'deuxième'
			  },
			  de: {
			    order: 'Transaktionsauftrag',
			    inTransaction: 'in transaktion',
			    closed: 'Geschlossen',
			    quantity: 'Menge',
			    puprice: 'Kaufpreis',
			    cuPrice: 'Derzeitiger Preis',
			    profitLoss: 'Geschätzter Gewinn und Verlust',
			    Countdown: 'Countdown',
			    fiprice: 'Endgültiger Preis',
			    fee: 'Bearbeitungsgebühr',
			    loss: 'Gewinn-und Verlust',
			    loading: 'Wird geladen...',
			    nodata: 'Keine Daten',
			    noMore: 'Nicht mehr',
			    tian:'Tag',
			    shi:'Stunde',
			    fenz:'Minute',
			    miao:'zweite'
			  },
			  it: {
			    order: 'Ordine di transazione',
			    inTransaction: 'in transazione',
			    closed: 'Chiuso',
			    quantity: 'Quantità',
			    puprice: "Prezzo d'acquisto",
			    cuPrice: 'Prezzo attuale',
			    profitLoss: 'Profitti',
			    Countdown: 'Conto alla rovescia',
			    fiprice: 'prezzo finale',
			    fee: 'Commissione di gestione',
			    loss: 'Profitti e perdite',
			    loading: 'Caricamento in corso...',
			    nodata: 'Nessun dato',
			    noMore: 'Non piu',
			    tian:'giorno',
			    shi:'ora',
			    fenz:'minuto',
			    miao:'secondo'
			  },
			  th:{
				"order": "คำสั่งซื้อขาย",
				"inTransaction": "การแลกเปลี่ยน",
				"closed": "ตำแหน่งปิด",
				"quantity": "จำนวนรวม",
				"puprice": "ราคาซื้อ",
				"cuPrice": "ราคาปัจจุบัน",
				"profitLoss": "กำไรและขาดทุน",
				"Countdown": "การนับถอยหลัง",
				"fiprice": "ราคาธุรกรรม",
				"fee": "ค่าธรรมเนียม",
				"loss": "ขาดทุน",
				"loading": "โหลดคำแปล",
				"nodata": "ไม่มีข้อมูล",
				"noMore": "ไม่อีกต่อไป",
				"tian": "กลางวัน",
				"shi": "ชั่วโมง",
				"fenz": "นาที",
				"miao": "วินาที"
			}
            }
        
          }
    },
    computed:{
       
    },
    methods:{
      secondsFormat(s) { 
        var day = Math.floor( s/ (24*3600) ); // Math.floor()向下取整 
        var hour = Math.floor( (s - day*24*3600) / 3600); 
        var minute = Math.floor( (s - day*24*3600 - hour*3600) /60 ); 
        var second = s - day*24*3600 - hour*3600 - minute*60; 
        let d = day > 0 ? day + this.transwords[this.lang].tian :'';
        let h = hour > 0 ? hour + this.transwords[this.lang].shi:'';
        let m = minute > 0 ? minute + this.transwords[this.lang].fenz : '';
        let se = second >= 0 ? second + this.transwords[this.lang].miao : '';
        return  d + h + m + se
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
            console.log('上拉加载了')
            // 发起ajax请求
            this.pageSize.page++
            this.getList(this.active)
          }
        }
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
      goback() {
        if (this.socket) {
          this.socket.close()
        }

        if (window.plus) {
          uni.navigateBack({
            delta: 1,
          })
          console.log(111111)
        } else {
          history.back(-1)
          console.log(222222)
        }
      },
      setActive(val) {
        this.pageSize.page = 1
        this.isScroll = true
        this.list = []
        this.active = val
        this.getList(val)
      },
      getList(val) {
        if (window.plus) {
          if (!plus.storage.getItem('token')) {
            return
          }
        } else {
          if (
            !localStorage.getItem('token')
          ) {
           return
          }
        }
        if (this.set != null) {
          clearInterval(this.set)
        }
        this.show = false
        let obj = get_all_params()
        this.symbol = obj.symbol
        initDataToken(
          {
            url: 'microtrade/lists',
            data: {
              match_id: obj.currency_match_id,
              status: val || 1, //为1 交易中  为3 已平仓  默认为交易中
              ...this.pageSize,
            },
          },
          (res) => {
            this.show = true
            for (var i = 0; i < res.data.length; i++) {
              res.data[i].remain_milli_seconds = parseInt(
                Number(res.data[i].remain_milli_seconds) / 1000
              )
              this.list.push(res.data[i])
            }
            if (this.list.length >= res.total) {
              console.log(this.list.length)
              console.log(res.total)
              this.isScroll = false
            }
            this.set = setInterval(() => {
              for (let i = 0; i < res.data.length; i++) {
                if (res.data[i].remain_milli_seconds <=0) {
                  res.data[i].remain_milli_seconds = 0
                } else {
                  res.data[i].remain_milli_seconds--
                }
              }
            }, 1000)

            if (this.active == 1 && this.list.length > 0 && this.isWs) {
              this.getData()
              this.isWs = false
            }
          }
        )
      },
      //获取币种
      getCurrency() {
        initDataToken(
          {
            url: 'market/currency_matches',
          },
          (res) => {
            this.currencyList = res.filter(
              (item) => item.is_quote == 1 && item.code == 'USDT'
            )
          }
        )
      },
      //ws socket
      getData() {
        let that = this
        let tokens = null
        that.socket = new WebSocket(that.websockUrl)
        let socket = that.socket

        if (window.plus) {
          tokens = plus.storage.getItem('token')
        } else {
          tokens = localStorage.getItem('token')
        }
        let data = [
          { type: 'login', params: tokens },
          { type: 'sub', params: 'DAY_MARKET' },
          { type: 'sub', params: 'MICRO_CLOSED' },
          { type: 'sub', params: 'GLOBAL_TX.' + that.symbol },
        ]
        socket.onopen = function () {
          console.log('socket已连接')
          //清除定时器
          clearInterval(this.heartbeat)

          //send参数
          for (let key in data) {
            socket.send(JSON.stringify(data[key]))
          }

          //发送心跳

          socket.send('ping')
          this.heartbeat = setInterval(() => {
            socket.send('ping')
          }, 5000)
        }
        socket.onmessage = function (msg) {
          let data = JSON.parse(msg.data)
          if (that.currencyList.length > 0) {
            if (data.type == 'GLOBAL_TX') {
              console.log(data.completes[0].price)
              that.price = data.completes[0].price
            }
            //获取当前币种实时价格
            //     let datas = that.currencyList[that.currentIndex].matches;
            //     datas.forEach((item, index) => {
            //         if (item.currency_quotation.currency_match_id == data.currency_match_id) {
            //         that.currencyList[that.currentIndex].matches[
            //             index
            //         ].currency_quotation.change = data.quotation.change;
            //         that.currencyList[that.currentIndex].matches[
            //             index
            //         ].currency_quotation.close = data.quotation.close;
            //         }
            //     });
            //     //判断页面显示当前那种币种
            //    let currencys=that.currencyList[that.currentIndex].matches
            //    let parmas =get_all_params()
            //    for(let key in currencys){
            //         if(currencys[key].id==parmas.currency_match_id){
            //             that.currencyObj=currencys[key].currency_quotation
            //         }
            //    }
          }

          if (data.type == 'MICRO_CLOSED') {
            for (let i = 0; i < that.list.length; i++) {
              if (that.list[i].id == data.order.id) {
				  console.log(data)
                that.list[i] = data.order
                setTimeout(function () {
                  let arr = that.list
                  arr.splice(i, 1)
                  that.list = arr
				  that.$emit('getby')
                }, 500)
                return false
              }
            }
          }
          //计算预计盈亏
          for (var i = 0; i < that.list.length; i++) {
            let buy = that.list[i].open_price //购买价
            let current = that.price //当前价
			if(that.list[i].type==1){
			
				if(current > buy){
					that.list[i].ploss = that.list[i].number * that.list[i].profit_ratio
				}else if(current < buy){
					that.list[i].ploss = that.list[i].number * that.list[i].profit_ratio * -1
				}else{
					 that.list[i].ploss = 0
				}
			
			}else{
				
				if(current < buy){
					that.list[i].ploss = that.list[i].number * that.list[i].profit_ratio
				}else if(current > buy){
					that.list[i].ploss = that.list[i].number * that.list[i].profit_ratio * -1
				}else{
					that.list[i].ploss = 0
				}
			
			}
			
            // if (current > buy) {
            //   that.list[i].ploss =
            //     that.list[i].number * that.list[i].profit_ratio
            // } else if (current < buy) {
            //   that.list[i].ploss = that.list[i].number * -1
            // } else {
            //   that.list[i].ploss = 0
            // }
          }
        }
      },
    },
    created(){
        console.log(this.getSear)
        let that = this
        if (window.plus) {
          that.lang = plus.storage.getItem('lang') || 'zh'
        } else {
          // that.lang = JSON.parse(localStorage.getItem('lang')).data;
          that.lang = localStorage.getItem('lang') || 'zh'
        }
        if (window.plus) {
          if (plus.storage.getItem('token')) {
            that.token = plus.storage.getItem('token')
          }
        } else {
          if (
            localStorage.getItem('token')
          ) {
            that.token =localStorage.getItem('token')
          }
        }
        this.getList()
        this.getCurrency()
        this.setScroll()

    },
    template:` <div id="app" v-cloak>
    <div class="order dark:order">
      <div class="header">
      <!--  <div class="fixed">
          <img src="../../../static/image/return.png" @click="goback" />
          <span>{{transwords[lang].order}}</span>
        </div>-->
      </div>
      <div class="content" v-if="token">
        <div class="tab">
        
          <ul>
            <li :class="active==1?'active':''" @click="setActive(1)">
              {{transwords[lang].inTransaction}}
            </li>
            <li :class="active==3?'active':''" @click="setActive(3)">
              {{transwords[lang].closed}}
            </li>
          </ul>
          <!-- 交易中 -->
          <div>
            <div class="item" v-if="active==1" v-for="(item,index) in list" :key="index">
              <div class="item-top">
                <span class="type">{{transwords[lang].inTransaction}}</span>
                <img src="children/image/top.png" alt="" v-if="item.ploss>=0" />
                <img src="children/image/bottom.png" alt="" v-else />
                <p>{{item.symbol_name}} {{secondsFormat(item.seconds)}}</p>
              </div>
              <div class="item-center">
                <p>
                  <span>{{transwords[lang].quantity}}</span>
                  <span>{{parseInt(item.number)}}</span>
                </p>
                <p>
                  <span>{{transwords[lang].puprice}}</span>
                  <span>{{item.open_price}}</span>
                </p>
                <p>
                  <span>{{transwords[lang].cuPrice}}</span>
                  <span>{{price||0.0000}}</span>
                </p>
                <p>
                  <span>{{transwords[lang].profitLoss}}</span>
                  <span>{{item.ploss | tofixedFour}}</span>
                </p>
              </div>
               <div class="item-center top">
                  <p style="text-align: left;">
                    <span>{{transwords[lang].Countdown}}</span>
                    <span style="display:block;">{{secondsFormat(item.remain_milli_seconds)||0}}</span>
                  </p>
               </div>
             
            </div>
            <!-- 已平仓 -->
            <div class="item" v-else-if="active==3">
              <div class="item-top">
                <span class="type">{{transwords[lang].closed}}</span>
                <img
                  src="children/image/top.png"
                  alt=""
                  v-if="item.fact_profits>=0"
                />
                <img src="children/image/bottom.png" alt="" v-else />
                <p>{{item.symbol_name}} {{secondsFormat(item.seconds||0)}}</p>
              </div>
              <div class="item-center">
                <p>
                  <span>{{transwords[lang].quantity}}</span>
                  <span>{{parseInt(item.number)}}</span>
                </p>
                <p>
                  <span>{{transwords[lang].puprice}}</span>
                  <span>{{item.open_price}}</span>
                </p>
                <p>
                  <span>{{transwords[lang].fiprice}}</span>
                  <span>{{item.end_price}}</span>
                </p>
               <!--<p>
                  <span>{{transwords[lang].fee}}</span>
                  <span>{{item.fee}}</span>
                </p>-->
                <p>
                  <span>{{transwords[lang].loss}}</span>
                  <span>{{item.fact_profits}}</span>
                </p>
              </div>
            </div>
          </div>
          <div class="loading">
            <div v-show="isScroll">
				<img src="children/image/loading.gif" alt="" />
				<span>{{transwords[lang].loading}}</span>
            </div>
            <div v-show="list.length>0 && !isScroll">
				<span>{{transwords[lang].noMore}}</span>
            </div>
			<div  v-show="list.length<1 && show">
				<span>{{transwords[lang].nodata}}</span>
		    </div>
          </div>
        </div>
      </div>
    </div>
  </div>`
})
