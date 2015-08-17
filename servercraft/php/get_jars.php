<?php
	$mc = "/home/agustinantoine/minecraft-servers";
	$dir = $mc."/jars";
	$ficheros  = scandir($dir);

	foreach($ficheros as $value){
		if($value!="." && $value!=".."){
			//print_r($value);
			 $array[$value]=$value;
		}
	}

	echo(json_encode($array));

?>
