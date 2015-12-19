<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/10/14
 * Time: 下午2:44
 */
namespace Home\Controller;

use Think\Controller;

/**
 * Class AnalyseController 广告流量分析控制器
 * @package Home\Controller
 */
class AnalyseController extends Controller {
	
	public function index() {
		$this->assign('title','广告和流量分析');
        $this->assign('class2','action');
    	$Line = A ( 'Line' );
    	$data = $Line->getLineList ();
    	$this->assign ( 'line_list', $data );
    	$Bus=M('Bus');
    	$data1 = $Bus->where('line_id='.$data[0][id])->select();
    	$this->assign ( 'bus_list', $data1 );
    	$Ad=M('Ad');
    	$data2 = $Ad->where('line_id='.$data[0][id])->field('text,click_num')->order('click_num desc')->limit(6)->select();
    	$this->assign ( 'adInfo', json_encode ( $data2 ) );
    	$this->display ();
	}
	
	public function analyse() {
		$this->assign('title','广告和流量分析');
        $this->assign('class2','action');
		$this->display ();
	}
	
	public function adver_rank() {
		$this->assign('title','广告和流量分析');
		$this->assign('class2','action');
		$this->display ();
	}
	
	public function getAdInfo($line_id=0) {
		$Ad=M('Ad');
		$data = $Ad->where('line_id='.$line_id)->field('text,click_num')->order('click_num desc')->limit(6)->select();
		$this->ajaxReturn ( $data  );
	}
	
	
	
}