let oss = require('ali-oss')
export default {
    info: {
        region: 'oss-cn-hongkong',
        accessKeyId: 'LTAI5tQzzPnLCSiqF4HW94T3',
        accessKeySecret: 'FfxfF96skmBKRDkBrNePxOcEA8M4hY',
        bucket: 'exchange-hk',
    },
    client() {
        return new oss(this.info)
    }
}