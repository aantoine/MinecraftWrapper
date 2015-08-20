function changeView(view, div){
  var xmlhttp;
  if (window.XMLHttpRequest) {
    xmlhttp=new XMLHttpRequest();
  }else{
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange = function(){
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById(div).innerHTML = xmlhttp.responseText;
    }
  }

  xmlhttp.open("GET",view, true);
  xmlhttp.send();
}

function changeNavSelection(inactive, active, option, view){
  document.getElementById(inactive).innerHTML = "<li><a href=changeView('"+view+"')>"+option+"</a></li>";
  document.getElementById(active).innerHTML = "<li class='active'><a>"+option+"<span class='sr-only'>(current)</span></a></li>";
}