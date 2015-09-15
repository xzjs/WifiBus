<?php
namespace Home\Model;
use Think\Model;
class LineModel extends Model {
    // 定义自动验证
    protected $_validate    =   array(
        array('ssid','require','设备ssid不能为空！'),
    	array('bus_id','require','bus_id不能为空！'),
        );
 }