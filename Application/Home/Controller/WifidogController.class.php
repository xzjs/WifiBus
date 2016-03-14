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
    /**
     * 加判重条件（第二次登陆时时间大于30s写入数据库）
     * @param number $gw_port
     * @param string $gw_address
     * @param string $gw_id
     * @param string $mac
     */
    public function login($gw_port = 2060, $gw_address = '192.168.18.1', $gw_id = '0e:60:55:f3:3d:0a', $mac = '假的')
    {
        if (!S($gw_id . '.' . $mac . '.' . '0')) {
            S($gw_id . '.' . $mac . '.' . '0', time(), strtotime("tomorrow") - time());
            $data = array(
                'mac' => $mac,
                'device_mac' => $gw_id,
                'time' => S($gw_id . '.' . $mac . '.' . '0'),
                'is_back' => 0);
        } elseif ((time() - S($gw_id . '.' . $mac . '.' . '0') > 30) && (!S($gw_id . '.' . $mac . '.' . '1'))) {
            S($gw_id . '.' . $mac . '.' . '1', time(), strtotime("tomorrow") - time());
            $data = array(
                'mac' => $mac,
                'device_mac' => $gw_id,
                'time' => S($gw_id . '.' . $mac . '.' . '1'),
                'is_back' => 1);
        }
        $WifidoglogModel = M('Wifidoglog');
        $WifidoglogModel->add($data);
        $this->assign('url', "http://$gw_address:$gw_port/wifidog/auth?token=" . time());
        $this->show();


        /*$condition=array(
            'mac'=>$mac,
            'time'=>array('gt',strtotime('today'))
        );
        S ('x', 1345);
        S ('y', 2468 );

        var_dump(S('x').S('y'));
        $result=$WifidoglogModel->where($condition)->select();
        if(count($result)==0) {
            $is_back =  0;
            $data = array(
                'mac' => $mac,
                'device_mac' => $gw_id,
                'time' => time(),
                'is_back' => $is_back
            );
        }elseif((count($result)==1)&&((time()-$result[0]['time'])>30))
        {
            	$is_back =  1;
            	$data = array(
            			'mac' => $mac,
            			'device_mac' => $gw_id,
            			'time' => time(),
            			'is_back' => $is_back);
          }*/
    }

    public function ping()
    {
        echo 'pong';
    }

    public function auth($token)
    {
        echo "Auth: 1";
    }

    public function portal()
    {
        redirect('192.168.50.1', 1);
    }
}