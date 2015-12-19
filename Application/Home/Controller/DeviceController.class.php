<?php

namespace Home\Controller;

use Think\Controller;

/**
 * wifi设备控制器类
 *
 * @author xiuge
 *
 */
class DeviceController extends Controller
{

    /**
     * 添加设备
     */
    public function add($bus_id=0,$mac=0)
    {
        $Device = D('Device');
        $Device->bus_id=$bus_id;
        $Device->mac=$mac;
        if ($Device->create()) {
            $result = $Device->add();
            if ($result) {
               return $result;
            } else {
                 return 0;
            }
        } else {
             return -1;
        }
    }

    /**
     * 查询设备信息
     *
     * @param number $id :设备id
     */
    public function select($id = 0)
    {
        $Device = M('Device');
        // 读取数据
        if ($id != 0)
            $condition ['id'] = $id;
        $data = $Device->where($condition)->select();
        var_dump($data);
    }

    /**
     * 测试更新设备方法
     *
     * @param number $id :设备id
     */
    public function edit($id = 0)
    {
        $Device = M('Device');
        if ($id == 0) {
            $data = $Device->select();
        } else {
            $data = $Device->find($id);
        }
        if ($result) {
            $this->assign('device', $result);
            $this->display();
        } else {
            $this->error('写入错误！');
        }
    }

    /**
     * 更新广告信息
     *
     * @param number $id :设备ID
     * @param string $mac :设备MAC
     * @param string $useage :设备使用率
     * @param string $time :设备上次更新时间
     * @param string $ssid :设备SSID
     * @param string $firmware :设备固件版本
     * @param string $content :设备内容
     * @param number $status :设备状态
     * @param number $bus_id :设备所安放的车辆ID
     */
    public function update($id = 0, $mac = '', $useage = '', $time = '', $ssid = '', $firmware = '', $content = '', $status = 0, $bus_id = 0)
    {
        if (IS_POST) {
            $Device = D('Device');
            if ($Device->create()) {
                $result = $Device->save();
                if ($result) {
                    $this->success('操作成功！');
                } else {
                    $this->error('写入错误！');
                }
            } else {
                $this->error($Device->getError());
            }
        } elseif (IS_GET) {
            $Device = M('Device');
            if ($mac != '')
                $data ['mac'] = $mac;
            if ($useage != '')
                $data ['useage'] = $useage;
            if ($time != '')
                $data ['time'] = $time;
            if ($ssid != '')
                $data ['ssid'] = $ssid;
            if ($firmware != '')
                $data ['firmware'] = $firmware;
            if ($content != '')
                $data ['content'] = $content;
            if ($status != 0)
                $data ['status'] = $status;
            if ($bus_id != 0)
                $data ['bus_id'] = $bus_id;
            $result = $Device->where('id=' . $id)->setField($data);
            if ($result) {
                $this->success('操作成功！');
            } else {
                $this->error('写入错误！');
            }
        }
    }

    /**
     * 删除设备
     *
     * @param number $id :设备ID
     */
    public function delete($id = 0)
    {
        $Device = M('Device');
        if ($Device->delete($id)) {
            $this->success('操作成功！');
        } else {
            $this->error('删除失败！');
        }
    }

    /**
     * 路由器命令控制函数
     */
    public function cmd()
    {
        $Command = M("Command");
        $mac_array = I('post.mac');
        $data['device_id'] = 37;
        $data['cmd'] = 'Reboot';
        $data['status'] = 0;
        $Command->add($data);
        /*foreach ($mac_array as $mac) {
            $data['device_id']=$mac;
            $data['finish']=0;
            switch(I('post.sub')){
                case '磁盘使用率':
                    $data['cmd']='Df';
                    break;
                case '重启':
                    $data['cmd']='Reboot';
                    break;
                case '清理磁盘':
                    $data['cmd']='Clean';
                    break;
                case '修改ssid':
                    $data['cmd']='Ssid='.I('post.ssid');
                    $Route=M('Device');
                    $Route->ssid=I('post.ssid');
                    $Route->where('mac="'.$mac.'"')->save();
                    break;
                case '固件升级':
                    break;
                case '内容升级':
                    break;
                default:
                    break;
            }
            $Command->add($data);
        }*/
        $this->success('操作成功');
    }
}