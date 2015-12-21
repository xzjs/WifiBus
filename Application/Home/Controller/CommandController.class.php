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
     * @param int|string $cmd 操作命令
     * @param int $arg 参数
     * @throws 命令更新异常
     */
    public function ping($mac,$lon,$lat,$online_num,$usage,$flow_num,$cmd = 0, $arg = 0)
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
            $b=$Bus->find($d['bus_id']);
            if($b){
                if($lon*$lat) {
                    $Bus->position_x = $lon;
                    $Bus->position_y = $lat;
                    $Bus->save();
                }
            }
            if($cmd){
                if(!$this->update($cmd,2)){
                    throw exception;
                }
            }else{
                $CommandModel=D('Command');
                $command_condition=array(
                    'device_id'=>$d['id'],
                    'status'=>0
                );
                $command=$CommandModel->where($command_condition)->find();
                if($command){
                    $this->output($command['cmd'],$command['id'],$command['arg']);
                    return;
                }
            }
        }
        $this->output('pong');
    }

    /**
     * 格式化输出
     * @param $str 要输出的字符串
     */
    private function output($str,$id=0,$arg=0)
    {
        echo "--$str:$id,$arg";
    }

    /**
     * 添加心跳命令
     * @param $device_id 设备id
     * @param $cmd 命令
     * @param int $arg 参数
     * @return mixed 插入的id或者false
     */
    public function add($device_id,$cmd,$arg=0){
        $CommandModel=D('Command');
        $data=array(
            'device_id'=>$device_id,
            'cmd'=>$cmd,
            'arg'=>$arg,
            'status'=>0,
            'time'=>time()
        );
        $CommandModel->create($data,1);
        $result=$CommandModel->add();
        return $result;
    }

    /**
     *修改心跳命令完成进度
     * @param $command_id 命令id
     * @param $status 要更新到额状态
     * @return bool 受影响的行数或者false
     */
    public function update($command_id,$status){
        $CommandModel=D('Command');
        $data=array(
            'id'=>$command_id,
            'status'=>$status
        );
        $CommandModel->create($data);
        return $CommandModel->save();
    }
}