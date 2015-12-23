<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/12/21
 * Time: 下午5:38
 */
namespace Home\Controller;

use Think\Controller;

class LogController extends BaseController
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
    public function add($mac, $lon, $lat, $online_num, $usage, $flow_num, $cmd, $arg)
    {
        if ($lon * $lat) {
            $LogModel = M('Log');
            $data = array(
                'mac' => $mac,
                'lon' => $lon,
                'lat' => $lat,
                'online_num' => $online_num,
                'usage' => $usage,
                'flow_num' => $flow_num,
                'cmd' => $cmd,
                'arg' => $arg,
                'time' => time()
            );
            $LogModel->add($data);
        }
    }
}