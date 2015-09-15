<?php

namespace Home\Controller;

use Think\Controller;

class DeviceController extends Controller {
	
	/**
	 * 添加设备
	 */
	public function add() {
		$Device = D ( 'Device' );
		if ($Device->create ()) {
			$result = $Device->add ();
			if ($result) {
				$this->success ( '数据添加成功！' );
			} else {
				$this->error ( '数据添加错误！' );
			}
		} else {
			$this->error ( $Device->getError () );
		}
	}
	
	/**
	 * 查询设备信息
	 *
	 * @param number $id
	 *        	设备id
	 */
	public function select($id = 0) {
		$Device = M ( 'Device' );
		// 读取数据
		$data = $Device->find ( $id );
		if ($data) {
			$this->assign ( 'device', $data ); // 模板变量赋值
		} else {
			$this->error ( '数据错误' );
		}
		$this->display ();
	}
	
	/**
	 * 测试更新设备方法
	 *
	 * @param number $id
	 *        	设备id
	 */
	public function edit($id = 0) {
		$Device = M ( 'Device' );
		$result=$Device->find($id);
		if ($result) {
			$this->assign ( 'device', $result );
			$this->display ();
		} else {
			$this->error ( '写入错误！' );
		}
	}
	
	/**
	 * 更新设备信息
	 */
	public function update() {
		$Device = D ( 'Device' );
		if ($Device->create ()) {
			$result = $Device->save ();
			if ($result) {
				$this->success ( '操作成功！' );
			} else {
				$this->error ( '写入错误！' );
			}
		} else {
			$this->error ( $Device->getError () );
		}
	}
	
	/**
	 * 删除设备
	 */
	public function delete($id = 0) {
		$Device = M ( 'Device' );
		if ($Device->delete ( $id )) {
			$this->success ( '操作成功！' );
		} else {
			$this->error ( '删除失败！' );
		}
	}
}