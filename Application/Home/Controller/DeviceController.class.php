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
	public function mac_select(){
		$DeviceModel=D("Device");
		return $DeviceModel->select();
		//$result=M()->query("select mac from")
	}
/**
 * 更新设备所属车辆
 */
	public function update_bus($bus_line){
		$result=M()->execute("UPDATE  think_device SET bus_id=NULL WHERE bus_id=$bus_line");
		return  $result;
	}
	
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
    
   /**
    * 根据id列表查询ssid，相同则返回ssid，不同则返回空
    * @param array $device_ids id列表
    * @return string ssid名
    */
    public function get_ssid($device_ids=null) {
    	$Device=M('Device');
    	$result=$Device->field('ssid')->find($device_ids[0]);
    	$ssid_or_null=$result['ssid'];
    	for($i=0;$i<count($device_ids);$i++){
    		$result=$Device->field('ssid')->find($device_ids[$i]);
    		if($ssid_or_null!=$result['ssid']){
    			$ssid_or_null='';
    			break;
    		}
    	}
    	return $ssid_or_null;
    }
    
    /**
     * 设置id列表的设备的ssid
     * @param array $device_ids id列表
     * @param unknown $ssid ssid名
     * @return boolean 操作结果
     */
    public function set_ssid($device_ids,$ssid) {
    	$Device=M('Device');
    	$data['ssid']=$ssid;
    	$Command=A('Command');
    	$cmd_str='Ssid';
    	for($i=0;$i<count($device_ids);$i++){
    		$cmd_result=$Command->add($device_ids[$i],$cmd_str,$ssid);
    		if(!$cmd_result)
    			return 1;
    		$data['id']=$device_ids[$i];
    		$result=$Device->data($data)->save();
    		if(!$result)
    			return 2;//更新失败！
    	}
    	return 0;//更新成功！
    }
    
    /**
     * 查询id列表设备的网速限制
     * @param array $device_ids id列表
     * @return string 相同则返回限制值，不同则返回空
     */
    public function get_network_limit($device_ids) {
    	$Device=M('Device');
    	$result=$Device->field('network_limit')->find($device_ids[0]);
    	$limit_or_null=$result['network_limit'];
    	for($i=0;$i<count($device_ids);$i++){
    		$result=$Device->field('network_limit')->find($device_ids[$i]);
    		if($limit_or_null!=$result['network_limit']){
    			$limit_or_null='';
    			break;
    		}
    	}
    	return $limit_or_null;
    }
    
    /**
     * 设置id列表设备的网速限制值
     * @param array $device_ids 设备id列表
     * @param unknown $network_limit 网速限制值
     * @return boolean 更新成功与否
     */
    public function set_network_limit($device_ids,$network_limit) {
    	$Device=M('Device');
    	$Command=A('Command');
    	$cmd_str="Networklimit";
    	$data['network_limit']=$network_limit;
    	for($i=0;$i<count($device_ids);$i++){
    		$cmd_result=$Command->add($device_ids[$i],$cmd_str,$network_limit);
    		if(!$cmd_result)
    			return 1;
    		else{
    			$data['id']=$device_ids[$i];
    			$result=$Device->data($data)->save();
    			if(!$result)
    				return 2;//更新失败！
    		}
    		
    	}
    	return 0;//更新成功！
    }

    /**
     * 通过mac获取设备的id
     * @param $mac 设备mac
     * @return int 0或者id
     */
    public function get_id($mac){
        $DeviceModel=D('Device');
        $condition['mac']=$mac;
        $result=$DeviceModel->where($condition)->find();
        return $result?$result['id']:0;
    }

    public function reboot($device_ids){
        $Device=M('Device');
        $Command=A('Command');
        $cmd_str="Reboot";
        for($i=0;$i<count($device_ids);$i++){
            $cmd_result=$Command->add($device_ids[$i],$cmd_str);
        }
        return 0;//更新成功！
    }

    public function get_terminal_info(){
        $Device=M('Device');
        $result=$Device->field('online_num')->select();
        $total=0;
        foreach($result as $vo){
            $total+=$vo['online_num'];
        }
        $terminal_info=$total/C('TOTAL_ONLINE_NUM')/count($result)*100;
        return $terminal_info;



    }
    
    public function  get_device_state($line_id=0){
    	$work_info=array();
    	$working=array();
    	$unworking=array();
    	if($line_id==0){
    		$sql="select d.time as time,b.no as bus_no from think_device as d,think_bus as b,think_line as l where d.bus_id=b.id and b.line_id= l.id";
    	}else{
    		$sql="select d.time as time,b.no as bus_no from think_device as d,think_bus as b,think_line as l where d.bus_id=b.id and b.line_id= l.id and l.id=".$line_id;
    	}
    	$result=M()->query($sql);
    	$total=0;
    	$normal=0;
    	foreach ($result as $bus){
    		$total++;
    		if((time()-$bus['time'])<=180){
    			$normal++;
    			array_push($working, $bus['bus_no']);
    		}else{
    			array_push($unworking, $bus['bus_no']);
    		}
    	}
    	if($total!=0){
    		$work_info['work'] = ($normal/$total)*100;
    		$work_info['working'] = $working;
    		$work_info['unworking'] = $unworking;
    	}
    	else 
    		$work_info['work'] = 0;
    	return $work_info;
    	
    }
}