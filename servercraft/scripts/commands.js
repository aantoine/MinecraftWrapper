function disableButtons(){
  var status = document.getElementById('_status').innerHTML
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

  var server = document.getElementById("server_name").innerHTML;
  var url = "php/scripts/command.php?server="+server+"&"+action; 
  xmlhttp.open("GET", url, true);
  xmlhttp.send();
}

function changeDOMStatus(id, status){
  if(!!document.getElementById(id)){
    document.getElementById(id).innerHTML=status;
  }
}

function manageResult(action, res){
  if(action=="start"){
    if(res=="success\n"){
      document.getElementById("status_img").src="res/online.png";
      document.getElementById("_status").innerHTML="online";
      changeDOMStatus("status", "online");
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
      document.getElementById("status_img").src="res/offline.png";
      document.getElementById("_status").innerHTML="offline";
      changeDOMStatus("status", "offline");
      disableButtons();
      alert("Server is now stopped!");
    }
    else if(res=="error\n"){
      disableButtons();
      alert("Error! Server couldn't be stopped");
    }
  }
}