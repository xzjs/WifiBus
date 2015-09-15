<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/9/15
 * Time: 上午10:35
 */

namespace Org\MyClass;


class LowAdmin extends Admin
{
    private $title;
    private $time;
    private $tel;
    private $content;
    private $email;
    private $url;
    private $status;

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

    public static function getLowAdmin($a){
        $admin=new LowAdmin($a);
        return $admin;
    }
}