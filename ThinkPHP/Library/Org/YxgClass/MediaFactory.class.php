<?php
namespace Org\YxgClass; 
/**
 * 媒体工厂类
 * @author xiuge
 *
 */
class MediaFactory{
	/**
	 * 
	 * @param $type 媒体类型
	 * @return 媒体类型的一个实例
	 */
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