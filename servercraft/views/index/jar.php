<script type="text/javascript">

	function sendFile() {
        var uri = "php/upload.php";
        var xhr = new XMLHttpRequest();
        var fd = new FormData();
        
        var file = document.getElementById("uploadInput").value;
        var desc = document.getElementById("fileDescription").value;

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle response.
                alert(xhr.responseText); // handle response.
            }
        };

        fd.append('myFile', file);
        fd.append("fileDescription", desc);

        xhr.open("POST", uri, true);

        // Initiate a multipart/form-data upload
        xhr.send(fd);
    }

</script>



<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

  <h1 class="page-header">Add new Jar</h1>
  <form id="form" action="php/upload.php" method="POST">
	  <table class="table table-striped">
	  	<tbody>
		    <tr>
		      <td>Select Jar</td>
		      <td>
		        <input id="uploadInput" type="text" name="myFiles" style="display:inline" 
		        	placeholder="Jar file Url">
		      </td>
		    </tr>
		    <tr>
		      <td>File Description</td>
		      <td>
		        <input id="fileDescription" type="text" name="fileDescription" 
		        	placeholder="ej: Minecraft 1.9">
		      </td>
		    </tr>
		    
		    <tr>
		      <td></td>
		      <td>
		        <button type="button" onclick="sendFile();">Upload File</button>
		      </td>
		    </tr>
	  	</tbody>
	  </table>
  </form>

</div>