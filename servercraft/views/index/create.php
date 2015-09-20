<?php
require_once("classes/Server.php");
require_once("classes/HtmlCreator.php");

$server_handle = new Server();
$html_creator = new HtmlCreator();

$jars = $server_handle->getJars();
$jar_selector = $html_creator->createSelector($jars, '', 'jar_prop', True, 'width:175px');

?>




<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">Create new Server</h1>
  <form id="general-form" method="post" action=<?php echo("index.php");?>>
    <input type="hidden" name="createServer" value="createServer">

    <h4><u>General</u></h4>
    <table class="table table-striped" id="server-generar" style="width:auto">
      <tbody>
        <tr>
          <td>Name</td>
          <td>
            <input name="name" id="name" type="text" value="">
          </td>
        </tr>
        <tr>
          <td class="firstRow">Jar</td>
          <td class="secondRow">
            <?php echo($jar_selector)?>
          </td>
        </tr>
        <tr>
          <td>Xms</td>
          <td>
            <input name="xms_prop" id="xms_prop" type="text" value="">
          </td>
        </tr>
        <tr>
          <td>Xmx</td>
          <td>
            <input name="xmx_prop" id="xmx_prop" type="text" value="">
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <input type="submit" value="Add Server">
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>