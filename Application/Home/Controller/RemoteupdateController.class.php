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
	
	
	
	
}