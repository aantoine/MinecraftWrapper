<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">
    Config Setup
  </h1>
  <div class="table-responsive">
  <form id="general-form" method="post" action="install.php">
    <input type="hidden" name="step" value="3">
    <table class="table table-striped" id="server-prop" style="width:auto">
      <tbody>
        <tr>
          <td class="firstRow">PATH</td>
          <td class="secondRow">
            <input name="path" id="path" type="text">
          </td>
        </tr>
        <tr>
          <td class="firstRow">USER</td>
          <td class="secondRow">
            <input name="user" id="user" type="text">
          </td>
        </tr>
        <tr>
          <td class="firstRow">PASS</td>
          <td class="secondRow">
            <input name="pass" id="pass" type="password">
          </td>
        </tr>
        <tr>
          <td class="firstRow">REPEAT PASS</td>
          <td class="secondRow">
            <input name="pass-repeat" id="pass-repeat" type="password">
          </td>
        </tr>
        <tr>
          <td class="firstRow"></td>
          <td class="secondRow">
            <div id="save">
              <input type="submit" value="Next">
            </div>
          </td>
        </tr>
      </tbody>
    </table>
              
  </form>
  </div>
</div>