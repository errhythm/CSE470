window.addEventListener("app:mounted",(function(){var e={colors:["#4ade80","#f43f5e","#a855f7"],series:[44,55,67],chart:{height:250,type:"radialBar"},plotOptions:{radialBar:{hollow:{margin:10,size:"35%"},track:{margin:10},dataLabels:{name:{fontSize:"22px"},value:{fontSize:"16px"},total:{show:!0,label:"Total",formatter:function(e){return e.config.series.reduce((function(e,t){return e+t}))}}}}},grid:{padding:{top:-20,bottom:-20,right:0,left:0}},stroke:{lineCap:"round"},labels:["Booked","Cancelled","Unconfirmed"]},t=document.querySelector("#analytics-chart");setTimeout((function(){t._chart=new ApexCharts(t,e),t._chart.render()}));var o={colors:["#0EA5E9"],series:[{name:"Expense",data:[82,25,60,30,50,20]}],chart:{type:"area",stacked:!1,height:180,parentHeightOffset:0,toolbar:{show:!1}},dataLabels:{enabled:!1},grid:{padding:{left:0,right:0,top:-20,bottom:-8}},fill:{type:"gradient",gradient:{shadeIntensity:1,inverseColors:!1,opacityFrom:.45,opacityTo:.1,stops:[20,100,100,100]}},stroke:{width:2},tooltip:{shared:!0},legend:{show:!1},yaxis:{show:!1},xaxis:{labels:{show:!1},axisTicks:{show:!1},axisBorder:{show:!1}}},r=document.querySelector("#expense-chart");setTimeout((function(){r._chart=new ApexCharts(r,o),r._chart.render()}));var a={placement:"bottom-end",modifiers:[{name:"offset",options:{offset:[0,4]}}]};new Popper("#travels-history-menu",".popper-ref",".popper-root",a),new Popper("#analytics-menu",".popper-ref",".popper-root",a),new Popper("#expense-menu",".popper-ref",".popper-root",a)}),{once:!0});