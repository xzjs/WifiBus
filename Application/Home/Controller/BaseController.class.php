<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/11/23
 * Time: 上午11:12
 */
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {
	/**
	
	  * 根据时间戳返回星期几
	
	  * @param string $time 时间戳
	
	  * @return 星期几
	
	  */
	
	 function weekday($time)
	
	{//$time=I('post.time');
	
		     if(is_numeric($time))
	
			    {
	
			        $weekday = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
	
			         return  $weekday[date('w', $time)];
	
			     }
	
		     return   false;
	
		 }
		 
		 /**
		  * 文件上传
		  */
		 public function upload_file( ) {
		 	$suffix=I('param.suffix');
		 	$upload = new \Think\Upload (); // 实例化上传类
		 	$upload->maxSize = 3145728; // 设置附件上传大小
		 	$upload->exts = array(
		 			$suffix
		 	); // 设置附件上传类型
		 	$upload->rootPath = "./Uploads/"; // 设置附件上传根目录
		 	$upload->autoSub = false;
		 	$upload->saveName = '_'.time(); // 上传文件
		 	$info = $upload->upload();
		 	echo $info ['file'] ['savename'];
		 }
}