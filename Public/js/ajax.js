/**
 * 加载线路列表(暂未用到)
 */
function load_line() {
	$.post("Line/select", {
		is_ajax : 1
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
}


/**
 * 显示某线路上的车辆的车牌号
 * 
 * @param str：线路Id
 */
function get_bus_list_check(url,id,display) {
	$.post(url, {
		is_getbuslist : 1,
		line_id : id
	}, function(data, status) {
		if (status == 4 || status == "success") {
			var bus_info = eval(data);
			var bus_list = "";
			for (var i = 0; i < bus_info.length; i++) {
				bus_list += "<li><input type='checkbox' name='car' value="+bus_info[i].id+"> <a>"+ bus_info[i].no +"</a></li>";
			}
			$("ul#"+display).html(bus_list);
		}
	});
}


/**
 * 显示某线路上的车辆的车牌号
 * 
 * @param str：线路Id
 */
function get_bus_list(url,id,display) {
	$.post(url, {
		is_getbuslist : 1,
		line_id : id
	}, function(data, status) {
		if (status == 4 || status == "success") {
			var bus_info = eval(data);
			var bus_list = "";
			for (var i = 0; i < bus_info.length; i++) {
				bus_list += "<li><a href='#'>" + bus_info[i].no + "</a></li>";
			}
			$("ul#"+display).html(bus_list);
		}
	});
}

/**
 * 根据车牌号搜索车辆
 * 
 * @param str：搜索关键字
 */
function search_bus(url,keys) {
	$.post(url, {
		is_getbuslist : 1,
		search_keys : keys
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
 * 搜索线路（用户控制——》线路管理——》搜索）
 * @param key 搜索关键字
 */
function search_line(url,key){
	$.post(url, {
		is_ajax : 1,
		search_keys : key
	}, function(data, status) {
		if (status == 4 || status == "success") {
			var line_info = eval(data);
			var line_list = "";
			for (var i = 0; i < line_info.length; i++) {
				line_list +="<li><a href='#'>" + line_info[i].name + "</a></li>";
				//line_list += "<li><a href='#'>" + line_info[i].no + "</a></li>";
				//line_list +="<li><a onclick=func('{:U("Home/Index/bus/str")}/"+line_info[i].id+"','"+line_info[i].no+"','{:U("Bus/select")}',"+line_info[i].id+",'ul_bus_list')>"+line_info[i].no+"</a></li>";
			}
			$("ul#ul_line_list").html(line_list);
		}
	});
}





