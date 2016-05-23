<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 16/5/23
 * Time: 下午1:41
 */
namespace Home\Controller;

use Think\Controller;

class UserController extends BaseController
{
    /**
     * 手机认证注册登录
     * @param string $gw_port 路由器端口号
     * @param string $gw_address 路由器ip
     * @param string $phone 用户手机号
     * @param string $code 验证码
     */
    public function login($gw_port = '', $gw_address = '', $phone = '', $code = '')
    {
        $UserModel = M('User');
        $UserModel->getByPhone($phone);
        if ($UserModel->code == $code) {
            $token = $phone + $code + time();
            redirect("http://$gw_address:$gw_port/wifidog/token=$token");
        } else {
            $this->error('验证码错误');
        }
    }
}