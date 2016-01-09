<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/12/21
 * Time: 下午5:38
 */
namespace Home\Controller;

use Think\Controller;

class LogController extends Controller
{
    /**
     * 日志添加功能
     * @param $mac 设备mac
     * @param $lon 经度
     * @param $lat 纬度
     * @param $online_num 在线人数
     * @param $usage 磁盘使用率
     * @param $flow_num 已使用流量
     * @param $cmd 操作命令
     * @param $arg 参数
     */
    public function add($mac, $lon, $lat, $online_num, $usage, $flow_num, $cmd, $arg, $heartbeat)
    {
        $LogModel = M('Log');
        $data = [
            'mac' => $mac,
            'lon' => $lon,
            'lat' => $lat,
            'online_num' => $online_num,
            'usage' => $usage,
            'flow_num' => $flow_num,
            'cmd' => $cmd,
            'arg' => $arg,
            'heartbeat' => $heartbeat,
            'time' => time()
        ];
        $LogModel->add($data);
        $num = $LogModel->count();
        if ($num > 200000) {
            $condition['id'] = array('LT', $num - 100000);
            $LogModel->where($condition)->delete();
        }
    }
}