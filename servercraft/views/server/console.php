<?php

$server_name = $server;

require_once("classes/Log.php");
require_once("classes/Player.php");
require_once("classes/Server.php");
$server_handle = new Server();
$log_handle = new Log();
$player_handle = new Player($server_name);

$log = $log_handle->getLog($server_name);
$onlinePlayers = $player_handle->getOnlinePlayers($server_handle, $log_handle);


?>

<script type="text/javascript">
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

	var liArray = document.getElementById('operators').getElementsByTagName('li');
	for (var i = 0; i < liArray.length; i++) {
	    if(liArray[i].className=="active" && liArray[i].id=="say-tab"){
	    	command="say "+command;
	    }
	}

	xmlhttp.onreadystatechange = function(){
	  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	    var data = xmlhttp.responseText;
	    if(data!=""){
	    	alert(data);
	    }
	  }
	}

	var id = <?php echo("\"".$server_name."\"")?>;

	xmlhttp.open("GET","php/scripts/command.php?server="+id+"&command="+command, true);
	xmlhttp.send();

}

function changeTab(selected){
	var liArray = document.getElementById('operators').getElementsByTagName('li');
	for (var i = 0; i < liArray.length; i++) {
	    liArray[i].className="";
	}
	document.getElementById(selected).className="active";
}



</script>



  <div style="float:left;">
	  <ul id="operators" class="consoleOperator">
	    <li id="say-tab" class="active"><a href="javascript:changeTab('say-tab')">Say</a></li>
	    <li id="command-tab"><a href="javascript:changeTab('command-tab')">Command</a></li>
	  </ul>
	  <input type="text" id="command" name="command" style="width:500px" onkeydown="pressed(event)">
	  
	  <br></br>
	  <textarea class="logArea" readonly="readonly" name="log" id="log" rows="22" style="width: 700px;"><?php echo($log);?></textarea>
	  <script type="text/javascript">
	  	var textarea = document.getElementById('log');
	  	textarea.scrollTop = textarea.scrollHeight;
	  </script>
  </div>

  <div style="float:left; padding-left: 15px;">
	<h4>Online Players</h4>
	<ul>
		<?php
  		foreach ($onlinePlayers as $key => $value) {
  			echo("<li>$value</li>");
  		}
  		?>
	</ul>
  </div>	
</div>