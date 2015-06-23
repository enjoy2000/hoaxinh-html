<?php
require_once dirname(__FILE__) . '/functions.php';
/** settings **/
$hoaxinh = new HoaXinh();
$image_files = $hoaxinh->getImages();

$page = (int)$_REQUEST['page'];
$start = ($page - 1) * 10;
$end = $page * 10 - 1;

if(count($image_files)) {
    $data = ['result' => []];
    foreach($image_files as $index=>$file) {
        if ($index >= $start && $index <= $end) {
            $src = HoaXinh::THUMBS_DIR . $file;
            $source_image = imagecreatefromjpeg($src);
            $width = imagesx($source_image);
            $height = imagesy($source_image);
            $data['result'][] = [
                'image' => HoaXinh::THUMBS_DIR . $file,
                'width' => $width,
                'height' => $height,
                'big' => HoaXinh::IMAGES_DIR . $file,
                'title' => $file,
            ];
        }
    }
    $data['total'] = count($data['result']);
    header('Content-Type: application/json');
    echo json_encode($data);
}



