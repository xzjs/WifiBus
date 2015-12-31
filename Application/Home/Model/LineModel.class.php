<?php
namespace Home\Model;
use Think\Model\RelationModel;

class LineModel extends RelationModel{
    /**
     * 定义验证规则
     * 线路名称不可重复
     * 线路id不能为空
     */
    protected $_validate    =   array(
        array('name','require','线路名称不能为空！'), 
        array('name','','线路名称已经存在',0,'unique',3),
    );
    
    /**
     * 关联模型
     * @var array
     */
    protected $_link = array(
    		'Bus'=> self::HAS_MANY,
    );
 }