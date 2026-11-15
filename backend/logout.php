<?php
session_start();
session_destroy();
setcookie("user_name","",time()-10);
echo json_encode([
	"success"=>true,
	"message"=>"logout successfull"
]);
?>
