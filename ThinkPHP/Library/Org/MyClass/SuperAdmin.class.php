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
        $this->id=$a->getField('id');
        $this->name=$a->getField('name');
        $this->pwd=$a->getField('pwd');
    }

    /**
     * 获取类的对象
     * @param $a 实例化参数
     * @return SuperAdmin 对象
     */
    public static function getSuperAdmin($a){
        $admin=new SuperAdmin($a);
        return $admin;
    }

    /**
     * 添加管理员
     * @param $a post过来的admin数据
     * @return int|mixed 成功返回插入的id,失败返回0
     */
    public function add($a){
        $Admin=M('Admin');
        $result=$Admin->data($a)->add();
        if($result){
            return $result;
        }else{
            return 0;
        }
    }

    /**
     * 查询用户,当不传入id时查询所有数据,否则查询传入的id
     * @param int $id 需要查询的id
     * @return mixed 全部数据或单条数据
     */
    public function select($id=0){
        $Admin=M('Admin');
        if($id==0){
            return $Admin->where('type="Low"')->select();
        }else{
            return $Admin->find($id);
        }
    }

    /**
     * 更新管理员
     * @param $a 要更新的管理员数据
     * @return bool 返回受影响的行数或者false
     */
    public function update($a){
        $Admin=M('Admin');
        return $Admin->save($a);
    }

    /**
     * 删除管理员
     * @param $id 管理员id
     * @return mixed 受影响的行数
     */
    public function delete($id){
        $Admin=M('Admin');
        return $Admin->delete($id);
    }
}