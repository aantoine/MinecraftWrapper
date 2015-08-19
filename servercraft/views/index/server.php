<?php

require_once("classes/Server.php");

$server_handle = new Server();

?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">Servers</h1>

  <?php
  $servers = $server_handle->getServers();
	foreach ($servers as $i => $value) {
	    print_r($value);
	}
  #$server_handle = new Server();

  ?>

  <div class="table-responsive">
    <table class="table table-striped" id ="servers-table">
    </table>
  </div>
</div>