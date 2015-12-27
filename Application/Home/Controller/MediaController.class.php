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
class MediaController extends BaseController
{

    /**
     * 添加媒体
     */
    public function add()
    {
        $img=$this->upload_file();
        $Media = D('Media');
        if ($Media->create()) {
            $Media->img=$img;
            $media_id=$Media->add();
            if($media_id){
                $buses=explode(' ',I('post.ids'));
                foreach ($buses as $bus) {
                    $DeviceModel=D('Device');
                    $condition['bus_id']=$bus;
                    $device=$DeviceModel->where($condition)->find();
                    $dmModel=M('Device_media');
                    $data=array(
                        'device_id'=>$device['id'],
                        'media_id'=>$media_id
                    );
                    $result=$dmModel->add($data);
                    if($result){
                        $CommandCtrl=A('Command');
                        $cmd_result=$CommandCtrl->add($device['id'],'Contentsupdate',C('IP').C('PORT').'/WifiBus/Update/|'.$img.'|'.I('post.position').'.'.I('post.suffix'));
                        if($cmd_result){
                            echo '成功';
                        }else{
                            echo '命令插入错误';
                        }
                    }else{
                        echo '添加关系表失败';
                    }
                }
            }else{
                echo '上传成功';
            }
        } else {
            echo $Media->getError();
        }
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