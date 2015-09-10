<?php
function __autoload($class_name) {
    include 'class/' . $class_name . '.php';
}
ini_set('display_errors',1);
session_start();
/**
 * Delete files
 */
if (isset($_POST['method']) && $_POST['method'] == 'delete') {
    $json = ['error' => true];
    $pdo = new SafePDO();
    $sth = $pdo->prepare("SELECT id, file_name FROM images WHERE id=:id");
    $sth->execute(['id' => $_POST['id']]);
    $image = $sth->fetch(PDO::FETCH_ASSOC);
    //var_dump($image);die;
    $sth = $pdo->prepare("DELETE FROM images WHERE id=:id");
    $deleted = $sth->execute(['id' => $_POST['id']]);
    if ($deleted) {
        //var_dump(__DIR__ . '/thumbs/' . $image['file_name']);die;
        unlink(__DIR__ . '/thumbs/' . $image['file_name']);
        unlink(__DIR__ . '/hoaxinh/' . $image['file_name']);
        $json['message'] = 'Em đã xóa thành công!';
        $json['error'] = false;
    } else {
        $json['error'] = true;
    }
    echo json_encode($json);
    die;
}
 
/*
 * List files and pagination 
 */
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
    if(!file_exists($src)) {
        HoaXinh::make_thumb(
            HoaXinh::IMAGES_DIR . $file,
            $src,
            HoaXinh::THUMBS_WIDTH
        );
    }
    $src = imagecreatefromjpeg($src);
    $width = imagesx($src);
    $height = imagesy($src);
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
