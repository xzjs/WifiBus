<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/10/14
 * Time: 下午5:06
 */
namespace Home\Controller;

use Think\Controller;

class CommandController extends Controller
{
    /**
     * @param $mac 路由器mac地址
     * @param $cmd 命令
     * @param $arg 回执参数
     */
    public function ping($mac, $cmd = '0', $arg = 0)
    {
        $Device=D("Device");
        $d=$Device->where('mac="'.$mac.'"')->find();
        $Command = M("Command");
        if($cmd=='0'){
            $data=$Command->where('device_id=' . $d['id'] . ' and status=0')->find();
            if($data){
                $this->output($data['cmd']);
            }else{
                $this->output('pong');
            }
            return;
        }
        $data=$Command->where('cmd="' . $cmd . '" and device_id="' . $d['id'] . '" and status=0')->find();
        switch ($cmd) {
            case "Reboot":
                break;
            case "Df":
                $Route = M('Route');
                $data = $Route->where('mac="' . $mac . '"')->find();
                $Route->useage_rate = $arg;
                $Route->where('id='.$data['id'])->save();
                break;
            case "Ssid":
                $data = $Command->where('mac="' . $mac . '"')->find();
                if ($arg != $data['ssid']) {
                    $Route = M('Route');
                    $data = $Route->where('mac="' . $mac . '"')->find();
                    if ($data['ssid'] == $arg) {
                        $Command->finish = 1;
                        $Command->where('mac="' . $mac . '"')->save();
                    }
                }
                break;
            case "Clean":
                break;
            default:
                $this->output('pong');
                return;
                break;
        }
        $Command->status = 1;
        $Command->where('id=' . $Command->id)->save();
        $this->output('pong');
    }

    public function index()
    {

    }

    /**
     * 格式化输出
     * @param $str 要输出的字符串
     */
    private function output($str)
    {
        echo "--$str";
    }
}