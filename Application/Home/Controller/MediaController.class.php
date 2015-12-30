<?php

namespace Home\Controller;

use Think\Controller;

/**
 * 媒体控制器类（包括文本、图片和视频）
 * @author xiuge
 *
 */
class MediaController extends BaseController
{

    /**
     * 添加媒体
     */
    public function add()
    {
        $error_data['status']=0;
        $img=$this->upload_file();
        $Media = D('Media');
        if ($Media->create()) {
            $Media->img=$img;
            $media_id=$Media->add();
            if($media_id){
                $buses=explode('_',I('post.ids'));
                foreach ($buses as $bus) {
                    $DeviceModel=D('Device');
                    $condition['bus_id']=$bus;
                    $device=$DeviceModel->where($condition)->relation(true)->find();
                    $m='';
                    foreach ($device['Media'] as $media) {
                        $m=$media['position']==I('post.position')?$media:$m;
                    }
                    $dmModel=M('Device_media');
                    $result=false;
                    if($m==''){
                        $data=array(
                            'device_id'=>$device['id'],
                            'media_id'=>$media_id
                        );
                        $result=$dmModel->add($data);
                    }else{
                        $condition=array(
                            'device_id'=>$device['id'],
                            'media_id'=>$m['id']
                        );
                        $dm=$dmModel->where($condition)->find();
                        $dm['media_id']=$media_id;
                        $result=$dmModel->save($dm);
                    }
                    if($result){
                        $CommandCtrl=A('Command');
                        $cmd_result=$CommandCtrl->add($device['id'],'Contentsupdate',C('IP').':'.C('PORT').'/WifiBus/Update/|'.$img.'|'.I('post.position').'.'.I('post.suffix'));
                        if($cmd_result){
                            $error_data['status']=0;
                            $error_data['data']='成功';
                        }else{
                            $error_data['data']='命令插入错误';
                        }
                    }else{
                        $error_data['data']= '添加关系表失败';
                    }
                }
            }else{
                $error_data['data']= '上传失败';
            }
        } else {
            $error_data['data']= $Media->getError();
        }
        echo json_encode($error_data);
    }
    
    /**
     * 上传电影、电子书、apk等文件
     */
    public function upload() {
    	$error_data['status']=0;
    	$file_name=$this->upload_file();
    
    	$Media = D('Media');
    	if ($Media->create()) {
    		$Media->url=$file_name;
    		$name_str=explode(".",$file_name);
    		$Media->img=$name_str[0].'.jpg';
    		$media_id=$Media->add();
    		if($media_id){
    			$buses=explode('_',I('post.ids'));
    			foreach ($buses as $bus) {
    				$DeviceModel=D('Device');
    				$condition['bus_id']=$bus;
    				$devices=$DeviceModel->where($condition)->relation(true)->select();
    				if(!$devices)
    					continue;
    				$device=$devices[0];
    				$m='';
    				foreach ($device['Media'] as $media) {
    					$m=$media['position']==I('post.position')?$media:$m;
    				}
    				$dmModel=M('Device_media');
    				$result=false;
    				if($m==''){
    					$data=array(
    							'device_id'=>$device['id'],
    							'media_id'=>$media_id
    					);
    					$result=$dmModel->add($data);
    				}else{
    					$condition=array(
    							'device_id'=>$device['id'],
    							'media_id'=>$m['id']
    					);
    					$dm=$dmModel->where($condition)->find();
    					
    					$dm['media_id']=$media_id;
    					$result=$dmModel->save($dm);
    				}
    				if($result){
    					$CommandCtrl=A('Command');
    					$cmd_result1=$CommandCtrl->add($device['id'],'Contentsupdate',C('IP').':'.C('PORT').'/WifiBus/Update/|'.$file_name.'|'.I('post.position').'.'.$name_str[1]);
    					$cmd_result2=$CommandCtrl->add($device['id'],'Contentsupdate',C('IP').':'.C('PORT').'/WifiBus/Update/|'.$name_str[0].'.jpg'.'|'.I('post.position').'.jpg');
    					if($cmd_result1&&$cmd_result2){
    						$error_data['status']=0;
    						$error_data['data']='成功';
    					}else{
    						$error_data['data']='命令插入错误';
    					}
    				}else{
    					$error_data['data']= '添加关系表失败';
    				}
    			}
    		}else{
    			$error_data['data']= '上传失败';
    		}
    	} else {
    		$error_data['data']= $Media->getError();
    	}
    	$this->ajaxReturn($error_data);
    }

    /**
     * 查询媒体
     *
     * @param number $id
     *            媒体id
     * @param number $type
     *            媒体类型
     * @param number $admin_id
     *            创建者ID
     */
    public function select($id = 0, $type = 0, $admin_id = 0)
    {
        $Media = M('Media');
        if ($id != 0)
            $condition ['id'] = $id;
        if ($type != 0)
            $condition ['type'] = $type;
        if ($admin_id != 0)
            $condition ['admin_id'] = $admin_id;
        $result = $Media->where($condition)->select();
        var_dump($result);
    }

    /**
     * 测试更新媒体信息的方法
     *
     * @param number $id
     *            媒体id
     */
    public function edit($id = 0)
    {
        $Media = M('Media');
        if ($id == 0) {
            $data = $Media->select();
        } else {
            $data = $Media->find($id);
        }
        $this->assign('media', $Media->find($id));
        $this->display();
    }

    /**
     * 更新媒体信息
     *
     * @param number $id
     *            媒体ID
     * @param number $click_num
     *            媒体点击数量
     * @param string $describle
     *            媒体描述信息
     */
    public function update($id = 0, $click_num = 0, $describle = '')
    {
        if (IS_POST) {
            $Media = D('Media');
            if ($Media->create()) {
                $result = $Media->save();
                if ($result) {
                    $this->success('操作成功！');
                } else {
                    $this->error('写入错误！');
                }
            } else {
                $this->error($Media->getError());
            }
        } elseif (IS_GET) {
            $Media = M('Media');
            if ($click_num != 0)
                $data ['click_num'] = $click_num;
            if ($describle != '')
                $data ['describle'] = $describle;
            $result = $Media->where('id=' . $id)->setField($data);
            if ($result) {
                $this->success('操作成功！');
            } else {
                $this->error('写入错误！');
            }
        }
    }

    /**
     * 删除媒体
     *
     * @param number $id
     *            媒体ID
     */
    public function delete($id = 0)
    {
        $Media = M('Media');
        if ($Media->delete($id)) {
            $this->success('操作成功！');
        } else {
            $this->error($Media->getError());
        }
    }


    
}
