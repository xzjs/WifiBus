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
	 * 添加ssh功能
	 * @param $device_id 设备id
	 * @param $cmd 命令
	 * @param int $arg 参数
	 * @return mixed 插入的id或者falsedui
	 */
	public function ssh_add()
	{
		$device_id=I('post.device_id');
	    $cmd='Ssh'; 
	    $arg=I('post.arg');
		$CommandModel = D('Command');
		$data = array(
				'device_id' => $device_id,
				'cmd' => $cmd,
				'arg' => $arg,
				'status' => 0,
				'time' => time()
		);
		$CommandModel->create($data, 1);
		$result = $CommandModel->add();
		echo $result;
	}
    /**
     * 查询失联设备
     * 返回mac,bus_id
     */
    public function select_dead_devic()
    {
        $de = D('Device');
        $result = $de->where("(UNIX_TIMESTAMP(NOW())-TIME) >30")->select();
        echo json_encode($result);

    }

    /**
     * 心跳接口
     * @param 设备mac|string $mac 设备mac
     * @param 经度|int $lon 经度
     * @param 纬度|int $lat 纬度
     * @param 在线人数|int $online_num 在线人数
     * @param 使用率|int $usage 使用率
     * @param 使用流量|int $flow_num 使用流量
     * @param int|string $cmd 操作命令
     * @param int $arg 参数
     * @throws
     */
    public function ping($mac='2e:60:ed:d8:3d:0a', $lon=120, $lat=36, $online_num=0, $usage=0, $flow_num=0, $cmd = 0, $arg = 0)
    {
        $LogCtrl = A('Log');
        $LogCtrl->add($mac, $lon, $lat, $online_num, $usage, $flow_num, $cmd, $arg);
        $Device = D("Device");
        $condition['mac'] = $mac;
        $d = $Device->where($condition)->find();
        $CommandModel = D('Command');
        if ($d) {
            $Device->useage = $usage;
            $Device->online_num = $online_num;
            $flow_num = $flow_num < 0 ? 0 : $flow_num;
            $Device->flow_num = $flow_num + $d['flow_num'];
            $DeviceCtrl = A('Device');
            $FlowCtrl = A('Flow');
            $FlowCtrl->update($flow_num, $d['id']);
            $Device->time = time();
            $Device->save();
            $Bus = D('Bus');
            $b = $Bus->find($d['bus_id']);
            $LogModel = M('Log');
            $log_condition['mac'] = $mac;
            $log_num = $LogModel->where($log_condition)->count();
            if ($log_num % 300 == 0 && $log_num) {
                $this->add($d['id'], 'Reboot');
            }
            if ($b) {
                if ($lon * $lat) {
                    $du = floor($lat / 100);
                    $new_lon = $du + ($lat - $du * 100) / 60;
                    $du = floor($lon / 100);
                    $new_lat = $du + ($lon - $du * 100) / 60;
                    $Bus->position_x = $new_lon;
                    $Bus->position_y = $new_lat;
                    $Bus->save();
                }
            }
            if ($cmd) {
                $data_c = array(
                    'status' => 2,
                    'return_arg' => $arg
                );
                if (!$CommandModel->where("id=$cmd")->save($data_c)) {
                    throw exception;
                }
            }

            $command_condition = array(
                'device_id' => $d['id'],
                'status' => 0
            );
            $command = $CommandModel->where($command_condition)->find();
            if ($command) {
                $this->output($command['cmd'], $command['id'], $command['arg']);
                return;
            }
        }
        $this->output('pong');
    }

    /**
     * 格式化输出
     * @param $str 要输出的字符串
     */
    private function output($str, $id = 0, $arg = 0)
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
    public function add($device_id, $cmd, $arg = 0)
    {
        $CommandModel = D('Command');
        $data = array(
            'device_id' => $device_id,
            'cmd' => $cmd,
            'arg' => $arg,
            'status' => 0,
            'time' => time()
        );
        $CommandModel->create($data, 1);
        $result = $CommandModel->add();
        return $result;
    }

    /**
     *修改心跳命令完成进度
     * @param $command_id 命令id
     * @param $status 要更新到额状态
     * @return bool 受影响的行数或者false
     */
    public function update($command_id, $status)
    {
        $CommandModel = D('Command');
        $data = array(
            'id' => $command_id,
            'status' => $status,
            'time' => time()
        );
        $CommandModel->create($data);
        $result = $CommandModel->save();
        echo $result;
        return $result;
    }

    /**
     * 获取心跳命令的结果
     * @param $id 命令id
     */
    public function get_result($id)
    {
        $CommandModel = D('Command');
        $result = $CommandModel->find($id);
        echo json_encode($result);
    }
}