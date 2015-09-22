<?php
require_once("classes/Server.php");
require_once("classes/HtmlCreator.php");

$server_handle = new Server();
$html_creator = new HtmlCreator();

$jars = $server_handle->getJars();
$jar_selector = $html_creator->createSelector($jars, '', 'jar_prop', True, 'width:175px');

?>

<script type="text/javascript">
function validateForm() {
    var x = document.forms["general-form"]["name"].value;
    if (x == null || x == "") {
        alert("Error: Name must be filled out");
        return false;
    }
    if(x.length>60){
      alert("Error: Invalid Name");
      return false;
    }

    var xms = document.forms["general-form"]["xms_prop"].value;
    if (xms == null || xms == "") {
        alert("Error: Xms must be filled out");
        return false;
    }
    if (isNaN(xms) || xms<0 || xms>20480) {
        alert("Error: Xms must be a positive numeric value");
        return false;
    }

    var xmx = document.forms["general-form"]["xmx_prop"].value;
    if (xmx == null || xmx == "") {
        alert("Error: Xmx must be filled out");
        return false;
    }
    if (isNaN(xmx) || xmx<0 || xmx>20480) {
        alert("Error: Xmx must be a positive numeric value");
        return false;
    }
}
</script>




<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">Create new Server</h1>
  <form id="general-form" method="post" action="index.php" onsubmit="return validateForm()">
    <input type="hidden" name="createServer" value="createServer">

    <table class="table table-striped" id="server-generar" style="width:auto">
      <tbody>
        <tr>
          <td>Name</td>
          <td>
            <input name="name" id="name" type="text" value="" placeholder="Server Name">
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
            <input name="xms_prop" id="xms_prop" type="text" value="" placeholder="1024">
          </td>
        </tr>
        <tr>
          <td>Xmx</td>
          <td>
            <input name="xmx_prop" id="xmx_prop" type="text" value="" placeholder="2048">
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