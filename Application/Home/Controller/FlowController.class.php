<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/12/29
 * Time: 下午5:30
 */
namespace Home\Controller;

use Think\Controller;

class FlowController extends BaseController{

    /**
     * 更新设备当日流量
     * @param $num 流量
     * @param $device_id 设备id
     * @return bool 是否更新成功
     */
    public function update($num,$device_id){
        $FlowModel=M('Flow');
        $condition=array(
            'device_id'=>$device_id,
            'time'=>array('GT',strtotime('today'))
        );
        $flow=$FlowModel->where($condition)->find();
        if($flow){
            $flow['num']+=$num;
            $result=$FlowModel->save($flow);
            if($result){
                return true;
            }
        }else{
            $data=array(
                'num'=>$num,
                'device_id'=>$device_id,
                'time'=>time()
            );
            $result=$FlowModel->add($data);
            if($result){
                return true;
            }
        }
        return false;
    }

    /**
     * 获取流量使用率
     * @return float 流量使用率
     */
    public function get_flow_info($type,$line_id,$bus_id){
        $FlowModel=M('Flow');
        $condition_time['time']=array('gt',mktime(0, 0 , 0,date("m"),1,date("Y")));
        if($type=='line'){
            if($line_id==0){
                $result=$FlowModel->field('device_id,sum(num) as num')->where($condition_time)->group('device_id')->select();
            }else{
                $result=M()->query("select f.device_id,sum(f.num) as num from think_flow as f,think_device as d,think_bus as b where b.line_id=".$line_id." and f.time>".mktime(0, 0 , 0,date('m'),1,date('Y'))."
                 and b.id=d.bus_id and d.id=f.device_id group by f.device_id");
            }
            $used_flow=0;
            foreach($result as $vo){
                $used_flow+=$vo['num'];
            }
            $flow_info=$used_flow/(C('TOTAL_FLOW')*count($result))*100;
        }elseif($type=='bus'){
            $result=M()->query("select sum(f.num) as num from think_flow as f,think_device as d where d.bus_id=".$bus_id." and f.time>=".mktime(0, 0 , 0,date('m'),1,date('Y'))."
                  and d.id=f.device_id");
            $flow_info=$result[0]['num']/C('TOTAL_FLOW')*100;
        }

        return $flow_info;
    }
}