<?php
namespace Home\Controller;
use Think\Controller;
class OthersController extends Controller {
	
	/**
	 * “其它”页面
	 */
    public function others(){
    	$this->assign('title','其它设置');
        $this->assign('class3','action');
        $Line = A ( 'Line' );
        $data = $Line->getLineList ();
        $this->assign ( 'line_list', $data );
        $Bus=A('Bus');
        $data = $Bus->select(0,$data[0][id],'',0);
        $this->assign ( 'bus_list', $data );
    	$this->display ();
    }

    /**
     * 获取id列表的ssid和网速限制值
     * @param unknown $ids id列表
     */
    public function get_device_set($ids){
    	$id_list=$ids;
    	$device=M('Device');
    	for($i=0;$i<count($id_list);$i++){
    		$condition['bus_id']=$id_list[$i];
    		$result=$device->where($condition)->field('id')->find();
    		$device_ids[$i]=$result['id'];
    	}
    	$Device=A('Device');
		$json['ssid']=$Device->get_ssid($device_ids);
		$json['flow_limit']=$Device->get_network_limit($device_ids);
		$this->ajaxReturn($json);
    } 
    	
    /**
     * 设置id列表的设备的ssid
     * @param unknown $ids id列表
     * @param unknown $ssid 
     */
    public function set_ssid($ids,$ssid) {
    	$id_list=$ids;
    	$device=M('Device');
    	$device_ids=array();
    	for($i=0;$i<count($id_list);$i++){
    		$condition['bus_id']=$id_list[$i];
    		$result=$device->where($condition)->field('id')->find();
    		if(count($result)>0)
    			array_push($device_ids,$result['id']);
    	}
    	$Device=A('Device');
    	$result=$Device->set_ssid($device_ids,$ssid);
    	$this->ajaxReturn($result);
    }
    
    /**
     * 设置id列表的网速限制
     * @param unknown $ids id列表
     * @param unknown $ssid
     */
    public function set_network_limit($ids,$network_limit) {
    	$id_list=$ids;
    	$device=M('Device');
    	$device_ids=array();
    	for($i=0;$i<count($id_list);$i++){
    		$condition['bus_id']=$id_list[$i];
    		$result=$device->where($condition)->field('id')->find();
    		if(count($result)>0)
    			array_push($device_ids,$result['id']);
    	}
    	$Device=A('Device');
    	$result=$Device->set_network_limit($device_ids,$network_limit);
    	$this->ajaxReturn($result);
    }
    
}