<?php
include_once "dbconnect.php";
$sql = "select * from user";
$ps = $conn->prepare($sql);
$rs = $ps->execute();
$arr = $ps->get_result();
//echo $arr->num_rows;//2 <--- gave result
$a = $arr->fetch_all(MYSQLI_ASSOC);
echo json_encode($a);
?>
