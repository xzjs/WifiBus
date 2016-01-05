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

    public function get_flow_info(){
        $FlowModel=M('Flow');
        $result=$FlowModel->field('device_id,sum(num) as num')->group('device_id')->select();
        $used_flow=0;
        foreach($result as $vo){
            $used_flow+=$vo['num']%(C('TOTAL_FLOW'))*100;
        }
        $flow_info=$used_flow/(C('TOTAL_FLOW')*count($result));
        return $flow_info;
    }
}