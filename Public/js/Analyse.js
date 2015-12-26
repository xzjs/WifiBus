
$(document).ready(
		function(){
			get_ad_click_top(0,0);
			get_ad_click(0,0);
			
		}
		);
function getAdInfo_line(line_id){
	get_ad_click_top(line_id,0);
	get_ad_click(line_id,0);
}
function getAdInfo_bus(bus_id){
	get_ad_click_top(0,bus_id);
	get_ad_click(0,bus_id);
}
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