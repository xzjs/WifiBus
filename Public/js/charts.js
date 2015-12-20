// ****************************
// 总览中的一些饼状图Pie
// ****************************
var myColor = ['#10C460', '#DE4949', '#CEC51A', '#16A2EF'];
var labelFromatter = {
    normal: {
        label: {
            formatter: function (params) {
                return Math.round((100 - params.value) * 100) / 100 + '%'
            },
            textStyle: {
                baseline: 'top'
            }
        }
    },
};
var labelTop = {
    normal: {
        label: {
            show: false
        },
        labelLine: {
            show: false
        }
    }
};
var labelBottom = {
    normal: {
        color: '#ccc',
        label: {
            show: true,
            position: 'center',
            textStyle: {
                fontSize: 26,
                fontFamily: 'Microsoft YaHei, sans-serif',
                color: '#fff',
            }
        },
        labelLine: {
            show: false
        }
    },
    emphasis: {
        color: 'rgba(0,0,0,0)'
    }
};

// 正在工作设备量
function workOption(a, url) {
    var optionWork = {
        legend: {
            orient: 'vertical',
            x: 'right',
            y: 'bottom',
            data: ['正在工作设备量', '设备总量'],
            textStyle: {
                color: '#fff'
            }
        },
        title: {
            x: 'center',
            y: 'center',
            text: '正常工作\n',
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 20,
                color: '#FF7F50',
                textAlign: 'center'
            },
            link: url,
            target: 'self'

        },
        series: [{
            name: '正常工作',
            type: 'pie',
            radius: ['50%', '70%'],
            itemStyle: labelFromatter,
            data: [{
                value: (100 - a),
                name: '设备总量',
                itemStyle: labelBottom
            }, {

                value: a,
                name: '正在工作设备量',
                itemStyle: labelTop
            }]
        }]
    };
    return optionWork;
}

//在线人数
function onlineOption(a, url) {
    var optionOnline = {
        legend: {
            orient: 'vertical',
            x: 'right',
            y: 'bottom',
            data: ['当前在线总人数', '可承载人数'],
            textStyle: {
                color: '#fff'
            }
        },
        title: {
            x: 'center',
            y: 'center',
            text: '在线人数\n',
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 20,
                color: myColor[1],
                textAlign: 'center'
            },
            link: url,
            target: 'self'

        },
        series: [{
            name: '在线人数',
            type: 'pie',
            radius: ['50%', '70%'],
            itemStyle: labelFromatter,
            data: [{
                value: a,
                name: '已经认证人数',
                itemStyle: labelBottom

            }, {
                value: (100 - a),
                name: '当前在线总人数',
                itemStyle: {
                    normal: {
                        color: myColor[1],
                        label: {
                            show: false,
                        },
                        labelLine: {
                            show: false
                        }
                    }
                },
            }]
        }]
    };

    return optionOnline;
};

// 流量
function flowOption(c, url) {
    var optionFlow = {
        legend: {
            orient: 'vertical',
            x: 'right',
            y: 'bottom',
            data: ['已用流量', '所有设备流量总量'],
            textStyle: {
                color: '#fff'
            }
        },
        title: {
            x: 'center',
            y: 'center',
            text: '流量已用\n',
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 20,
                color: myColor[3],
            },
            link: url,
            target: 'self'

        },
        series: [{
            name: '流量已用',
            type: 'pie',
            radius: ['50%', '70%'],
            itemStyle: labelFromatter,
            data: [{
                value: (100 - c),
                name: '所有设备流量总量',
                itemStyle: labelBottom

            }, {
                value: c,
                name: '已用流量',
                itemStyle: {
                    normal: {
                        color: myColor[3],
                        label: {
                            show: false,
                        },
                        labelLine: {
                            show: false
                        }
                    }
                },
            }]
        }]
    };

    return optionFlow;
};

// 广告点击量
function adOption(a, url) {
    var optionAd = {
        legend: {
            orient: 'vertical',
            x: 'right',
            y: 'bottom',
            data: ['广告点击量', '本地资源访问量', 'APP下载量'],
            textStyle: {
                color: '#fff'
            }
        },
        title: {
            x: 'center',
            y: 'center',
            text: '广告点击量',
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 20,
                color: '#fff'
            },
            link: url,
            target: 'self'

        },
        series: [{
            name: '广告点击量',
            type: 'pie',
            radius: ['50%', '70%'],
            itemStyle: {
                normal: {
                    label: {
                        show: false
                    },
                    labelLine: {
                        show: false
                    }
                }
            },
            data: [{
                value: a,
                name: '广告下载量',

            }, {
                value: (70 - a),
                name: '本地资源访问量',
            }, {
                value: 30,
                name: 'APP下载量',
            }]
        }]
    };

    return optionAd;
};

