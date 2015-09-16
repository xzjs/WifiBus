<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/9/15
 * Time: 上午11:00
 */

namespace Home\Model;
use Think\Model;

class AdminModel extends Model{
    /**
     * 定义验证规则
     * @var array 用户名不可重复
     */
    protected $_validate=array(
        array('name','unique','用户名重复')
    );
}