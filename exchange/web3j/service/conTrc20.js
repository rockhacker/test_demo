const tronService = require('../service/tronService.js')
const contractAddress = 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t' // 合约地址
let contract
;(async () => {
    contract = await tronService.tronWeb.contract().at(contractAddress)
})()

// let result = await contract.function_name(para1,para2,...).call();

//代币余额
async function balance(address) {
    let success = false
    try {
        let balance = await contract.balanceOf(address).call()
        return {
            balance: tronService.tronWeb.toDecimal(balance._hex) / 1000000,
            success: true
        }
    } catch (error) {
        return {success, error: error.messagea}
    }
}

async function tran(from, to, num, limit, priKey) {
    // tronWeb.address.toHex("TNPeeaaFB7K9cmo4uQpcU32zGK8G1NYqeL")
    const functions = 'transferFrom(address,address,uint256)' //调用函数
    // const functions = 'allowance(address,address)' //调用函数
    const options = {
        // Permission Id
        // feeLimit: 100000000,
        // callValue: 0,
        // tokenValue: 10,
        // tokenId: 1000001
    }
    // address _from, address _to, uint _value
    // const parameter = [from,to,num] // 调用函数的参数
    const parameter = [
        {type: 'address', value: from},
        {type: 'address', value: to},
        {type: 'uint256', value: num * 1000000}
    ]


    const issuerAddress = tronService.tronWeb.address.fromPrivateKey(priKey) //调用合约者的地址

    let success = false

    try {
        // 1.调用合约
        const res =
            await tronService.tronWeb.transactionBuilder.triggerSmartContract(
                contractAddress,
                functions,
                options,
                parameter,
                issuerAddress
            )
        // 2.签名
        const signedtxn = await tronService.tronWeb.trx.sign(
            res.transaction,
            priKey
        )
        // 3.将已签名的交易广播到网络
        const receipt = await tronService.tronWeb.trx.sendRawTransaction(signedtxn)
        success = true
        return { hash:receipt.txid, success }
    } catch (error) {
        console.log(error)
        return {success, error: error}
    }
}

module.exports = {
    balance,
    tran
}
