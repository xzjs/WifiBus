<?php

namespace Home\Controller;

use Think\Controller;

/**
 * 公交线路控制器类
 *
 * @author xiuge
 *
 */
class LineController extends Controller
{

    /**
     * 线路查询
     */
    public function select()
    {
        $line = D('Line');
        //$id=I('post.id');
        $data = $line->field('id as lineId,name as lineName')->order('id')->select();
        $a = json_encode($data);
        echo $a;
    }

    /**
     * 查询线路下的车辆
     */
    public function  line_bus()
    {
        $bus = A('Bus');
        $reslut = $bus->select_bus($id = 0, $line_id = I('post.id'), $search_keys = '', $is_getbuslist = 1);
        echo $reslut;
    }

    /**
     * 添加线路或则车辆
     * 返回值：-1路线名重复，-2车牌号重复
     */
    public function add()
    {
        $Line = D('Line');
        if ($Line->create()) {
            $result = $Line->add();
            echo $result ? '添加成功' : '添加失败';
        } else {
            echo $Line->getError();
        }

    }

    /**
     * 添加一辆车
     */
    public function adds()
    {
        $Bus = D('Bus');
        $device = D('Device');
        $post=I('post.');
        if ($Bus->create() && $device->create()) {
            $result = $Bus->add();
            $device->bus_id = $result;
            $flag = $device->add();
            if ($flag && $result) {
                echo '添加成功';
            } else {
                echo '添加失败';
            }
        } else {
            echo $Bus->getError() . $device->getError();
        }
    }

    /**
     * 查询线路
     *
     * @param number $id
     *            线路id
     */
    public function getLineList($id = 0, $search_keys = '', $is_ajax = 0)
    {
        $Line = M('Line');
        if ($id != 0) {
            $data = $Line->find($id);
        } elseif ($search_keys != '') { // 根据关键字搜索
            $map ['name'] = array(
                'like',
                '%' . $search_keys . '%'
            );
            $data = $Line->where($map)->select();
        } else {
            $data = $Line->order('name')->select();
        }

        if ($is_ajax == 1) {
            $a = json_encode($data);
            $this->ajaxReturn(json_encode($data));
        } else
            return $data;
    }

    /**
     * 测试更新线路方法
     *
     * @param number $id
     *            线路id
     */
    public function edit($id = 0)
    {
        $Line = M('Line');
        if ($id == 0) {
            $data = $Line->select();
        } else {
            $data = $Line->find($id);
        }
        $this->assign('line', $data);
        $this->display();
    }

    /**
     * 更新线路
     */
    public function update()
    {
        $Line = D('Line');

        $name = I('post.name');
        $id = I('post.id');
        //echo $name;
        if ($Line->create()) {

            $result = M()->execute("UPDATE think_line SET name='$name' WHERE id=$id");

            if ($result) {
                echo '更新成功！';
            } else {
                echo '更新失败！';
            }
        } else {
            //echo "ee";
            echo $Line->getError();
        }
    }

    /**
     * 删除线路
     *
     * @param number $id
     *            线路ID
     */
    public function delete()
    {
        $Line = M('Line');
        $bus = A('Bus');
        //echo I('post.id');
        //$Line->id=I('post.lineId');
        if ($bus->update_line(I('post.id')) && $Line->delete(I('post.id'))) {
            echo '操作成功！';
        } else {
            echo "删除失败";
        }
    }

    /**
     * 获取指定线路下的车辆
     * @param $line_id 线路id
     * @return mixed 车辆数组
     */
    public function get_buses($line_id)
    {
        $LineModel = D('Line');
        $line = $LineModel->find($line_id);
        $BusModel = D('Bus');
        $condition['line_id'] = $line_id;
        $data = array(
            'line' => $line,
            'buses' => $BusModel->where($condition)->relation(true)->select()
        );
        echo json_encode($data);
    }
}