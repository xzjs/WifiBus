<?php
namespace Org\YxgClass;
use Org\Util\Date; 
/**
 * 
 */
class TextAd extends Media{
	public function addMedia($Media) {
		$cur_date=new Date();
		$Media->url=TEXT_PATH.$cur_date->format("%Y%m%d%H%M%S").rand(0,99999).".$Media->suffix";
		return $Media->add();
	}
} 