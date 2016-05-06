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
class AdController extends Controller
{
    /**
     * “广告设置”页面
     */
    public function index()
    {
        $this->assign('title', '广告设置');
        $this->assign('class4', 'action');
        $Line = A('Line');
        $data = $Line->getLineList();
        $this->assign('line_list', $data);
        $Bus = A('Bus');
        $data = $Bus->select(0, $data[0][id], '', 0);
        $this->assign('bus_list', $data);

        $this->display();
    }

    /**
     * 添加广告
     */
    public function add()
    {
        $Ad = D('Ad');
        if ($Ad->create()) {
            if (empty ($Bus->click_num))
                $Bus->click_num = 0;
            if ($result = $Ad->add()) {
                $this->success('添加成功！');
            } else {
                $this->error('添加失败！');
            }
        } else {
            $this->error($Ad->getError());
        }
    }

    /**
     * 查询广告信息
     *
     * @param number $id
     *            广告Id
     * @param number $type 广告类型
     */
    public function select()
    {
        $Ad = M('Ad');
        $lineid = I('param.line_id');
        if (I('param.line_id', 0) != 0) {
            $result = $Ad->where('line_id=%d', $lineid)->order('click_num desc')->limit(6)->select();
            $this->ajaxReturn($result);
        } else {
            if ($id != 0)
                $condition ['id'] = $id;
            if ($type != 0)
                $condition ['type'] = $type;
            $result = $Ad->where($condition)->select();
            if ($result) {
                var_dump($result);
            } else {
                $this->error('查询失败！');
            }
        }

    }

    /**
     * 测试更新广告信息的方法
     *
     * @param number $id
     *            广告Id
     */
    public function edit($id)
    {
        $Ad = M('Ad');
        if ($id == 0) {
            $result = $Ad->select();
        } else {
            $result = $Ad->find($id);
        }
        if ($result) {
            $this->assign('ad', $result);
        } else {
            $this->error('查询失败！');
        }
        $this->display();
    }

    /**
     * 更新广告
     * @param number $id
     * @param number $click_num
     */
    public function update($id = 0, $click_num = 0, $text = '')
    {
        if (IS_POST) {
            $Ad = D('Ad');
            if ($Ad->create()) {
                $result = $Ad->save();
                if ($result) {
                    $this->success('更新成功！');
                } else {
                    $this->error('更新失败！');
                }
            } else {
                $this->error($Ad->getError());
            }
        } elseif (IS_GET) {
            if ($text != '')
                $data['text'] = $text;
            if ($click_num != 0)
                $data['click_num'] = $click_num;
            $result = $Ad->where('id=' . $id)->setField($data);
        }


    }

    /**
     * 删除广告信息
     * @param unknown $id 广告ID
     */
    public function delete($id)
    {
        $Ad = M('Ad');
        $result = $Ad->delete($id);
        if ($result) {
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！');
        }
    }

    public function get_img($ids = 0)
    {
        $Media = A('Media');
        $img_list = $Media->get_img();
        for ($i = 0; $i < count($img_list); $i++) {
            $img_url[$i]['img'] = 'http://' . GetHostByName($_SERVER['SERVER_NAME']) . '/WifiBus/Uploads/' . $img_list[$i]['url'];
            $img_url[$i]['text'] = $img_list[$i]['text'];
        }
        $this->ajaxReturn($img_url);
    }

    public function upload()
    {
        $a = I('param.img_dsc');
        $b = I('param.text_dsc');
        $this->ajaxReturn($a);
    }

    public function get_media_info($ids)
    {
        $id_list = $ids;
        $device = M('Device');
        $device_ids = array();
        for ($i = 0; $i < count($id_list); $i++) {
            $condition['bus_id'] = $id_list[$i];
            $result = $device->where($condition)->field('id')->find();
            if ($result)
                array_push($device_ids, $result['id']);
        }

        $json['ssid'] = $this->get_media($device_ids);


        $json['flow_limit'] = $Device->get_network_limit($device_ids);
        $this->ajaxReturn($json);
    }

    /**
     * 根据id列表查询media信息
     * @param array $device_ids id列表
     * @return string ssid名
     */
    public function get_media($device_ids)
    {
        $position_arr = array("ad1", "ad2", "ad3", "ad4", "ad5", "ad6");
        if (count($device_ids) == 0) {
            for ($j = 0; $j < count($position_arr); $j++) {
                $position_info[$position_arr[$j]] = null;
            }
        } else {
            for ($i = 0; $i < count($device_ids); $i++) {
                $device_id_str .= $device_ids[$i];
                if ($i != count($device_ids) - 1)
                    $device_id_str .= ",";
            }
            for ($j = 0; $j < count($position_arr); $j++) {
                $sql = 'select m.url,m.img,m.text from think_media as m,think_device_media as dm
							where m.id=dm.media_id AND dm.device_id IN(' . $device_id_str . ') AND m.position="' . $position_arr[$j] . '"';
                $result = M()->query($sql);
                $position_info[$position_arr[$j]] = $this->get_position_info($result, count($device_ids));
            }
        }
        $this->ajaxReturn($position_info);
    }


    /**
     * 判断该position改显示的内容（查询条数若不等于id列表的的条数则表示该position不全相同）
     * @param unknown $result
     * @param unknown $count
     */
    public function get_position_info($result, $count)
    {
        if (GetHostByName($_SERVER['SERVER_NAME']) == "127.0.0.1") {
            $ip = GetHostByName($_SERVER['SERVER_NAME']);
        } elseif (GetHostByName($_SERVER['SERVER_NAME']) == "192.168.4.96") {
            $ip = GetHostByName($_SERVER['SERVER_NAME']) . ":48093";
        } elseif (GetHostByName($_SERVER['SERVER_NAME']) == "192.168.4.97") {
            $ip = GetHostByName($_SERVER['SERVER_NAME']) . ":48082";
        }


        if ($count == 1) {
            if ($result[0]['url'])
                $result[0]['url'] = 'http://' . $ip . '/WifiBus/Update/' . $result[0]['url'];
            if ($result[0]['img'])
                $result[0]['img'] = 'http://' . $ip . '/WifiBus/Update/' . $result[0]['img'];
            return $result[0];
        } else if (count($result) != $count) {
            return null;
        } else {
            $flag = false;
            for ($i = 1; $i < count($result); $i++) {
                if ($result[$i - 1]['url'] != $result[$i]['url']) {
                    $flag = true;
                    break;
                }
            }
            if ($flag)
                return null;
            else {
                if ($result[0]['url'])
                    $result[0]['url'] = 'http://' . $ip . '/WifiBus/Update/' . $result[0]['url'];
                if ($result[0]['img'])
                    $result[0]['img'] = 'http://' . $ip . '/WifiBus/Update/' . $result[0]['img'];
                return $result[0];
            }
        }
    }


}