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
     * 心跳接口
     * @param $mac 设备mac
     * @param $lon 经度
     * @param $lat 纬度
     * @param $online_num 在线人数
     * @param $usage 使用率
     * @param $flow_num 使用流量
     * @param string $cmd 操作命令
     * @param int $arg 参数
     */
    public function ping($mac,$lon,$lat,$online_num,$usage,$flow_num,$cmd = '0', $arg = 0)
    {
        $Device=D("Device");
        $condition['mac']=$mac;
        $d=$Device->where($condition)->find();
        if($d){
            $Device->useage=$usage;
            $Device->online_num=$online_num;
            $Device->flow_num=$flow_num;
            $Device->time=time();
            $Device->save();
            $Bus=D('Bus');
            $b=$Bus->find($Device->bus_id);
            if($b){
                if($lon*$lat) {
                    $Bus->position_x = $lon;
                    $Bus->position_y = $lat;
                    $Bus->save();
                }
            }
        }
        $this->output('pong');
        /*$Command = M("Command");
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
        $this->output('pong');*/
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