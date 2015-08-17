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
            var table = document.getElementById('server-prop');
            var keys = Object.keys(data);
            var count = 0;
            
            for(i=0; i<keys.length; i++){
              var row = table.insertRow(count);

              var prop_name = row.insertCell(0);
              var prop_input = row.insertCell(1);
              prop_name.className += (prop_name.className ? " " : "")+"firstRow";
              prop_input.className += (prop_input.className ? " " : "")+"secondRow";

              var input = document.createElement('input');
              input.type = "text";
              input.name = keys[i];
              input.id = keys[i];
              input.value = data[keys[i]];

              prop_name.innerHTML = keys[i];
              prop_input.appendChild(input);
              count++;
            }
          }
        }

        xmlhttp.open("GET","php/get_server_prop.php?server="+id, true);
        xmlhttp.send();
      }

      
      function load(){
        getServerProp(<?php echo("\"".$server_name."\"")?>);
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
            <li><a href=<?php echo("server-detail.php?server=".$server_name);?>>General <span class="sr-only">(current)</span></a></li>
            <li class="active"><a href="#">Properties</a></li>
            <li><a href="#">Players</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href=<?php echo("console.php?server=".$server_name);?> >Console</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header"><?php echo($server_name);?></h1>

          <form id= "save-form" method="post" action='#'>

            <div class="table-responsive">

              <h4><u>Properties</u></h4>
              <table class="table table-striped" id="server-prop" style="width:auto">
                <tbody>
                </tbody>
              </table>

              <table class="table table-striped" id="table-save" style="width:auto">
                <tbody>
                  <tr>
                    <td class="firstRow"></td>
                    <td class="secondRow">
                      <div id="save">
                        <input type="submit" value="Save">
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
