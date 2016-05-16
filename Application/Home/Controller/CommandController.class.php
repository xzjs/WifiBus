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
        $device_id = I('post.device_id');
        $cmd = 'Ssh';
        $arg = I('post.arg');
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
     * @param string $mac 设备mac
     * @param int $lon 经度
     * @param int $lat 纬度
     * @param int $online_num 在线人数
     * @param int $usage 使用率
     * @param int $flow_num 使用流量
     * @param int|string $cmd 操作命令
     * @param int $arg 参数
     * @throws
     */
    public function ping($mac = '2e:60:ed:d8:3d:0a', $lon = 120, $lat = 36, $online_num = 0, $usage = 0, $flow_num = 0, $cmd = 0, $arg = 0, $ver = 0)
    {
        $LogCtrl = A('Log');
        $LogCtrl->add($mac, $lon, $lat, $online_num, $usage, $flow_num, $cmd, $arg, $ver);

        $CommandModel = D('Command');
        $DeviceModel = D('Device');
        //获取设备信息
        $d = $this->getDevice($mac);
        if ($d) {
            $d['useage'] = $usage;
            $d['online_num'] = $online_num;
            $flow_num = $flow_num < 0 ? 0 : $flow_num;
            $d['flow_num'] = $flow_num + $d['flow_num'];

            $d['time'] = time();
            $DeviceModel->save($d);

            //增加流量
            $this->addFlow($d['id'], $flow_num);

            //自动化限速
            $this->auto_limit($d['id']);

            $Bus = D('Bus');
            $b = $Bus->find($d['bus_id']);
            $LogModel = M('Log');
            $log_condition['mac'] = $mac;
            $log_num = $LogModel->where($log_condition)->count();
            $debug = $d['debug'];
            if ($log_num % 300 == 0 && $log_num && $debug == 0) {
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

    /**
     * 任意文件上传到任意位置测试函数
     */
    public function anyfile_test()
    {
        $DeviceCtrl = A('Device');
        if (IS_POST) {
            $BaseCtrl = A('Base');
            $file_name = $BaseCtrl->upload_file();
            $device_id = $DeviceCtrl->get_id(I('post.mac'));
            $arg = '/WifiBus/Update/|' . $file_name . '|' . I('post.name') . '|' . I('post.url');
            $result = $this->add($device_id, 'FreeUpdate', $arg);
            if ($result) {
                $this->success('上传成功');
            } else {
                $this->error('上传失败');
            }
        } else {
            $macs = $DeviceCtrl->mac_select();
            $this->assign('macs', $macs);
            $this->show();
        }
    }

    /**
     * config文件测试
     */
    public function cfg_test()
    {
        $DeviceCtrl = A('Device');
        if (IS_POST) {
            $BaseCtrl = A('Base');
            $file_name = $BaseCtrl->upload_file();
            $device_id = $DeviceCtrl->get_id(I('post.mac'));
            $arg = '/WifiBus/Update/|' . $file_name . '|' . I('post.name');
            $result = $this->add($device_id, 'Heatbeatcfgupdate', $arg);
            if ($result) {
                $this->success('上传成功');
            } else {
                $this->error('上传失败');
            }
        } else {
            $macs = $DeviceCtrl->mac_select();
            $this->assign('macs', $macs);
            $this->show();
        }
    }

    /**
     * 流量溢出限速函数
     * @param $device_id 设备id
     */
    public function auto_limit($device_id)
    {
        $DeviceModel = M('device');
        $networkLimit = $DeviceModel->where("id=$device_id")->getField('network_limit');
        if ($networkLimit != 0 || $networkLimit == null) {
            $FlowModel = M('Flow');
            $year = date('Y');
            $month = date('m');
            $allday = date('t');
            $condition = array(
                "device_id" => $device_id,
                'time' => array(
                    array('gt', strtotime($year . "-" . $month . "-1")),
                    array('lt', strtotime($year . "-" . $month . "-" . $allday))
                )
            );
            $sumFlow = $FlowModel->where($condition)->sum('num');
            if ($sumFlow > (C('TOTAL_FLOW') - (0.5 * 1024 * 1024))) {
                $DeviceCtrl = A('Device');
                $device_ids = array($device_id);
                $result = $DeviceCtrl->set_network_limit($device_ids, 0);
                if ($result) {
                    throw_exception('限速失败');
                }
            }
        }
    }

    /**
     * 增加设备的流量
     * @param $device_id 设备id
     * @param $num 使用的流量
     * @return mixed 是否添加成功
     */
    public function addFlow($device_id, $num)
    {
        $FlowCtrl = A('Flow');
        return $FlowCtrl->update($num, $device_id);
    }

    /**
     * 获取设备信息
     * @param $mac 设备mac
     * @return mixed 设备信息数组
     */
    public function getDevice($mac)
    {
        $Device = D("Device");
        $condition['mac'] = $mac;
        $d = $Device->where($condition)->find();
        return $d;
    }
}