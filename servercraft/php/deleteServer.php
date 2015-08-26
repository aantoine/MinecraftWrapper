<?php
if(isset($_POST['deleteServer'])){
	require_once("../config/db.php");
	require_once("../classes/Server.php");
	$server_handle = new Server();

	foreach ($server_handle->messages as $key => $value) {
		echo($value);
	}
	foreach ($server_handle->errors as $key => $value) {
		echo($value);
	}
}
?>