<?php
require_once dirname(__FILE__) . '/functions.php';
/** settings **/
$images_dir = 'hoaxinh/';
$thumbs_dir = 'thumbs/';
$thumbs_height = 500;
$images_per_row = 3;  // test deploy

$image_files = get_files($images_dir);
ksort($image_files);

$page = (int)$_REQUEST['page'];
$start = ($page-1)*10;
$end = $page*10;

if(count($image_files)) {
    $data = ['result' => []];
    foreach($image_files as $index=>$file) {
        if ($index >= $start && $index <= $end) {
            $src = $thumbs_dir . $file;
            $source_image = imagecreatefromjpeg($src);
            $width = imagesx($source_image);
            $height = imagesy($source_image);
            $data['result'][] = [
                'image' => $thumbs_dir . $file,
                'width' => $width,
                'height' => $height,
                'big' => $images_dir . $file,
            ];
        }
    }
    $data['total'] = count($data['result']);
    header('Content-Type: application/json');
    echo json_encode($data);
}



