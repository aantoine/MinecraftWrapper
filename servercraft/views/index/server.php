<?php

require_once("classes/Server.php");

$server_handle = new Server();

#Show Messages and Errors
foreach ($properties_handle->messages as $key => $value) {
  echo("<script type='text/javascript'>alert('$value');</script>");
}
foreach ($properties_handle->errors as $key => $value) {
  echo("<script type='text/javascript'>alert('Error: $value');</script>");
}
foreach ($server_handle->messages as $key => $value) {
  echo("<script type='text/javascript'>alert('$value');</script>");
}
foreach ($server_handle->errors as $key => $value) {
  echo("<script type='text/javascript'>alert('Error: $value');</script>");
}



$servers = $server_handle->getServers();

$table = "";

foreach ($servers as $i => $value) {
    $server = $value['name'];
    $status = $value['status'];
    $img = "res/online.png";
    if(strcmp($status , "offline")==0){
      $img = "res/offline.png";
    }

    $table = $table.(sprintf("<tr style='cursor:pointer' onclick='show_details(\"%s\")'>
          <td><img src=\"%s\" class=\"img-responsive\" alt=\"Status\"></td>
          <td>%s</td>
          <td>%s</td>
          </tr>\n",
          $server,
          $img,
          $server,
          $status));
}

?>

<script type="text/javascript">
function show_details(server){
  document.getElementById('server').value = server;
  document.DetailForm.submit();
}
</script>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">Servers</h1>
  <div class="table-responsive">
    <table class="table table-striped" id ="servers-table">
      <thead><th></th><th>Name</th><th>Status</th></thead>
      <tbody>
      <?php
      	echo($table);
      ?>
      </tbody>
    </table>
  </div>
  <div class="table-responsive">
    <table class="table table-striped" id ="servers-table">
    </table>
  </div>
  <div id ="form">
    <form action='server.php' method='GET' name='DetailForm'>
        <input id="server" type='hidden' name='server' value=''>
    </form>
  </div>
</div>