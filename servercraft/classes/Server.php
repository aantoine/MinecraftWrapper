<?php

class Server
{

	private $db_connection = null;
    private $mc_path = null;

	public $errors = array();


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
        #echo($this->mc_path);

        if (isset($_POST["nameUpdate"])) {
            $this->nameUpdate();
        }
        if (isset($_POST["javaUpdate"])) {
            $this->javaUpdate();
        }
        if (isset($_POST["createServer"])) {
            $this->createServer();
        }

    }

    public function getServers(){
        //results array
        $res=[];

        // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno){
        	$sql = "SELECT server_name AS name, server_id AS dir FROM servers ORDER BY dir;";
            $query_server = $this->db_connection->query($sql);
            
            //for every server in the database 
			for ($num_fila = 0; $num_fila < $query_server->num_rows; $num_fila++) {
                $array=[];
			    $query_server->data_seek($num_fila);
			    $fila = $query_server->fetch_assoc();
                //add to the result array its name and its status
			    $array["name"] = $fila['name'];
                $array["status"] = $this->_getStatus($fila['dir']);
                $res[]=$array;
			}
        }
        else{
        	$this->errors[] = "Sorry, no database connection.";
        }

        return $res;
    }

    public function getProperties($server=null){
        if (!$this->db_connection->connect_errno){
            if($server==null){
                $server = $this->db_connection->real_escape_string(strip_tags($_GET["server"], ENT_QUOTES));
            }
            $name = $this->db_connection->real_escape_string(strip_tags($server, ENT_QUOTES));
            $sql = "SELECT jars.jar_name AS jar, jars.file AS file, servers.server_xms AS xms, servers.server_xmx AS xmx,".
                    "servers.server_world AS world ".
                    "FROM servers ".
                    "INNER JOIN jars ".
                    "ON jars.jar_id=servers.server_jar ".
                    "WHERE server_name = '".$name."';";

            $query_properties = $this->db_connection->query($sql);
            
            return $query_properties->fetch_assoc();
        }
        else{
            $this->errors[] = "Sorry, no database connection.";
        }
    }

    public function getJars(){
        $res=[];
        if (!$this->db_connection->connect_errno){
            $sql = "SELECT jar_name AS jar, file  FROM jars;";

            $query_jars = $this->db_connection->query($sql);

            for ($num_fila = 0; $num_fila < $query_jars->num_rows; $num_fila++) {
                $query_jars->data_seek($num_fila);
                $fila = $query_jars->fetch_assoc();
                #echo($fila['jar']);
                $res[$fila['file']]=$fila['jar'];
            }
        }
        else{
            $this->errors[] = "Sorry, no database connection.";
        }
        return $res;
    }

    public function getStatus($server){
        if (!$this->db_connection->connect_errno){
            $sql = "SELECT server_id AS dir FROM servers WHERE server_name='".$server."';";
            $query_path = $this->db_connection->query($sql);
            $res = $query_path->fetch_assoc();
            $dir = $res['dir'];

            return $this->_getStatus($dir);

        }
        else{
            $this->errors[] = "Sorry, no database connection.";
        }

    }

    private function _getStatus($file){
    	#echo($server);
        $script = $this->mc_path."/scripts";
        $old_path = getcwd();
        chdir($script);
        //executes status command, outupt = 'server status'
        $output = shell_exec('./main.sh status '.$file);
        $res = explode(" ", $output);
        //obtain status from output
        $status = substr($res[1], 0, strlen($res[1])-1);
        return $status;  
    }

    public function turnOn($server, $dir=False){
        if (!$this->db_connection->connect_errno){
            if(!$dir){
                $sql = "SELECT server_id AS dir FROM servers WHERE server_name='".$server."';";
                $query_path = $this->db_connection->query($sql);
                $res = $query_path->fetch_assoc();
                $dir = $res['dir'];
            } else $dir = $server;

            $properties = $this->getProperties($server);
            $jar = $properties['file'];
            $xms = $properties['xms'];
            $xmx = $properties['xmx'];

            $old_path = getcwd();

            $scripts = ($this->mc_path)."/scripts";
            #echo($scripts);
            #echo("<br>");
            chdir($scripts);    
            
            #echo('./server1.sh start '.$this->mc_path.' '.$dir.' '.$jar.' '.$xms.' '.$xmx);
            $output = shell_exec('./server1.sh start '.$this->mc_path.' '.$dir.' '.$jar.' '.$xms.' '.$xmx);
            chdir($old_path);
            return $output;

        }
        else{
            $this->errors[] = "Sorry, no database connection.";
        }
    }

    public function turnOff($server, $dir=False){    
        if (!$this->db_connection->connect_errno){
            if(!$dir){
                $sql = "SELECT server_id AS dir FROM servers WHERE server_name='".$server."';";
                $query_path = $this->db_connection->query($sql);
                $res = $query_path->fetch_assoc();
                $dir = $res['dir'];
            } else $dir = $server;

            $old_path = getcwd();

            $scripts = ($this->mc_path)."/scripts";
            #echo($scripts);
            #echo("<br>");
            chdir($scripts);    
            
            #echo('./server1.sh start '.$this->mc_path.' '.$dir.' '.$jar.' '.$xms.' '.$xmx);
            $output = shell_exec('./server1.sh stop '.$dir);
            chdir($old_path);
            return $output;

        }
        else{
            $this->errors[] = "Sorry, no database connection.";
        }
    }

    private function javaUpdate(){
        if (!$this->db_connection->connect_errno){
            $server = $this->db_connection->real_escape_string(strip_tags($_GET["server"], ENT_QUOTES));
            $xms = $this->db_connection->real_escape_string(strip_tags($_POST["xms_prop"], ENT_QUOTES));
            $xmx = $this->db_connection->real_escape_string(strip_tags($_POST["xmx_prop"], ENT_QUOTES));

            $file = $this->db_connection->real_escape_string(strip_tags($_POST["jar_prop"], ENT_QUOTES));

            $jar_sql = "SELECT jar_id AS id FROM jars WHERE file='".$file."';";
            $jar_query = $this->db_connection->query($jar_sql);
            $res = $jar_query->fetch_assoc();
            $id = $res['id'];

            $sql = "UPDATE servers SET server_jar='".$id."', server_xmx='".$xmx."', server_xms='".$xms."' WHERE server_name='".$server."';";
            #echo($sql);
            $query_jars = $this->db_connection->query($sql);
        }
        else{
            $this->errors[] = "Sorry, no database connection.";
        }
    }

    private function nameUpdate(){
        if (!$this->db_connection->connect_errno){
            $name = $this->db_connection->real_escape_string(strip_tags($_GET["server"], ENT_QUOTES));
            $sql = "SELECT * FROM servers WHERE server_name='".$name."';";
            $query_check_server_name = $this->db_connection->query($sql);

            if ($query_check_server_name->num_rows == 1) {
                $this->errors[] = "Server name must be unique!";
            } else {
                $server = $this->db_connection->real_escape_string(strip_tags($_POST["old_name"], ENT_QUOTES));
                $sql = "UPDATE servers SET server_name='".$name."' WHERE server_name='".$server."';";
                #echo($sql);
                $query_jars = $this->db_connection->query($sql);
            }
        }
        else{
            $this->errors[] = "Sorry, no database connection.";
        }
    }

    private function createServer(){
        #echo("<script type='text/javascript'>alert('create!');</script>");
        //Verify data!!

        //Add row to the server table
        $name = $this->db_connection->real_escape_string(strip_tags($_POST["name"], ENT_QUOTES));
        $jar = $this->db_connection->real_escape_string(strip_tags($_POST["jar_prop"], ENT_QUOTES));
        $xms = $this->db_connection->real_escape_string(strip_tags($_POST["xms_prop"], ENT_QUOTES));
        $xmx = $this->db_connection->real_escape_string(strip_tags($_POST["xmx_prop"], ENT_QUOTES));

        $jar_sql = "SELECT jar_id AS id FROM jars WHERE file='".$jar."';";
        $jar_query = $this->db_connection->query($jar_sql);
        $res = $jar_query->fetch_assoc();
        $jar_id = $res['id'];       

        $server_sql = "INSERT INTO servers (server_name, server_jar, server_xmx, server_xms, server_world) VALUES('$name', $jar_id, $xmx, $xms, 'world');";
        $query_server = $this->db_connection->query($server_sql);

        //Turn On and Off the server to create folders
        $dir_sql = "SELECT server_id AS id FROM servers ORDER BY id DESC LIMIT 1;";
        $dir_query = $this->db_connection->query($dir_sql);
        $res = $dir_query->fetch_assoc();
        $dir = $res['id'];

        //Creates directory
        $server = ($this->mc_path)."/servers/".$dir;
        mkdir("$server");
        copy(($this->mc_path)."/servers/eula.txt", $server."/eula.txt");

        $o1=substr($this->turnOn($name), 0, -1);
        #echo("<script type='text/javascript'>alert('$o1');</script>");
        $o2=substr($this->turnOff($name), 0, -1);
        #echo("<script type='text/javascript'>alert('$o2');</script>");


        //Show succes or failure message
    }

}

?>