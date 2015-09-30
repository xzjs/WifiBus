<?php

namespace Home\Controller;

use Think\Controller;

/**
 * 公交线路控制器类
 *
 * @author xiuge
 *        
 */
class LineController extends Controller {
	
	/**
	 * 添加线路
	 */
	public function add() {
		$Line = D ( 'Line' );
		if ($Line->create ()) {
			$result = $Line->add ();
			if ($result) {
				$this->success ( '数据添加成功！' );
			} else {
				$this->error ( '数据添加错误！' );
			}
		} else {
			$this->error ( $Line->getError () );
		}
	}
	
	/**
	 * 查询线路
	 *
	 * @param number $id
	 *        	线路id
	 */
	public function select($id = 0) {
		$Line = M ( 'Line' );
		// 读取数据
		if ($id == 0) {
			$data = $Line->select ();
		} else {
			$data = $Line->find ( $id );
		}
		if ($data) {
			var_dump ( $data );
		} else {
			$this->error ( '数据错误' );
		}
	}
	
	/**
	 * 测试更新线路方法
	 *
	 * @param number $id
	 *        	线路id
	 */
	public function edit($id = 0) {
		$Line = M ( 'Line' );
		if ($id == 0) {
			$data = $Line->select ();
		} else {
			$data = $Line->find ( $id );
		}
		$this->assign ( 'line', $data );
		$this->display ();
	}
	
	/**
	 * 更新线路
	 */
	public function update() {
		$Line = D ( 'Line' );
		if ($Line->create ()) {
			$result = $Line->save ();
			if ($result) {
				$this->success ( '操作成功！' );
			} else {
				$this->error ( '写入错误！' );
			}
		} else {
			$this->error ( $Line->getError () );
		}
	}
	
	/**
	 * 删除线路
	 *
	 * @param number $id
	 *        	线路ID
	 */
	public function delete($id = 0) {
		$Line = M ( 'Line' );
		if ($Line->delete ( $id )) {
			$this->success ( '操作成功！' );
		} else {
			$this->error ( $Line->getError () );
		}
	}
}