<?php
$server_name = $server;

require_once("classes/Server.php");
$server_handle = new Server();
$status = $server_handle->getStatus($server_name);
$img="res/online.png";
if(strcmp($status, "offline")==0){
  $img="res/offline.png";
}

foreach ($server_handle->messages as $key => $value) {
  echo("<script type='text/javascript'>alert('$value');</script>");
}
foreach ($server_handle->errors as $key => $value) {
  echo("<script type='text/javascript'>alert('Error: $value');</script>");
}
?>


<script src="scripts/commands.js"></script>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <div class="page-header">
    <div style="display: inline-block;">
      <h1 id="server_name"><?php echo($server_name);?></h1>
    </div>
    <div style="display: inline-block; margin: 0 15px 0; position: relative; bottom: 2px;">
      <p id="_status" style="display: none;"><?php echo($status)?></p>
      <img id="status_img" src=<?php echo("\"$img\""); ?> class="img-responsive" alt="Status">
    </div>  
    <div style="display: inline-block; margin: 0 5px 0; position: relative; bottom: 5px;">
        <button type="button" id="start_button" onclick="actionServer('start')">Start</button>
        <button type="button" id="stop_button" onclick="actionServer('stop')">Stop</button>
        <button type="button" id="restart_button">Restart</button>
    </div>
  </div>
  <script type="text/javascript">disableButtons();</script>

