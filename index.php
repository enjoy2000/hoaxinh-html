<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Hòa Xinh</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/pubu.js"></script>
    <style type="text/css">
        header {
            background: #db4a39;
            border-bottom: 5px solid #BD3A2B;
            color: #fff;
            padding: 5px 20px;
        }
        header .logo {
            padding-top: 30px;
        }
        header .slogan {
            margin-right: 10px;
            padding-top: 40px;
            font-size: 20px
        }

        #pubu {
            margin: 0 auto;
            position: relative;
        }
        #pubu .box {
            width: 280px;
            height: auto;
            padding: 10px;
            float: left;
        }
        #pubu .box .pic {
            width: 280px;
            height: auto;
            box-shadow: 1px 1px 4px #ddd, -1px -1px 4px #ddd;
            border-radius: 4px;
        }
        #pubu .box .pic img {
            display: block;
            width: 250px;
            margin: 0 auto;
            padding: 15px 0;
            cursor: pointer;
        }
    </style>
</head>
<?php  
require_once dirname(__FILE__) . '/functions.php';
/** settings **/
$images_dir = 'hoaxinh/';
$thumbs_dir = 'thumbs/';
$thumbs_height = 500;
$images_per_row = 3;  // test deploy
?>
<body>
<header class="clearfix">
    <div class="logo col-sm-4">
        <h1>Hòa Xinh</h1>
    </div>
    <div class="pull-right col-sm-8 clearfix">
        <img class="fb-avt pull-right" src="http://graph.facebook.com/100007996269960/picture?type=normal" alt="Facebook Profile">
        <p class="pull-right slogan">Xinh nhất quả đất ^_^!!!</p>
    </div>
</header>
    <div id=pubu class="gallery-container fuild-container">
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
                break;
                echo '<div class="box"><a class="pic" href="'.$images_dir.$file.'" class="item thumb_link" rel="gallery">
                <img width="100" class="thumb" src="'.$thumbnail_image.'" /></a></div>';
            }
        }
        ?>
    </div>
</body>
</html>
