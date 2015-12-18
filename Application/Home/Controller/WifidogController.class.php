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
    public function login($gw_port,$gw_address){
        echo $gw_port;
        echo $gw_address;
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
        echo "hello";
    }

    public function gw_message()
    {
        if (isset($_REQUEST["message"])) {
            echo $_REQUEST['message'];
            switch ($_REQUEST["message"]) {
                case 'failed_validation':
                    //auth的stage为login时，被服务器返回AUTH_VALIDATION_FAILED时，来到该处处理
                    //认证失败，请重新认证
                    break;
                case 'denied':
                    //auth的stage为login时，被服务器返回AUTH_DENIED时，来到该处处理
                    //认证被拒
                    break;
                case 'activate':
                    //auth的stage为login时，被服务器返回AUTH_VALIDATION时，来到该处处理
                    //待激活
                    break;
                default:
                    break;
            }
        } else {
            //不回显任何信息
            echo '出错了';
        }
    }
}