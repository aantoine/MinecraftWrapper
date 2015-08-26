function deleteServer(server, resHandle){

  var xmlhttp;
  if (window.XMLHttpRequest) {
    xmlhttp=new XMLHttpRequest();
  }else{
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  var url = "php/deleteServer.php";
  var params = "deleteServer=true&server="+server;
  xmlhttp.open("POST", url, true);

  //Send the proper header information along with the request
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.setRequestHeader("Content-length", params.length);
  xmlhttp.setRequestHeader("Connection", "close");

  xmlhttp.onreadystatechange = function() {//Call a function when the state changes.
      if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          resHandle(xmlhttp.responseText);
      }
  }
  xmlhttp.send(params);

}