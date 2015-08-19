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

    }

    public function getServers(){
        //results array
        $res=[];

        // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno){
        	$sql = "SELECT server_name AS name FROM servers;";
            $query_server = $this->db_connection->query($sql);
            
            //for every server in the database 
			for ($num_fila = 0; $num_fila < $query_server->num_rows; $num_fila++) {
                $array=[];
			    $query_server->data_seek($num_fila);
			    $fila = $query_server->fetch_assoc();
                //add to the result array its name and its status
			    $array["name"] = $fila['name'];
                $array["status"] = $this->getStatus($fila['name']);
                $res[]=$array;
			}
        }
        else{
        	$this->errors[] = "Sorry, no database connection.";
        }

        return $res;
    }

    public function getProperties($server){
        if (!$this->db_connection->connect_errno){
            $name = $this->db_connection->real_escape_string(strip_tags($server, ENT_QUOTES));
            $sql = "SELECT jars.jar_name AS jar, servers.server_xms AS xms, servers.server_xmx AS xmx,".
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
            $sql = "SELECT jar_name AS jar FROM jars;";

            $query_jars = $this->db_connection->query($sql);

            for ($num_fila = 0; $num_fila < $query_jars->num_rows; $num_fila++) {
                $query_jars->data_seek($num_fila);
                $fila = $query_jars->fetch_assoc();
                echo($fila);
                $res[]=$fila['jar'];
            }
        }
        else{
            $this->errors[] = "Sorry, no database connection.";
        }
        return $res;
    }

    public function getStatus($server){
    	#echo($server);
        $script = $this->mc_path."/scripts";
        $old_path = getcwd();
        chdir($script);
        //executes status command, outupt = 'server status'
        $output = shell_exec('./main.sh status '.$server);
        $res = explode(" ", $output);
        //obtain status from output
        $status = substr($res[1], 0, strlen($res[1])-1);
        return $status;  
    }

    public function turnOn($server){

    }
    public function turnOff($server){
        
    }
    public function update($server, $jar, $xms, $xmx, $world){

    }

}

?>