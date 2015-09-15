<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/9/15
 * Time: 上午10:46
 */

namespace Org\MyClass;


class LowAdminFactory extends Creator
{

    /**
     * 工厂虚方法
     * @return mixed
     */
    protected function factoryMethod($a)
    {
        return LowAdmin::getLowAdmin($a);
    }
}