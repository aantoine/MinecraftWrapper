<?php
require_once("php/install_functions.php");


$step = isset( $_POST['step'] ) ? (int) $_POST['step'] : 0;

if(dbConfigExists() && canConnect()){
	#requiere error 503 view!
	die();
}

switch($step) {
	case 0: // Step 0, Welcome Screen
		#Check dbConfigExists and have valid data (ie not default data)
		#if exists, jumps to step 2
		#if dont, jumps to step 1

	case 1: // Step 1, Config Setup
		#Creates config file if it doesnt exist (if exists exit!)
		#Ask for database settings (DB_HOST, DB_USER, DB_PASS, DB_NAME)
		#jumps to step 2

	case 2: // Step 2, Initial Data
		#Try to connects to the database
		#if cant connect show error message (possible mysql not installed, or wrong configs..)
		#if connections works ask path, admin username and admin pass (if they doesnt exit (die))
		#jumps to step 3

	case 3: // Step 3, Checking
		#Updates the tables, if everything is correct links to the index of the app

?>



