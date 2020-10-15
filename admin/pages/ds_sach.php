<?php
    $so_trang_sach = 10;

    $conn = new PDO('mysql:host=localhost; dbname=ban_sach_online_db', 'root', '');

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->query("set names utf8");

    $sql = 'SELECT * FROM bs_sach';

    $state = $conn->prepare($sql);
    $state->execute();

    $danh_sach = $state->fetchAll(PDO::FETCH_OBJ);

    //cho  '<pre>',print_r($danh_sach),'</pre>';
    $trang_hien_tai = (isset($_GET['trang']))?$_GET['trang']:0;

    $sql = "SELECT * FROM bs_sach LIMIT " . $trang_hien_tai * $so_trang_sach . ",$so_trang_sach";

    //echo $sql;

    $state = $conn->prepare($sql);
    $state->execute();

    $danh_sach_hien_tai= $state->fetchAll(PDO::FETCH_OBJ);

    $so_sach = count($danh_sach);
    $so_trang_hien_thi = ceil($so_sach/$so_trang_sach);

    
    // echo $so_sach;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" media="screen" href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <link type="text/css" rel="stylesheet" href="./css/pagination.css"/>
    <script type="text/javascript" src="./js/pagination.js"></script>
    
</head>
<body>
    
    <div class="container">
        
        <!-- <table class="table table-hover" id='myTable'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Sách</th>
                    <th>Đơn Gía</th>
                    <th>Gía Bìa</th>
                    <th>Chọn</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($danh_sach_hien_tai as $key){
            ?>
                <tr>
                    <td><?php echo $key->id ?></td>
                    <td><?php echo $key->ten_sach?></td>
                    <td><?php echo $key->don_gia?></td>
                    <td><?php echo $key->gia_bia?></td>
                    <td> 
                        <input type="checkbox" name='chon[]' value="><?php echo $key->id?>">
                    </td>
                </tr>
                <?php
                }
            ?>
            </tbody>
        </table>
    
        <div>
        <?php
            for($i = 0; $i < $so_trang_hien_thi; $i++){
        ?>
            <ul class="pagination">
                <li><a href="<?php echo $_SERVER['REQUEST_URI']; ?>&trang=<?php echo $i; ?>"><?php echo $i + 1; ?></a></li>
            </ul>
        <?php
        }
        ?>       
        </div> -->
        


        <table id="table_sach" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sách</th>
                    <th>Đơn giá</th>
                    <th>Giá bìa</th>
                    <th>Chọn</th>
                </tr>
            </thead>
            <tbody id="data_show">
            </tbody>
        </table>

        <div id="pagination" class="pagination"></div>
        
        <script>
        // $(document).ready( function () {
        //     $('#table_sach').DataTable();
        // } );

        function function_build_html(data_list){
            var string_html = '';

            for(var i = 0; i < data_list.length; i++){
                string_html += `
                <tr>
                    <td>${data_list[i].id}</td>
                    <td>${data_list[i].ten_sach}</td>
                    <td>${data_list[i].don_gia}</td>
                    <td>${data_list[i].gia_bia}</td>
                    <td>
                        <input type="checkbox" name="chon_sach[]" value="${data_list[i].id}">
                    </td>
                </tr>
                `
            }

            console.log(string_html);

            $('#data_show').html(string_html);
        }

        $(function() {
            $('#pagination').pagination({
                items: <?php echo $so_sach ?>,
                itemsOnPage: 10,
                cssStyle: 'light-theme',
                onPageClick: function(pageNumber) {
                    console.log(pageNumber - 1);
                    // // We need to show and hide `tr`s appropriately.
                    // var showFrom = perPage * (pageNumber - 1);
                    // var showTo = showFrom + perPage;

                    // // We'll first hide everything...
                    // items.hide()
                    //     // ... and then only show the appropriate rows.
                    //     .slice(showFrom, showTo).show();

                    $.get('http://localhost:8181/test_php/do_an_nho_nho/admin/api.php?trang=' + (pageNumber - 1))
                        .done((data) => {
                            console.log(JSON.parse(data));

                            function_build_html(JSON.parse(data));
                        })
                        .fail((err) => {
                            console.log(err);
                        })

                }
            });
        });
        </script>



    </div>
    <script>
        // $(document).ready( function () {
        //     $('#myTable').DataTable();
        // } );

        // $(function() {
        //     $(selector).pagination({
        //         items: <?php echo $so_sach ?>,
        //         itemsOnPage: 10,
        //         cssStyle: 'light-theme'
        //     });
        // });
    </script>
</body>
</html>