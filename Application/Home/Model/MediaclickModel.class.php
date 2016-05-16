<?php
/**
 * Created by PhpStorm.
 * User: xzjs
 * Date: 16/5/6
 * Time: 下午4:04
 */
namespace Home\Model;
use Think\Model\RelationModel;
class MediaclickModel extends RelationModel{
    protected $_link = array(
        'Media'=> array(
            'mapping_type'=>self::BELONGS_TO,
            'class_name'=>'Media',
            'foreign_key'=>'media_id',
            'as_fields'=>'text',
        ),
        //'Media'=>self::BELONGS_TO,
    );
}