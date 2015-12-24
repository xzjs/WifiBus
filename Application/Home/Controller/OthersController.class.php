<?php
namespace Home\Controller;
use Think\Controller;
class OthersController extends Controller {
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
    	
    
}