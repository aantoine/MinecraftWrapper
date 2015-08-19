<?php
$server_name = $server;

require_once("classes/Server.php");

$server_handle = new Server();
$status = $server_handle->getStatus($server_name);

$properties = $server_handle->getProperties($server_name);

$jars = $server_handle->getJars();
#echo($server_handle->errors);
#echo($jars);

$jar = $properties['jar'];
?>



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
            <td id="status"><?php echo($status)?></td>
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