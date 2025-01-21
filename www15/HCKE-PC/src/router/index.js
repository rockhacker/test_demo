import Vue from 'vue'
import Router from 'vue-router'
// import HelloWorld from '@/views/HelloWorld'
import Buy from '@/views/buy'
import Notice from '@/views/notice'
import Login from '@/views/login'
import Register from '@/views/register'
import Home from '@/views/home'
import Market from '@/views/markets/index'
// 法币模块
import LegalIndex from '@/views/legal/index'
// 商家
import Myshop from '@/views/legal/myshop'
// 锁仓挖矿
import Staking from '@/views/staking/index'
import StakingOrders from '@/views/staking/orders'
import StakingDetails from '@/views/staking/details'
import StakingIncome from '@/views/staking/income'
// 币币模块
import Trade from '@/views/trade/index'
// 资产模块
import Assets from '@/views/assets/index'
import LegalAccount from '@/views/assets/legalAccount'
import LeverAccount from '@/views/assets/leverAccount'
import isoLeverAccount from '@/views/assets/isoleverAccount'
import TradeAccount from '@/views/assets/tradeAccount'
import OptionAccount from '@/views/assets/optionAccount'
import SubscriptionRunning from '@/views/assets/subscriptionRunning'
import BindAddress from '@/views/assets/bindAddress'
import DealRecords from '@/views/assets/dealRecords'
import mentionRecords from '@/views/assets/mentionRecords'
import Transfer from '@/views/assets/transfer'
import exchange from '@/views/assets/exchange'
import chargeRecord from '@/views/assets/charge_record.vue'
// 合约交易
import Lever from '@/views/lever/index'
// 合约交易
import isoLever from '@/views/isolever/index'
//秒合约交易

import bigTrade from '@/views/bigTrade/index'

import recharge from '@/views/lever/recharge'
import rechargeOpen from '@/views/lever/rechargeOpen'

import Second from '@/views/second/index'
// 个人中心
import Personal from '@/views/personal/index'
import AccountSettings from '@/views/personal/accountSettings'
import TransactionLog from '@/views/personal/transactionLog'
import CollectionSettings from '@/views/personal/collectionSettings'
import Authentication from '@/views/personal/authentication'
import ResetPassword from '@/views/personal/resetPassword'
import ForgetPassword from '@/views/personal/forgetPassword'
import TradePassword from '@/views/personal/tradePassword'
import BindAccount from '@/views/personal/bindAccount'
import optionct from '@/views/optionct/index'

//新币申购
import project from '@/views/project/index'
import projeDetail from '@/views/project/projeDetail'

import Subscription from '@/views/subscription/index'
import SubscriptionOrders from '@/views/subscription/orders'
import SubscriptionDetails from '@/views/subscription/details'

import rechargeTransfer from '@/views/lever/rechargeTransfer'

