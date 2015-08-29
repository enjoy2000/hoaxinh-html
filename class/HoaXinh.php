<?php
class HoaXinh
{
	const LIMIT = 10;
	const IMAGES_DIR = 'hoaxinh/';
	const THUMBS_DIR = 'thumbs/';
	const THUMBS_WIDTH = 300;
	
	public static function getImages() {
		/** settings **/
		$images_dir = self::IMAGES_DIR;
		$thumbs_dir = self::THUMBS_DIR;
		$thumbs_width = self::THUMBS_WIDTH;
		
        $image_files = self::get_files($images_dir);
        if(count($image_files)) {
            foreach($image_files as $index=>$file) {
                $thumbnail_image = $thumbs_dir.$file;
                if(!file_exists($thumbnail_image)) {
                    $extension = self::get_file_extension($thumbnail_image);
                    if($extension) {
                        self::make_thumb($images_dir.$file,$thumbnail_image,$thumbs_width);
                    }
                }
            }
        }
        ksort($image_files);
        
        return $image_files;
	}
	/* function:  generates thumbnail */
	public static function make_thumb($src,$dest,$desired_width) {
		/* read the source image */
		$source_image = imagecreatefromjpeg($src);
		$width = imagesx($source_image);
		$height = imagesy($source_image);
		/* find the "desired height" of this thumbnail, relative to the desired width  */
	    $desired_height = floor($height*($desired_width/$width));
		/* create a new, "virtual" image */
		$virtual_image = imagecreatetruecolor($desired_width,$desired_height);
		/* copy source image at a resized size */
		imagecopyresized($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height);
		/* create the physical thumbnail image to its destination */
		imagejpeg($virtual_image,$dest);
	}
	
	/* function:  returns files from dir */
	public static function get_files($images_dir,$exts = array('jpg')) {
		$files = array();
		if($handle = opendir($images_dir)) {
			while(false !== ($file = readdir($handle))) {
				$extension = strtolower(self::get_file_extension($file));
				if($extension && in_array($extension,$exts)) {
					$files[] = $file;
				}
			}
			closedir($handle);
		}
		asort($files);
		return $files;
	}
	
	/* function:  returns a file's extension */
	public static function get_file_extension($file_name) {
		return substr(strrchr($file_name,'.'),1);
	}
	
	public static function getTotalImages()
	{
		$pdo = new SafePDO();
		$sth = $pdo->prepare("SELECT count(*) as total FROM images");
		$sth->execute();
		$count = $sth->fetch();
		
		return $count['total'];
	}
	
	public static function getConfig($key = null)
	{
		$config = parse_ini_file('../config.ini');
		if ($key === null) {
			return $config;
		} else {
			return isset($config[$key]) ? $config[$key] : false;
		}
	}
}