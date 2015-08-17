<?php
if(isset($_GET['server'])){
	$mc = "/home/agustinantoine/minecraft-servers";
	$dir = $mc."/servers/".htmlspecialchars($_GET['server']);

	$old_path = getcwd();
	$scripts = $mc."/scripts";
	chdir($scripts);

	$file = $dir."/logs/latest.log";
	$myfile = fopen($file, "r") or die("Unable to open file!");

	while(!feof($myfile)){
		echo(fgets($myfile));
	}

	fclose($myfile);
	chdir($old_path);
}

?>