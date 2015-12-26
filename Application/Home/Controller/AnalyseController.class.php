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

	/**
	 * ssh查询车牌号mac
	 */
	public function select(){
		
		$result = M()->query("SELECT b.id,b.no, d.mac FROM think_device AS d,think_bus AS b WHERE b.id=d.bus_id");
		
		for($i=0;$i<count($result);$i++){
			$array[$i]=array(
					'id'=>$result[$i]['id'],
					'value'=>$result[$i]['no'].";".$result[$i]['mac'],
			);
		}
		echo json_encode($array);
	}

	/**
	 * 回头客流量——时间关系查询
	 */
	public function get_back(){
		$time=time()-6*86400;
		$sql="SELECT mac,TIME,DATE,is_back FROM think_wifidoglog WHERE   TIME>(UNIX_TIMESTAMP(NOW())-6*86400) AND is_back=1";
		$result=M()->query($sql);
		$array=array();
		$base=A('Base');
		$today=$base->weekday(strtotime("now "));
		//f "d".$today;
		for ($h = 0; $h <7; $h++) {
			$sum[$h] = 0;
		}
		
		for($i=0;$i<count($result);$i++){
			$dif= (int)((strtotime("now ")-(strtotime(date('Y-m-d', $result [$i] ['time']))))/86400);
      
        	$sum[$dif]=$sum[$dif]+1;
        
			
	
		}
		for($i=0;$i<7;$i++){
	
			$array[$i]=array(
					'time'=>"周".mb_substr(($base->weekday((strtotime("now ")-(86400*$i)))),-1),
					'num'=>$sum[$i],
			);
			//echo 	$sum[$i];
		}
		echo json_encode($array);
	
	}
	/**
	 * 客流量——时间关系查询
	 */
	public function get_online_num(){
		$time=time()-6*86400;
		$sql="SELECT TIME FROM think_wifidoglog WHERE   TIME>(UNIX_TIMESTAMP(NOW())-6*86400)";
		$result=M()->query($sql);
		$array=array();
		$base=A('Base');
		$today=$base->weekday(strtotime("now "));
		//f "d".$today;
		for ($h = 0; $h <7; $h++) {
			$sum[$h] = 0;
		}
		for($i=0;$i<count($result);$i++){
			$dif= (int)((strtotime("now ")-(strtotime(date('Y-m-d', $result [$i] ['time']))))/86400);
			$sum[$dif]=$sum[$dif]+1;
	
		}
		for($i=0;$i<7;$i++){
	
			$array[$i]=array(
					'time'=>"周".mb_substr(($base->weekday((strtotime("now ")-(86400*$i)))),-1),
					'num'=>$sum[$i],
			);
			//echo 	$sum[$i];
		}
		echo json_encode($array);
	
	}
	/**
	 * 流量——时间关系查询
	 */
	public function get_flow(){
		$line_id = I('post.line_id');
		$bus_id =I('post.bus_id');
		$time=time()-6*86400;
		if ($bus_id == 0 && $line_id == 0) {
			$sql="SELECT num,TIME FROM think_flow WHERE   TIME>(UNIX_TIMESTAMP(NOW())-6*86400)";
		}
		else {
			if ($bus_id == 0) {
				$sql="SELECT num,TIME FROM think_flow WHERE   TIME>(UNIX_TIMESTAMP(NOW())-6*86400) AND device_id IN(SELECT think_device.id FROM think_device,think_bus WHERE think_device.bus_id=think_bus.id AND think_bus.line_id=$line_id)";
				
			}
			else{
				$sql="SELECT num,TIME FROM think_flow WHERE   TIME>(UNIX_TIMESTAMP(NOW())-6*86400) AND device_id IN(SELECT think_device.id FROM think_device,think_bus WHERE think_device.bus_id=think_bus.id AND think_bus.id=$bus_id)";
				
			}
		}
		$result=M()->query($sql);
		$array=array();
		$base=A('Base');
		$today=$base->weekday(strtotime("now "));
		//f "d".$today;
		for ($h = 0; $h <7; $h++) {
			$sum[$h] = 0;
		}
		for($i=0;$i<count($result);$i++){
			$dif= (int)((strtotime("now ")-(strtotime(date('Y-m-d', $result [$i] ['time']))))/86400);
			$sum[$dif]=$sum[$dif]+$result [$i]['num'];
				
		}
		for($i=0;$i<7;$i++){
		
			$array[$i]=array(
					'time'=>"周".mb_substr(($base->weekday((strtotime("now ")-(86400*$i)))),-1),
					'num'=>$sum[$i],
			);
			//echo 	$sum[$i];
		}
		echo json_encode($array);
		
	}
	
	public function index() {
		
		$this->assign('title','广告和流量分析');
        $this->assign('class2','action');
    	$Line = A ( 'Line' );
    	$data = $Line->getLineList ();
    	$this->assign ( 'line_list', $data );
    	$Bus=A('Bus');
    	$data1 = $Bus->select(0,$data[0][id],'',0);
    	$this->assign ( 'bus_list', $data1 );
    	//$Ad=M('Ad');
    	//$data2 = $Ad->where('line_id='.$data[0][id])->field('text,click_num')->order('click_num desc')->limit(6)->select();
    	//$this->assign ( 'adInfo', json_encode ( $data2 ) );
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
	/**
	 * 线路和车辆条件下查询时间与广告点击量的关系
	 * @param number $line_id
	 * @param number $bus_id
	 */
	public function get_ad_click() {
		$line_id = I('post.line_id');
		$bus_id =I('post.bus_id');
		if ($bus_id == 0 && $line_id == 0) {
			$sql="SELECT SUM(mac.click_num) AS click_num,md.text,mac.time FROM think_media AS md,think_mediaclick AS mac 
WHERE mac.media_id=md.id AND mac.time>(UNIX_TIMESTAMP(NOW())-6*86400)
GROUP BY mac.media_id ORDER BY  click_num DESC LIMIT 6";
		}
		else {
			if ($bus_id == 0) {
				$sql="SELECT SUM(mac.click_num) AS click_num,md.text,mac.time FROM think_media AS md,think_mediaclick AS mac 
                        WHERE mac.media_id=md.id   AND mac.media_id IN(SELECT media_id FROM think_device_media WHERE device_id IN (SELECT  think_device.id FROM think_device,think_bus,think_line
                       WHERE think_line.id=think_bus.line_id AND think_line.id=$line_id AND think_device.bus_id=think_bus.id)
                               )  AND mac.time>(UNIX_TIMESTAMP(NOW())-6*86400) GROUP BY mac.media_id ORDER BY  click_num DESC LIMIT 6";
			}
			else{
				$sql="  SELECT SUM(mac.click_num) AS click_num,md.text ,mac.time FROM think_media AS md,think_mediaclick AS mac 
     WHERE mac.media_id=md.id   AND mac.media_id IN(SELECT think_device_media.media_id FROM think_device_media ,think_device 
                 WHERE think_device_media.device_id=think_device.id AND think_device.bus_id=$bus_id)  AND mac.time>(UNIX_TIMESTAMP(NOW())-6*86400) GROUP BY mac.media_id ORDER BY  click_num DESC LIMIT 6";
			}
		}
		$result=M()->query($sql);
		//$MediaModel=D('Media');
		$array=array();
		$base=A('Base');
		$today=$base->weekday(strtotime("now "));
		//f "d".$today;
		for ($h = 0; $h <7; $h++) {
			$sum[$h] = 0;
		}
		for($i=0;$i<count($result);$i++){
			$dif= (int)((strtotime("now ")-(strtotime(date('Y-m-d', $result [$i] ['time']))))/86400);
			$sum[$dif]=$sum[$dif]+$result [$i]['click_num'];
				
		}
		for($i=0;$i<7;$i++){
		
			$array[$i]=array(
					'time'=>"周".mb_substr(($base->weekday((strtotime("now ")-(86400*$i)))),-1),
					'num'=>$sum[$i],
			);
			//echo 	$sum[$i];
		}
		echo json_encode($array);
		
	
	}
public function get_ad_click_top() {
		 $line_id = I('post.line_id');
		$bus_id =I('post.bus_id');
		
		if ($bus_id == 0 && $line_id == 0) {
			$sql = 'SELECT SUM(mac.click_num) AS click_num,md.text FROM think_media AS md,think_mediaclick AS mac WHERE mac.media_id=md.id GROUP BY mac.media_id ORDER BY  click_num DESC LIMIT 6';
		} else {
			if ($bus_id == 0) {
				$sql = "SELECT SUM(mac.click_num) AS click_num,md.text FROM think_media AS md,think_mediaclick AS mac 
                        WHERE mac.media_id=md.id   AND mac.media_id IN(SELECT media_id FROM think_device_media WHERE device_id IN (SELECT  think_device.id FROM think_device,think_bus,think_line
                       WHERE think_line.id=think_bus.line_id AND think_line.id=$line_id AND think_device.bus_id=think_bus.id)
                               ) GROUP BY mac.media_id ORDER BY  click_num DESC LIMIT 6" ;
			} 
			else {
			$sql="SELECT SUM(mac.click_num) AS click_num,md.text FROM think_media AS md,think_mediaclick AS mac 
                 WHERE mac.media_id=md.id   AND mac.media_id IN(SELECT think_device_media.media_id FROM think_device_media ,think_device WHERE think_device_media.device_id=think_device.id AND think_device.bus_id=$bus_id) GROUP BY mac.media_id ORDER BY  click_num DESC LIMIT 6";
			}
		}
	
	$result = M ()->query ( $sql );
		$array = array ();
		for($i = 0; $i < count ( $result ); $i ++) {
			
			$array [$i] = array (
					'text' => $result [$i] ['text'],
					
					'click_num' => $result [$i] ['click_num'] 
			)
			;
		} 
		echo json_encode ( $array );
		
		/* $data = array (
				'name' => array (
						'可口可乐',
						'百事可乐',
						'非常可乐' 
				),
				'data' => array (
						11,
						12,
						13 
				) 
		);
		echo json_encode ( $data ); */
		// echo I('post.line_id'); 
	}
	
	
	
}