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

    public function get_ssid($ids){
		
    }
}