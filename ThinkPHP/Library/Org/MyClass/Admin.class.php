<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/9/15
 * Time: 上午9:22
 */

namespace Org\MyClass;

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
    public function logout($id){

    }
}