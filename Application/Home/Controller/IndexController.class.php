<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $sa=new \Org\MyClass\SuperAdmin();
        $sa->login();
    }
    
    public function hello(){
    	echo 'hello,thinkphp!';
    }
}