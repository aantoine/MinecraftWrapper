<?php

class Log
{
    private $mc_path = null;
    private $db_connection = null;

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

    }

    public function getLog($server){
   		$log = $this->getLogAsArray($server);
   		$lines = "";
   		foreach ($log as $key => $value) {
   			$lines=$lines.$value;
   		}
   		return $lines;
    }

    public function getLastLogLine($server){
  		$log = $this->getLogAsArray($server);
  		return end($log);
    }

    private function getLogAsArray($server){
    	$server = $this->db_connection->real_escape_string(strip_tags($server, ENT_QUOTES));
   		$sql = "SELECT server_id AS dir FROM servers WHERE server_name='".$server."';";
        $query_path = $this->db_connection->query($sql);
        $res = $query_path->fetch_assoc();
        $dir = $this->mc_path.'/servers/'.$res['dir'];

		$file = $dir."/logs/latest.log";


		return file($file);
    }


}

?>