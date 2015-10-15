<?php

namespace Home\Controller;

use Think\Controller;

class ManageController extends Controller {
	
	/**
	 * 加载初始界面
	 */
	public function line_manage() {
		$this->assign('title','用户控制');
		$this->assign('class3','action');
		$Line = A ( 'Line' );
		$data = $Line->select ();
		$this->assign ( 'line_list', $data );
		$this->display ('line_manage');
	}
	 /**
	  * 将批量上传的excel文档中的数据存入数据库
	  */
	public function upload() {
		if (! empty ( $_FILES ['j'] ['name'] ))
		{
			$upload = new \Think\Upload (); // 实例化上传类
			$upload->maxSize = 3145728; // 讴置附件上传大小
			$upload->allowExts = array (
					'xls',
					'xlsx' 
			); // 讴置附件上传类型
			$upload->savePath = 'excel/'; // 讴置附件上传目录
			$upload->autoSub=false;
			$info = $upload->upload ();
			$resurl = "./Uploads/" . $info ['j'] ['savepath'] . $info ['j'] ['savename']; // $resurl 为excel的路径
			$res = D ( 'Manage' )->read ( $resurl );
			unlink ( $resurl );
			
			
			
			foreach ( $res as $k => $v ) {
				if ($k == 1) {
					continue;
				} // 如果是第一行则跳过
				$line ['name'] = $v [0] . '路';
				$Line = M ( 'Line' );
				$is_exit = $Line->where ( $line )->find ();
				if (! $is_exit) {
					$line_id = D ( 'Line' )->add ( $line );
				} else {
					$line_id = $is_exit ['id'];
				}
				
				$bus ['no'] = $v [1];
				$Bus = M ( 'Bus' );
				$is_exit = $Bus->where ( $bus )->find ();
				if (! $is_exit) {
					$bus ['line_id'] = $line_id;
					$bus_id = D ( 'Bus' )->add ( $bus );
				} else {
					$bus_id = $is_exit ['id'];
				}
				$bus = '';//清空bus
				
				$device ['mac'] = $v [2];
				$Device = M ( 'Device' );
				$is_exit = $Device->where ( $device )->find ();
				if (! $is_exit) {
					$device ['bus_id'] = $bus_id;
					$result = D ( 'Device' )->add ( $device );
				}
				$device = '';//清空device
			}
			$this->redirect('line_manage');
		}
	}
}