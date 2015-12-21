<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 15/12/20
 * Time: 下午9:31
 */
namespace Home\Model;

use Think\Model\RelationModel;

class CommandModel extends RelationModel{
    /**
     * @var array 自动完成规则
     */
    protected $_auto = array (
        array('time','time',3,'function'), // 对update_time字段在更新的时候写入当前时间戳
        array('status','0'),
    );
}