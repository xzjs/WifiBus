<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/9/15
 * Time: 上午11:05
 */

namespace Home\Controller;

use Think\Controller;
use Think\Exception;

/**
 * 管理员控制器
 * Class AdminController
 * @package Home\Controller
 */
class AdminController extends BaseController
{
    /**
     * 登录
     */
    public function loginx()
    {
        $Admin = D('Admin');
        if ($Admin->create()) {
            $condition=array(
                'name'=>$Admin->name,
                'pwd'=>md5($Admin->pwd)
            );
            $result=$Admin->where($condition)->find();
            if($result){
                $_SESSION['admin']=$result;
                $this->success('登录成功',U('Index/index'));
            }else{
                $this->error('登录失败');
            }
        } else {
            $this->error($Admin->getError());
        }

    }

    /**
     * 添加管理员
     */
    public function add()
    {
        $Admin = M('Admin');
        if ($Admin->create()) {
            $a = $_SESSION['admin'];
            if ($Admin->id == 0) {
                $result = $a->add($Admin->data());
                if ($result > 0) {
                    $this->success('添加成功', 'adminlist');
                } else {
                    $this->error('添加失败');
                }
            } else {
                $result = $a->update($Admin->data());
                if ($result) {
                    $this->success('修改成功', 'adminlist');
                } else {
                    $this->error('添加失败');
                }
            }
        }
    }

    /**
     * 显示管理员列表
     */
    public function adminlist()
    {
        $a = $_SESSION['admin'];
        $list = $a->select();
        $this->assign('list', $list);
        $this->show();
    }

    /**
     * 创建和修改
     * @param int $id 要修改的管理员id
     */
    public function edit($id = 0)
    {
        $data['id'] = 0;
        if ($id != 0) {
            $a = $_SESSION['admin'];
            $data = $a->select($id);
            $this->assign('data', $data);
        }
        $this->show();
    }

    /**
     * 修改密码
     */
    public function update_pwd()
    {
        try {
            $data = I('post.');
            $a = $_SESSION['admin'];
            $result = $a->update_pwd($data);
            if ($result) {
                $this->success('修改成功', 'adminlist');
            } else {
                $this->error('修改失败');
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 注销
     */
    public function logout()
    {
        session_unset();
        session_destroy();
        $this->success('注销成功','login');
    }

    /**
     * 删除
     * @param $id 管理员id
     */
    public function delete($id)
    {
        $a = $_SESSION['admin'];
        $result = $a->delete($id);
        if ($result == 1) {
            $this->success('删除成功', '__URL__/adminlist');
        } else {
            $this->error('删除失败');
        }
    }

    public function upload(){
        if(is_uploaded_file($_FILES['file1']['tmp_name'])){
            $a=$this->upload_file();
            var_dump($a);
        }
    }

    public function progress(){
        session_start();

        $i = ini_get('session.upload_progress.name');

        $key = ini_get("session.upload_progress.prefix") . $_GET[$i];

        if (!empty($_SESSION[$key])) {
            $current = $_SESSION[$key]["bytes_processed"];
            $total = $_SESSION[$key]["content_length"];
            echo $current < $total ? ceil($current / $total * 100) : 100;
        }else{
            echo 100;
        }
    }

}