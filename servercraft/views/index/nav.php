
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
    <?php
      if(!$create && !$jar){
        echo("<li class='active'><a>Servers<span class='sr-only'>(current)</span></a></li>");
      }
      else{
        //echo("<li><form method='post' action='index.php' name='server_form'><input type='submit'  name='server' value='Servers' /> </form></li>");
        echo("<li><a href='index.php'>Servers</a></li>");
      }

      if(isset($create) && $create){
        echo("<li class='active'><a>Create<span class='sr-only'>(current)</span></a></li>");
      }
      else{
        echo("<li><a href='index.php?create'>Create</a></li>"); 
      }
    ?>
  </ul>
  <ul class="nav nav-sidebar">
    <?php
      if(isset($jar) && $jar){
        echo("<li class='active'><a>Add Jar<span class='sr-only'>(current)</span></a></li>");
      }
      else{
        echo("<li><a href='index.php?jar'>Add Jars</a></li>"); 
      }
    ?>
  </ul>
</div>
        