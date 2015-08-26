<?php

require_once("classes/Server.php");

$server_handle = new Server();

#Show Messages and Errors

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


    $table = $table.(sprintf("<tr>
          <td><img src=\"%s\" class=\"img-responsive\" alt=\"Status\"></td>
          <td style='cursor:pointer' onclick='show_details(\"%s\")'>%s</td>
          <td>%s</td>
          <td><a href='javascript:deleteDialog(\"%s\")'><img src='res/delete.png' class='img-responsive' alt='Delete'></a></td>
          </tr>\n",
          $img,
          $server,
          $server,
          $status,
          $server));
}

#echo("<script type='text/javascript'>alert('All good');</script>");

?>
<script type="text/javascript">
function show_details(server){
  document.getElementById('server').value = server;
  document.DetailForm.submit();
}

function deleteDialog(server){
  if (confirm('Are you sure you want to delete this server?')) {
    document.getElementById('delServer').value = server;
    document.DeleteForm.submit();
  }
}
</script>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">Servers</h1>
  <div class="table-responsive">
    <table class="table table-striped" id ="servers-table">
      <thead><th></th><th>Name</th><th>Status</th><th></th></thead>
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
    <form action='index.php' method='POST' name='DeleteForm'>
        <input id="delServer" type='hidden' name='delServer' value=''>
        <input id="deleteServer" type='hidden' name='deleteServer' value='true'>
    </form>
  </div>
</div>