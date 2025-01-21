<template>
	<div class="setp">
        <el-steps :active="active" finish-status="success" align-center>
            <el-step :title="$t('add.zhzc')"></el-step>
            <el-step :title="$t('add.smrz')"></el-step>
            <el-step :title="$t('add.aqbd')"></el-step>
            <el-step :title="$t('add.qjy')"></el-step>
        </el-steps>
    </div>
</template>

<script>

export default {
	data() {
		return {

        }
	},
    props:{
        active:{
            type:Number,
            default:0
        }
    },
	mounted() {
		
	},
	methods: {
		
	},
}
</script>
<style scoped lang="scss">
.setp{
    width: 440px;
    padding: 30px 20px 0 ;
    background: #fff;
    >>> .is-process .el-step__icon,>>> .is-success .el-step__icon{
        background: #2ebd85;
        border:1px solid #e5e9f0;
        width: 35px;
        height: 35px;
        color:#fff;
    }
    >>> .el-step__icon{
        background: #e5e9f0;
        border:1px solid #e5e9f0;
        width: 35px;
        height: 35px;
        color:#fff;
    }
    >>> .el-step__title{
        color:#c0c4cc;
        font-size: 14px;
    }
    >>>.el-step__title.is-process, >>> .el-step__title.is-success{
        color:#2ebd85;
        font-weight:initial;
    }
    >>> .el-step.is-horizontal .el-step__line{
        top: 17px;
    }
}
</style>