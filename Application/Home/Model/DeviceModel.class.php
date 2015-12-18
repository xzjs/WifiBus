<?php
namespace Home\Model;
use Think\Model;
class DeviceModel extends Model {
    // 定义自动验证
    protected $_validate    =   array(
        array('ssid','require','设备ssid不能为空！'),
    	array('bus_id','require','bus_id不能为空！'),
    	array('ssid','unique','设备id重复！'),
        );

    /**
     * 定义自动完成
     * @var array
     */
    protected $_auto = array (
        array('time','time',3,'function'), // 对update_time字段在更新的时候写入当前时间戳
    );
 }