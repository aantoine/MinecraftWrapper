<?php
require_once("php/install_functions.php");
if(isset( $_POST['step'] ) || !dbConfigExists() || !canConnect() || !isPopulated()){
	#echo("hola");
	require_once("views/installation/install.php");
	die();
}

// include the configs / constants for the database connection
require_once("config/db.php");

//HEADER
require_once("views/header.html");

$jar=False;
$create=False;

if (isset($_GET["jar"]))        $jar=True;
elseif (isset($_GET["create"])) $create=True;


//NAV
require_once("views/index/nav.php");


//CONTENT
if (isset($_GET["jar"]))        require_once("views/index/jar.php");
elseif (isset($_GET["create"])) require_once("views/index/create.php");
else{
	require_once("views/index/server.php");
}


//FOOTER
require_once("views/footer.html");


?>