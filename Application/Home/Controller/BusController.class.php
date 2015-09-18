<?php

namespace Home\Controller;

use Think\Controller;

/**
 * 公交车控制器类
 * 
 * @author xiuge
 *        
 */
class BusController extends Controller {
	
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
				$this->success ( '数据添加成功！' );
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
	 * @param number $id
	 *        	车辆id
	 */
	public function select($id = 0) {
		$Bus = M ( 'Bus' );
		if ($id == 0) {
			$data = $Bus->select ();
		} else {
			$data = $Bus->find ( $id );
		}
		if ($data) {
			$this->assign ( 'bus', $data ); // 模板变量赋值
		} else {
			$this->error ( '数据错误' );
		}
		$this->display ();
	}
	
	/**
	 * 测试更新车辆信息的方法
	 * 
	 * @param number $id
	 *        	车辆id
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
	 * 更新车辆信息
	 */
	public function update($id = 0, $position_x = 0, $position_y = 0) {
		if (($position_x == 0) && ($position_y == 0)) {
			$Bus = D ( 'Bus' );
			if ($Bus->create ()) {
				$result = $Bus->save ();
			} else {
				$this->error ( $Bus->getError () );
			}
		} else {
			$Bus = M ( 'Bus' );
			$data = array (
					'position_x' => $position_x,
					'position_y' => $position_y 
			);
			$result = $Bus->where ( 'id=' . $id )->setField ( $data );
		}
		if ($result) {
			$this->success ( '操作成功！' );
		} else {
			$this->error ( '写入错误！' );
		}
	}
	
	/**
	 * 删除车辆
	 */
	public function delete($id = 0) {
		$Bus = M ( 'Bus' );
		if ($Bus->delete ( $id )) {
			$this->success ( '操作成功！' );
		} else {
			$this->error ( $Bus->getError () );
		}
	}
}