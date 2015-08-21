<?php

class HtmlCreator
{
	private $mc_path = null;
	private $db_connection=null;


	public function __construct()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);       
        // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")){
            $this->errors[] = $this->db_connection->error;
        }

        $sql = "SELECT opt_value AS opt FROM config WHERE opt_name='mc_path';";
        $query_path = $this->db_connection->query($sql);
        $res = $query_path->fetch_assoc();
        $this->mc_path = $res['opt'];
    }

    public function createSelector($opt, $selected, $id, $cmpValue, $style = ""){
    	$html="<select name='".$id."' id='".$id."' style=".$style.">\n";
        echo($selected);
    	foreach ($opt as $i => $value){
    		if(strcmp($value , $selected)==0 && $cmpValue){
		      	$html=$html."<option selected value='".$i."'>".$value."</option>\n";
		    }
            elseif(strcmp($i , $selected)==0 && !$cmpValue){
                $html=$html."<option selected value='".$i."'>".$value."</option>\n";   
            }
		    else{
    			$html=$html."<option value='".$i."'>".$value."</option>\n";
    		}
		}
		$html=$html."</select>";

		return $html;
    }

    public function createInput($id, $value, $type = "text"){
    	return "<input name='".$id."' id='".$id."' type='".$type."' value='".$value."'>";
    }
}


?>