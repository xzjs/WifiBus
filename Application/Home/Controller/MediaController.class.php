<?php

namespace Home\Controller;

use Think\Controller;
use Org\Util\Date;
use Org\YxgClass\MediaFactory;
/**
 * 媒体控制器类（包括文本、图片和视频）
 * @author xiuge
 *
 */
class MediaController extends Controller {
	/**
	 * 添加媒体
	 */
	public function add() {
		$Media = D ( 'Media' );
		if ($Media->create ()) {
			$Media->click_num=0;
			$Media->suffix=I('param.suffix');
			$media=MediaFactory::createMedia($Media->type);
			$result=$media->addMedia($Media);
			if ($result) {
				$this->success ( '数据添加成功！' );
			} else {
				$this->error ( '数据添加错误！' );
			}
		} else {
			$this->error ( $Media->getError () );
		}
	}
	
	/**
	 * 查询媒体信息
	 * @param number $id 媒体id        	
	 */
	public function select($id = 0) {
		$Media = M ( 'Media' );
		if($id==0){
			$data=$Media->select();
		}else{
			$data = $Media->find ( $id );
		}
		if ($data) {
			$this->assign ( 'media', $data ); // 模板变量赋值
		} else {
			$this->error ( '数据错误' );
		}
		$this->display ();
	}
	
	/**
	 * 测试更新媒体信息的方法
	 * @param number $id 媒体id 
	 */
	public function edit($id=0){
		$Media   =   M('Media');
		if($id==0){
			$data=$Media->select();
		}else{
			$data = $Media->find ( $id );
		}
		$this->assign('media',$Media->find($id));
		$this->display();
	}
	
	/**
	 * 更新媒体信息
	 */
	public function update() {
		$Media = D ( 'Media' );
		if ($Media->create ()) {
			$result = $Media->save ();
			if ($result) {
				$this->success ( '操作成功！' );
			} else {
				$this->error ( '写入错误！' );
			}
		} else {
			$this->error ( $Media->getError () );
		}
	}
	
	/**
	 * 删除媒体
	 */
	public function delete($id = 0) {
		$Media = M ( 'Media' );
		if ($Media->delete ( $id )) {
			$this->success ( '操作成功！' );
		} else {
			$this->error ( $Media->getError () );
		}
	}
}