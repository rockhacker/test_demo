const tronService = require('../service/tronService.js')
const conTrc20 = require('../service/conTrc20')
const router = require('koa-router')()

router.prefix('/tron')

//创建账户
router.get('/create', async (ctx, next) => {
  let res = await tronService.create()
  ctx.body = res
})

//查询账户余额
router.get('/balance', async (ctx, next) => {
  const address = ctx.query.address
  let balance = await tronService.balance(address)
  console.log(balance)
  ctx.body = balance
})

// 合约信息
// router.get('/getContract', async (ctx, next) => {
//   let res = await tronService.getContract()
//   ctx.body = res
// })

// 合约余额
router.get('/conBalance', async (ctx, next) => {
  const address = ctx.query.address
	let balance = await conTrc20.balance(address)
	console.log(balance)
	ctx.body = balance
})

//合约代币交易
router.get('/conTran', async (ctx, next) => {
  const { fromAdd, toAdd, num, limit = '64000', privatekey } = ctx.query
	let hash = await conTrc20.tran(fromAdd, toAdd, num, limit, privatekey)
	console.log(hash)
	ctx.body = hash
})


module.exports = router