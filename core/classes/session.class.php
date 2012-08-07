<?php 
class session {
	function __construct() {
		session_start();
	}
	
	function destroy() {
		session_destroy();
	}
	
	function exists($id) {
		return isset($_SESSION[$id]);
	}
	
	function get($id) {
		return @$_SESSION[$id];
	}
	
	function set($id, $value) {
		@$_SESSION[$id] = $value;
	}
	
	function isLogged($adm = false) {
		$key = ($adm) ? "aid" : "uid";
		if(!isset($_SESSION[$key]) or $_SESSION[$key] == "") {
			return false;
		}
		return true;
	}
	
	function hasPrivileges($level) {
	    return ($_SESSION["alevel"] >= $level);
	}
}
?>
