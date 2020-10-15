<?php

    $so_trang_sach = 10;
    $conn = new PDO('mysql:host=localhost; dbname=ban_sach_online_db', 'root', '');

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->query("set names utf8");
    $trang_hien_tai = (isset($_GET['trang']))?$_GET['trang']:0;

    $sql = "SELECT * FROM bs_sach LIMIT " . $trang_hien_tai * $so_trang_sach . ",$so_trang_sach";

    //echo $sql;

    $state = $conn->prepare($sql);
    $state->execute();

    $danh_sach_hien_tai= $state->fetchAll(PDO::FETCH_OBJ);

    

    echo json_encode($danh_sach_hien_tai);

?>