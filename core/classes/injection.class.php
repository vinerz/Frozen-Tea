<?php
function rstrstr($haystack, $needle) {
    if(!is_array($needle)) return false;

    foreach($needle as $element) {
        if(strstr($haystack, $element)) return true;
    }
    
    return false;
}

class injection {
	function __construct() {
		foreach ($_GET as $key => $value) {
			$_GET[$key] = addslashes($value);
			if(rstrstr($value, array("CONCAT", "SELECT", "UNION"))) die("Um comportamento estranho fez com que o sistema se protegesse.");
		}
		
		foreach ($_POST as $key => $value) {
			$_POST[$key] = addslashes(utf8_decode($value));
			if(rstrstr($value, array("CONCAT", "SELECT", "UNION"))) die("Um comportamento estranho fez com que o sistema se protegesse.");
		}
	}
}
?>
