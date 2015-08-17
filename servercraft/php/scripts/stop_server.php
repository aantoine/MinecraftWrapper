<?php
if(isset($_GET['server'])){
	$mc = "/home/agustinantoine/minecraft-servers";
	$old_path = getcwd();
	$scripts = $mc."/scripts";
	chdir($scripts);	
	$value = htmlspecialchars($_GET['server']);
	$output = shell_exec('./'.$value.'.sh stop');
	chdir($old_path);
	echo($output);
}
?>