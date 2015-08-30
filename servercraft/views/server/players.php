<?php
$server_name = $server;

require_once("classes/Player.php");

$player_handle = new Player($server_name);
$ops = $player_handle->getOpPlayers();
$whitelist = $player_handle->getWhitelist();
$banPlayers = $player_handle->getBannedPlayers();
$banIps = $player_handle->getBannedIps();

?>


<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header"><?php echo($server_name);?></h1>

  <h4><u>Op Players</u></h4>
  <ul>
  	<?php
  		foreach ($ops as $key => $value) {
  			echo("<li>$value</li>");
  		}
  	?>
  </ul>

  <br>

  <h4><u>Whitelisted Players</u></h4>
  <ul>
  	<?php
  		foreach ($whitelist as $key => $value) {
  			echo("<li>$value</li>");
  		}
  	?>
  </ul>

  <br>

  <h4><u>Banned Players</u></h4>
  <ul>
  	<?php
  		foreach ($banPlayers as $key => $value) {
  			echo("<li>$value</li>");
  		}
  	?>
  </ul>

  <br>

  <h4><u>Banned Ips</u></h4>
  <ul>
  	<?php
  		foreach ($banIps as $key => $value) {
  			echo("<li>$value</li>");
  		}
  	?>
  </ul>



  
</div>