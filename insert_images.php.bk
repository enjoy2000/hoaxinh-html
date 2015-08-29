<?php
function __autoload($class_name) {
    include 'class/' . $class_name . '.php';
}
/** settings **/
$hoaxinh = new HoaXinh();
$image_files = $hoaxinh->getImages();
$pdo = new SafePDO();

foreach ($image_files as $fileName) {
    $sth = $pdo->prepare("insert into images (file_name) VALUES (:fileName)");
    $sth->execute(['fileName' => $fileName]);
    echo $fileName . '<br />';
}
$pdo = null;