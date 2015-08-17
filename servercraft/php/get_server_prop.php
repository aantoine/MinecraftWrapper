<?php
include_once("propertiesUtils.php");
if(isset($_GET['server'])){
  $mc = "/home/agustinantoine/minecraft-servers";
  
  $dir = $mc."/servers/".htmlspecialchars($_GET['server']);

  $file = $dir."/server.properties";

  $arr = properties2array($file);
  echo(json_encode($arr));
}
?>