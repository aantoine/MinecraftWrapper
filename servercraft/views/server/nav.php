
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
    <?php
      if(!$general && !$player && !$console &&!$properties){
        echo("<li class='active'><a>General<span class='sr-only'>(current)</span></a></li>");
      }
      else{
        //echo("<li><form method='post' action='index.php' name='server_form'><input type='submit'  name='server' value='Servers' /> </form></li>");
        echo("<li><a href='server.php?server=".$server."'>General</a></li>");
      }

      if(isset($properties) && $properties){
        echo("<li class='active'><a>Properties<span class='sr-only'>(current)</span></a></li>");
      }
      else{
        echo("<li><a href='server.php?server=".$server."&properties'>Properties</a></li>"); 
      }

      if(isset($player) && $player){
        echo("<li class='active'><a>Players<span class='sr-only'>(current)</span></a></li>");
      }
      else{
        echo("<li><a href='server.php?server=".$server."&player'>Players</a></li>"); 
      }
    ?>
  </ul>
  <ul class="nav nav-sidebar">
    <?php
      if(isset($console) && $console){
        echo("<li class='active'><a>Console<span class='sr-only'>(current)</span></a></li>");
      }
      else{
        echo("<li><a href='server.php?server=".$server."&console'>Console</a></li>"); 
      }
    ?>
  </ul>
</div>
        