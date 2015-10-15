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
    
    public function upload(){
    	
    	if (! empty ( $_FILES ['j'] ['name'] ))
    	{
    		$upload = new \Think\Upload (); // 实例化上传类
    		$upload->maxSize = 3145728; // 讴置附件上传大小
    		$upload->allowExts = array (
    				'xls',
    				'xlsx'
    		); // 讴置附件上传类型
    		$upload->savePath = 'excel/'; // 讴置附件上传目录
    		$upload->autoSub=false;
    		$info = $upload->upload ();
    	}
    	
    }
    

    
}