const Web3 = require('web3')
const router = require('koa-router')()
const ethService = require('../service/ethService.js')
const conService = require('../service/conService.js')
router.prefix('/eth')

//创建账户
router.get('/create', async (ctx, next) => {
  let acc = ethService.create()
  ctx.body = acc
})

//获取gas价格
router.get('/gasPrice', async (ctx, next) => {
  let price = await ethService.getGasPrice()
  ctx.body = { price, gwei: Web3.utils.fromWei(price, 'gwei') }
})

//查询账户余额
router.get('/balance', async (ctx, next) => {
  const address = ctx.query.address
  let balance = await ethService.balance(address)
  console.log(balance)
  ctx.body = balance
})

//交易
router.get('/tran', async (ctx, next) => {
  const { fromAdd, toAdd, num, limit = '21000', privatekey } = ctx.query
  console.log(ctx.query)
  let hash = await ethService.tran(fromAdd, toAdd, num, limit, privatekey)
  console.log(hash)
  ctx.body = hash
})

// 合约余额
router.get('/conBalance', async (ctx, next) => {
  const address = ctx.query.address
	let valance = await conService.balance(address)
	ctx.body = valance
})

//合约代币交易
router.get('/conTran', async (ctx, next) => {
  const { fromAdd, toAdd, num, limit = '64000', privatekey } = ctx.query
	let hash = await conService.tran(fromAdd, toAdd, num, limit, privatekey)
	console.log(hash)
	ctx.body = hash
})

module.exports = router
