<?php
function __autoload($class_name) {
    include 'class/' . $class_name . '.php';
}
ini_set('display_errors', 0);
session_start();
/** settings **/
$hoaxinh = new HoaXinh();
$image_files = $hoaxinh->getImages();

if (!isset($_SESSION['random'])) {
    $_SESSION['random'] = rand(1, 1000);
}
$seed = $_SESSION['random'];

$page = (int)$_GET['page'];
$limit = HoaXinh::LIMIT;
$offset = ($page - 1) * $limit;
$end = $page * 10 - 1;

$pdo = new SafePDO();
$sth = $pdo->prepare("SELECT * FROM images ORDER BY RAND({$seed}) LIMIT {$limit} OFFSET {$offset}");
$sth->execute();
$images = $sth->fetchAll(PDO::FETCH_ASSOC);

// Prepare data to send response
$data = ['result' => []];
foreach ($images as $img) {
    $file = $img['file_name'];
    $src = HoaXinh::THUMBS_DIR . $file;
    if(!file_exists($thumbnail_image)) {
        HoaXinh::make_thumb(
            HoaXinh::IMAGES_DIR . $file,
            HoaXinh::THUMBS_DIR . $file,
            $thumbs_width
        );
    }
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

$data['total'] = count($images);
header('Content-Type: application/json');
echo json_encode($data);
