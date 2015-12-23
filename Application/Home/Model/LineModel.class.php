<?php
namespace Home\Model;
use Think\Model;
class LineModel extends Model {
    /**
     * 定义验证规则
     * 线路名称不可重复
     * 线路id不能为空
     */
    protected $_validate    =   array(
        array('name','require','线路名称不能为空！'), 
        array('name','','线路名称已经存在',0,'unique',1),
    		array('name','','线路名称已经存在',0,'unique',2),
    );
 }