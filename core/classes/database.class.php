<?php
/* ----------------------------------------------------- *
 * Database Class. Database connection and misc functions
 * By VinerzZ 2011 (c)
 * Do not redistribute it without proper authorization
 * ----------------------------------------------------- *
 */
class database {
	private $link;
	
	function login($host, $dbuser, $dbpass, $db) {
		if($this->link = @mysql_connect($host, $dbuser, $dbpass)) {
			if(!@mysql_select_db($db, $this->link)) {
				erro("Não foi possível selecionar o Banco de Dados.", E_USER_ERROR);
			}
		} else {
			erro("Não foi possível se conectar com o Banco de Dados", E_USER_ERROR);
		}
	}
	
	function query($qry) {
		if(($res = @mysql_query($qry, $this->link))) {
			return $res;
		} else {
			echo $this->error();
			erro("Não foi possível executar a consulta", E_USER_ERROR);
		}
	}
	
	function data($res) {
		if($res) {
			if($res = mysql_fetch_assoc($res)) {
				foreach($res as $key => $val) {
					$res[$key] = utf8_encode($res[$key]);
				}
				return $res;
			} else {
				return false;
			}
		} else {
			erro("Não foi possível realizar a listagem de dados, a consulta não é válida", E_USER_ERROR);
		}
	}
	
	function listAll($qry) {
		$resp = array();
		while(false !== ($r = mysql_fetch_assoc($qry))) {
			foreach($r as $key => $value) {
				$r[$key] = utf8_encode($r[$key]);
			}
			array_push($resp, $r);
		}
		return $resp;
	}
	
	function searchDB($qry) {
		if(($res = @mysql_query($qry, $this->link))) {
			if($this->countRows($res) == 0) return false;
			$res = @mysql_fetch_assoc($res);
			if($res) {
				foreach(@$res as $key => $value) {
					$res[$key] = utf8_encode($res[$key]);
				}
			} else {
				return false;
			}
			return $res;
		} else {
			erro("Não foi possível executar a consulta", E_USER_ERROR);
		}
	}
	
	function countRows($qry){
		if($qry) {
			return @mysql_num_rows($qry);
		} else {
			erro("Não foi possível realizar a contagem de dados, a consulta não é válida", E_USER_ERROR);
		}
	}
	
	function insertID() {
		return @mysql_insert_id($this->link);
	}
	
	function error() {
		return mysql_error($this->link);
	}
	
	function saveData($qry) {
		if(@mysql_query($qry, $this->link)) {
			return true;
		} else {
			return false;
		}
	}
	
	function end() {
		if(@mysql_close($this->link)) {
			return true;
		} else {
			return false;
		}
	}
}
?>