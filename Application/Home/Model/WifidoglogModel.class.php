<?php
namespace Home\Model;
use Think\Model\RelationModel;

class WifidoglogModel extends RelationModel{
    /**
     * 定义验证规则
     * 线路名称不可重复
     * 线路id不能为空
     */
    protected $_validate    =   array(
        array('mac','unique','mac已经存在',0,'unique',3),
    );

 }