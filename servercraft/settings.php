<?php

// include the configs / constants for the database connection
require_once("config/db.php");

//HEADER
require_once("views/header.html");


//NAV
require_once("views/settings/nav.php");


//CONTENT
if (isset($_GET["properties"]))	 require_once("views/server/properties.php");
#elseif (isset($_GET["player"]))  require_once("views/server/players.php");
#elseif (isset($_GET["console"])) require_once("views/server/console.php");
else{
	require_once("views/settings/settings.php");
}


//FOOTER
require_once("views/footer.html");


?>