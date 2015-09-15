<?php
namespace Home\Model;
use Think\Model;
class LineModel extends Model {
    // 定义自动验证
    protected $_validate    =   array(
        array('line_id','require','线路Id不能为空！'),
        );
 }