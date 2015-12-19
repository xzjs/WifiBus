<?php
namespace Home\Model;
use Think\Model;
class AdModel extends Model {
    protected $_validate = array(
			array('type','require','用户id必须'),
	);
    
    protected $_auto = array (
    		array('text','time',2,'function'), // 对update_time字段在更新的时候写入当前时间戳
    );
    
 }