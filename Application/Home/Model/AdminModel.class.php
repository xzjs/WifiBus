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
        //array('name','','帐号名称已经存在！',0,'unique',1),
    	array('name','require','用户名不能为空，请重新输入！'),
    	array('pwd','require','密码不能为空,请重新输入！'),
    );

    /**
     * 定义自动完成
     * @var array
     */
    protected $auto=array(
        array('pwd','md5',3,'function') ,
        array('type','Low'),
    );
}