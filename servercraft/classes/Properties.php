<?php

class Properties
{
    private $mc_path = null;
    private $db_connection = null;
    public $errors =  array();
    public $messages =  array();

	public function __construct()
    {
        if ($this->db_connection==null){
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        }
        // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")){
            $this->errors[] = $this->db_connection->error;
        }

        $sql = "SELECT opt_value AS opt FROM config WHERE opt_name='mc_path';";
        $query_path = $this->db_connection->query($sql);
        $res = $query_path->fetch_assoc();
        $this->mc_path = $res['opt'];

        if (isset($_POST["propertiesUpdate"])) {
            $this->update();
        }

    }

    public function update(){
   		$server = $this->db_connection->real_escape_string(strip_tags($_GET["server"], ENT_QUOTES));
   		$sql = "SELECT server_id AS dir FROM servers WHERE server_name='".$server."';";
        $query_path = $this->db_connection->query($sql);
        $res = $query_path->fetch_assoc();
        $dir = $this->mc_path.'/servers/'.$res['dir'];

		$file = $dir."/server.properties";

		$lines = file($file);
		
		foreach($lines as $num_línea => $line) {
			if(mb_substr($line, 0, 1, 'utf-8')!="#" && $line!=""){
				$split = explode("=", $line);
				if(array_key_exists($split[0], $_POST)){
					$lines[$num_línea]=$split[0]."=".$_POST[$split[0]]."\n";
				}
				
			}
		}

		//print_r($lines);

		$contenido = implode("", $lines);

		// Primero vamos a asegurarnos de que el archivo existe y es escribible.
		if (is_writable($file)) {
		    // En nuestro ejemplo estamos abriendo $nombre_archivo en modo de adición.
		    // El puntero al archivo está al final del archivo
		    // donde irá $contenido cuando usemos fwrite() sobre él.
		    if (!$gestor = fopen($file, 'w')) {
		         $this->errors[]="The file $file cannot be open";
		         exit;
		    }

		    // Escribir $contenido a nuestro archivo abierto.
		    if (fwrite($gestor, $contenido) === FALSE) {
		        $this->errors[]="The file $file is not writable";
		        exit;
		    }

		    //echo "Éxito, se escribió ($contenido) en el archivo ($file)";

		    fclose($gestor);
		    $this->messages[]="Changes saved succesfully";

		} else {
			$this->errors[]="The file $file is not writable";
		}

    }

    public function getProperties(){
    	$server = $this->db_connection->real_escape_string(strip_tags($_GET["server"], ENT_QUOTES));
   		$sql = "SELECT server_id AS dir FROM servers WHERE server_name='".$server."';";
        $query_path = $this->db_connection->query($sql);
        $res = $query_path->fetch_assoc();
        $dir = $this->mc_path.'/servers/'.$res['dir'];

		$file = $dir."/server.properties";
		$arr = $this->properties2array($file);
		return $arr;
    }

    private function properties2array($file){
		$myfile = fopen($file, "r") or die("Unable to open file!");
		// Output one line until end-of-file
		while(!feof($myfile)){
			$line = fgets($myfile);
			if(mb_substr($line, 0, 1, 'utf-8')!="#" && $line!=""){
				$split = explode("=", $line);
				$array[$split[0]]=substr($split[1], 0, strlen($split[1])-1);
			}
		}
		fclose($myfile);
		return $array;
	}

}

?>