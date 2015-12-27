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
    public function login($gw_port=2060,$gw_address='192.168.18.1'){
        $this->assign('url',"http://$gw_address:$gw_port/wifidog/auth?token=".time());
        $this->show();
    }

    public function ping(){
        echo 'pong';
    }

    public function auth($token){
        echo "Auth: 1";
    }

    public function portal(){
        redirect('http://wifi21.com',1);
    }
}