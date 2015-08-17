<?php
if(isset($_GET['server']) && isset($_GET['command'])){
	$mc = "/home/agustinantoine/minecraft-servers";
	$old_path = getcwd();
	$scripts = $mc."/scripts";
	chdir($scripts);	
	$value = htmlspecialchars($_GET['server']);
	$command = htmlspecialchars($_GET['command']);
	$output = shell_exec('./'.$value.'.sh command '.$command);
	chdir($old_path);
	echo("success");
}
else{
	echo("error");
}
?>