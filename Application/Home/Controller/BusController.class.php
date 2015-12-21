<?php

namespace Home\Controller;

use Think\Controller;

/**
 * 公交车控制器类
 *
 * @author xiuge
 *        
 */
class BusController extends BaseController {
	
	/**
	 * 添加车辆
	 */
	public function add() {
		$Bus = D ( 'Bus' );
	
		if ($Bus->create ()) {
			if (empty ( $Bus->position_x ) && empty ( $Bus->position_y )) {
				$Bus->position_x = 0;
				$Bus->position_y = 0;
			}
			$result = $Bus->add ();
			if ($result) {
				$device=D('Device');
				$flag=$device->add();
				if ($flag>0)
					echo $result;
				else 
				{
					$this->error ( '数据添加错误！' );
				}
			} else {
				$this->error ( '数据添加错误！' );
			}
		} else {
			$this->error ( $Bus->getError () );
		}
	}
	
	/**
	 * 查询车辆信息
	 *
	 * @param number $id:车辆id
	 */
	public function select($id = 0, $line_id = 0, $search_keys = '', $is_getbuslist = 0) {
		$Bus = M ( 'Bus' );
		//获取车辆列表
		if ($is_getbuslist == 1) {
			if ($search_keys != '') {//根据关键字搜索
				$map ['no'] = array (
						'like',
						'%' . $search_keys . '%' 
				);
			} elseif ($line_id != 0) {//根据线路搜索
				$map ['line_id'] = $line_id;
			}
			$data = $Bus->where ( $map )->field ( 'id,no' )->order('no')->select ();
			$a = json_encode ( $data );
			$this->ajaxReturn ( json_encode ( $data ) );
		} else {
			if ($id != 0)
				$condition_bus ['id'] = $id;
			if ($line_id != 0)
				$condition_bus ['line_id'] = $line_id;
			$data = $Bus->where ( $condition_bus )->order('no')->select ();
			return $data;
		}
	}

	
	/**
	 * 测试更新车辆信息的方法
	 *
	 * @param number $id:车辆id
	 */
	public function edit($id = 0) {
		$Bus = M ( 'Bus' );
		if ($id == 0) {
			$data = $Bus->select ();
		} else {
			$data = $Bus->find ( $id );
		}
		$this->assign ( 'bus', $Bus->find ( $id ) );
		$this->display ();
	}
	/**
	 * 删除line 更新 bus表
	 */
	public function update_line($lineId){
		$bus=D('Bus');
		$result=$bus->where('line_id='.$lineId)->setField('line_id',null);
		return  $result;
	}
	/**
	 * 更新车辆信息
	 *
	 * @param number $id:车辆id
	 * @param number $position_x:车辆位置横坐标
	 * @param number $position_y:车辆位置纵坐标
	 */
	public function update($id = 0, $no = '', $line_id = 0, $mac = '', $position_x = 0, $position_y = 0) {
		
		
		if (IS_POST) {
			$Bus = D ( 'Bus' );
			if ($Bus->create ()) {
				$result = $Bus->save ();
				if ($result) {
					$this->success ( '操作成功！' );
				} else {
					$this->error ( '写入错误！' );
				}
			} else {
				$this->error ( $Bus->getError () );
			}
		} elseif (IS_GET) {
			if ($mac == '') {
				$Bus = M ( 'Bus' );
				if ($position_x != 0)
					$data ['position_x'] = $position_x;
				if ($position_y != 0)
					$data ['position_y'] = $position_y;
				if ($no != '')
					$data ['no'] = $no;
				if ($line_id != 0)
					$data ['line_id'] = $line_id;
				$result = $Bus->where ( 'id=' . $id )->setField ( $data );
				if ($result) {
					$this->success ( '操作成功！' );
				} else {
					$this->error ( '写入错误！' );
				}
			} else {
				S ( $mac . 'x', $position_x );
				S ( $mac . 'y', $position_y );
				$update_time = S ( 'update_time' );
				if (S ( 'update_time' ) == null) {
					$update_time = 1;
				} else {
					$update_time = S ( 'update_time' );
					$update_time ++;
					if ($update_time > 5) {
						$update_time = 0;
						$Device = M ( "Device" );
						$info = $Device->field ( 'bus_id,mac' )->select ();
						foreach ( $info as $value ) {
							$Bus = M ( 'Bus' );
							$data ['position_x'] = S ( $value ['mac'] . 'x' );
							$data ['position_y'] = S ( $value ['mac'] . 'y' );
							$data ['id'] = $value ['bus_id'];
							$Bus->save ( $data );
						}
					}
				}
				S ( 'update_time', $update_time );
			}
		}
		
	}
	
	/**
	 * 删除车辆
	 *
	 * @param number $id:车辆id
	 */
	public function delete($id = 0) {
		$Bus = M ( 'Bus' );
		if ($Bus->delete ( $id )) {
			$this->success ( '操作成功！' );
		} else {
			$this->error ( $Bus->getError () );
		}
	}

    public function index(){
        $BusModel=D('Bus');
        $buses=$BusModel->relation(true)->select('41,42');
        $this->assign('data',$buses);
        //var_dump($buses);
        $this->show();
    }
}