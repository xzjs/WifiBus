<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/12/26
 * Time: 下午6:00
 */
namespace Home\Controller;

use Think\Controller;

class TestController extends BaseController
{
    public function index(){
        var_dump(I('.post'));
    }
}