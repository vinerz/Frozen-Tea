<?
class comprict {
    function enc($string) {
	    $r = "";
	    for($i = 0; $i < strlen($string); $i++ ) {
		    $toChar = ord(substr($string, $i, 1));
		    if(strlen($toChar) == 1) $toChar = "00".$toChar;
		    if(strlen($toChar) == 2) $toChar = "0".$toChar;
		    $r .= $toChar;
	    }
	    return rawurlencode(str_replace(array("/", "=", "+"), array(".", ",", ";"), strrev(base64_encode(gzdeflate($r)))));
    }

    function dec($string) {
	    $string = gzinflate(base64_decode(strrev(str_replace(array(".", ",", ";"), array("/", "=", "+"), $string))));
	    $r = "";
	    $size = strlen($string);
	    $loops = $size/3;
	    for($i = 0; $i < $loops; $i++ ) {
		    $toStr = chr(substr($string, $i*3, 3));
		    $r .= $toStr;
	    }
	    return $r;
    }
}
?>
