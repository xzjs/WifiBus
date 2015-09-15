<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/9/15
 * Time: 上午11:05
 */

namespace Home\Controller;
use Org\MyClass\Admin;
use Think\Controller;

class AdminController extends Controller
{
    /**
     * 登录
     */
    public function loginx(){
        $data['name']=I('post.name');
        $data['pwd']=I('post.pwd');
        $a=new Admin();
        $o=$a->login($data);
        if($o){
            $_SESSION['admin']=$o;
            var_dump($o);
        }else{
            $this->error('登录失败');
        }
    }
}