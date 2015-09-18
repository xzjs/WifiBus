<?php

namespace Home\Controller;

use Think\Controller;

/**
 *
 * 广告控制器类
 * 
 * @author xiuge
 *        
 */
class AdController extends Controller {
	
	/**
	 * 添加广告
	 */
	public function add() {
		$Ad = D ( 'Ad' );
		if ($Ad->create ()) {
			if ($result = $Ad->add ()) {
				$this->success ( '添加成功！' );
			} else {
				$this->error ( '添加失败！' );
			}
		} else {
			$this->error ( $Ad->getError () );
		}
	}
	
	/**
	 * 查询广告信息
	 *
	 * @param number $id
	 *        	广告Id
	 */
	public function select($id = 0) {
		$Ad = M ( 'Ad' );
		if ($id == 0) {
			$result = $Ad->select ();
		} else {
			$result = $Ad->find ( $id );
		}
		if ($result) {
			$this->assign ( 'ad', $result );
		} else {
			$this->error ( '查询失败！' );
		}
		$this->display ();
	}
	
	/**
	 * 测试更新广告信息的方法
	 *
	 * @param number $id
	 *        	广告Id
	 */
	public function edit($id) {
		$Ad = M ( 'Ad' );
		if ($id == 0) {
			$result = $Ad->select ();
		} else {
			$result = $Ad->find ( $id );
		}
		if ($result) {
			$this->assign ( 'ad', $result );
		} else {
			$this->error ( '查询失败！' );
		}
		$this->display ();
	}
	
	/**
	 * 更新广告信息
	 */
	public function update($id = 0, $click_num = 0) {
		if (($id == 0) && ($click_num == 0)) {
			$Ad = D ( 'Ad' );
			if ($Ad->create ()) {
				$result = $Ad->save ();
			} else {
				$this->error ( $Ad->getError () );
			}
		} else {
			$Ad = M ( 'Ad' );
			$result = $Ad->where ( 'id=' . $id )->setField ( 'click_num', $click_num );
		}
		if ($result) {
			$this->success ( '更新成功！' );
		} else {
			$this->error ( '更新失败！' );
		}
	}
	public function delete($id) {
		$Ad = M ( 'Ad' );
		$result = $Ad->delete ( $id );
		if ($result) {
			$this->success ( '删除成功！' );
		} else {
			$this->error ( '删除失败！' );
		}
	}
}