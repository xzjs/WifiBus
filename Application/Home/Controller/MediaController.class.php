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

    public function test($aaa)
    {
        var_dump(S('abc'));
        S('abc', $aaa, 3);
    }


    /**
     * 上传固件升级文件
     */
    public function upload_devicefile()
    {
        $error_data['status'] = 0;
        //$file_name=$this->upload_file();
        $upload = new \Think\Upload(); // 实例化上传类
        $upload->maxSize = 9999999999999; // 设置附件上传大小
        $upload->rootPath = "./Update/"; // 设置附件上传根目录
        $upload->autoSub = false;
        $upload->saveName = '_' . time(); // 上传文件
        $info = $upload->upload();
        $file_name = $info ['file'] ['savename'];
        $CommandCtrl = A('Command');
        if (I('post.mac') == "all devices") {
            $device_list = M('Device')->field('mac')->select();
            foreach ($device_list as $vo) {
                $device_id = A('Device')->get_id($vo['mac']);
                $cmd_result1 = $CommandCtrl->add($device_id, 'Firmwareupdate', '/WifiBus/Update/|' . $file_name . '|' . 'heartbeat');
                if ($cmd_result1 > 0)
                    echo $file_name;
            }
        } else {
            $device_id = A('Device')->get_id(I('post.mac'));
            //$device_idhh=$device->get_id(I('post.mac'));
            // $file_name=I('post.ye');
            $cmd_result1 = $CommandCtrl->add($device_id, 'Firmwareupdate', '/WifiBus/Update/|' . $file_name . '|' . 'heartbeat');
            if ($cmd_result1 > 0)
                echo $file_name;
            //$this->success('ok');
            //$cmd_result2=$CommandCtrl->add($device['id'],'Contentsupdate','/WifiBus/Update/|'.$name_str[0].'.jpg'.'|'.I('post.position').'.jpg');

        }

    }


    /**
     * 添加媒体
     */
    public function add()
    {
        $error_data['status'] = 0;
        $img = $this->upload_file("ad");
        $Media = D('Media');
        if ($Media->create()) {
            $Media->img = $img;
            $media_id = $Media->add();
            if ($media_id) {
                $buses = explode('_', I('post.ids'));
                foreach ($buses as $bus) {
                    $DeviceModel = D('Device');
                    $condition['bus_id'] = $bus;
                    $device = $DeviceModel->where($condition)->relation(true)->find();
                    $m = '';
                    foreach ($device['Media'] as $media) {
                        $m = $media['position'] == I('post.position') ? $media : $m;
                    }
                    $dmModel = M('Device_media');
                    $result = false;
                    if ($m == '') {
                        $data = array(
                            'device_id' => $device['id'],
                            'media_id' => $media_id
                        );
                        $result = $dmModel->add($data);
                    } else {
                        $condition = array(
                            'device_id' => $device['id'],
                            'media_id' => $m['id']
                        );
                        $dm = $dmModel->where($condition)->find();
                        $dm['media_id'] = $media_id;
                        $result = $dmModel->save($dm);
                    }
                    if ($result) {
                        $CommandCtrl = A('Command');
                        $position = substr(I('post.position'), 0, 2);
                        if ($position == 'ad') {
                            $cmd_result = $CommandCtrl->add($device['id'], 'AdUpdate', '/WifiBus/Update/|' . $img . '|' . I('post.position') . '.jpg|' . I('post.url') . '|' . I('post.text'));
                        } else {
                            $cmd_result = $CommandCtrl->add($device['id'], 'Contentsupdate', '/WifiBus/Update/|' . $img . '|' . I('post.position') . '.jpg');
                        }
                        if ($cmd_result) {
                            $error_data['status'] = 0;
                            $error_data['data'] = '成功';
                        } else {
                            $error_data['data'] = '命令插入错误';
                        }
                    } else {
                        $error_data['data'] = '添加关系表失败';
                    }
                }
            } else {
                $error_data['data'] = '上传失败';
            }
        } else {
            $error_data['data'] = $Media->getError();
        }
        $this->ajaxReturn($error_data);
    }

    public function progress()
    {
        session_start();

        $i = ini_get('session.upload_progress.name');

        $key = ini_get("session.upload_progress.prefix") . $_GET[$i];

        if (!empty($_SESSION[$key])) {
            $current = $_SESSION[$key]["bytes_processed"];
            $total = $_SESSION[$key]["content_length"];
            echo $current < $total ? ceil($current / $total * 100) : 100;
        } else {
            echo 100;
        }
    }

    /**
     * 上传电影、电子书、apk等文件
     */
    public function upload()
    {
        $error_data['status'] = 0;
        if (strstr(I('post.position'), 'video')) {
            $file_name = $this->upload_video('video');
        } elseif (strstr(I('post.position'), 'book')) {
            $file_name = $this->upload_file('book');
        } elseif (strstr(I('post.position'), 'app')) {
            $file_name = $this->upload_file('app');
        }
        $Media = D('Media');
        if ($Media->create()) {
            $Media->url = $file_name;
            $name_str = explode(".", $file_name);
            $Media->img = $name_str[0] . '.jpg';
            $media_id = $Media->add();
            if ($media_id) {
                $buses = explode('_', I('post.ids'));
                foreach ($buses as $bus) {
                    $DeviceModel = D('Device');
                    $condition['bus_id'] = $bus;
                    $devices = $DeviceModel->where($condition)->relation(true)->select();
                    if (!$devices)
                        continue;
                    $device = $devices[0];
                    $m = '';
                    foreach ($device['Media'] as $media) {
                        $m = $media['position'] == I('post.position') ? $media : $m;
                    }
                    $dmModel = M('Device_media');
                    $result = false;
                    if ($m == '') {
                        $data = array(
                            'device_id' => $device['id'],
                            'media_id' => $media_id
                        );
                        $result = $dmModel->add($data);
                    } else {
                        $condition = array(
                            'device_id' => $device['id'],
                            'media_id' => $m['id']
                        );
                        $dm = $dmModel->where($condition)->find();

                        $dm['media_id'] = $media_id;
                        $result = $dmModel->save($dm);
                    }
                    if ($result) {
                        $CommandCtrl = A('Command');
                        $cmd_result1 = $CommandCtrl->add($device['id'], 'Contentsupdate', '/WifiBus/Update/|' . $file_name . '|' . I('post.position') . '.' . $name_str[1]);
                        $cmd_result2 = $CommandCtrl->add($device['id'], 'Contentsupdate', '/WifiBus/Update/|' . $name_str[0] . '.jpg' . '|' . I('post.position') . '.jpg');
                        if ($cmd_result1 && $cmd_result2) {
                            $error_data['status'] = 0;
                            $error_data['data'] = '成功';
                        } else {
                            $error_data['data'] = '命令插入错误';
                        }
                    } else {
                        $error_data['data'] = '添加关系表失败';
                    }
                }
            } else {
                $error_data['data'] = '上传失败';
            }
        } else {
            $error_data['data'] = $Media->getError();
        }
        $this->ajaxReturn($error_data);
    }

    /**
     * 查询媒体
     *
     * @param int|number $id
     *            媒体id
     * @param int|number $type
     *            媒体类型
     * @param int|number $admin_id
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

    /**
     * 更新媒体
     * @param $mac 设备mac
     * @param $position 位置
     */
    public function update_click($mac, $position)
    {
        $DeviceModel = D('Device');
        $condition['mac'] = $mac;
        $device = $DeviceModel->where($condition)->find();
        $DeviceMediaModel = M('DeviceMedia');
        unset($condition);
        $condition['device_id'] = $device['id'];
        $media_ids = $DeviceMediaModel->where($condition)->getField('media_id');
        unset($condition);
        $condition['id'] = array('in', $media_ids);
        $condition['position'] = $position;
        $MediaModel = D('Media');
        $media_id = $MediaModel->where($condition)->fetchSql(false)->getField('id');
        $MediaclickModel = M('Mediaclick');
        unset($condition);
        $condition['media_id'] = $media_id;
        $condition[time] = array(array('gt', strtotime('yesterday')), array('lt', strtotime('tomorrow')));
        $result = $MediaclickModel->where($condition)->find();
        if ($result) {
            $result['click_num'] += 1;
            $result['time'] = time();
            $update_num = $MediaclickModel->save($result);
            if (!$update_num) {
                throw_exception('修改失败');
            }
        } else {
            $data = array(
                'media_id' => $media_id,
                'click_num' => 1,
                'time' => time()
            );
            $insert_id = $MediaclickModel->add($data);
            if (!$insert_id) {
                throw_exception('添加失败');
            }
        }
    }
}
