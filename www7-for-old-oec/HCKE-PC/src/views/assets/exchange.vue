<template>
  <div class="mymention pb60">
    <div class="flex between baselight2 ptb20 plr20 ft16 bgheader">
      <span>{{ $t("new.duih") }}</span>
    </div>
    <div class="mt20 plr30">
      <div class="flex alcenter mb20 wt500 pop">
        <div class="flex alcenter flex1 wt100 r-left" ref="left">
          <el-select
            v-model="currencyCode"
            class="flex1 selectBor bdinput"
            @change="changeCurrency"
            placeholder=""
          >
            <el-option
              v-for="item in arr"
              :key="item.currency_id"
              :label="item.currency_code"
              :value="item.currency_id"
            ></el-option>
          </el-select>
        </div>
        <div class="flex alcenter r-center">
          <img
            @click="setShow(2)"
            src="../../assets/images/qweqwekkk.png"
            alt
            class="imgct"
          />
        </div>
        <div class="flex alcenter flex1 r-right" ref="right">
          <el-select
            v-model="currencyProtocolsCode"
            class="flex1 selectBor bdinput"
            @change="changeProtocols"
            placeholder=""
          >
            <el-option
              v-for="item in nArr"
              :key="item.id"
              :label="item.currency_code"
              :value="item.currency_id"
            ></el-option>
          </el-select>
        </div>
      </div>
      <div class="flex alcenter wt500 mb40 duih mt40">
        <span class="wt100">{{ $t("new.dhs") }}:</span>
        <input
          type="text"
          v-model="num"
          class="ht40 lh40 plr20 bdinput flex1 baselight2"
        />
        <p class="quanb" @click="setAll">{{ $t("new.quanb") }}</p>
      </div>
      <div class="text-flex wt500">
        <div class="top child">
          <span>{{ $t("new.dangq") }}</span>
          <span>{{ $t("new.keyong") }}</span>
          <span>{{ $t("new.ked") }}</span>
        </div>
        <div class="bottom child">
          <span>{{ rate }}</span>
          <span v-if='show==1'>{{yue}}</span>
          <span v-else>{{yues}}</span>
          <span v-if='show==1'>{{(num/rate).toFixed(8)}}</span>
          <span v-else>{{(num*rate).toFixed(8)}}</span>
        </div>
      </div>
      <div
        class=" btn mt30 radius2 tc ht48 lh48 wt217 white bgblue"
        @click="sub"
      >
        {{ $t("new.duih") }}
      </div>
    </div>
  </div>
</template>
  <script>
  export default {
    data() {
      return {
        currencyCode:'',
        arr:[],
        currencyProtocolsCode:'',
        nArr:[],
        num:'',
        rate:0,
        show:1,
        cid:'',
        did:'',
        rate:'',
        yue:'',
        yues:''
      };
    },
    created() {
      this.getAll()
    },
    methods: {
      setAll(){
       
        if(this.show==1){
          this.num=this.yue
        }else{
          this.num=this.yues
        }
      },
        setShow(val){
          this.num=''
            if(this.show==1){
                let left=this.$refs['left']
                let right=this.$refs['right']
                left.style.left='auto'
                right.style.right='auto'
                 left.style.right='0'
                right.style.left='0'
                this.show=2
            }else{
                let left=this.$refs['left']
                let right=this.$refs['right']
                left.style.left='0'
                right.style.right='0'
                left.style.right='auto'
                right.style.left='auto'
                this.show=1
            }
        },
        changeCurrency(val){
          this.num=''
          for(let key in this.arr){
            if(this.arr[key].currency_id==val)
             this.yue=this.arr[key].balance
          }
            this.cid=val   
            this.getRa()        
        },
        changeProtocols(val){
          this.num=''
            for(let key in this.nArr){
              if(this.nArr[key].currency_id==val)
              this.yues=this.nArr[key].balance
            }
            this.did=val
            this.getRa() 
        },
        getAll(){
            this.$http.initDataToken({ url: "account/list" }, false).then(res => {
                  
              if(res.length>0){
                        this.arr=res[0].accounts.filter((item)=>{
                            return item.currency.is_quote==1;
                        })
                        this.currencyCode=this.arr[0].currency_code
                        this.cid=this.arr[0].currency_id
                        this.yue=this.arr[0].balance
                        
                        this.nArr=res[0].accounts.filter((item)=>{
                            return item.currency.is_quote==0;
                        })
                        this.currencyProtocolsCode=this.nArr[0].currency_code
                        this.did=this.nArr[0].currency_id
                        this.yues=this.nArr[0].balance
                        this.num=''
                        this.getRa()
                      
                }
            })
        },
         getRa(msg){
                this.$http.initDataToken({url:'exchange/lastPrice',type:'POST',data:{
                     base_id:this.did,
                     quote_id:this.cid
                    }},false).then(res=>{
						             this.rate=res.last_price
                         if(msg){
                            this.num=''
                         }
					})
          },
          sub(){
              if(this.num<=0||!this.num){
                this.$message({
                    type:'warning',
                    message:this.$t('new.err')
                })
                return
              }
                 this.$http.initDataToken({url:'exchange/submit',type:'POST',data:{
                        base_id:this.did,
                        quote_id:this.cid,
                        amount:this.num,
                        type:this.show
                        }})
                      .then(res=>{
                          this.getAll()
                      })
              
          }
    }
  };
  </script>
  <style lang="">
    .btn{
      cursor: pointer;
    }
.text-flex .child {
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 50px;
  text-align: center;
}
.child span {
  display: block;
  flex: 1;
}
.cointransfer .el-input__inner {
  border-color: #252a44;
}
.imgct {
  width: 50px;
  height: 50px;
  cursor: pointer;
}
.r-center {
  left: 225px;
  position: absolute;
}
.wt500 {
  width: 500px;
}
.duih {
  position: relative;
}
.quanb {
  position: absolute;
  right: 10px;
  cursor: pointer;
}
.pop {
  position: relative;
  text-align: center;
}
.pop > .flex {
  position: absolute;
  width: 200px;
  z-index: 10;
}
.pop .r-left {
  left: 0;
}
.pop .r-right {
  right: 0;
}
</style>