<template>
	<div :id="'chart'+id"></div>
</template>

<script>
import Highcharts from 'highcharts/highstock';
export default {
	props: {
		id:Number,
		symbol: String,
		color: String
	},
	data() {
		return {}
	},
	mounted() {
		this.getLine();
	},
	methods: {
		getLine(){
			if(!this.symbol)return false;
			this.$http.initDataToken({ 
				url: this.$http._DOMAIN+'/feature/getCacheKline', 
				data: {symbol: this.symbol},
				type: 'get'
			},false,false).then(res=>{
				if(res.length){
					let arr=[]
					for(let key in res){
						arr.push(Number(res[key].close))
					}
					this.creationLine(arr)
				}
            });
		},
		//折线图
		creationLine(data){
			// 创建图表
			Highcharts.chart('chart'+this.id, { 
				/*Highcharts 配置*/
		        chart:{
					type: 'area',
					backgroundColor: 'transparent',
					margin:[0,0,0,0]
				},
				credits: {
					enabled:false //去掉地址
				},
				title: {
					text:null,
				},
				exporting: {
					enabled:false
				},
				xAxis: {
					labels: {
						format: ' '
					},
					tickColor: 'transparent',
					lineColor: 'transparent',
					minPadding:0,
					maxPadding:0
				},
				tooltip: {
					enabled:false,
					followTouchMove:false
				},
				yAxis: {
					max: Math.max.apply(null, data),
					min: Math.min.apply(null, data),
					tickAmount: 8,
					title: {
						text: '',
					},
					labels: {
						format: ' '
					},
					gridLineColor: 'transparent'
				},
				legend: {
					enabled: false
				},
				plotOptions: {
					series: {
						fillOpacity: 0.5
					}
				},
				series: [{
					data: data,
					lineColor: this.color,
					color: this.color,
					lineWidth:1
				}]
			});
		}
	},
}
</script>