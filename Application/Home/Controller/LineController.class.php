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
	 * 添加线路或则车辆
	 * 返回值：-1路线名重复，-2车牌号重复
	 */
	public function add() {
		
		
			$Line = D ( 'Line' );
			$Line->id=I('post.lineId');
			$Line->name=I('post.lineName');
			if ($Line->create ()) {
				$result = $Line->add ();
				if($result)
					echo "成功";
				else 
					echo "失败";
			} else {
				echo  $Line->getError () ;
			}
		
	}
		
	public function adds() {
		$flag = 1;
		if (I ( 'post.type' ) == 0) {
			$Line = D ( 'Line' );
			if ($Line->create ()) {
				$result = $Line->add ();
			} else {
				exit ( $Line->getError () );
			}
		} 

		else {
			$Line = D ( 'Bus' );
			$device = D ( 'Device' );
			if ($Line->create() && $device->create()) {
				$result = $Line->add ();
				$device->bus_id = $result;
				$flag = $device->add ();
				if ($flag && $result) {
					echo $result;
				} else {
					$this->error ( '数据添加失败！' );
				}
			} else {
				$erro=$device->getError()+$Line->getError();
				 //exit($erro);
				
			}
		}
		
		if ($flag && $result) {
			echo $result;
		} else {
			$this->error ( '数据添加失败！' );
		}
	}
	
	/**
	 * 查询线路
	 *
	 * @param number $id
	 *        	线路id
	 */
	public function getLineList($id = 0, $search_keys = '', $is_ajax = 0) {
		$Line = M ( 'Line' );
		if ($id != 0) {
			$data = $Line->find ( $id );
		} elseif ($search_keys != '') { // 根据关键字搜索
			$map ['name'] = array (
					'like',
					'%' . $search_keys . '%' 
			);
			$data = $Line->where ( $map )->select ();
		} else {
			$data = $Line->order ( 'name' )->select ();
		}
		
		if ($is_ajax == 1) {
			$a = json_encode ( $data );
			$this->ajaxReturn ( json_encode ( $data ) );
		} else
			return $data;
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
	public function delete() {
		$Line = M ( 'Line' );
		$bus=A('Bus');
		echo I('post.lineId');
		//$Line->id=I('post.lineId');
		if ($bus->update_line(I('post.lineId'))&&$Line->delete (I('post.lineId'))) {
			echo'操作成功！' ;
		} else {
			echo "删除失败";
		}
	}
}