<?php
class user {
	function __construct() {
		
	}
	
	function request() {
		global $database, $session;
		
		$data = func_get_args();
		
		if(count($data) > 1) {
			$i = 0;
			$columnQuery = "";
			foreach($data as $itm) {
				if($i > 0) $columnQuery .= ', ';
				$columnQuery .= 'user_'.$itm;
				$i++;
			}
			
			$sDat = $database->searchDB("SELECT {$columnQuery} FROM signi_users WHERE user_id=".$session->get("uid"));
			
			$finalRes = array();
			foreach($sDat as $key => $val) {
				$finalRes[str_replace("user_", "", $key)] = $val;
			}
			
			return $finalRes;
		} else {
			$sDat = $database->searchDB("SELECT user_".$data[0]." FROM signi_users WHERE user_id=".$session->get("uid"));
			return $sDat["user_".$data[0]];
		}
	}
}
?>