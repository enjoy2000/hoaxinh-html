<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Hòa Xinh</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.12/jquery.mousewheel.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.js"></script>
    <script type="text/javascript" src="js/handlebars.js"></script>
    <script type="text/javascript" src="js/waterfall.js"></script>
</head>
<?php  
ini_set('display_errors', 1);
function __autoload($class_name) {
    include 'class/' . $class_name . '.php';
}

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
        $hoaxinh = new HoaXinh();
        $image_files = $hoaxinh->getImages();
        ?>
    </div>
<script type="text/x-handlebars-template" id="waterfall-tpl">
    {{#result}}
    <div class="item">
        <a rel="hoaxinh" title="{{title}}" class="fancybox" href="{{big}}">
            <img src="{{image}}" width="{{width}}" height="{{height}}" />
        </a>
    </div>
    {{/result}}
</script>
<script>
    $('#hoaxinh').waterfall({
        itemCls: 'item',
        colWidth: <?php echo HoaXinh::THUMBS_WIDTH ?>,
        gutterWidth: 15,
        gutterHeight: 15,
        checkImagesLoaded: false,
        isAnimated: true,
        resizable: true,
        maxPage: <?php echo count($image_files)/10 ?>,
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
