<?php

namespace Home\Controller;

use Think\Controller;

class BusController extends Controller {
	
	/**
	 * 添加车辆
	 */
	public function add() {
		$Bus = D ( 'Bus' );
		if ($Bus->create ()) {
			$result = $Bus->add ();
			if ($result) {
				$this->success ( '数据添加成功！' );
				echo $result;
			} else {
				$this->error ( '数据添加错误！' );
			}
		} else {
			$this->error ( $Bus->getError () );
		}
	}
	
	/**
	 * 查询车辆信息
	 * @param number $id 车辆id        	
	 */
	public function select($id = 0) {
		$Bus = M ( 'Bus' );
		// 读取数据
		$data = $Bus->find ( $id );
		if ($data) {
			$this->assign ( 'data', $data ); // 模板变量赋值
		} else {
			$this->error ( '数据错误' );
		}
		$this->display ();
	}
	
	/**
	 * 测试更新车辆信息的方法
	 * @param number $id 车辆id 
	 */
	public function edit($id=0){
		$Bus   =   M('Bus');
		$this->assign('Bus',$Bus->find($id));
		$this->display();
	}
	
	/**
	 * 更新车辆信息
	 */
	public function update() {
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