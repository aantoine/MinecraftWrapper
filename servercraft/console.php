<?php
if(isset($_GET['server'])){
  $server_name = htmlspecialchars($_GET['server']);
}
else{
  $server_name = "";
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Server-Craft</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bootstrap/css/dashboard.css" rel="stylesheet">

    <script type="text/javascript">
      var nIntervId;

      function setTimeLoad(time_milis){
        load();
        nIntervId = setInterval(load, time_milis);
      }
      function getLog(id){
        var xmlhttp;
        if (window.XMLHttpRequest) {
          xmlhttp=new XMLHttpRequest();
        }else{
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function(){
          if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            var data = xmlhttp.responseText;
            document.getElementById('log').innerHTML=data;
            document.getElementById('log').scrollTop=document.getElementById('log').scrollHeight;
          }
        }

        xmlhttp.open("GET","php/getLog.php?server="+id, true);
        xmlhttp.send();
      }

      function load(){
        getLog(<?php echo("\"".$server_name."\"")?>);
      }

      function pressed(e){
        if((window.event ? event.keyCode : e.which) == 13){
          sendCommand();
        }
      }

      function sendCommand(){
        var command= document.getElementById('command').value;
        document.getElementById('command').value="";
        var xmlhttp;
        if (window.XMLHttpRequest) {
          xmlhttp=new XMLHttpRequest();
        }else{
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function(){
          if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            var data = xmlhttp.responseText;
            if(data == "success"){
              load();
            }
            alert(data);
          }
        }

        var id = <?php echo("\"".$server_name."\"")?>;

        xmlhttp.open("GET","php/scripts/command.php?server="+id+"&command="+command, true);
        xmlhttp.send();

      }
    </script>
  </head>

  <body onload="setTimeLoad(5000)">

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Server-Craft</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index.html">Home</a></li>
            <li><a href="index.html">Servers</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Help</a></li>
          </ul>

        </div>
      </div>
    </nav>


    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href=<?php echo("server-detail.php?server=".$server_name);?>>General</a></li>
            <li><a href=<?php echo("properties.php?server=".$server_name);?>>Properties</a></li>
            <li><a href="#">Players</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Console <span class="sr-only">(current)</span></a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header"><?php echo($server_name);?></h1>
          <input type="text" id="command" name="command" style="width:500px" onkeydown="pressed(event)">
          <input type="submit" id="send" name="send" style="width:80px" value="Send" onclick="sendCommand()">
          <button type="button" onclick="load()">Refresh</button>
          <br></br>
          <textarea class="logArea" readonly="readonly" name="log" id="log" rows="23">
          </textarea>

        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
  </body>
</html>
