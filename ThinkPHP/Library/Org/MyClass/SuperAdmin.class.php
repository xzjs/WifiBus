<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/9/15
 * Time: 上午9:26
 */

namespace Org\MyClass;


/**
 * Class SuperAdmin
 * @package Org\MyClass
 */
class SuperAdmin extends Admin
{
    private function __construct($a){
        $this->title=$a->getField('title');
        $this->time=$a->getField('time');
        $this->tel=$a->getField('tel');
        $this->content=$a->getField('content');
        $this->email=$a->getField('email');
        $this->url=$a->getField('url');
        $this->status=$a->getField('status');
        $this->id=$a->getField('id');
        $this->name=$a->getField('name');
        $this->pwd=$a->getField('pwd');
    }

    public static function getSuperAdmin($a){
        $admin=new SuperAdmin($a);
        return $admin;
    }

    /**
     * 添加用户
     */
    public function add(){

    }
}