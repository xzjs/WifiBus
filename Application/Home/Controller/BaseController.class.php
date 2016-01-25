<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/11/23
 * Time: 上午11:12
 */
namespace Home\Controller;

use Think\Controller;

class BaseController extends Controller
{

    /**
     * 根据时间戳返回星期几
     * @param string $time 时间戳
     * @return 星期几
     */
    function weekday($time)
    {
        //$time=I('post.time');
        if (is_numeric($time)) {
            $weekday = array('周日', '周一', '周二', '周三', '周四', '周五', '周六');
            return $weekday[date('w', $time)];
        }
        return false;
    }

    /**
     * 文件上传
     */
    public function upload_file()
    {
        $upload = new \Think\Upload(); // 实例化上传类
        $upload->maxSize = 9999999999999; // 设置附件上传大小
        $upload->rootPath = "./Update/"; // 设置附件上传根目录
        $upload->autoSub = false;
        $upload->saveName = '_' . time(); // 上传文件
        $info = $upload->upload();
        return $info ['file'] ['savename'];
    }

    /**
     * 电影上传
     */
    public function upload_video(){
        $name='_' . time();
        $file_name=explode(".",$_FILES['file']['name']);
        $img_name=explode(".",$_FILES['img']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], "./Update/".$name.".".$file_name[1]);
        move_uploaded_file($_FILES['img']['tmp_name'], "./Update/".$name.".".$img_name[1]);
        return $name.".".$file_name[1];
    }

    /**
     * 父类构造函数
     */
    /*public function __construct(){
        parent::__construct();
        if(!$_SESSION['admin']){
            $this->error('请先登录',U('Admin/login'));
        }
    }*/


    /**
     * 实时返回上传进度
     */
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