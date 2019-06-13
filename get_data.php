<?php
include "config.php";

$sql = mysqli_query($conn, "select * from suhu order by id_suhu desc limit 1");
$data = mysqli_fetch_assoc($sql);

echo json_encode($data);