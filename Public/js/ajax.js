/**
 * index页面初始化
 */
function init_index() {
	load_line();
	load_device_status();
}

/**
 * 加载所有设备的工作状态
 */
function load_device_status() {

	
}

/**
 * 加载线路列表
 */
function load_line() {
	$.post("Line/select", {
		is_getlinelist : 1
	}, function(data, status) {
		if (status == 4 || status == "success") {
			var line_list = eval(data);
			var search_list_str = "";
			for (var i = 0; i < line_list.length; i++) {
				search_list_str += "<option value='" + line_list[i].id + "'>"
						+ line_list[i].name + "</option>"
			}
			$("select#line_selector").html(search_list_str);
			var line_list_str = "";
			for (var i = 0; i < line_list.length; i++) {
				line_list_str += "<li><a href='#'>" + line_list[i].name
						+ "</a></li>"
			}
			$("ul#line_list_ul").html(line_list_str);
		}
	});
	show_bus_no(1);// 默认显示一路
}

/**
 * 显示某线路上的车辆的车牌号
 * 
 * @param str：线路Id
 */
function show_bus_no(str) {
	$.post("Bus/select", {
		is_getbuslist : 1,
		line_id : str
	}, function(data, status) {
		if (status == 4 || status == "success") {
			var bus_info = eval(data);
			var bus_list = "";
			for (var i = 0; i < bus_info.length; i++) {
				bus_list += "<li><a href='#'>" + bus_info[i].no + "</a></li>";
			}
			$("ul#bus_no_selector").html(bus_list);
		}
	});
}

/**
 * 根据车牌号搜索车辆
 * 
 * @param str：搜索关键字
 */
function search_bus(str) {
	$.post("Bus/select", {
		is_getbuslist : 1,
		search_keys : str
	}, function(data, status) {
		if (status == 4 || status == "success") {
			var bus_info = eval(data);
			var bus_list = "";
			for (var i = 0; i < bus_info.length; i++) {
				bus_list += "<li><a href='#'>" + bus_info[i].no + "</a></li>";
			}
			$("ul#bus_no_selector").html(bus_list);
		}
	});
}
