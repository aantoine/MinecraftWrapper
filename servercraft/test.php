<?php
$server_name = "Nuevo";

?>

<div>
  <div style="display: inline-block;">
    <h1>
      <?php echo($server_name);?>
    </h1>
  </div>
  <div style="display: inline-block;">
        <button type="button" id="start_button" onclick="actionServer('start')">Start</button>
        <button type="button" id="stop_button" onclick="actionServer('stop')">Stop</button>
        <button type="button" id="restart_button">Restart</button>
  </div>
</div>