Vue.use(Router)
export default new Router({
  linkActiveClass:'routeractive',
  routes: [
    // 首页
    {
      path: '/',
      redirect:'/home'
    },
    {
      path:'/optionct',
      name:'optionct',
      component:optionct,
    },
    // 首页
    {
      path: '/home',
      name:'home',
      component:Home
    },
    {
      path: '/bigTrade',
      name:'bigTrade',
      component:bigTrade
    },
    // 锁仓挖矿
    {
		path: '/staking',
		name:'staking',
		component:Staking
    },
    {
		path: '/stakingOrders',
		name:'stakingOrders',
		component:StakingOrders
    },
    {
		path: '/stakingDetails',
		name:'stakingDetails',
		component:StakingDetails
    },
    {
		path: '/stakingIncome',
		name:'stakingIncome',
		component:StakingIncome
    },
	// 新币申购
	{
		path: '/subscription',
		name:'subscription',
		component:Subscription
	},
	{
		path: '/subscriptionOrders',
		name:'subscriptionOrders',
		component:SubscriptionOrders
	},
	{
		path: '/subscriptionDetails',
		name:'subscriptionDetails',
		component:SubscriptionDetails
	},
     // 行情
     {
      path: '/markets',
      name:'market',
      component:Market
    },
     // 法币
     {
      path: '/legalIndex',
      name:'legalIndex',
      component:LegalIndex,
      redirect:'/legalIndex/legal',
      children:[
        {
          path:'legal',
          component:() => import ('@/views/legal/legal')
        },
        {
          path:'orders',
          component:() => import ('@/views/legal/orders')
        },
        {
          path:'orderdetail',
          component:() => import ('@/views/legal/orderdetail')
        }
      ]
    },
    //首发项目
    {
      path: '/project',
      name:'project',
      component:project,
    },
    {
      path: '/projeDetail',
      name:'projeDetail',
      component:projeDetail,
    },
    // 我的店铺
    {
      path: '/myshop',
      name:'myshop',
      component:Myshop,
	  redirect:'/myshop/myshoporders',
      children:[
        {
          path:'myshoporders',
          component:() => import ('@/views/legal/myshoporders')
        },
        {
          path:'shoporders',
          component:() => import ('@/views/legal/shoporders')
        },
        {
          path:'shoporderdetail',
          component:() => import ('@/views/legal/shoporderdetail')
        }
      ]
    },
     // 币币
     {
      path: '/trade',
      name:'trade',
      component:Trade
    },
    // 公告页面
    {
      path: '/notice',
      name: 'notice',
      component: Notice
    },
    {
      path: '/buy',
      name: 'buy',
      component: Buy
    },
    // 登录页面
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta:{
        green:true
      }
    },
    // 注册页面
    {
      path: '/register',
      name: 'register',
      component: Register,
      meta:{
        green:true
      }
    },
    // 资产页面
    {
      path:'/assets',
      name:'assets',
      component:Assets,
      redirect:'/assets/tradeAccount',
      children:[
        // 币币账户
        {
          path:'tradeAccount',
          name:'tradeAccount',
          component:TradeAccount
        },
        // 法币账户
        {
          path:'legalAccount',
          name:'legalAccount',
          component:LegalAccount
        },
        // 合约账户
        {
          path: 'leverAccount',
          name: 'leverAccount',
          component: LeverAccount
        },
        // 逐仓合约账户
        {
          path: 'isoleverAccount',
          name: 'isoleverAccount',
          component: isoLeverAccount
        },
        //秒合约账户
        {
          path:'secondAccount',
          name:'secondAccount',
          component:() => import ('@/views/assets/secondAccount')
        },
		//秒合约账户
		{
			path:'optionAccount',
			name:'optionAccount',
			component:() => import ('@/views/assets/optionAccount')
		},
		//新币申购流水
		{
			path:'subscriptionRunning',
			name:'subscriptionRunning',
			component:() => import ('@/views/assets/subscriptionRunning')
		},
        // 绑定提币地址
        {
          path: 'bindAddr',
          name: 'bindAddr',
          component: BindAddress
        },
         // 财务记录
         {
          path: 'dealRecords',
          name: 'dealRecords',
          component: DealRecords
        },
        // 提币记录
        {
          path: 'mentionRecords',
          name: 'mentionRecords',
          component: mentionRecords
        },
        {
          path:'chargeRecord',
          name:'chargeRecord',
          component: chargeRecord
        },
        // 财务记录
        {
          path: 'transfer',
          name: 'transfer',
          component: Transfer
        },
		//兑换
		{
		  path: 'exchange',
		  name: 'exchange',
		  component: exchange
		},
         //划转记录
         {
          path: 'transferLog',
          name: 'transferLog',
          component:() => import ('@/views/assets/transferLog')
        },
      ]
    },
    // 合约交易
    {
      path: '/lever',
      name:'lever',
      component:Lever
    },
    {
      path: '/rechargeOpen',
      name:'rechargeOpen',
      component:rechargeOpen
    },
    {
      path: '/rechargeTransfer',
      name:'rechargeTransfer',
      component:rechargeTransfer
    },
    {
      path: '/recharge',
      name:'recharge',
      component:recharge
    },
    // 逐仓交易
    {
      path: '/isolever',
      name:'isolever',
      component:isoLever
    },
     // 秒合约交易
     {
      path: '/second',
      name:'second',
      component:Second
    },
    // 个人中心
    {
      path:'/personal',
      name:'personal',
      component:Personal,
      children:[
        // 账户设置
        {
          path:'accountSettings',
          name:'accountSettings',
          component:AccountSettings
        },
        // 交易日志
        {
          path:'transactionLog',
          name:'transactionLog',
          component:TransactionLog
        },
        // 收款设置
        {
          path: 'collectionSettings',
          name: 'collectionSettings',
          component: CollectionSettings
        },
        // 身份认证
        {
          path: 'authentication',
          name: 'authentication',
          component: Authentication
        },
         //用户反馈
         {
          path: 'feedback',
          name: 'feedback',
          component:() => import ('@/views/personal/feedback')
        }
        
      ]
    },
    {
      path: '/resetPassword',
      name:'resetPassword',
      component:ResetPassword
    },
    {
      path: '/tradePassword',
      name:'tradePassword',
      component:TradePassword
    },
    {
      path: '/bindAccount',
      name:'bindAccount',
      component:BindAccount
    },
    {
      path: '/forgetPassword',
      name:'forgetPassword',
      component:ForgetPassword
    },
    {
      path:'/marketingTeam/index',
      name:'teamIndex',
      component:() => import ('@/views/marketingTeam/index')
    },
    {
      path:'/marketingTeam/order',
      name:'teamOrder',
      component:() => import ('@/views/marketingTeam/order')
    },

      // name: 'HelloWorld',
      // component: HelloWorld,
      // children:[
     
      // ]
    // },
  ]
})
