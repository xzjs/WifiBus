<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	
    public function index(){
        /*if(!isset($_SESSION['admin'])){
            $this->error('请先登录',U('Admin/login'));
        }*/
        $this->assign('title','首页');
        $this->assign('class1','action');
    	$Line = A ( 'Line' );
    	$data = $Line->getLineList ();
    	$this->assign ( 'line_list', $data );
    	$Bus=A('Bus');
    	$data = $Bus->select(0,$data[0][id],'',0);
    	$this->assign ( 'bus_list', $data );
    	$this->display ();
    }
    
    public function bus($str){
        $str=urldecode($str);
        $data=array(
            '35'=>array(
                array(120.240311,36.055683),//黄岛轮渡
                array(120.004914,35.877262),//体育场
                array(120.178963,36.018485),//青岛育人医院
                array(120.172229,35.980938),//青职学院
                array(120.198808,35.961895),//城市桂冠
                array(120.21714,35.965749),//理工大学
                array(120.235136,35.971364)//嘉陵江东路
            ),
            '36'=>array(
                array(120.240311,36.055683),//黄岛轮渡
                array(120.172229,35.980938),//青职学院
                array(120.21714,35.965749),//理工大学
                array(120.198808,35.961895),//城市桂冠
                array(120.179246,35.970552),//老年大学
                array(120.250947,35.966188)//金沙滩
            ),
            '37'=>array(
                array(120.21714,35.965749),//理工大学
                array(120.198808,35.961895),//城市桂冠
                array(120.250947,35.966188),//金沙滩
                array(120.191441,35.958657),//家佳源
                array(120.295569,35.995049),//隧道薛家岛枢纽站
                array(120.132005,35.923543)//灵山卫公交枢纽站
            ),
            '38'=>array(
                array(120.093147,36.098653),//龙泉王家
                array(120.198808,35.961895),//城市桂冠
                array(120.178963,36.018485)//青岛育人医院
            )
        );
        $arr['data']=$data[$str];
        echo json_encode($arr);
    }

    public function all(){
        $data=array(
            array(120.240311,36.055683),//黄岛轮渡
            array(120.004914,35.877262),//体育场
            array(120.178963,36.018485),//青岛育人医院
            array(120.172229,35.980938),//青职学院
            array(120.198808,35.961895),//城市桂冠
            array(120.21714,35.965749),//理工大学
            array(120.235136,35.971364), //嘉陵江东路
            array(120.240311,36.055683),//黄岛轮渡
            array(120.172229,35.980938),//青职学院
            array(120.21714,35.965749),//理工大学
            array(120.198808,35.961895),//城市桂冠
            array(120.179246,35.970552),//老年大学
            array(120.250947,35.966188),//金沙滩
            array(120.21714,35.965749),//理工大学
            array(120.198808,35.961895),//城市桂冠
            array(120.250947,35.966188),//金沙滩
            array(120.191441,35.958657),//家佳源
            array(120.295569,35.995049),//隧道薛家岛枢纽站
            array(120.132005,35.923543),//灵山卫公交枢纽站
            array(120.093147,36.098653),//龙泉王家
            array(120.198808,35.961895),//城市桂冠
            array(120.178963,36.018485)//青岛育人医院
        );
        $arr['data']=$data;
        echo json_encode($arr);
    }

    /**
     * @param $f 图例
     * @param $num 数值
     */
    public function work($f,$num){
        $this->assign('title','详细状态');
        $this->assign('class1','action');
        $this->assign('f',$f);
        $this->assign('num',$num);
        $this->show();
    }
}