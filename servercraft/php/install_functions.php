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

?>