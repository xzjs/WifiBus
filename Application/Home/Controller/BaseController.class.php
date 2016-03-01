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
    public static $VIDEO_HEIGHT=224;
    public static $VIDEO_WIDE=400;
    public static $BOOK_HEIGHT=213;
    public static $BOOK_WIDE=305;
    public static $APP_HEIGHT=256;
    public static $APP_WIDE=256;
    public static $AD_HEIGHT=142;
    public static $AD_WIDE=434;


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
     * 实现电子书，apk和简介图片上传
     */
    public function upload_file($type)
    {
        $upload = new \Think\Upload(); // 实例化上传类
        $upload->maxSize = 9999999999999; // 设置附件上传大小
        $upload->rootPath = "./Update/"; // 设置附件上传根目录
        $upload->autoSub = false;
        $upload->saveName = '_' . time(); // 上传文件
        $info = $upload->upload();
        $name_str=explode(".",$info ['file'] ['savename']);
        if($type=="book")
            $this->imagecropper("./Update/".$name_str[0].".jpg",self::$BOOK_WIDE,self::$BOOK_HEIGHT);
        elseif($type=="app")
            $this->imagecropper("./Update/".$name_str[0].".jpg",self::$APP_WIDE,self::$APP_HEIGHT);
        elseif($type=="ad")
            $this->imagecropper("./Update/".$name_str[0].".jpg",self::$AD_WIDE,self::$AD_HEIGHT);
        return $info ['file'] ['savename'];
    }

    /**
     * 实现电影和简介图片上传
     */
    public function upload_video(){
        $name='_' . time();
        $file_name=explode(".",$_FILES['file']['name']);
        $img_name=explode(".",$_FILES['img']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], "./Update/".$name.".".$file_name[1]);
        move_uploaded_file($_FILES['img']['tmp_name'], "./Update/".$name.".".$img_name[1]);
        $this->imagecropper("./Update/".$name.".".$img_name[1],self::$VIDEO_WIDE,self::$VIDEO_HEIGHT);
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

    /**
     * @param $source_path
     * @param $target_width
     * @param $target_height
     * @return bool 裁剪缩放图片
     */
    function imagecropper($source_path, $target_width, $target_height)
    {
        $source_info   = getimagesize($source_path);
        $source_width  = $source_info[0];
        $source_height = $source_info[1];
        $source_mime   = $source_info['mime'];
        $source_ratio  = $source_height / $source_width;
        $target_ratio  = $target_height / $target_width;

        // 源图过高
        if ($source_ratio > $target_ratio)
        {
            $cropped_width  = $source_width;
            $cropped_height = $source_width * $target_ratio;
            $source_x = 0;
            $source_y = ($source_height - $cropped_height) / 2;
        }
        // 源图过宽
        elseif ($source_ratio < $target_ratio)
        {
            $cropped_width  = $source_height / $target_ratio;
            $cropped_height = $source_height;
            $source_x = ($source_width - $cropped_width) / 2;
            $source_y = 0;
        }
        // 源图适中
        else
        {
            $cropped_width  = $source_width;
            $cropped_height = $source_height;
            $source_x = 0;
            $source_y = 0;
        }

        switch ($source_mime)
        {
            case 'image/gif':
                $source_image = imagecreatefromgif($source_path);
                break;

            case 'image/jpeg':
                $source_image = imagecreatefromjpeg($source_path);
                break;

            case 'image/png':
                $source_image = imagecreatefrompng($source_path);
                break;

            default:
                return false;
                break;
        }

        $target_image  = imagecreatetruecolor($target_width, $target_height);
        $cropped_image = imagecreatetruecolor($cropped_width, $cropped_height);

        // 裁剪
        imagecopy($cropped_image, $source_image, 0, 0, $source_x, $source_y, $cropped_width, $cropped_height);
        // 缩放
        imagecopyresampled($target_image, $cropped_image, 0, 0, 0, 0, $target_width, $target_height, $cropped_width, $cropped_height);

        header('Content-Type: image/jpeg');
        imagejpeg($target_image,$source_path);
        imagedestroy($source_image);
        imagedestroy($target_image);
        imagedestroy($cropped_image);
    }

}