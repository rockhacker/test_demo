<template>
	<view class="blue" :class="{ light: theme == 'light' }">
         <v-tabs v-model="current" :fixed="true" color="#868c9a" :lineScale="0.4" :bold="false" lineColor="#6879d1" lineHeight="6rpx"  activeColor="#000"  :tabs="tabs" field="name" @change="changeTab"></v-tabs>
	     <view class="px-10 bgPart">
            <view class="flex items-center between p-30 bdbf5" v-for="(item,index) in logList" :key="index">
                <view class="flex items-center">
                    <img v-if="item.value>0" class="h-50 w-50 mr-20" src="../../static/image/top.png" alt="">
                    <img v-else class="h-50 w-50 mr-20" src="../../static/image/bottom.png" alt="">
                    <view>{{item.memo}}</view>    
                </view>
                <view>
                    <view class="ft16 tr" :class="item.value>0 ?'green':'red3'">{{ item.value }}{{item.currency.code}}</view>
                    <view class="mt-10 ft14 tr">{{ item.created_at }}</view>
                </view>
            </view>
         </view>
         <view class="mt-40 text-center" v-if="logList.length == 0 && !loading">
            <image src="../../static/image/anonymous.png" class="w-120 h-120"></image>
            <view>{{ $t('home.norecord') }}</view>
        </view>
        <!-- <view class="mt-40 text-center" v-if="loading">
            <img src="../../static/image/loading.gif" class="w-60 h-60" alt="">
        </view> -->
    </view>
</template>

<script>
import { mapState } from 'vuex';
export default {
	data() {
		return {
            current: 0,
            tabs: [],
            currency_id:'',
            page: 1,
            logList:[],
            hasMore: true,
            loading:false
		};
	},
	computed: {
		...mapState(['theme'])
	},
	onShow() {
		this.$utils.setThemeTop(this.theme);
        
	},
	onLoad(e) {
		uni.setNavigationBarTitle({
				title: this.$t('add.zbjl')
		});
        this.getAssets()
	},
	methods: {
        changeTab(index) {
            this.currency_id = this.tabs[index].accounts[0].currency_id
            this.setFilter(this.tabs[index].account_code)
            this.page = 1
            this.logList = []
            this.getLog()
        },
        getAssets() {
            this.$utils.initDataToken({url:'account/list'},res=>{
                console.log(res)
                this.tabs = res;
                this.setFilter(this.tabs[0].account_code)
                this.currency_id =  this.tabs[0].accounts[0].currency_id
                this.getLog()
            })
		},
        getLog() {
			let that = this;
			let url = 'account_log/' + this.logurl;
            this.loading = true
			this.$utils.initDataToken({ url: url, data: { currency_id: this.currency_id, page: this.page, limit: 15 } }, res => {
				uni.stopPullDownRefresh();
                this.loading = false
				let data = res.data;
				that.isBottom = false;
				that.logList = that.page == 1 ? data : that.logList.concat(data);
				that.hasMore = res.last_page == res.current_page ? false : true;
			});
		},
        setFilter(val){
            if (val == 'change_account') {
                this.logurl = 'change';
               
            } else if (val == 'lever_account') {
                this.logurl = 'lever';
               
            } else if (val == 'micro_account'){
                this.logurl = 'micro';
               
            }else {
                this.logurl = 'legal';
               
            }
        }
	},
	onPullDownRefresh() {
		this.page = 1;
		(this.bottom = false), (this.hasMore = true), this.getLog();
	},
	onReachBottom() {
        if (!this.hasMore) return;
		this.page++;
		this.getLog();
	}
};
</script>

<style></style>
