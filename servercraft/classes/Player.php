<?php

class Player
{

	private $db_connection = null;
    private $mc_path = null;
    private $directory = null;

	public $errors = array();
    public $messages = array();


	public function __construct($server)
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

        $server = $this->db_connection->real_escape_string(strip_tags($server, ENT_QUOTES));
        $sql = "SELECT server_id AS dir FROM servers WHERE server_name='".$server."';";
        $query_path = $this->db_connection->query($sql);
        $res = $query_path->fetch_assoc();
        $this->directory = $this->mc_path.'/servers/'.$res['dir'];

    }

    public function getOnlinePlayers(){
        echo("hola");
    }

    private function getJsonFile($file){
        $jsonFile = file_get_contents($file);
        return json_decode($jsonFile, true);
    }

    public function getOpPlayers(){
        $file = $this->directory.'/ops.json';
        $json = $this->getJsonFile($file);
        $res = [];
        foreach ($json as $op => $op_a){
            $res[] = $op_a['name'];
        }
        if(count($res)==0){
            $res[] = "There is non OP players on this server";
        }
        return $res;
    }

    public function getWhitelist(){
        $file = $this->directory.'/whitelist.json';
        $json = $this->getJsonFile($file);
        $res = [];
        foreach ($json as $op => $op_a){
            $res[] = $op_a['name'];
        }
        if(count($res)==0){
            $res[] = "There is non Whitelisted players on this server";
        }
        return $res;
    }

    public function getBannedPlayers(){
        $file = $this->directory.'/banned-players.json';
        $json = $this->getJsonFile($file);
        $res = [];
        foreach ($json as $op => $op_a){
            $res[] = $op_a['name'];
        }
        if(count($res)==0){
            $res[] = "There is non banned players on this server";
        }
        return $res;
    }

    public function getBannedIps(){
        $file = $this->directory.'/banned-ips.json';
        $json = $this->getJsonFile($file);
        $res = [];
        foreach ($json as $op => $op_a){
            $res[] = $op_a['name'];
        }
        if(count($res)==0){
            $res[] = "There is non banned ips on this server";
        }
        return $res;
    }

}

?>