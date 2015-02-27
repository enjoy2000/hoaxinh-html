<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hòa Xinh</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="js/gridify-min.js"></script>
    <style type="text/css">
        .container {
            background: #eee;
            width: 90%;
            margin: auto;
        }
        header {
            background: #db4a39;
            border-bottom: 5px solid #BD3A2B;
        }
    </style>
</head>
<?php  
require_once dirname(__FILE__) . '/functions.php';
/** settings **/
$images_dir = 'hoaxinh/';
$thumbs_dir = 'thumbs/';
$thumbs_height = 100;
$images_per_row = 3;  // test deploy
?>
<body>
    <div class="gallery-container">
        <?php
        $image_files = get_files($images_dir);
        if(count($image_files)) {
            foreach($image_files as $index=>$file) {
                $thumbnail_image = $thumbs_dir.$file;
                if(!file_exists($thumbnail_image)) {
                    $extension = get_file_extension($thumbnail_image);
                    if($extension) {
                        make_thumb($images_dir.$file,$thumbnail_image,$thumbs_height);
                    }
                }
                echo '<div class="item"><a href="'.$images_dir.$file.'" class="item thumb_link" rel="gallery">
                <img width="250" class="thumb" src="'.$thumbnail_image.'" /></a></div>';
            }
        }
        ?>
    </div>
    <script>
        window.onload = function(){
            var options =
            {
                srcNode: 'img',             // grid items (class, node)
                margin: '20px',             // margin in pixel, default: 0px
                width: '250px',             // grid item width in pixel, default: 220px
                max_width: '',              // dynamic gird item width if specified, (pixel)
                resizable: true,            // re-layout if window resize
                transition: 'all 0.5s ease' // support transition for CSS3, default: all 0.5s ease
            }
            document.querySelector('.gallery-container').gridify(options);
        }
    </script>
</body>
</html>
