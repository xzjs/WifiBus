<?php

namespace Home\Controller;

use Think\Controller;

class RemoteupdateController extends BaseController {
	
	public function remoteupdate() {
		$this->assign ( 'title', '用户控制' );
		$this->assign ( 'class3', 'action' );
		$Line = A ( 'Line' );
		$data = $Line->getLineList ();
		$this->assign ( 'line_list', $data );
		$Bus = M ( 'Bus' );
		$data = $Bus->where ( 'line_id=' . $data [0] [id] )->select ();
		$this->assign ( 'bus_list', $data );
		$this->display ( );
	}
	
	public function get_media_info($ids) {
		$id_list=$ids;
		$device=M('Device');
		$device_ids=array();
		for($i=0;$i<count($id_list);$i++){
			$condition['bus_id']=$id_list[$i];
			$result=$device->where($condition)->field('id')->find();
			if($result)
				array_push($device_ids, $result['id']);
		}
		
		$json['ssid']=$this->get_media($device_ids);
		
		
		$json['flow_limit']=$Device->get_network_limit($device_ids);
		$this->ajaxReturn($json);
	}
	
	/**
	 * 根据id列表查询media信息
	 * @param array $device_ids id列表
	 * @return string ssid名
	 */
	public function get_media($device_ids) {
		$position_arr=array("video1","video2","video3","video4","video5","video6","video7","video8",
				"book1","book2","book3","book4","app1","app2","app3","app4");
		if(count($device_ids)==0){
			for($j=0;$j<count($position_arr);$j++){
				$position_info[$position_arr[$j]]=null;
			}
		}else{
			$Device=M('Device');
			$medias=array();
			for($i=0;$i<count($device_ids);$i++){
				$device_id_str.=$device_ids[$i];
				if($i!=count($device_ids)-1)
					$device_id_str.=",";
			}
			for($j=0;$j<count($position_arr);$j++){
					$sql='select m.url,m.img,m.text from think_media as m,think_device_media as dm 
							where m.id=dm.media_id AND dm.device_id IN('.$device_id_str.') AND m.position="'.$position_arr[$j].'"';
					$result=M()->query($sql);
					$position_info[$position_arr[$j]]=$this->get_position_info($result,count($device_ids));
			}
		}
		$this->ajaxReturn($position_info);
	}
	
	/**
	 * 判断该position改显示的内容（查询条数若不等于id列表的的条数则表示该position不全相同）
	 * @param unknown $result
	 * @param unknown $count
	 */
	public function get_position_info($result,$count) {
		if(GetHostByName($_SERVER['SERVER_NAME'])=="127.0.0.1"){
			$ip=GetHostByName($_SERVER['SERVER_NAME']);
		}elseif(GetHostByName($_SERVER['SERVER_NAME'])=="192.168.4.96"){
			$ip=GetHostByName($_SERVER['SERVER_NAME']).":48093";
		}elseif(GetHostByName($_SERVER['SERVER_NAME'])=="192.168.4.97"){
			$ip=GetHostByName($_SERVER['SERVER_NAME']).":48082";
		}



		if($count==1){
			if($result[0]['url'])
				$result[0]['url']='http://'.$ip.'/WifiBus/Update/'.$result[0]['url'];
			if($result[0]['img'])
				$result[0]['img']='http://'.$ip.'/WifiBus/Update/'.$result[0]['img'];
			return $result[0];
		}else if(count($result)!=$count){
			return null;
		}else{
			$flag=false;
			for($i=1;$i<count($result);$i++){
				if($result[$i-1]['url']!=$result[$i]['url'])
				{
					$flag=true;
					break;
				}
			}
			if($flag)
				return null;
			else{
				if($result[0]['url'])
					$result[0]['url']='http://'.$ip.'/WifiBus/Update/'.$result[0]['url'];
				if($result[0]['img'])
					$result[0]['img']='http://'.$ip.'/WifiBus/Update/'.$result[0]['img'];
				return $result[0];
			}
		}
	}




	
	
}