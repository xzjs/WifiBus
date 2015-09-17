<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/9/15
 * Time: 上午11:05
 */

namespace Home\Controller;
use Org\MyClass\Admin;
use Think\Controller;
use Think\Exception;

class AdminController extends Controller
{
    /**
     * 登录
     */
    public function loginx(){
        $data['name']=I('post.name');
        $data['pwd']=I('post.pwd');
        $a=new Admin();
        $o=$a->login($data);
        if($o){
            $_SESSION['admin']=$o;
            //var_dump($o);
            $this->success('登陆成功','adminlist');
        }else{
            $this->error('登录失败');
        }
    }

    /**
     * 添加管理员
     */
    public function add(){
        $Admin=M('Admin');
        if($Admin->create()){
            $Admin->pwd=md5('1');
            $Admin->type='Low';
            $a=$_SESSION['admin'];
            if($Admin->id==0){
                $result=$a->add($Admin->data());
                if($result>0){
                    $this->success('添加成功','adminlist');
                }else{
                    $this->error('添加失败');
                }
            }else{
                $result=$a->update($Admin->data());
                if($result){
                    $this->success('修改成功','adminlist');
                }else{
                    $this->error('添加失败');
                }
            }

        }
    }

    /**
     * 显示管理员列表
     */
    public function adminlist(){
        $a=$_SESSION['admin'];
        $list=$a->select();
        $this->assign('list',$list);
        $this->show();
    }

    /**
     * 创建和修改
     * @param int $id 要修改的管理员id
     */
    public function edit($id=0){
        $data['id']=0;
        if($id!=0){
            $a=$_SESSION['admin'];
            $data=$a->select($id);
            $this->assign('data',$data);
        }
        $this->show();
    }

    /**
     * 修改密码
     */
    public function update_pwd(){
        try {
            $data = I('post.');
            $a = $_SESSION['admin'];
            $result = $a->update_pwd($data);
            if ($result) {
                $this->success('修改成功', 'adminlist');
            } else {
                $this->error('修改失败');
            }
        }catch (Exception $e){
            $this->error($e->getMessage());
        }
    }

    public function logout(){
        $a = $_SESSION['admin'];
        $a->logout();
        $this->success('注销成功','login');
    }
}