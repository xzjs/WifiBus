<?php
namespace Home\Model;
use Think\Model;
class LineModel extends Model {
    // 定义自动验证
    protected $_validate    =   array(
        array('name','require','线路名不能为空！'),
        );
 }