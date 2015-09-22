<?php
	function isJarFile($file){
		$ext = explode('.', $file);
		return (strcmp(end($ext), 'jar') == 0);
	}

	# 1. Verificar integridad archivo (tamaño, extension, nombre)
	# 2. crear entrada en la base de datos con el nombre del archivo y la descripcion
	# 3. mover el archivo al directorio de jars
 	# 4. imprimir mensaje (exito o error)

	if (!isset($_POST['myFile'])) {
		echo("Error: No file to upload");
	    die();
	}

	$url = $_POST['myFile'];

	require_once("../config/db.php");
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (!$db_connection->set_charset("utf8")){
        echo "Error: Database connection refused";
	    die();
    }

    $sql = "SELECT opt_value AS opt FROM config WHERE opt_name='mc_path';";
    $query_path = $db_connection->query($sql);
    $res = $query_path->fetch_assoc();
    $mc_path = $res['opt'];

    $fName = $db_connection->real_escape_string(strip_tags(basename($url), ENT_QUOTES));
    #echo($fName);
    $temp_file = $mc_path."/tmp/".$fName;
	
	$upload = file_put_contents($temp_file, file_get_contents($url));
	//check success
	if(!$upload){
		echo "Error: Unable to upload selected file";
		die();
	}

	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$fType = finfo_file($finfo, $temp_file) ;
	finfo_close($finfo);
	if(($fType!="application/jar" && $fType!="application/zip") || !isJarFile($temp_file)){
		echo("Error: Uploaded file is not a Minecraft file");
		unlink($temp_file);
		die();
	}

	$target_file = $mc_path."/jars/".$fName;
	if (file_exists($target_file)) {
	    echo "Error: Uploaded file already exists";
	    unlink($temp_file);
	    die();
	}

	$description = $_POST["fileDescription"];
	$description = $db_connection->real_escape_string(strip_tags($description, ENT_QUOTES));
	if(strlen($description)<=0 || strlen($description)>=64){
		echo "Error: Invalid jar file name";
	    unlink($temp_file);
	    die();
	}

	$upload_sql = "INSERT INTO jars (jar_name, file) VALUES('$description', '$fName');";
	
	if (rename($temp_file, $target_file)){
		$query_upload = $db_connection->query($upload_sql);
		echo("Selected Jar file has been uploaded.");
	}	
	else{
		echo("Error: Unable to upload selected file");
	}

	unlink($temp_file);
?>