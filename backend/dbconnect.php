<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$HOST = "1x3hqy.h.filess.io";
$USER = "Recipe_keeper_dawngrayas";
$PASS = "726e0f6b712fc1b7bcb63741ba3b5f258dba2b9a";
$DB = "Recipe_keeper_dawngrayas";
$PORT =  61001; // Optional

$conn = null;

try {
	$conn = new mysqli($HOST, $USER, $PASS, $DB, $PORT);
//	echo "connected";


} catch (mysqli_sql_exception $se){
	echo "Connection Error: ".$se->getMessage(). " @Line: ".$se->getLine();
}

?>
