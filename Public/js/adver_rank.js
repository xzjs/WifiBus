$(document).ready(function() {
	get_online();
	// get_onl

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