<?php
$server_name = $server;
require_once("classes/Properties.php");
require_once("classes/HtmlCreator.php");

$properties_handle = new Properties();
$html_creator = new HtmlCreator();
foreach ($properties_handle->messages as $key => $value) {
  echo("<script type='text/javascript'>alert('$value');</script>");
}
foreach ($properties_handle->errors as $key => $value) {
  echo("<script type='text/javascript'>alert('Error: $value');</script>");
}

$properties = $properties_handle->getProperties();
$table = $html_creator->createInputTable($properties, "server-prop","table table-striped", "width:auto");

?>



  
  <form id= "save-form" method="post" action=<?php echo("server.php?server=".$server_name."&properties");?>>
  	<input type="hidden" name="propertiesUpdate" id="propertiesUpdate" value="propertiesUpdate">
    <div class="table-responsive">
      <h4><u>Properties</u></h4>
      <?php echo($table);?>

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