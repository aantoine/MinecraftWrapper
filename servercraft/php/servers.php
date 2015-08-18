<?php
	$mc = "/var/www/html/MinecraftWrapper/minecraft_server_proyect";
	$dir = $mc."/servers";
	$ficheros  = scandir($dir);
	 
	//print_r($ficheros1);

	echo("<thead><th></th><th>Name</th><th>Status</th></thead>");
	$old_path = getcwd();
	$scripts = $mc."/scripts";
	chdir($scripts);
	echo("<tbody>");
	foreach($ficheros as $value){
		if($value!="." && $value!=".."){
			$output = shell_exec('./'.$value.'.sh status');
			$res = explode(" ", $output);
			$status = substr($res[1], 0, strlen($res[1])-1);
			
			$img = "res/online.png";
			if(strcmp($status , "offline")==0){
				$img = "res/offline.png";
			}

		 	echo(sprintf("<tr style='cursor:pointer' onclick='show_details(\"%s\", \"%s\")'>
		 					<td><img src=\"%s\" class=\"img-responsive\" alt=\"Status\"></td>
							<td>%s</td>
							<td>%s</td>
							</tr>",
							$value,
							$status,
							$img,
							$value,
							$status));	
		}
	}
	echo("</tbody>");

	chdir($old_path);
?>