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
}