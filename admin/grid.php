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

        $limit = $_GET['length'];
        $offset = $_GET['start'];

        // Prepare query base on request from data table
        $sql = "SELECT * FROM images LIMIT {$limit}, {$offset}";

        $sth = $pdo->prepare($sql);
        $sth->execute();
        $images = $sth->fetchAll(PDO::FETCH_ASSOC);


        $json = [];
        if (count($images)) {
            $json = [
                "draw" => 1,
                "recordsTotal" => count($images),
                "recordsFiltered" => count($images),
            ];
        }
        foreach ($images as $img) {
            $json['data'][] = [
                $img['id'],
                '<img src="/thumbs/' . $img['file_name'] . '" alt="" />',
                $img['file_name'],
                '<a href="/admin?' . $img['file_name'] . '">Del</a>',
            ];
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
    <link href="/css/styles.css" rel="stylesheet">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <div class="fluid-container">
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
        } );
    </script>
</body>
</html>
<?php endif; ?>