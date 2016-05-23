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
    public static $VIDEO_HEIGHT = 224;
    public static $VIDEO_WIDE = 400;
    public static $BOOK_HEIGHT = 213;
    public static $BOOK_WIDE = 305;
    public static $APP_HEIGHT = 256;
    public static $APP_WIDE = 256;
    public static $AD_HEIGHT = 142;
    public static $AD_WIDE = 434;


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
        $name_str = explode(".", $info ['file'] ['savename']);
        if ($type == "book")
            $this->imagecropper("./Update/" . $name_str[0] . ".jpg", self::$BOOK_WIDE, self::$BOOK_HEIGHT);
        elseif ($type == "app")
            $this->imagecropper("./Update/" . $name_str[0] . ".jpg", self::$APP_WIDE, self::$APP_HEIGHT);
        elseif ($type == "ad")
            $this->imagecropper("./Update/" . $name_str[0] . ".jpg", self::$AD_WIDE, self::$AD_HEIGHT);
        return $info ['file'] ['savename'];
    }

    /**
     * 实现电影和简介图片上传
     */
    public function upload_video()
    {
        $name = '_' . time();
        $file_name = explode(".", $_FILES['file']['name']);
        $img_name = explode(".", $_FILES['img']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], "./Update/" . $name . "." . $file_name[1]);
        move_uploaded_file($_FILES['img']['tmp_name'], "./Update/" . $name . "." . $img_name[1]);
        $this->imagecropper("./Update/" . $name . "." . $img_name[1], self::$VIDEO_WIDE, self::$VIDEO_HEIGHT);
        return $name . "." . $file_name[1];
    }

    /**
     * 实时返回上传进度
     */
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
     * @param $source_path
     * @param $target_width
     * @param $target_height
     * @return bool 裁剪缩放图片
     */
    function imagecropper($source_path, $target_width, $target_height)
    {
        $source_info = getimagesize($source_path);
        $source_width = $source_info[0];
        $source_height = $source_info[1];
        $source_mime = $source_info['mime'];
        $source_ratio = $source_height / $source_width;
        $target_ratio = $target_height / $target_width;

        // 源图过高
        if ($source_ratio > $target_ratio) {
            $cropped_width = $source_width;
            $cropped_height = $source_width * $target_ratio;
            $source_x = 0;
            $source_y = ($source_height - $cropped_height) / 2;
        } // 源图过宽
        elseif ($source_ratio < $target_ratio) {
            $cropped_width = $source_height / $target_ratio;
            $cropped_height = $source_height;
            $source_x = ($source_width - $cropped_width) / 2;
            $source_y = 0;
        } // 源图适中
        else {
            $cropped_width = $source_width;
            $cropped_height = $source_height;
            $source_x = 0;
            $source_y = 0;
        }

        switch ($source_mime) {
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

        $target_image = imagecreatetruecolor($target_width, $target_height);
        $cropped_image = imagecreatetruecolor($cropped_width, $cropped_height);

        // 裁剪
        imagecopy($cropped_image, $source_image, 0, 0, $source_x, $source_y, $cropped_width, $cropped_height);
        // 缩放
        imagecopyresampled($target_image, $cropped_image, 0, 0, 0, 0, $target_width, $target_height, $cropped_width, $cropped_height);

        header('Content-Type: image/jpeg');
        imagejpeg($target_image, $source_path);
        imagedestroy($source_image);
        imagedestroy($target_image);
        imagedestroy($cropped_image);
    }

    function send_mail($phone, $content)
    {
        /*
         * 乱码问题解决方案，1、GBK编码提交的首先urlencode短信内容（content），然后在API请求时，带入encode=gbk
        
            2、UTF-8编码的将content 做urlencode编码后，带入encode=utf8或utf-8
            实例：http://m.5c.com.cn/api/send/index.php?username=XXX&password_md5=XXX&apikey=XXX&mobile=XXX&content=%E4%BD%A0%E5%A5%BD%E6%89%8D%E6%94%B6%E7%9B%8A%E9%9F%A6&encode=utf8
         * 
         * 关于内容转码问题。      UTF-8 转 GBK：$content = iconv("UTF-8","GBK//IGNORE",$content);GBK 转 UTF-8：$content = iconv("GBK","UTF-8",$content);
         * 
         * username  用户名
         * password_md5   密码
         * mobile  手机号
         * apikey  apikey秘钥
         * content  短信内容
         * startTime  UNIX时间戳，不写为立刻发送，http://tool.chinaz.com/Tools/unixtime.aspx （UNIX时间戳网站）
         *
         * success:msgid  提交成功。
         error:msgid  提交失败
         error:Missing username  用户名为空
         error:Missing password  密码为空
         error:Missing apikey  APIKEY为空
         error:Missing recipient  手机号码为空
         error:Missing message content  短信内容为空
         error:Account is blocked  帐号被禁用
         error:Unrecognized encoding  编码未能识别
         error:APIKEY or password error  APIKEY或密码错误
         error:Unauthorized IP address  未授权 IP 地址
         error:Account balance is insufficient  余额不足
         * */

        $encode = 'UTF-8';  //页面编码和短信内容编码为GBK。重要说明：如提交短信后收到乱码，请将GBK改为UTF-8测试。如本程序页面为编码格式为：ASCII/GB2312/GBK则该处为GBK。如本页面编码为UTF-8或需要支持繁体，阿拉伯文等Unicode，请将此处写为：UTF-8

        $obj = $this->get_json()['sms'];
        $username = $obj['name'];  //用户名

        $password_md5 = md5($obj['pwd']);  //32位MD5密码加密，不区分大小写

        $apikey = $obj['key'];  //apikey秘钥（请登录 http://m.5c.com.cn 短信平台-->账号管理-->我的信息 中复制apikey）

        $mobile = $phone;  //手机号,只发一个号码：13800000001。发多个号码：13800000001,13800000002,...N 。使用半角逗号分隔。

        $content = $content;  //要发送的短信内容，特别注意：签名必须设置，网页验证码应用需要加添加【图形识别码】。

        //$content = iconv("GBK", "UTF-8", $content);

        $contentUrlEncode = urlencode($content);//执行URLencode编码  ，$content = urldecode($content);解码

        $result = $this->sendSMS($username, $password_md5, $apikey, $mobile, $contentUrlEncode, $encode);  //进行发送

        if (strpos($result, "success") > -1) {
            //提交成功
            //逻辑代码
            return true;
        } else {
            //提交失败
            //逻辑代码
            return $result;
        }

//发送接口
    }

    private function sendSMS($username, $password_md5, $apikey, $mobile, $contentUrlEncode, $encode)
    {
        //发送链接（用户名，密码，apikey，手机号，内容）
        $url = "http://m.5c.com.cn/api/send/index.php?";  //如连接超时，可能是您服务器不支持域名解析，请将下面连接中的：【m.5c.com.cn】修改为IP：【115.28.23.78】
        $data = array
        (
            'username' => $username,
            'password_md5' => $password_md5,
            'apikey' => $apikey,
            'mobile' => $mobile,
            'content' => $contentUrlEncode,
            'encode' => $encode,
        );
        $result = $this->curlSMS($url, $data);
        //print_r($data); //测试
        return $result;
    }

    private function curlSMS($url, $post_fields = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//用PHP取回的URL地址（值将被作为字符串）
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//使用curl_setopt获取页面内容或提交数据，有时候希望返回的内容作为变量存储，而不是直接输出，这时候希望返回的内容作为变量
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);//30秒超时限制
        curl_setopt($ch, CURLOPT_HEADER, 1);//将文件头输出直接可见。
        curl_setopt($ch, CURLOPT_POST, 1);//设置这个选项为一个零非值，这个post是普通的application/x-www-from-urlencoded类型，多数被HTTP表调用。
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);//post操作的所有数据的字符串。
        $data = curl_exec($ch);//抓取URL并把他传递给浏览器
        curl_close($ch);//释放资源
        $res = explode("\r\n\r\n", $data);//explode把他打散成为数组
        return $res[2]; //然后在这里返回数组。
    }

    /**
     * 读取json配置文件
     * @return mixed 返回的对象
     */
    public function get_json()
    {
        $file = 'config.js';
        $str = file_get_contents($file);
        $obj = json_decode($str,true);
        return $obj;
    }
}
