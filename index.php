<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Hòa Xinh</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.css" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.12/jquery.mousewheel.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.js"></script>
    <script type="text/javascript" src="js/handlebars.js"></script>
    <script type="text/javascript" src="js/waterfall.js"></script>
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
$thumbs_width = 300;
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
    <div id=hoaxinh class="gallery-container fuild-container">
        <?php
        $image_files = get_files($images_dir);
        if(count($image_files)) {
            foreach($image_files as $index=>$file) {
                $thumbnail_image = $thumbs_dir.$file;
                //if(!file_exists($thumbnail_image)) {
                    $extension = get_file_extension($thumbnail_image);
                    if($extension) {
                        make_thumb($images_dir.$file,$thumbnail_image,$thumbs_width);
                    }
                //}
            }
        }
        ?>
    </div>
<script type="text/x-handlebars-template" id="waterfall-tpl">
    {{#result}}
    <div class="item">
        <a rel="hoaxinh" class="fancybox" href="{{big}}">
            <img src="{{image}}" width="{{width}}" height="{{height}}" />
        </a>
    </div>
    {{/result}}
</script>
<script>
    $('#hoaxinh').waterfall({
        itemCls: 'item',
        colWidth: <?php echo $thumbs_width ?>,
        gutterWidth: 15,
        gutterHeight: 15,
        checkImagesLoaded: false,
        isAnimated: true,
        resizable: true,
        maxPage: <?php echo count($image_files)/10 ?>,
        loadingMsg: '&lt;div style="text-align:center;padding:10px 0; color:#999;">&lt;img src="data:image/gif;base64,R0lGODlhEAALAPQAAP///zMzM+Li4tra2u7u7jk5OTMzM1hYWJubm4CAgMjIyE9PT29vb6KiooODg8vLy1JSUjc3N3Jycuvr6+Dg4Pb29mBgYOPj4/X19cXFxbOzs9XV1fHx8TMzMzMzMzMzMyH5BAkLAAAAIf4aQ3JlYXRlZCB3aXRoIGFqYXhsb2FkLmluZm8AIf8LTkVUU0NBUEUyLjADAQAAACwAAAAAEAALAAAFLSAgjmRpnqSgCuLKAq5AEIM4zDVw03ve27ifDgfkEYe04kDIDC5zrtYKRa2WQgAh+QQJCwAAACwAAAAAEAALAAAFJGBhGAVgnqhpHIeRvsDawqns0qeN5+y967tYLyicBYE7EYkYAgAh+QQJCwAAACwAAAAAEAALAAAFNiAgjothLOOIJAkiGgxjpGKiKMkbz7SN6zIawJcDwIK9W/HISxGBzdHTuBNOmcJVCyoUlk7CEAAh+QQJCwAAACwAAAAAEAALAAAFNSAgjqQIRRFUAo3jNGIkSdHqPI8Tz3V55zuaDacDyIQ+YrBH+hWPzJFzOQQaeavWi7oqnVIhACH5BAkLAAAALAAAAAAQAAsAAAUyICCOZGme1rJY5kRRk7hI0mJSVUXJtF3iOl7tltsBZsNfUegjAY3I5sgFY55KqdX1GgIAIfkECQsAAAAsAAAAABAACwAABTcgII5kaZ4kcV2EqLJipmnZhWGXaOOitm2aXQ4g7P2Ct2ER4AMul00kj5g0Al8tADY2y6C+4FIIACH5BAkLAAAALAAAAAAQAAsAAAUvICCOZGme5ERRk6iy7qpyHCVStA3gNa/7txxwlwv2isSacYUc+l4tADQGQ1mvpBAAIfkECQsAAAAsAAAAABAACwAABS8gII5kaZ7kRFGTqLLuqnIcJVK0DeA1r/u3HHCXC/aKxJpxhRz6Xi0ANAZDWa+kEAA7" alt="">&lt;br />Loading...&lt;/div>',
        animationOptions: {
        },
        path: function(page) {
            return '/ajax.php?page=' + page;
        }
    });

    $('a.fancybox').fancybox({
        'transitionIn'  :   'elastic',
        'transitionOut' :   'elastic'
    });
</script>
</body>
</html>