// ***************************************
// 总览中的一些饼状图Pie  End end end end 
// ***************************************


// ***************************************
// 广告和流量分析中的一些图表   
// ***************************************

// 广告点击量
function adMainFunction(text,click_num) {
    var tempOption = {
        title: {
            text: '广告点击量',
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 24,
                color: '#fff'
            }
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: ['2015年'],
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 16,
                color: '#fff'
            }
        },
        xAxis: [{
            type: 'value',
            boundaryGap: [0, 0.01],
            axisLabel: {
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            },
        }],
        yAxis: [{
            type: 'category',
            data: text,
            axisLabel: {
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            },
        }],
        series: [{
            name: '2015年',
            type: 'bar',
            data: click_num,
        }]
    };
    return tempOption;
};

// 广告点击量时间关系图
function adMainTimeFunction(date1, date2) {
    var tempOption = {
        title: {
            text: '广告点击量时间关系图',
            x: 'center',
            y: 'bottom',
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 18,
                color: '#fff'
            }
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: ['上周', '本周'],
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 12,
                color: '#fff'
            }
        },
        xAxis: [{
            type: 'category',
            boundaryGap: false,
            data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日'],
            axisLabel: {
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            },
        }],
        yAxis: [{
            type: 'value',
            axisLabel: {
                formatter: '{value}',
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            }
        }],
        series: [{
            name: '上周',
            type: 'line',
            data: [date1[0], date1[1], date1[2], date1[3], date1[4], date1[5], date1[6]],

        }, {
            name: '本周',
            type: 'line',
            data: [date2[0], date2[1], date2[2], date2[3], date2[4], date2[5], date2[6]],
        }]
    };
    return tempOption;
}

// 流量时间关系图
function adMainFlowFunction(date) {
    var tempOption = {
        title: {
            text: ' 流量时间关系图',
            x: 'center',
            y: 'bottom',
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 18,
                color: '#fff'
            }
        },
        tooltip: {
            trigger: 'axis'
        },
        xAxis: [{
            type: 'category',
            boundaryGap: false,
            data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日'],
            axisLabel: {
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            },
        }],
        yAxis: [{
            type: 'value',
            axisLabel: {
                formatter: '{value}',
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            }
        }],
        series: [{
            name: '流量',
            type: 'line',
            data: [date[0], date[1], date[2], date[3], date[4], date[5], date[6]],
            itemStyle: {
                normal: {
                    color: myColor[0]
                }
            },
        }]
    };
    return tempOption;
}

// 客流量时间关系图
function adMainCustomerFunction(date) {
    var tempOption = {
        title: {
            text: '客流量时间关系图',
            x: 'center',
            y: 'bottom',
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 18,
                color: '#fff'
            }
        },
        tooltip: {
            trigger: 'axis'
        },
        xAxis: [{
            type: 'category',
            boundaryGap: false,
            data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日'],
            axisLabel: {
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            },
        }],
        yAxis: [{
            type: 'value',
            axisLabel: {
                formatter: '{value}',
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            }
        }],
        series: [{
            name: '客流量',
            type: 'line',
            data: [date[0], date[1], date[2], date[3], date[4], date[5], date[6]],
            itemStyle: {
                normal: {
                    color: myColor[2]
                }
            },
        }]
    };
    return tempOption;
}

// 回头率时间关系图
function adMainTurnBackFunction(date) {
    var tempOption = {
        title: {
            text: '回头率时间关系图',
            x: 'center',
            y: 'bottom',
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 18,
                color: '#fff'
            }
        },
        tooltip: {
            trigger: 'axis'
        },
        xAxis: [{
            type: 'category',
            boundaryGap: false,
            data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日'],
            axisLabel: {
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            },
        }],
        yAxis: [{
            type: 'value',
            axisLabel: {
                formatter: '{value}',
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            }
        }],
        series: [{
            name: '回头率',
            type: 'line',
            data: [date[0], date[1], date[2], date[3], date[4], date[5], date[6]],
            itemStyle: {
                normal: {
                    color: myColor[1]
                }
            },
        }]
    };
    return tempOption;
}
// ***************************************
// 广告和流量分析中的一些图表 End end end
// ***************************************


