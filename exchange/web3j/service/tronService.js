const TronWeb = require('tronweb')
const HttpProvider = TronWeb.providers.HttpProvider
const fullNode = new HttpProvider('https://api.trongrid.io')
const solidityNode = new HttpProvider('https://api.trongrid.io')
const eventServer = new HttpProvider('https://api.trongrid.io')
const privateKey =
  'd7bb6cc82b4b03de2605f930028691d9195323b257ff9b2ab99a6fc4ccbcb6c0'
const tronWeb = new TronWeb(fullNode, solidityNode, eventServer, privateKey)
tronWeb.setHeader({
  'TRON-PRO-API-KEY': '2415f313-c813-4fb3-ba3f-1c101c1ca663'
})

//创建账户
async function create() {
  try {
    let acc = await tronWeb.createAccount()
    return acc
  } catch (error) {
    return error
  }
}

async function balance(address) {
  try {
    let balance = await tronWeb.trx.getBalance(address)
    return balance / 1000000
  } catch (error) {
    return error
  }
}

// 返回指定地址处的合同的详细信息
// async function getContract(address){
//     try {
//        let info = await tronWeb.trx.getContract(address);
//        return info
//     } catch (error) {
//         return error
//     }
// }

module.exports = {
  tronWeb,
  create,
  // getGasPrice,
  balance
  //   getContract
  // tran,
  // web3
}
