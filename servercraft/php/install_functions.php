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

function setupConfigFile(){
	$db_host = htmlspecialchars($_POST["db-host"]);
	$db_name = htmlspecialchars($_POST["db-name"]);
	$db_user = htmlspecialchars($_POST["db-user"]);
	$db_pass = htmlspecialchars($_POST["db-pass"]);

	$file = "config/db.php";
	$lines = file($file);
		
	foreach($lines as $num_línea => $line) {
		$line=changeLine($line, "\"DB_HOST\"", $db_host);
		$line=changeLine($line, "\"DB_NAME\"", $db_name);
		$line=changeLine($line, "\"DB_USER\"", $db_user);
		$lines[$num_línea]=changeLine($line, "\"DB_PASS\"", $db_pass);
		#echo($lines[$num_línea]);
	}

	$content = implode("", $lines);

	// Primero vamos a asegurarnos de que el archivo existe y es escribible.
	if (is_writable($file)) {
	    // En nuestro ejemplo estamos abriendo $nombre_archivo en modo de adición.
	    // El puntero al archivo está al final del archivo
	    // donde irá $contenido cuando usemos fwrite() sobre él.
	    if (!$gestor = fopen($file, 'w')) {
	         echo "The file $file cannot be open";
	         exit;
	    }

	    // Escribir $contenido a nuestro archivo abierto.
	    if (fwrite($gestor, $content) === FALSE) {
	        echo "The file $file is not writable";
	        exit;
	    }

	    //echo "Éxito, se escribió ($contenido) en el archivo ($file)";

	    fclose($gestor);

	} else {
		echo "The file $file is not writable";
	}

}

function changeLine($line, $pattern, $sustitute){
	$split = explode($pattern, $line);
	if(count($split)>1){
		$value = explode("\"", $split[1]);
		$value[1]="\"".$sustitute."\"";
		$split[1]=implode("", $value);			
		$line=implode($pattern, $split);
		$lines[$num_línea]=$line;
		#echo($line);
	}
	return $line;
}

function createTables(){
	$sqlSource = file_get_contents('config/database.sql');
	require_once("config/db.php");
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	return mysqli_multi_query ( $mysqli , $sqlSource );
}

function updatePath(){
	require_once("config/db.php");
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$path = $mysqli->real_escape_string(strip_tags($_POST["path"], ENT_QUOTES));
	$server_sql = "INSERT INTO config (opt_name, opt_value) VALUES('mc_path', '$path');";
    $query_server = $mysqli->query($server_sql);	
    return $path;
}

function createProyectFolder($path){
	$name = "/minecraft_wrapper";
	if(!mkdir($path.$name)) {
	    return 0;
	}
	mkdir($path.$name."/jars");
	mkdir($path.$name."/servers");
	mkdir($path.$name."/scripts");
	copy("res/main.sh", $path.$name."/scripts/main.sh");
	return 1;
}

function resetInstall(){
	if (canConnect()){
		require_once("config/db.php");
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$drop_sql = "drop table config; drop table servers; drop table users; drop table jars;";
    	mysqli_multi_query ( $mysqli , $drop_sql );
	}
	if (dbConfigExists()){
		unlink("config/db.php");
	}

}

function isPopulated(){
	require_once("config/db.php");
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$config_sql = "select opt_id from config where opt_name='mc_path'";
	$res = $mysqli->query($config_sql);
	if($res->num_rows == 0){
		return 0;
	}
	return 1;
}

function addError($message, $errnum){
	return "".
	"<div class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main'>
	  <h1 class='page-header'>
	    Error $errnum
	  </h1>
	  <h3>$message</h3>
	</div>";
}

?>