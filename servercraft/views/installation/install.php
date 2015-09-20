<?php

$step = isset( $_POST['step'] ) ? (int) $_POST['step'] : 0;

require_once("views/header.html");
require_once("views/installation/nav.php");
switch($step) {
	case 0: // Step 0, Welcome Screen
		#Check dbConfigExists and have valid data (ie not default data)
		#if exists, jumps to step 2
		#if dont, jumps to step 1

		if(dbConfigExists() && canConnect() && isPopulated()){
			echo addError("Instalation already Exist!", "403");
			#require_once("views/installation/error.php");
			die();
		}
		require_once("views/installation/phase0.php");
		break;

	case 1: // Step 1, Config Setup
		if(dbConfigExists() && canConnect() && isPopulated()){
			echo addError("Instalation already Exist!", "403");
			die();
		}
		#Creates config file if it doesnt exist (if exists exit??)
		if(!dbConfigExists()){
			copy("config/db-sample.php", "config/db.php");
		}
		#Ask for database settings (DB_HOST, DB_USER, DB_PASS, DB_NAME)
		#jumps to step 2

		require_once("views/installation/phase1.php");
		break;

	case 2: // Step 2, Initial Data
		#Try to connects to the database
		#if cant connect show error message (possible mysql not installed, or wrong configs..)
		#if connections works ask path, admin username and admin pass (if they doesnt exit (die))
		#jumps to step 3

		if(!dbConfigExists() or !isset($_POST["db-host"]) or !isset($_POST["db-name"])
		or !isset($_POST["db-user"]) or !isset($_POST["db-pass"]) ){ //previous step creates the file
			resetInstall();
			echo addError("Bad Request, Reseting Installation", "400");
			die();
		}

		setupConfigFile();

		if(!canConnect()){
			resetInstall();
			echo addError("Couldnt setup Config File, Reseting Installation", "500");
			die();
		}

		if(!createTables()){
			#TODO: Request Specific error page
			resetInstall();
			echo addError("Couldnt create Tables in given database, Reseting Installation", "500");
			die();
		}

		require_once("views/installation/phase2.php");
		break;

	case 3: // Step 3, Checking
		#Updates the tables, if everything is correct links to the index of the app

		if(!dbConfigExists() || !canConnect()){
			echo addError("Instalation already Exist!", "403");
			die();
		}

		$path = updatePath();
		if(!createProyectFolder($path)){
			#TODO: Request Specific error page
			resetInstall();
			echo addError("Apache user must have write permissions on selected path (ie: /var/www/)", "400");
			die();
		}
		require_once("views/installation/phase3.php");

		break;
}
require_once("views/footer.html");
?>



