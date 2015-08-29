<?php
session_start();
function __autoload($class_name) {
    include '../class/' . $class_name . '.php';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Hòa Xinh</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.5.7/css/jquery.fileupload.min.css" rel="stylesheet">
    <link href="/css/styles.css" rel="stylesheet">
    
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.5.7/jquery.iframe-transport.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.5.7/jquery.fileupload.min.js"></script>
    
</head>
<body>
<?php if (isset($_GET['reset'])) unset($_SESSION['hoaxinh']) ?>
<?php  if ((isset($_POST['hoaxinh']) && $_POST['hoaxinh'] == HoaXinh::getConfig('admin'))
        || (isset($_SESSION['hoaxinh']))) : ?>
    <?php $_SESSION['hoaxinh'] = 1; ?>
    <!-- Check password ok, show form cho Hoa Xinh  -->
    <h1 class="text-center text-success">Up nhiều nhiều nha Hòa!</h1>
    <div class="fluid-cotainer text-center">
        <form class="form form-horizontal" role="form" action="/admin/upload.php" method="POST">
            <input type="hidden" name="hoaxinh" value="<?php echo $_POST['hoaxinh'] ?>" />
            <input class="form-control" data-url="/admin/upload.php" id="fileupload" type="file" name="files[]" multiple="">
            
            <!-- Show progress -->
            <div id="progress" class="progress">
                <div class="progress-bar bar progress-bar-success"></div>
            </div>
            
            <!-- Show list files -->
            <div id="files" class="files"></div>
        </form>
    </div>
    <script>
        $(function () {
            $('#fileupload').fileupload({
                dataType: 'json',
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .bar').css(
                        'width',
                        progress + '%'
                    );
                },
                done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        if (!file.error) {
                            var img  = $('<img>').attr('src', file.thumbnailUrl).attr('alt', file.name);
                            $('#files').append(img);
                        }
                    });
                }
            });
        });
    </script>
<?php endif; ?>

    
<?php if (!isset($_SESSION['hoaxinh'])) : ?>
    <?php if (isset($_POST['hoaxinh']) && $_POST['hoaxinh'] != HoaXinh::getConfig('admin')) : ?>
    <h1 class="text-center text-danger">WRONG PASS!</h1>
    <?php endif; ?>
    <h1 class="text-center text-success">Hòa Xinh nhập mật mã để upload nha :-*</h1>
    <div class="col-xs-12">
        <form class="form form-horizontal" role="form" action method="POST">
            <div style="margin-bottom: 10px">
                <input class="form-control" placeholder="Nhập vô đây nè :-*" type="password" name="hoaxinh" />
            </div>
            <input class="form-control btn btn-primary" type="submit" value="Submit" />
        </form>
    </div>
<?php endif; ?>
</body>
</html>