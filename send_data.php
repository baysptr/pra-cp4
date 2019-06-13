<?php
date_default_timezone_set('Asia/Jakarta');
include "config.php";

$lembap = $_GET['lembab'];
$cel = $_GET['cel'];
$status = $_GET['st'];
$tgl = date("Y-m-d H:i:s");

$sql = mysqli_query($conn, "insert into suhu values ('', '$lembap', '$cel', '$status', '$tgl')");
if($sql){
    echo "BERHASIL";
}else{
    echo "GAGAL";
}