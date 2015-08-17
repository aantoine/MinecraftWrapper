<?php
if(isset($_GET['server'])){
  $mc = "/home/agustinantoine/minecraft-servers";
  
  $old_path = getcwd();
  $scripts = $mc."/scripts";

  chdir($scripts);

  //echo(htmlspecialchars($_GET['server']));
  $data = shell_exec('./'.htmlspecialchars($_GET['server']).'.sh data');
  $data = explode(" ", $data);
  chdir($old_path);
  
  $arr["jar"] = $data[0];
  $arr["xms"] = $data[1];
  $arr["xmx"] = substr($data[2], 0, strlen($data[2])-1);
  echo(json_encode($arr));


}
else{
  $arr["jar"] = "--";
  $arr["xms"] = "--";
  $arr["xmx"] = "--";
  echo(json_encode($arr));
}
?>