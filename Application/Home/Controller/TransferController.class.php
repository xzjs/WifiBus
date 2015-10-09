<?php

namespace Home\Controller;

use Think\Controller;

class TransferController extends Controller {
	public function index() {
		$Device=M("Device");
		$info=$Device->field('bus_id,mac')->select();
		foreach ($info as $value){
			$Bus=M('Bus');
			$data['position_x']=S($value['mac'].'x');
			$data['position_y']=S($value['mac'].'y');
			$data['id']=$value['bus_id'];
			$Bus->save($data);
		}
	}
}