<?php
$server_name = $server;

require_once("classes/Server.php");
require_once("classes/Properties.php");
require_once("classes/HtmlCreator.php");

$properties_handle = new Properties();

foreach ($properties_handle->messages as $key => $value) {
  echo("<script type='text/javascript'>alert('$value');</script>");
}
foreach ($properties_handle->errors as $key => $value) {
  echo("<script type='text/javascript'>alert('Error: $value');</script>");
}

$html_creator = new HtmlCreator();
$status = $server_handle->getStatus($server_name);

$jar_properties = $server_handle->getProperties();
$jars = $server_handle->getJars();
$jar = $jar_properties['jar'];
$xms = $html_creator->createInput("xms_prop",$jar_properties['xms']);
$xmx = $html_creator->createInput("xmx_prop",$jar_properties['xmx']);
$jar_selector = $html_creator->createSelector($jars, $jar, 'jar_prop', True, 'width:175px');

$properties = $properties_handle->getProperties();

$gamemode=[
    "0" => "0 - Survival",
    "1" => "1 - Creative",
    "2" => "2 - Adventure",
    "3" => "3 - Spectator"
];
$gamemode_selector = $html_creator->createSelector($gamemode,
                       $properties['gamemode'], 'gamemode',False,'width:175px');

$difficulty=[
    "0" => "0 - Peaceful",
    "1" => "1 - Easy",
    "2" => "2 - Normal",
    "3" => "3 - Hard"
];
$difficulty_selector = $html_creator->createSelector($difficulty,
                       $properties['difficulty'], 'difficulty',False,'width:175px');

$online=[
    "true" => "True",
    "false" => "False"
];

$online_selector = $html_creator->createSelector($online,
                       $properties['online-mode'], 'online-mode',False,'width:175px');
?>

<script type="text/javascript"> 

function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 

document.onkeypress = stopRKey; 

</script>

<script type="text/javascript">
function changeFormAction(){
  var action = document.getElementById("name").value;
  var actualServer = document.getElementById("old_name").value;

  if(action==actualServer){ 
    return;
  }

  //First validate that the name is unique!

  var xmlhttp;
  if (window.XMLHttpRequest) {
    xmlhttp=new XMLHttpRequest();
  }else{
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange = function(){
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      if(xmlhttp.responseText=="success"){
        document.getElementById("general-form").action="server.php?server="+action;
        document.getElementById("general-form").submit();
      }
      else{
        alert("Server name must be unique!");
      }
    }
  }

  var server = document.getElementById("server_name").innerHTML;
  var url = "php/checkServer.php?server="+action; 
  xmlhttp.open("GET", url, true);
  xmlhttp.send();
}
</script>

  <div class="table-responsive">
  <form id="general-form" method="post" action=<?php echo("server.php?server=".$server_name);?>>
    <input type="hidden" name="nameUpdate" value="nameUpdate">
    <input type="hidden" id="old_name" name="old_name" value=<?php echo($server_name);?>>

    <h4><u>General</u></h4>
    <table class="table table-striped" id="server-generar" style="width:auto">
      <tbody>
        <tr>
          <td class="firstRow">Name</td>
          <td class="secondRow">
            <input name="name" id="name" type="text" value=<?php echo($server_name);?>>
          </td>
        </tr>
        <tr>
          <td>Status</td>
          <td id="status"><?php echo($status)?></td>
        </tr>
        <tr>
          <td></td>
          <td>
            <button type="button" onclick="changeFormAction()">Save</button>
          </td>
        </tr>
      </tbody>
    </table>
  </form>

  <form id= "java-form" method="post" action=<?php echo("server.php?server=".$server_name);?>>
    <input type="hidden" name="javaUpdate" id="javaUpdate" value="javaUpdate">
    <hr>
    <h4><u>Java</u></h4>
    <table class="table table-striped" id="java-prop" style="width:auto">
      <tbody>
        <tr>
          <td class="firstRow">Jar</td>
          <td class="secondRow">
            <?php echo($jar_selector)?>
          </td>
        </tr>
        <tr>
          <td>Xms</td>
          <td>
            <?php echo($xms)?>
          </td>
        </tr>
        <tr>
          <td>Xmx</td>
          <td>
            <?php echo($xmx)?>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <input type="submit" value="Save">
          </td>
        </tr>
      </tbody>
    </table>
  </form>
  <form id= "save-form" method="post" action=<?php echo("server.php?server=".$server_name);?>>
    <input type="hidden" name="propertiesUpdate" id="propertiesUpdate" value="propertiesUpdate">
    <hr>
    <h4><u>Properties</u></h4>
    <table class="table table-striped" id="server-prop" style="width:auto">
      <tbody>
        <tr>
          <td class="firstRow">Max Players</td>
          <td class="secondRow">
            <input name="max-players" id="max-players" type="text" 
              value=<?php echo($properties['max-players'])?>>
          </td>
        </tr>
        <tr>
          <td>Port</td>
          <td>
            <input name="server-port" id="server-port" type="text"
              value=<?php echo($properties['server-port'])?>>
          </td>
        </tr>
        <tr>
          <td>Level Name</td>
          <td>
            <input name="level-name" id="level-name" type="text"
              value=<?php echo($properties['level-name'])?>>
          </td>
        </tr>
        <tr>
          <td>Seed</td>
          <td>
            <input name="level-seed" id="level-seed" type="text"
              value=<?php echo($properties['level-seed'])?>>
          </td>
        </tr>
        <tr>
          <td>Game-Mode</td>
          <td>
            <?php echo($gamemode_selector);?>
          </td>
        </tr>
        <tr>
          <td>Difficulty</td>
          <td>
            <?php echo($difficulty_selector);?>
          </td>
        </tr>
        <tr>
          <td>Online-Mode</td>
          <td>
            <?php echo($online_selector);?>
          </td>
        </tr>
        <tr>
          <td>Motd</td>
          <td>
            <input name="motd" id="motd" type="text"
              value=<?php echo("'".$properties['motd']."'");?>>
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
  </form>
  </div>
</div>