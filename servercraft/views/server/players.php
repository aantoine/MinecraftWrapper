<?php
$server_name = $server;

require_once("classes/Player.php");

$player_handle = new Player($server_name);
$ops = $player_handle->getOpPlayers();

?>


<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header"><?php echo($server_name);?></h1>
  <?php
  	print_r($ops);
  ?>






  
</div>