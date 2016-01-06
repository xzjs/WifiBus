$(document).ready(function() {
	get_online();
	get_online_top();

});
function get_online() {
	$.ajax({
		type : "POST",
		url : "../Analyse/fenxi_get_on_line",
		success : function(data) {
			var adInfo = eval("(" + data + ")");
			var time = adInfo['time'];
			var busno = adInfo['num'];
			var adAnlyOption3 = adver_rankOptionFunction1(time, busno);
			myChartAdAnly3.setOption(adAnlyOption3);
		}
	});
}
function get_online_top() {
	$.ajax({
		type : "POST",
		url : "../Analyse/fenxi_get_on_line_top",
		success : function(data) {
			var adInfo = eval("(" + data + ")");
			var busno = adInfo['busno'];
			var value = adInfo['value'];
		    var adAnlyOption2 = adver_rankOptionFunction2(busno, value);
		    myChartAdAnly2.setOption(adAnlyOption2);			
		   ;
		}
	});
}