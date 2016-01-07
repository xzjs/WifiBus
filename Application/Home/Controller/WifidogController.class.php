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
class WifidogController extends Controller
{
    public function login($gw_port=2060,$gw_address='192.168.18.1',$gw_id='0e:60:55:f3:3d:0a',$mac='假的'){
        $WifidoglogModel=M('Wifidoglog');
        $condition=array(
            'mac'=>$mac,
            'time'=>array('gt',strtotime('today'))
        );
        $result=$WifidoglogModel->where($condition)->select();
        $is_back=count($result)>0?1:0;
        $data=array(
            'mac'=>$mac,
            'device_mac'=>$gw_id,
            'time'=>time(),
            'is_back'=>$is_back
        );
        $WifidoglogModel->add($data);
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