// **********************************
// 广告流量分析－－综合分析
// **********************************

// 广告点击量客流量流量使用量
function adAnlyOptionFunction1() {
    var tempOption = {
        title: {
            text: '广告点击量客流量流量使用量',
            x: 'center',
            y: 'bottom',
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 18,
                color: '#fff'
            },
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: ['广告点击量', '客流量', '流量'],
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 14,
                color: '#fff'
            }
        },
        xAxis: [{
            type: 'category',
            data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日'],
            axisLabel: {
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            },
        }],
        yAxis: [{
            type: 'value',
            axisLabel: {
                formatter: '{value}',
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            }
        }],
        series: [{
            name: '广告点击量',
            type: 'bar',
            data: [20, 58, 44, 38, 77, 68, 40],
        }, {
            name: '客流量',
            type: 'bar',
            data: [10, 40, 14, 20, 39, 61, 28],
        }, {
            name: '流量',
            type: 'bar',
            data: [26, 60, 35, 66, 16, 37, 45],
        }]
    };
    return tempOption;
};

// 广告点击量客流量时间
function adAnlyOptionFunction2() {
    var tempOption = {
        title: {
            text: '广告点击量客流量时间',
            x: 'center',
            y: 'bottom',
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 18,
                color: '#fff'
            },
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: ['广告点击量', '客流量'],
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 14,
                color: '#fff'
            }
        },
        xAxis: [{
            type: 'category',
            data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日'],
            axisLabel: {
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            },
        }],
        yAxis: [{
            type: 'value',
            axisLabel: {
                formatter: '{value}',
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            }
        }],
        series: [{
            name: '广告点击量',
            type: 'bar',
            data: [20, 58, 44, 38, 77, 68, 40],
            itemStyle: {
                normal: {
                    color: '#C12E34'
                }
            }
        }, {
            name: '客流量',
            type: 'bar',
            data: [10, 40, 14, 20, 39, 61, 28],
            itemStyle: {
                normal: {
                    color: '#EDCB4C'
                }
            }
        }]
    };
    return tempOption;
}

// 广告点击量流量时间
function adAnlyOptionFunction3() {
    var tempOption = {
        title: {
            text: '广告点击量流量时间',
            x: 'center',
            y: 'bottom',
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 18,
                color: '#fff'
            },
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: ['广告点击量', '流量'],
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 14,
                color: '#fff'
            }
        },
        xAxis: [{
            type: 'category',
            data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日'],
            axisLabel: {
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            },
        }],
        yAxis: [{
            type: 'value',
            axisLabel: {
                formatter: '{value}',
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            }
        }],
        series: [{
            name: '广告点击量',
            type: 'bar',
            data: [20, 58, 44, 38, 77, 68, 40],
            itemStyle: {
                normal: {
                    color: '#ED9678'
                }
            }
        }, {
            name: '流量',
            type: 'bar',
            data: [26, 60, 35, 66, 16, 37, 45],
            itemStyle: {
                normal: {
                    color: '#DAAFA9'
                }
            }
        }]
    };
    return tempOption;
}

// 客流量量流量时间
function adAnlyOptionFunction4() {
    var tempOption = {
        title: {
            text: '客流量量流量时间',
            x: 'center',
            y: 'bottom',
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 18,
                color: '#fff'
            },
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: ['客流量', '流量'],
            textStyle: {
                fontFamily: 'Microsoft YaHei, sans-serif',
                fontSize: 14,
                color: '#fff'
            }
        },
        xAxis: [{
            type: 'category',
            data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日'],
            axisLabel: {
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            },
        }],
        yAxis: [{
            type: 'value',
            axisLabel: {
                formatter: '{value}',
                textStyle: {
                    fontFamily: 'Microsoft YaHei, sans-serif',
                    fontSize: 14,
                    color: '#fff'
                }
            }
        }],
        series: [{
            name: '客流量',
            type: 'bar',
            data: [10, 40, 14, 20, 39, 61, 28],
            itemStyle: {
                normal: {
                    color: '#EC6A98'
                }
            }
        }, {
            name: '流量',
            type: 'bar',
            data: [26, 60, 35, 66, 16, 37, 45],
            itemStyle: {
                normal: {
                    color: '#F7EA83'
                }
            }
        }]
    };
    return tempOption;
}


// ********************************
// 广告流量分析－－综合分析 End
// ********************************

