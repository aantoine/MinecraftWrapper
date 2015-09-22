<?php
	require_once("../config/db.php");
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (!$db_connection->connect_errno){
	    $name = $db_connection->real_escape_string(strip_tags($_GET["server"], ENT_QUOTES));
	    $sql = "SELECT * FROM servers WHERE server_name='".$name."';";
	    $query_check_server_name = $db_connection->query($sql);

	    if ($query_check_server_name->num_rows >= 1) {
	        echo "error";
	    } else {
	        echo "success";
	    }
	    die();
	}
	echo "error";
?>