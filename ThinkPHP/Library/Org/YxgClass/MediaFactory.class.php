<?php
namespace Org\YxgClass; 
/**
 * 
 */
class MediaFactory{
	public static function createMedia($type) {
		if($type==1){
			$media=new ImageAd();
		}elseif ($type==2){
			$media=new TextAd();
		}elseif($type==3){
			$media=new VideoAd();
		}
		return $media;
	}
} 