//*********************************
//排行分析
//*********************************
function adver_rankOptionFunction3() {
    option = {
        color:["#669966"],
        title : {
            text: '当日故障率TOP10',
            textStyle:{
                "color":"#FFFFFF"
            }
        },
        tooltip : {
            trigger: 'axis'
        },

        calculable : true,
        xAxis : [
            {
                type : 'value',
                boundaryGap : [0, 0.001],
                axisLabel:{
                    textStyle:{
                        "color":"#FFFFFF"
                    }
                }
            }
        ],
        yAxis : [
            {
                type : 'category',
                data : ['鲁B123','鲁B124','鲁B125','鲁B126','鲁B127','鲁B128','鲁B127','鲁B129','鲁B138','鲁B139','鲁B130'],
                axisLabel:{
                    textStyle:{
                        "color":"#FFFFFF"
                    }
                }
            }
        ],
        series : [

            {

                type:'bar',
                data:[19, 23, 31,35, 50, 63,64,65,66,67,68,68,69,69]
            }
        ]
    };
    return option;
}

function adver_rankOptionFunction2(){
    option = {
        title : {
            text: '当日上网用户TOP10',
            textStyle:{
                "color":"#FFFFFF"
            }
        },
        tooltip : {
            trigger: 'axis'
        },

        calculable : true,
        xAxis : [
            {
                type : 'value',
                boundaryGap : [0, 0.001],
                axisLabel:{
                    textStyle:{
                        "color":"#FFFFFF"
                    }
                }
            }
        ],
        yAxis : [
            {
                type : 'category',
                data : ['鲁B123','鲁B124','鲁B125','鲁B126','鲁B127','鲁B128','鲁B127','鲁B129','鲁B138','鲁B139','鲁B130'],
                axisLabel:{
                    textStyle:{
                        "color":"#FFFFFF"
                    }
                }
            }
        ],
        series : [

            {

                type:'bar',
                data:[ 10,23, 31,35, 50, 63,70,100,110,129,188]
            }
        ]
    };
    return option;
}

function adver_rankOptionFunction1(){
    option = {
        color:["#FF6666"],
        title: {
            text: '当日用户上网走势',
            textStyle:{
                "color":"#FFFFFF"
            }
        },
        tooltip: {
            trigger: 'axis'
        },
        calculable: true,
        xAxis: [
            {
                type: 'category',
                boundaryGap: false,
                data: ['5:00', '6:00', '7:00', '8:00', '9:00', '10:00', '11:00',
                    '12:00', '13:00', '14:00', '15:00', '16:00', '17:00',
                    '18:00', '19:00', '20:00', '21:00', '22:00', '23:00',
                    '24:00', '00:00', '01:00', '02:00', '03:00', '04:00',
                    '05:00'],
                axisLabel:{
                    textStyle:{
                        "color":"#FFFFFF"
                    }
                }
            }
        ],
        yAxis: [
            {
                type: 'value',
                axisLabel: {
                    formatter: '{value}人次'
                },
                axisLabel:{
                    textStyle:{
                        "color":"#FFFFFF"
                    }
                }
            }
        ],
        series: [
            {
                name: '连接人次',
                type: 'line',
                data: [1, 3, 12, 13, 12, 13, 10, 15, 12, 10, 1, 6, 8, 9, 5, 5, 8, 1, 0, 0, 0, 0, 0, 0, 0],
                markPoint: {
                    data: [
                        {type: 'max', name: '×î´óÖµ'},
                        {type: 'min', name: '×îÐ¡Öµ'}
                    ]
                }

            }

        ]
    };
    return option;
}

//**************************
//足迹分析
//**************************
function footprintFunction(){
    option = {
        color:["#0099CC"],
        title : {
            text: '各站联网人数',
            textStyle:{
                "color":"#FFFFFF"
            }
        },
        tooltip : {
            trigger: 'axis'
        },

        calculable : true,
        xAxis : [
            {
                type : 'value',
                boundaryGap : [0, 0.001],
                axisLabel:{
                    textStyle:{
                        "color":"#FFFFFF"
                    }
                }
            }
        ],
        yAxis : [
            {
                type : 'category',
                data : ['石油大学','公共艺术园','东方华庭','上流汇','码头休闲村','海云家园','北船','武船','风和日丽','大湾港路','佳家园'],
                axisLabel:{
                    textStyle:{
                        "color":"#FFFFFF"
                    }
                }
            }
        ],
        series : [

            {

                type:'bar',
                data:[19, 23, 31,35, 50, 63,64,65,66,67,68,68,69,69]
            }
        ]
    };
    return option;
}