const Koa = require('koa') // 引入Koa构造函数
const app = new Koa() // 用构造函数创建对象——创建应用

const router = require('./controller/eth')
const TronRouter = require('./controller/tron')

app.use(router.routes())
app.use(TronRouter.routes())

app.listen(3000, () => {
  console.log('server is running 3000')
}) // 设置监听端口
