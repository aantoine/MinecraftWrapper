<?php
function parse($file){
	$repr="<tr><th>Property</th><th>Value</th></tr>";
	while(!feof($file)) {
		$line = fgets($file);
		if(mb_substr($line, 0, 1, 'utf-8')!="#" && $line!=""){
			$split = explode("=", $line);
			$repr=$repr.sprintf("<tr><td>%s</td><td>%s</td></tr>", $split[0], $split[1]);
		}
		
	}
	return $repr;
}

function properties2array($file){
	$myfile = fopen($file, "r") or die("Unable to open file!");
	// Output one line until end-of-file
	while(!feof($myfile)){
		$line = fgets($myfile);
		if(mb_substr($line, 0, 1, 'utf-8')!="#" && $line!=""){
			$split = explode("=", $line);
			$array[$split[0]]=substr($split[1], 0, strlen($split[1])-1);
		}
	}
	fclose($myfile);
	return $array;
}

?>