<?php

function dbConfigExists(){
	return file_exists("config/db.php");
}

function canConnect(){
	require_once("config/db.php");
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ($mysqli->connect_errno) {
    	#echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    	return 0;
    }
    return 1;
}

?>