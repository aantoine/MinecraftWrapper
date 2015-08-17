<?php
if(isset($_GET['server'])){
  $server_name = htmlspecialchars($_GET['server']);
}
else{
  $server_name = "";
}
?>

<?php
if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['online-mode'])){
	$mc = "/home/agustinantoine/minecraft-servers";
	$dir = $mc."/servers/".htmlspecialchars($_POST['id']);
	//print_r($_POST);
	//echo("<br>");

	$file = $dir."/server.properties";

	$lines = file($file);
	// Output one line until end-of-file
	foreach($lines as $num_línea => $line) {
		if(mb_substr($line, 0, 1, 'utf-8')!="#" && $line!=""){
			$split = explode("=", $line);
			if(array_key_exists($split[0], $_POST)){
				$lines[$num_línea]=$split[0]."=".$_POST[$split[0]]."\n";
			}
			//$array[$split[0]]=substr($split[1], 0, strlen($split[1])-1);
		}
	}

	//print_r($lines);

	$contenido = implode("", $lines);

	// Primero vamos a asegurarnos de que el archivo existe y es escribible.
	if (is_writable($file)) {

	    // En nuestro ejemplo estamos abriendo $nombre_archivo en modo de adición.
	    // El puntero al archivo está al final del archivo
	    // donde irá $contenido cuando usemos fwrite() sobre él.
	    if (!$gestor = fopen($file, 'w')) {
	         //echo "No se puede abrir el archivo ($nombre_archivo)";
	         exit;
	    }

	    // Escribir $contenido a nuestro archivo abierto.
	    if (fwrite($gestor, $contenido) === FALSE) {
	        //echo "No se puede escribir en el archivo ($file)";
	        exit;
	    }

	    //echo "Éxito, se escribió ($contenido) en el archivo ($file)";

	    fclose($gestor);

	} else {
	    //echo "El archivo $file no es escribible";
	}

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
      function disableButtons(){
        var status = document.getElementById('status').innerHTML
        if(status=="offline"){
          document.getElementById('stop_button').disabled=true;
          document.getElementById('restart_button').disabled=true;
          document.getElementById('start_button').disabled=false;
        }
        else{
          document.getElementById('start_button').disabled=true;
          document.getElementById('stop_button').disabled=false;
          document.getElementById('restart_button').disabled=false;
        }
      }

      function restartWorld(){
        alert("hola");
      }

      function getJavaProp(id){
        var xmlhttp;
        if (window.XMLHttpRequest) {
          xmlhttp=new XMLHttpRequest();
        }else{
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function(){
          if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            var data = JSON.parse(xmlhttp.responseText);
            document.getElementById('jar_prop').value=data["jar"];
            document.getElementById('xms_prop').value=data["xms"];
            document.getElementById('xmx_prop').value=data["xmx"];
          }
        }

        xmlhttp.open("GET","php/get_java_prop.php?server="+id, true);
        xmlhttp.send();
      }

      function getServerProp(id){
        var xmlhttp;
        if (window.XMLHttpRequest) {
          xmlhttp=new XMLHttpRequest();
        }else{
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function(){
          if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            var data = JSON.parse(xmlhttp.responseText);
            //alert(xmlhttp.responseText);
            document.getElementById('max-players').value=data["max-players"];
            document.getElementById('server-port').value=data["server-port"];
            document.getElementById('level-name').value=data["level-name"];
            document.getElementById('level-seed').value=data["level-seed"];
            document.getElementById('gamemode').value=data["gamemode"];
            document.getElementById('difficulty').value=data["difficulty"];
            document.getElementById('online-mode').value=data["online-mode"];
            document.getElementById('motd').value=data["motd"];
          }
        }

        xmlhttp.open("GET","php/get_server_prop.php?server="+id, true);
        xmlhttp.send();
      }

      function getStatus(id){
        var xmlhttp;
        if (window.XMLHttpRequest) {
          xmlhttp=new XMLHttpRequest();
        }else{
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function(){
          if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            var status = xmlhttp.responseText;
            document.getElementById("status").innerHTML=status;
            //alert(status);
            disableButtons();
          }
        }

        xmlhttp.open("GET","php/scripts/status_server.php?server="+id, true);
        xmlhttp.send();
      }

      function getJars(){
        var xmlhttp;
        if (window.XMLHttpRequest) {
          xmlhttp=new XMLHttpRequest();
        }else{
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function(){
          if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            //alert(xmlhttp.responseText);
            var data = JSON.parse(xmlhttp.responseText);
            var keys = Object.keys(data);
            var select = document.getElementById("jar_prop");
            for(i=0; i<keys.length; i++){
              var option = document.createElement("option");
              option.text = data[keys[i]];
              option.value = data[keys[i]];
              select.add(option, select[i]);
            }
          }
        }

        xmlhttp.open("GET","php/get_jars.php", true);
        xmlhttp.send();
      }

      function actionServer(action){
        var xmlhttp;
        document.getElementById('stop_button').disabled=true;
        document.getElementById('start_button').disabled=true;
        document.getElementById('restart_button').disabled=true;
        if(action=="start"){
          alert("Starting server, this action will need a couple of seconds");
        }
        if(action=="stop"){
          alert("Stopping server, this action will need a couple of seconds");
        }

        if (window.XMLHttpRequest) {
          xmlhttp=new XMLHttpRequest();
        }else{
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function(){
          if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            //alert("res: $"+xmlhttp.responseText+"$");
            manageResult(action, xmlhttp.responseText);
          }
        }

        var server = document.getElementById("name").value;
        var url;
        if(action=="start"){
          url = "php/scripts/start_server.php?server="+server;
          //alert(url);
        }
        if(action=="stop"){
          url = "php/scripts/stop_server.php?server="+server;
        }

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
      }

      function manageResult(action, res){
        if(action=="start"){
          if(res=="success\n"){
            document.getElementById("status").innerHTML="online";
            disableButtons();
            alert("Server is now running!");
          }
          else if(res=="error\n"){
            disableButtons();
            alert("Error! Server couldn't be started");
          }
        }
        else if(action=="stop"){
          if(res=="success\n"){
            document.getElementById("status").innerHTML="offline";
            disableButtons();
            alert("Server is now stopped!");
          }
          else if(res=="error\n"){
            disableButtons();
            alert("Error! Server couldn't be stopped");
          }
        }
      }

      function load(){
        getStatus(<?php echo("\"".$server_name."\"")?>);
        getJars();
        getServerProp(<?php echo("\"".$server_name."\"")?>);
        getJavaProp(<?php echo("\"".$server_name."\"")?>);
      }
    </script>
  </head>

  <body onload="load()">

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
            <li class="active"><a href="#">General <span class="sr-only">(current)</span></a></li>
            <li><a href=<?php echo("properties.php?server=".$server_name);?> >Properties</a></li>
            <li><a href="#">Players</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href=<?php echo("console.php?server=".$server_name);?> >Console</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header"><?php echo($server_name);?></h1>

          <form id= "save-form" method="post" action=<?php echo("server-detail.php?server=".$server_name);?>>
            <input type="hidden" name="id" value=<?php echo("'".$server_name."'");?>>
            <div class="table-responsive">

              <h4><u>General</u></h4>
              <table class="table table-striped" id="server-generar" style="width:auto">
                <tbody>
                  <tr>
                    <td class="firstRow"></td>
                    <td class="secondRow">
                      <div id="buttons">
                        <button type="button" id="start_button" onclick="actionServer('start')">Start</button>
                        <button type="button" id="stop_button" onclick="actionServer('stop')">Stop</button>
                        <button type="button" id="restart_button">Restart</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Nombre</td>
                    <td>
                      <input name="name" id="name" type="text" value=<?php echo($server_name);?>>
                    </td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td id="status">--</td>
                  </tr>
                </tbody>
              </table>

              <hr>
              <h4><u>Java</u></h4>
              <table class="table table-striped" id="java-prop" style="width:auto">
                <tbody>
                  <tr>
                    <td class="firstRow">Jar</td>
                    <td class="secondRow">
                      <select name="jar_prop" id="jar_prop" style="width:175px"></select>
                    </td>
                  </tr>
                  <tr>
                    <td>Xms</td>
                    <td>
                      <input name="xms_prop" id="xms_prop" type="text" value="...">
                    </td>
                  </tr>
                  <tr>
                    <td>Xmx</td>
                    <td>
                      <input name="xmx_prop" id="xmx_prop" type="text" value="...">
                    </td>
                  </tr>
                </tbody>
              </table>

              <hr>
              <h4><u>Properties</u></h4>
              <table class="table table-striped" id="server-prop" style="width:auto">
                <tbody>
                  <tr>
                    <td class="firstRow">Max Players</td>
                    <td class="secondRow">
                      <input name="max-players" id="max-players" type="text" value="...">
                    </td>
                  </tr>
                  <tr>
                    <td>Port</td>
                    <td>
                      <input name="server-port" id="server-port" type="text" value="...">
                    </td>
                  </tr>
                  <tr>
                    <td>Level Name</td>
                    <td>
                      <input name="level-name" id="level-name" type="text" value="...">
                    </td>
                  </tr>
                  <tr>
                    <td>Seed</td>
                    <td>
                      <input name="level-seed" id="level-seed" type="text" value="...">
                    </td>
                  </tr>
                  <tr>
                    <td>Game-Mode</td>
                    <td>
                      <select name="gamemode" id="gamemode" style="width:175px">
                        <option value="0">0 - Survival</option>
                        <option value="1">1 - Creative</option>
                        <option value="2">2 - Adventure</option>
                        <option value="3">3 - Spectator</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Difficulty</td>
                    <td>
                      <select name="difficulty" id="difficulty" style="width:175px">
                        <option value="0">0 - Peaceful</option>
                        <option value="1">1 - Easy</option>
                        <option value="2">2 - Normal</option>
                        <option value="3">3 - Hard</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Online-Mode</td>
                    <td>
                      <select name="online-mode" id="online-mode" style="width:175px">
                        <option value="true">True</option>
                        <option value="false">False</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Motd</td>
                    <td>
                      <input name="motd" id="motd" type="text" value="...">
                    </td>
                  </tr>
                </tbody>
              </table>

              <table class="table table-striped" id="table-save" style="width:auto">
                <tbody>
                  <tr>
                    <td class="firstRow"></td>
                    <td class="secondRow">
                      <div id="save">
                        <input type="submit" value="Save">
                        <button type="button" id="restart_world" onclick="restartWorld()">Restart World</button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </form>
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
