


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
 * 显示某线路上的车辆的车牌号列表，并且类型设为check
 * 
 * @param str：线路Id
 */
function get_bus_list_check(url, id, display, order) {
	if (order != selected) {
				$.post(
						url,
						{
							is_getbuslist : 1,
							line_id : id
						},
						function(data, status) {
							if (status == 4 || status == "success") {
								var bus_info = eval(data);
								var bus_list = "";
								
								for (var i = 0; i < bus_info.length; i++) {
									var a=getCheckState(bus_info[i].id);
									if(a==true){
										var str=" checked='true' ";
									}else{
										var str=" ";
									} 
									bus_list += "<li><input type='checkbox' class='bus_array' id="
											+ id +str
											+ " onchange='getCheckedList(this)' name='car' value="
											+ bus_info[i].id
											+ "> <a>"
											+ bus_info[i].no + "</a></li>";
								}
								$("ul#" + display).html(bus_list);
								var lineList = $(".line_array");
								for (var i = 0; i < lineList.length; i++) {
									if (lineList[i].checked != checkedLineArr[i]) {
										getCheckedList(lineList[i]);
										checkedLineArr[i] = lineList[i].checked;
									}
								}
							}
						});
				selected=order;
	} else {
		var lineList = $(".line_array");
		for (var i = 0; i < lineList.length; i++) {
			if (lineList[i].checked != checkedLineArr[i]) {
				getCheckedList(lineList[i]);
				checkedLineArr[i] = lineList[i].checked;
			}
		}
	}

}


/**
 * 获取状态改变的check
 * @param changedCheck
 */
function getCheckedList(changedCheck) {
	
	var pORc=changedCheck.name;//判断是该项为子项还是父项
	if(pORc=="roadLine"){
		lineCheckChange(changedCheck.checked);
	}else if(pORc=="car"){
		busCheckChange(changedCheck);
	}
	getDeviceInfo();
}

/**
 * line check改变后的操作
 * @param busList 
 * @param line_id
 * @param isChecked
 */
function lineCheckChange(isChecked){
	busList=$(".bus_array");
	for(var i=0;i<busList.length;i++){
		var bus=busList[i];
		bus.checked=isChecked;
		if(getBusIndex(bus.value)==-1){
			checkedIdList.push(new Bus(bus.id,bus.value,isChecked));//增加到选中check列表
		}else {
			var j=getBusIndex(bus.value);
			checkedIdList[j].isChecked=isChecked;//更新check属性的值
		}
	}
}

/**
 * bus check改变后的操作
 * @param busList
 * @param theBus
 */
function busCheckChange(theBus){
	busList=$(".bus_array");
	var lineList = $(".line_array");
	if(!theBus.checked){
		for(var i=0;i<lineList.length;i++){
			if(lineList[i].value==theBus.id)
				lineList[i].checked=false;
				checkedLineArr[i] = lineList[i].checked;
		}
		if(getBusIndex(theBus.value)!=-1){
			checkedIdList[getBusIndex(theBus.value)].isChecked=theBus.checked;
		}else{
			checkedIdList.push(new Bus(theBus.id,theBus.value,false));//增加到选中check列表
		}
	}else{
		var flag=new Boolean(true);
		for(var i=0;i<busList.length;i++){
			if(!busList[i].checked)
				flag=false;
		}
		for(var i=0;i<lineList.length;i++){
			if(lineList[i].value==theBus.id)
				lineList[i].checked=flag;
				checkedLineArr[i] = lineList[i].checked;
		}
	}
	if(getBusIndex(theBus.value)!=-1){
		checkedIdList[getBusIndex(theBus.value)].isChecked=theBus.checked;
	}else{
		checkedIdList.push(new Bus(theBus.id,theBus.value,theBus.checked));//增加到选中check列表
	}
}

/**
 * 获取bus_id在checkIdList中的索引
 * @param id bus_id
 * @returns {Number} 返回该id的索引,如果不存在则返回-1
 */
function getBusIndex(id){
	for(var i=0;i<checkedIdList.length;i++){
		if(checkedIdList[i].id==id)
			return i;
	}
	return -1;
}


/**
 * 获取bus_id在的check值
 * @param id bus_id
 * @returns {Number} 返回该id的check属性的值,如果不存在则返回-1
 */
function getCheckState(id){
	var flag=new Boolean(false);
	for(var i=0;i<checkedIdList.length;i++){
		if(checkedIdList[i].id==id)
			return checkedIdList[i].isChecked;
	}
	return -1;
}

/**
 * Bus对象
 */
function Bus(parent_id,id,isChecked){
	this.parent_id=parent_id;
	this.id=id;
	this.isChecked=isChecked;
}

/**
 * 显示某线路上的车辆的车牌号列表
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
				bus_list += "<li><a href='#' onclick='getAdInfo_bus({$vo.id})>' "+ bus_info[i].no + "</a></li>";
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
	//alert("dd");
	$.post(url, {
		is_getbuslist : 1,
		search_keys : keys
	}, function(data, status) {
	
		if (status == 4 || status == "success") {
			var bus_info = eval(data);
			var bus_list = "";
			for (var i = 0; i < bus_info.length; i++) {
				bus_list += "<li><a href='#' onclick='getAdInfo_bus("+bus_info[i].id+")' >" + bus_info[i].no + "</a></li>";
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

/**
 * ajax获取天气
 */
$(function () {
    $.post("/wifibus/index.php/Home/Weather/get_weather", {
        city_code: 370200,
    }, function (datas, status) {
        if (status == 4 || status == "success") {
            $("div#weather").html(datas);

        }
    });
})

