<?php
namespace Org\YxgClass;
use Org\Util\Date; 
/**
 * 视频广告管理类
 * @author xiuge
 *
 */
class AppAd extends Media{
	public static $format = array (
			'apk'
	);
	/**
	 * (non-PHPdoc)
	 * @see \Org\YxgClass\Media::addMedia()
	 * @param $Media 媒体 模型类
	 * @return 数据库操作结果
	 */
	public function addMedia($Media) {
		$cur_date=new Date();
		$Media->url=VIDEO_PATH.$cur_date->format("%Y%m%d%H%M%S").rand(0,99999).".$Media->suffix";//用日期和随机数命名
		return $Media->add();
	}
} 