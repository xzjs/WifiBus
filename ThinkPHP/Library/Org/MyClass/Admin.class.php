<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/9/15
 * Time: 上午9:22
 */

namespace Org\MyClass;
use Think\Exception;

/**
 * Class Admin
 * @package Org\MyClass
 */
class Admin
{
    protected $id;
    protected $name;
    protected $pwd;

    /**
     * 登录
     * @param $adminData post传递过来的登录数据
     * @return null 返回admin对象或空
     */
    public function login($adminData){
        $Admin=M("Admin");
        $data=$Admin->where('name="'.$adminData['name'].'" and pwd="'.md5($adminData['pwd']).'"')->find();
        if($data){
            $str='Org\MyClass\\'.$Admin->getField('type').'AdminFactory';
            $class=new \ReflectionClass($str);
            $instance=$class->newInstance();
            $a = $instance->startFactory($Admin);
            return $a;
        }else{
            return null;
        }
    }

    /**
     * 登出
     * @param $id 用户id
     */
    public function logout(){
        session_unset();
        session_destroy();
    }

    /**
     * 修改密码
     * @param $data 传入的密码数组
     * @return bool 受影响的行数或者false
     * @throws Exception 原密码不对和两次输入的密码不一致
     */
    public function update_pwd($data){
        $a=$_SESSION['admin'];
        if(md5($data['old_pwd'])!=$a->pwd){
            throw new Exception('原密码不对');
        }
        if($data['new_pwd1']!=$data['new_pwd2']){
            throw new Exception('两次输入的密码不一致');
        }
        $Admin=M('Admin');
        $result=$Admin->where('id='.$a->id)->setField('pwd',md5($data['new_pwd1']));
        if($result){
            $a->pwd=md5($data['new_pwd1']);
            $_SESSION['admin']=$a;
        }
        return $result;
    }
}