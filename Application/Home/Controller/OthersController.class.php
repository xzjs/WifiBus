<?php
namespace Home\Controller;
use Think\Controller;
class OthersController extends Controller {
    public function others(){
    	$this->assign('title','其它设置');
        $this->assign('class3','action');
    	$this->display ();
    }
    
    
}