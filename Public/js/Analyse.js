
$(document).ready(
		function(){
			get_ad_click_top(0,0);
			get_ad_click(0,0);
			get_flow(0,0);
			get_online_num(0,0);
			get_back(0,0);
		}
		);

function getAdInfo_line(line_id){
	get_ad_click_top(line_id,0);
	get_ad_click(line_id,0);
	get_flow(line_id,0);
	get_online_num(line_id,0);
	get_back(line_id,0);
}
function getAdInfo_bus(bus_id){
	get_ad_click_top(0,bus_id);
	get_ad_click(0,bus_id);
	get_flow(0,bus_id);
	get_online_num(0,bus_id);
	get_back(0,bus_id);
}
function get_back(line_id,bus_id){
	$.ajax({
		type : "POST",
		url : "../Analyse/get_back" ,
		data:{line_id:line_id,bus_id:bus_id},
		success : function(data) {
			adInfo = eval(data);
			 var timeList=new Array();
			var numList=new Array();
			for (var i = 0; i < adInfo.length; i++) {
				timeList[i]=adInfo[i].time;
				numList[i]=adInfo[i].num;
			}
	
			  var adMainTurnBack = adMainTurnBackFunction(timeList,numList);
		      myChartTurnBackTime.setOption(adMainTurnBack);
		}
	});
}
function get_online_num(line_id,bus_id){
	$.ajax({
		type : "POST",
		url : "../Analyse/get_online_num" ,
		data:{line_id:line_id,bus_id:bus_id},
		success : function(data) {
			adInfo = eval(data);
			 var timeList=new Array();
			var numList=new Array();
			for (var i = 0; i < adInfo.length; i++) {
				timeList[i]=adInfo[i].time;
				numList[i]=adInfo[i].num;
			}
		//	alert(timeList);
		        var adMainCustomer = adMainCustomerFunction(timeList,numList);
		    myChartCustomerTime.setOption(adMainCustomer);
		}
	});
}
/**
 * 流量-时间
 * @param line_id
 * @param bus_id
 */
function get_flow(line_id,bus_id){
	$.ajax({
		type : "POST",
		url : "../Analyse/get_flow" ,
		data:{line_id:line_id,bus_id:bus_id},
		success : function(data) {
			adInfo = eval(data);
			 var timeList=new Array();
			var numList=new Array();
			for (var i = 0; i < adInfo.length; i++) {
				timeList[i]=adInfo[i].time;
				numList[i]=adInfo[i].num/1024;
			}
		//	alert(numList);
		    var adMainFlow = adMainFlowFunction(timeList,numList);
		    myChartFlowTime.setOption(adMainFlow);
		}
	});
}
/**
 * 广告点击-时间
 * @param line_id
 * @param bus_id
 */
function get_ad_click(line_id,bus_id){
	$.ajax({
		type : "POST",
		url : "../Analyse/get_ad_click" ,
		data:{line_id:line_id,bus_id:bus_id},
		success : function(data) {
			adInfo = eval(data);
			
			 var timeList=new Array();
			var numList=new Array();
			for (var i = 0; i < adInfo.length; i++) {
				timeList[i]=adInfo[i].time;
				numList[i]=adInfo[i].num;
			}
			//alert(numList);
		    var adMainOption_adtime = adMainTimeFunction(timeList,numList);
		    myChartAdTime.setOption(adMainOption_adtime ); 
		}
	});
}
/**
 * 广告总排行榜
 * @param line_id
 * @param bus_id
 */
function get_ad_click_top(line_id,bus_id){
	//alert(line_id);
	$.ajax({
		type : "POST",
		url : "../Analyse/get_ad_click_top" ,
		data:{line_id:line_id,bus_id:bus_id},
		success : function(data) {
			adInfo = eval(data);
			 var textList=new Array();
			var numList=new Array();
			for (var i = 0; i < adInfo.length; i++) {
				textList[i]=adInfo[i].text;
				numList[i]=adInfo[i].click_num;
			}
		    var adMainOption = adMainFunction(textList,numList);
		    var myChartAdMain = echarts.init(document.getElementById('adMain'), 'macarons2');
		    myChartAdMain.setOption(adMainOption); 
		  // alert(textList);
		}
	});

}