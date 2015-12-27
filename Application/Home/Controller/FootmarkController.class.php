<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/12/26
 * Time: 下午9:56
 */
namespace Home\Controller;

use Think\Controller;

class FootmarkController extends BaseController{
    public function upload(){
        $file=$this->upload_file();
    }
}