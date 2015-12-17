<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/12/16
 * Time: 下午5:06
 */
namespace Home\Controller;

use Think\Controller;

/**
 * Wifidog控制器
 * @package Home\Controller
 */
class WifidogController extends BaseController
{
    public function index()
    {

    }

    public function login(){
        $this->redirect('auth');
    }

    public function ping(){

    }

    public function auth(){
        echo "Auth: 1";
    }
}