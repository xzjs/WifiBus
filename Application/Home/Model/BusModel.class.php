<?php
namespace Home\Model;

use Think\Model\RelationModel;

class BusModel extends RelationModel
{
    /**
     * 定义验证规则
     * 车牌号不可重复
     * 线路id不能为空
     */
    protected $_validate = array(
        array('line_id', 'require', '线路Id不能为空！'),
    	array('no','require','车牌号不能为空'),
    		array('no','','车牌号名称已经存在！',0,'unique',1),
    		//array('no','','车牌号名称已经存在！',0,'unique',2),
    );

    /**
     * 关联模型
     * @var array
     */
    protected $_link = array(
        'Device'=> self::HAS_ONE,
    );

    /**
     * @var array 自动完成
     */
    protected $_auto = array (
        array('position_x','0'),  // 新增的时候把status字段设置为1
        array('position_y','0'),  // 新增的时候把status字段设置为1
    );
}