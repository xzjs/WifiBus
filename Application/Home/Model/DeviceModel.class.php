<?php
namespace Home\Model;
use Think\Model\RelationModel;
class DeviceModel extends RelationModel {
    // 定义自动验证
    protected $_validate    =   array(
    		array('mac','require','mac不能为空'),
    		//array('mac','','mac名称已经存在！',0,'unique',1),
       // array('ssid','require','设备ssid不能为空！'),
    	//array('bus_id','require','bus_id不能为空！'),
    	//array('ssid','unique','设备id重复！'),
        );

    /**
     * 定义自动完成
     * @var array
     */
    protected $_auto = array (
        array('time','time',3,'function'), // 对update_time字段在更新的时候写入当前时间戳
    );

    /**
     * @var array 关联模型数组
     */
    protected $_link = array(
        'Media'=> self::MANY_TO_MANY,
    );
 }