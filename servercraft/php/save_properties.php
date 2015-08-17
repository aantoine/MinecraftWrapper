<?php
if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['online-mode'])){
	$mc = "/home/agustinantoine/minecraft-servers";
	$dir = $mc."/servers/".htmlspecialchars($_POST['id']);
	//print_r($_POST);
	//echo("<br>");

	$file = $dir."/server.properties";

	$lines = file($file);
	// Output one line until end-of-file
	foreach($lines as $num_línea => $line) {
		if(mb_substr($line, 0, 1, 'utf-8')!="#" && $line!=""){
			$split = explode("=", $line);
			if(array_key_exists($split[0], $_POST)){
				$lines[$num_línea]=$split[0]."=".$_POST[$split[0]]."\n";
			}
			//$array[$split[0]]=substr($split[1], 0, strlen($split[1])-1);
		}
	}

	//print_r($lines);

	$contenido = implode("", $lines);

	// Primero vamos a asegurarnos de que el archivo existe y es escribible.
	if (is_writable($file)) {

	    // En nuestro ejemplo estamos abriendo $nombre_archivo en modo de adición.
	    // El puntero al archivo está al final del archivo
	    // donde irá $contenido cuando usemos fwrite() sobre él.
	    if (!$gestor = fopen($file, 'w')) {
	         echo "No se puede abrir el archivo ($nombre_archivo)";
	         exit;
	    }

	    // Escribir $contenido a nuestro archivo abierto.
	    if (fwrite($gestor, $contenido) === FALSE) {
	        echo "No se puede escribir en el archivo ($file)";
	        exit;
	    }

	    echo "Éxito, se escribió ($contenido) en el archivo ($file)";

	    fclose($gestor);

	} else {
	    echo "El archivo $file no es escribible";
	}

}
?>
