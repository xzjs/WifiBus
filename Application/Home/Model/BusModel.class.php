<?php
namespace Home\Model;
use Think\Model;
class BusModel extends Model {
    /**
     * 定义验证规则
     * 车牌号不可重复
     * 线路id不能为空
     */
    protected $_validate    =   array(
        array('line_id','require','线路Id不能为空！'),
        );
    
 }