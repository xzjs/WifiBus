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

/**
 * 管理员控制器
 * Class AdminController
 * @package Home\Controller
 */
class AdminController extends Controller
{
	public function login(){
		$this->display();
	}
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
            $this->redirect('Index/index');
            //var_dump($o);
            //$this->success('登陆成功','adminlist');
        }else{
            $this->error('用户名或密码错误，请重新输入！');
        }
    }

    /**
     * 添加管理员
     */
    public function add(){
        $Admin=M('Admin');
        if($Admin->create()){
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

    /**
     * 注销
     */
    public function logout(){
        $a = $_SESSION['admin'];
        $a->logout();
        $this->success('注销成功','login');
    }

    /**
     * 删除
     * @param $id 管理员id
     */
    public function delete($id){
        $a=$_SESSION['admin'];
        $result=$a->delete($id);
        if($result==1){
            $this->success('删除成功','__URL__/adminlist');
        }else{
            $this->error('删除失败');
        }
    }
}