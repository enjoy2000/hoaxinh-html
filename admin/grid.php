<?php
/**
 * Created by Hat Dao.
 * User: hatdao
 * Date: 8/29/15
 * Time: 11:54 PM
 */
session_start();
function __autoload($class_name) {
    include '../class/' . $class_name . '.php';
}

if (!isset($_SESSION['hoaxinh'])) :  // redirect if not login
    header("Location: /admin"); exit();
else :
    /**
     * If request is post, we render data for ajax grid
     */
    if (isset($_GET['draw'])) {
        $pdo = new SafePDO();

        $limit = (int)$_GET['length'];
        $offset = (int)$_GET['start'];
        $limitOffset = " LIMIT {$limit} OFFSET {$offset}";

        $order = " ORDER BY id desc";

        // Prepare query base on request from data table
        $where = "";
        if ($value = $_GET['search']['value']) {
            $where .= " WHERE file_name like :value";
        }

        $sql = "SELECT * FROM images";

        $sth = $pdo->prepare($sql . $where . $order . $limitOffset);
        if ($where) {
            $sth->execute(['value' => '%' . $value . '%']);
        } else {
            $sth->execute();
        }
        $images = $sth->fetchAll(PDO::FETCH_ASSOC);
        $total = $sth->fetch(PDO::FETCH_COLUMN);
        //var_dump($images);die;

        $sql2 = "SELECT count(*) as total FROM images";
        $sth = $pdo->prepare($sql2);
        $sth->execute();
        $total = $sth->fetch();

        $sql3 = "SELECT count(*) as total FROM images";

        if ($where) {
            $sth = $pdo->prepare($sql3 . $where);
            $sth->execute(['value' => '%' . $value . '%']);
            $filter = $sth->fetch();

        }
        $sth = $pdo->prepare($sql3);
        $sth->execute();
        $total = $sth->fetch();
        if (!isset($filter)) {
            $filter = $total;
        }


        $json = [
            "draw" => $_GET['draw'],
            "recordsTotal" => $total['total'],
            "recordsFiltered" => $filter['total'],
            'data' => [],
        ];
        if (count($images)) {
            foreach ($images as $img) {
                $json['data'][] = [
                    $img['id'],
                    '<img src="/thumbs/' . $img['file_name'] . '" alt="" />',
                    $img['file_name'],
                    '<a title="Delete" class="btn btn-danger btn-delete" data-id="' . $img['id'] . '" href="javascript: void(0);"><i class="fa fa-remove"></i></a>',
                ];
            }
        }

        echo json_encode($json);die;

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
    <link href="//cdn.datatables.net/1.10.8/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="/css/styles.css" rel="stylesheet">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <div class="fluid-container">
        <div id="message" class="alert alert-info" role="alert">
            
        </div>
        
        <div class="row text-center">
            <a href="/admin" class="btn btn-primary">Upload Hình</a>
        </div>
        <div class="col-md-12">
            <h1 class="text-center text-success">Xem và xóa hình nha :D</h1>

            <div class="table">
                <table id="table">
                    <thead>
                    <tr>
                        <th>Id</td>
                        <th>Xem thử</td>
                        <th>Tên hình</td>
                        <th>Actions</td>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript" language="javascript" >
        $(document).ready(function() {
            var dataTable = $('#table').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": "/admin/grid.php"
            } );
            $('#table').on('click', 'a.btn-delete', function(e){
                e.preventDefault();
                
                var id = $(this).data('id');
                var tr = $(this).parents('tr');
                $.ajax({
                    url: '/ajax.php',
                    data: 'method=delete&id=' + $(this).data('id'),
                    method: 'POST',
                    success: function(data){
                        if (!data.error) {
                            tr.remove();
                            $('#message').html(data.message);
                        }
                    }
                }) 
            });
            
        } );
    </script>
</body>
</html>
<?php endif; ?>