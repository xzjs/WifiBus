<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	
    public function index(){
        /*if(!isset($_SESSION['admin'])){
            $this->error('请先登录',U('Admin/login'));
        }*/
        $this->assign('title','首页');
        $this->assign('class1','action');
    	$Line = A ( 'Line' );
    	$data = $Line->getLineList ();
    	$this->assign ( 'line_list', $data );
    	$Bus=A('Bus');
    	$data = $Bus->select(0,$data[0][id],'',0);
    	$this->assign ( 'bus_list', $data );
    	$this->display ();
    }
    
    public function bus($str,$flag){
    	if ($flag==0)$sql="SELECT think_device.time, think_device.id,think_bus.position_x,think_bus.position_y,think_bus.no,think_device.online_num,think_device.flow_num,think_device.useage
 FROM think_device,think_bus
  WHERE think_device.bus_id=think_bus.id AND think_bus.id=$str";
    	else $sql="
SELECT think_device.time, think_device.id,think_bus.position_x,think_bus.position_y,think_bus.no,think_device.online_num,think_device.flow_num,think_device.useage
 FROM think_device,think_bus
  WHERE think_device.bus_id=think_bus.id AND think_bus.line_id=$str";
      $result=M()->query($sql);
    	$time=time();
    	for($i=0;$i<count($result);$i++){
    		if(($time-$result[$i]['time'])>30*60)
    		{
    			$flag=1;//失联了
    		}
    		else {
    			$flag=0;
    		}
    		$array[$i]=array(
    				'flag'=>$flag,
    				'car_no'=>$result[$i]['no'],
    				'online_num'=>$result[$i]['online_num'],
    				'flow_num'=>$result[$i]['flow_num'],
    				'cipan_use'=>$result[$i]['useage'],
    				'p_x'=>$result[$i]['position_x'],
    				'p_y'=>$result[$i]['position_y'],
    		);
    	}
    	echo json_encode($array);
       
    }

    public function all(){
    	$result=M()->query("SELECT think_device.time, think_device.id,think_bus.position_x,think_bus.position_y,think_bus.no,think_device.online_num,think_device.flow_num,think_device.useage FROM think_device,think_bus WHERE think_device.bus_id=think_bus.id");
    	$time=time();
    	for($i=0;$i<count($result);$i++){
    		if(($time-$result[$i]['time'])>30*60)
    		{
    			$flag=1;//失联了
    		}
    		else {
    			$flag=0;
    		}
    		$array[$i]=array(
    				'flag'=>$flag,
    				'car_no'=>$result[$i]['no'],
    				'online_num'=>$result[$i]['online_num'],
    				'flow_num'=>$result[$i]['flow_num'],
    				'cipan_use'=>$result[$i]['useage'],
    				'p_x'=>$result[$i]['position_x'],
    				'p_y'=>$result[$i]['position_y'],
    		);
    	}
    	echo json_encode($array);
      	
    }

    /**
     * @param $f 图例
     * @param $num 数值
     */
    public function work($f='work',$line_id=0){
    	$this->assign('title','详细状态');
    	$this->assign('class1','action');
    	$Line = A ( 'Line' );
    	$data = $Line->getLineList ();
    	$this->assign ( 'line_list', $data );
    	$Bus=A('Bus');
    	$data = $Bus->select(0,$data[0][id],'',0);
    	$this->assign ( 'bus_list', $data );
        $this->assign('f',$f);
        
        $device=A('Device');
        $num=$device->get_device_state($line_id);
        
        
        $this->assign('num',$num);
        $this->show();
    }
    
    public function get_char_info() {
    	$device=A('Device');
    	$char_info['work']=$device->get_device_state(I('param.line_id'));
    	$this->ajaxReturn($char_info);
    }
}