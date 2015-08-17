<?php
if(isset($_GET['server'])){
	$mc = "/home/agustinantoine/minecraft-servers";
	$old_path = getcwd();
	$scripts = $mc."/scripts";
	chdir($scripts);	
	$value = htmlspecialchars($_GET['server']);
	$output = shell_exec('./'.$value.'.sh status');
	chdir($old_path);
	$res = explode(" ", $output);
	$status = substr($res[1], 0, strlen($res[1])-1);
	echo($status);
}
?>