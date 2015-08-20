<?php
if(isset($_GET['server'])){
	require_once("../../config/db.php");
	require_once("../../classes/Server.php");
	$server_handle = new Server();
	if(isset($_GET['start'])){
		echo($server_handle->turnOn($_GET['server']));
	}
	elseif(isset($_GET['stop'])){
		echo($server_handle->turnOff($_GET['server']));
	}
	elseif(isset($_GET['command'])){
		#echo(3);
	}
}
?>