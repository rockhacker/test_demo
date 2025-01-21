<template>
    <div class="plr30 ptb20 notice flex column alcenter jscenter">
        <div class="content baselight  mt10">
            <div class="bgpart flex column plr20 ptb20 baselight">
                <p class="ft26 mt20">{{title}}</p>
                 <div v-html="news" class="mt20 ft16"></div>
                <a :href="link" target="_blank" class="flex alcenter between bdblue ptb10 plr10 wt140 radius4 mt20">
                    <img src="../assets/images/shu.png" class="wt20" alt="">
                    <p class="blue ft16">white paper</p>
                </a>
                <div class="flex alcenter mt20">
                    <div class="flex alcenter wt217 ">
                        <el-select v-model="coin" class="bdinput radius2" @change="changeCoin">
                            <el-option
                            v-for="item in list"
                            :key="item.code"
                            :label="item.code"
                            :value="item"
                            >
                            </el-option>
                        </el-select>
                    </div>
                    <input type="number" class="ml30 wt217 bdline ht40 lh40 baselight2 radius2 plr20" @input="inputnum" v-model="number" />
                    <div class="ml30 wt217 bdline ht40 lh40 baselight2 radius2 plr20 tc">
                        ≈ {{price}} {{Company}}
                    </div>
                </div> 
                <div class="mt20"> 
                    <p class="ft14 mb10">{{$t('login.p_invitecode')}}</p>
                    <input type="text" class="wt217 bdline ht40 lh40 baselight2 radius2 plr20" :placeholder="$t('login.p_inviteInput')" v-model="invite_code" />
                </div>

                <div class="flex mt30 pt20">
                    <div class="bgblue lh48 ht48 tc white ft16 radius4 w100" @click="sumbit">{{$t('legal.buy')}}</div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            list:[],
            coinprice:'',
            price:'0.00',
            number: "",
            id:'',
            coin:'',
            votid:'',
            news:'',
            time:'',
            title:'',
            Company:'',
            link:'',
            invite_code:''

        }
    },
    created() {
        this.getList();
        this.getBanner();
    },
    methods:{ 
        getBanner() {
             this.$http.initDataToken({
                url: 'news/list',
                data: { category_id: 50 }
            },false).then(res=>{
                this.news = res.data[0].content;
                this.title = res.data[0].title;
                this.link = res.data[0].white_paper;

            })
        },
        //  getDetail(id){
        //     this.$http.initDataToken({
        //         url: 'news/info',
        //         data: { id: 83 }
        //     },false).then(res=>{
        //         console.log(res)
        //         this.news = res.content;
        //         this.title = res.title;
        //     })
        // },
		getList() {
            this.$http.initDataToken({
                url: 'new_tx/in_currency',
                data: {}
            },false).then(res=>{
                this.list = res;
                this.id = this.list[0].id;
                this.coin = this.list[0].code;
                this.coinprice = this.list[0].pb_price;
                this.list.map((item,index)=>{
                    // if(item.code=='VOT'){
                    //     this.votid = item.id;
                    // }
                    if(item.is_pb==1){
                        this.votid = item.id;
                        this.Company = item.code;
                    }
                })
            })
        },
        changeCoin(e) {
            var that = this;
            that.id = e.id;
            that.coin = e.code;
            that.coinprice = e.pb_price;
            that.number = '';
            that.price = '0.00';

        },
        inputnum(){
            this.price = this.coinprice*this.number;
        },
        sumbit() {
            let that = this;
            if (!that.number) {
                that.$utils.layerMsg(this.$t('trade.p_num'));
                return false;
            }
             if (!that.invite_code) {
                that.$utils.layerMsg(this.$t('login.p_inviteInput'));
                return false;
            }
            this.$http.initDataToken({url:'new_tx/in',data:{pb_currency_id:this.votid,number:this.number,base_currency_id:this.id,invite_code:this.invite_code},type:'POST'})
            .then(res=>{
                setTimeout(function () {
                    location.reload();
                }, 1000)
            })
            
		},
    }
}
</script>
<style lang="scss" scoped>
    .content{
        width: 1100px;
        min-height: 80vh;
    }
</style>