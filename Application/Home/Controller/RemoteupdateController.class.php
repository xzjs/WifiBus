<?php
namespace Home\Controller;
use Think\Controller;
class RemoteupdateController extends Controller {
	
    public function remoteupdate(){
    	$Line = A ( 'Line' );
    	$data = $Line->select ();
    	$this->assign ( 'line_list', $data );
    	$Bus=M('Bus');
    	$data = $Bus->where('line_id='.$data[0][id])->select();
    	$this->assign ( 'bus_list', $data );
    	$this->display ();
    }

    
}