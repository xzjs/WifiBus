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
class AnalyseController extends Controller
{
function test(){
	$id=97;
$result=M()->query('select * from think_bus where id=%s ',$id);
echo $result[0]['no'];

	//echo (int)( date ( "H", "1452456000" ));
}
 

	/**分析页面获取前十上网用户
	 *
	 */
	public function fenxi_get_on_line_top(){
		$result=M()->query("SELECT DISTINCT(think_wifidoglog.mac) ,COUNT(think_wifidoglog.id) AS VALUE ,think_bus.no FROM think_wifidoglog,think_bus,think_device 
WHERE  think_wifidoglog.is_back=0 and think_wifidoglog.TIME>UNIX_TIMESTAMP( CURDATE()) AND think_bus.id=think_device.bus_id AND
 think_device.mac=think_wifidoglog.device_mac GROUP BY think_wifidoglog.device_mac ORDER BY VALUE  LIMIT 10
				");
		$busno;
		$value;
		for($h = 0; $h<count($result); $h ++) {
			$busno[$h]=$result[$h]['no'];
			$value[$h]=$result[$h]['value'];
			
		}
		
		if(count ( $result )==0){
			for($i = 0; $i < 5;$i++){
				$busno[$i]="";
				$value[$i]="0";
			}
		}
		
			$array=array(
					"busno"=>$busno,
					"value"=>$value,
			);
		
		echo json_encode($array);
		//echo "ff".(date('H',strtotime("-0 hour"))+1);
	}
	 
/**分析上网用户走势
 * 
 */
	public function fenxi_get_on_line(){
	 $result=M()->query("SELECT DISTINCT (mac) , TIME FROM think_wifidoglog WHERE TIME>UNIX_TIMESTAMP( CURDATE())and is_back=0
				");
		$array=array();
		$num;
		$now = strtotime ( "now " );
		$now_h = date ( "H", $now ) ;
	$time;
	$j=0;
	$total;
	for($h = 0; $h<(date('H',strtotime("-0 hour"))+1); $h ++) {
		$to [$h] = 0;
		$total [$h] = 0;
	}	
				
			for($i=(date('H',strtotime("-0 hour")));$i>=0;$i--){
				
			$time[$j]=(int)date('H',strtotime("-".$i."hour"));
			$j++;
		
		}
		
		for($i=0;$i<count($result);$i++){
			$shour =( date ( "H", $result [$i] ['time'] ));
			$n = $now_h-$shour ;
			
			$to[$n] = $to[$n] + 1;
		}
		
		$p= count($to)-1;
	
		for($h = 0; $h<(date('H',strtotime("-0 hour"))+1); $h ++) {
			$total [$h] = $to[$p];
			$p--;
			
		}
		$array=array(
				"time"=>$time,
				"num"=>$total,
		);
	
	//echo  json_encode($total); 
	echo json_encode($array); 
	
	}
	
	/**
	 * busno查询time
	 */
	public function select_busno(){
		$busno=I("post.busno");
		
		$result = M()->query
		("SELECT think_device.TIME,think_bus.no FROM think_device ,think_bus WHERE think_bus.no LIKE '%$busno'AND think_device.bus_id=think_bus.id ORDER BY TIME DESC
				");
		$date=date('Y-m-d H:i:s',$result[0]['time']);

		echo json_encode($date);
	}
	
	/**
	 * ssh查询车牌号mac
	 */
	public function select(){
		
		$result = M()->query("SELECT d.id,b.no, d.mac FROM think_device AS d,think_bus AS b WHERE b.id=d.bus_id and(UNIX_TIMESTAMP(NOW())-d.TIME) ");
		
		for($i=0;$i<count($result);$i++){
			$array[$i]=array(
					'id'=>$result[$i]['id'],
					'value'=> $result[$i]['no'].";".$result[$i]['mac'],
			);
		}
		echo json_encode($array);
	}

	/**
	 * 回头客流量——时间关系查询
	 */
	public function get_back(){
		$line_id = I('post.line_id');
		$bus_id =I('post.bus_id');
		if ($bus_id == 0 && $line_id == 0) {
		$result=M()->query("SELECT DISTINCT (mac) ,TIME,DATE,is_back FROM think_wifidoglog WHERE   TIME>(UNIX_TIMESTAMP(NOW())-7*86400) AND is_back=1");
		}
		else{
			if ($bus_id == 0) {
				$result=M()->query('SELECT DISTINCT (mac) ,TIME,DATE,is_back FROM think_wifidoglog WHERE   TIME>(UNIX_TIMESTAMP(NOW())-7*86400) AND is_back=1  AND device_mac IN(SELECT think_device.mac FROM think_device,think_bus WHERE think_device.bus_id=think_bus.id AND think_bus.line_id=%s)',$line_id);
				 
			}
			else{
				
				$result=M()->query('SELECT DISTINCT (mac) ,TIME,DATE,is_back FROM think_wifidoglog WHERE   TIME>(UNIX_TIMESTAMP(NOW())-7*86400) AND is_back=1   AND device_mac IN(SELECT think_device.mac FROM think_device,think_bus WHERE think_device.bus_id=think_bus.id AND think_bus.id=%s)',$bus_id);
			}
		}
		
		
		$array=array();
		for ($h = 0; $h <7; $h++) {
			$sum[$h] = 0;
		}
		for($i=0;$i<count($result);$i++){
	     $dif= (int)((strtotime('tomorrow')-($result [$i] ['time']))/86400);
			$sum[$dif]=$sum[$dif]+1;
	 	}
	//	$base->weekday((strtotime("now ")-(86400*$i))),
		$j=0;
		for($i=6;$i>=0;$i--){
		
			$array[$j]=array(
					'time'=>date('m-d',(time()-(86400*$i))),
					'num'=>$sum[$i],
			);
			$j++;
		
		}
		echo json_encode($array);
	
	}
	
	/**
	 * 客流量——时间关系查询
	 */
	public function get_online_num(){
		$line_id = I('post.line_id');
		$bus_id =I('post.bus_id');
		if ($bus_id == 0 && $line_id == 0) {
		$result=M()->query("SELECT DISTINCT (mac) ,TIME FROM think_wifidoglog WHERE   TIME>(UNIX_TIMESTAMP(NOW())-7*86400) AND is_back=0");
		}
		else{if ($bus_id == 0) {
			
			$result=M()->query('SELECT DISTINCT (mac) ,TIME FROM think_wifidoglog WHERE  is_back=0 and  TIME>(UNIX_TIMESTAMP(NOW())-7*86400) AND device_mac  IN(SELECT think_device.mac FROM think_device,think_bus WHERE think_device.bus_id=think_bus.id AND think_bus.line_id=%d)',$line_id);	
			}
			else {
			$result=M()->query('SELECT DISTINCT (mac) ,TIME FROM think_wifidoglog WHERE is_back=0 and  TIME>(UNIX_TIMESTAMP(NOW())-7*86400) AND device_mac IN(SELECT think_device.mac FROM think_device,think_bus WHERE think_device.bus_id=think_bus.id AND think_bus.id=%d)',$bus_id);	
			}
		}
	
		$array=array();
		for ($h = 0; $h <7; $h++) {
			$sum[$h] = 0;
		}
		for($i=0;$i<count($result);$i++){
			$dif= (int)((strtotime('tomorrow')-($result [$i] ['time']))/86400);
			$sum[$dif]=$sum[$dif]+1;
	
		}
		$j=0;
		for($i=6;$i>=0;$i--){
	
			$array[$j]=array(
					'time'=>date('m-d',(time()-(86400*$i))),
					'num'=>$sum[$i],
			);
			$j++;
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
			$result=M()->query('SELECT num,TIME FROM think_flow WHERE   TIME>(UNIX_TIMESTAMP(NOW())-7*86400)');
		}
		else {
			if ($bus_id == 0) {
				$result=M()->query("SELECT num,TIME FROM think_flow WHERE   TIME>(UNIX_TIMESTAMP(NOW())-7*86400) AND device_id IN(SELECT think_device.id FROM think_device,think_bus WHERE think_bus.line_id=%d AND think_device.bus_id=think_bus.id )",$line_id);
			}
			else{
				$result=M()->query("SELECT num,TIME FROM think_flow WHERE   TIME>(UNIX_TIMESTAMP(NOW())-7*86400) AND device_id IN(SELECT think_device.id FROM think_device,think_bus WHERE think_device.bus_id=think_bus.id AND think_bus.id=%d)",$bus_id);	
			}
		}
		
		$array=array();
		$base=A('Base');
		$today=$base->weekday(strtotime("now "));
		for ($h = 0; $h <7; $h++) {
			$sum[$h] = 0;
		}
		for($i=0;$i<count($result);$i++){
			//echo date('Y-m-d', $result [$i] ['time'])."<br>";
			$dif= (int)((strtotime("now ")-(strtotime(date('Y-m-d', $result [$i] ['time']))))/86400);
			//echo $dif;
			$sum[$dif]=$sum[$dif]+$result [$i]['num'];
				
		}
		$j=0;
		for($i=6;$i>=0;$i--){
		
			$array[$j]=array(
					'time'=>date('m-d',(strtotime("now ")-(86400*$i))),
					'num'=>(int)($sum[$i]/1024),
					
			);
			//echo (int)($sum[$i]/1024)."<br>";
			$j++;
			//echo 	$sum[$i];
		}
		//echo json_encode($sum);
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
		$yestoday=strtotime("-24hours");
		$sql="SELECT COUNT(l.id) AS num,d.mac,b.no FROM (SELECT * FROM think_log WHERE think_log.time>".$yestoday.") AS l RIGHT JOIN think_device AS d ON d.mac=l.mac RIGHT JOIN think_bus AS b ON b.id=d.bus_id GROUP BY d.mac ORDER BY num";
		$result=M()->query($sql);
		$max=24*60*12;
		for($i=0;$i<10;$i++){
			$breakdown[$i]['no']=$result[$i]['no'];
			$tmp=($max-$result[$i]['num'])/$max*100;
			$breakdown[$i]['breakdown']=round($tmp,2);
		}
		$this->assign('breakdown',json_encode($breakdown));
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
			$result=M()->query("SELECT SUM(mac.click_num) AS click_num,md.text,mac.time FROM think_media AS md,think_mediaclick AS mac 
WHERE mac.media_id=md.id AND mac.time>(UNIX_TIMESTAMP(NOW())-7*86400)
GROUP BY mac.media_id ORDER BY  click_num DESC LIMIT 6");
		}
		else {
			if ($bus_id == 0) {
		
			$result=M()->query("SELECT SUM(mac.click_num) AS click_num,md.text,mac.time FROM think_media AS md,think_mediaclick AS mac 
                        WHERE mac.media_id=md.id   AND mac.media_id IN(SELECT media_id FROM think_device_media WHERE device_id IN (SELECT  think_device.id FROM think_device,think_bus,think_line
                       WHERE think_line.id=think_bus.line_id AND think_line.id=%d AND think_device.bus_id=think_bus.id)
                               )  AND mac.time>(UNIX_TIMESTAMP(NOW())-7*86400) GROUP BY mac.media_id ORDER BY  click_num DESC LIMIT 6",$line_id);
			//echo "dd";
			}
			else{
				$result=M()->query("  SELECT SUM(mac.click_num) AS click_num,md.text ,mac.time FROM think_media AS md,think_mediaclick AS mac 
     WHERE mac.media_id=md.id   AND mac.media_id IN(SELECT think_device_media.media_id FROM think_device_media ,think_device 
                 WHERE think_device_media.device_id=think_device.id AND think_device.bus_id=%d)  AND mac.time>(UNIX_TIMESTAMP(NOW())-7*86400) GROUP BY mac.media_id ORDER BY  click_num DESC LIMIT 6",$bus_id);
			}
		}
		
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
		$j=0;
		for($i=6;$i>=0;$i--){
		
			$array[$j]=array(
					'time'=>date('m-d',(strtotime("now ")-(86400*$i))),
					'num'=>$sum[$i],
			);
			$j++;
			//echo 	$array[1][time];
		}
		echo json_encode($array); 
		//echo "dd";
	
	}
public function get_ad_click_top() {
		$line_id = I('post.line_id');
		$bus_id =I('post.bus_id');
		if ($bus_id == 0 && $line_id == 0) {
	$result = M ()->query('SELECT SUM(mac.click_num) AS click_num,md.text FROM think_media AS md,think_mediaclick AS mac WHERE mac.media_id=md.id GROUP BY mac.media_id ORDER BY  click_num DESC LIMIT 6');
		} else {
			if ($bus_id == 0) {
			$result = M ()->query("SELECT SUM(mac.click_num) AS click_num,md.text FROM think_media AS md,think_mediaclick AS mac 
                        WHERE mac.media_id=md.id   AND mac.media_id IN(SELECT media_id FROM think_device_media WHERE device_id IN (SELECT  think_device.id FROM think_device,think_bus,think_line
                       WHERE think_line.id=think_bus.line_id AND think_line.id=%d AND think_device.bus_id=think_bus.id)
                               ) GROUP BY mac.media_id ORDER BY  click_num DESC LIMIT 6",$line_id) ;
			} 
			else {
			$result = M ()->query("SELECT SUM(mac.click_num) AS click_num,md.text FROM think_media AS md,think_mediaclick AS mac 
                 WHERE mac.media_id=md.id   AND mac.media_id IN(SELECT think_device_media.media_id FROM think_device_media ,think_device WHERE think_device_media.device_id=think_device.id AND 
                 		think_device.bus_id=%d) GROUP BY mac.media_id ORDER BY  click_num DESC LIMIT 6",$bus_id);
			}
		}
	
	
		$array = array ();
		for($i = 0; $i < count ( $result ); $i ++) {
			
			$array [$i] = array (
					'text' => $result [$i] ['text'],
					
					'click_num' => $result [$i] ['click_num'] 
			)
			;
		} 
		if(count ( $result )==0){
	for($i = 0; $i < 5;$i++){
			$array [$i] = array (
					'text' => "",
					
					'click_num' => 0
			);
		}
		}
		echo json_encode($array);
		
	
	}
	
	
	
}