<?php

// include the configs / constants for the database connection
require_once("config/db.php");

//HEADER
require_once("views/header.html");

if (!isset($_GET["server"])){
	echo("ERROR");
}

$server=$_GET["server"];
$properties=False;
$player=False;
$console=False;

if (isset($_GET["properties"]))     $properties=True;
elseif (isset($_GET["player"])) 	$player=True;
elseif (isset($_GET["console"])) 	$console=True;


//NAV
require_once("views/server/nav.php");


//CONTENT
if (isset($_GET["properties"]))	 require_once("views/server/properties.php");
elseif (isset($_GET["player"]))  require_once("views/server/players.php");
elseif (isset($_GET["console"])) require_once("views/server/console.php");
else{
	require_once("views/server/server.php");
}


//FOOTER
require_once("views/footer.html");


?>