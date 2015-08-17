<?php
$mc = "/home/agustinantoine/minecraft-servers";
$target_dir = $mc."/jars/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$text ="";
$jarType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is a jar - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $text .= " File is not a jar.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $text .= " File already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000000) {
    $text .= " Your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($jarType != "jar") {
    $text .= " Only jar files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $text .= " Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $text = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } /*else {
        $text .= " There was an error uploading your file.";
    }*/
}

    echo("<html><body>
            <form action='../index.html' method='POST' name='MyForm'>
                <input type='hidden' name='obra' value=''>
            </form>
            <script type='text/javascript'>alert('".$text."');</script>
            <script language='javascript' type='text/javascript'>
                document.MyForm.submit();
            </script>
            <noscript><input type='submit' value='verify submit'></noscript>
        </body></html>");

?> 
