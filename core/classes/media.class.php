<?php 
class media {
	function __construct() {
	}
	
	function url($relative, $absolute = false) {
		return "http://localhost/magiccity/".$relative;
		if(!$absolute) $absolute = "http://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"];
		
        $p = parse_url($relative);
        
        if(@$p["scheme"])return $relative;
        
        extract(parse_url($absolute));
        
        $path = dirname($path); 
        if($relative{0} == '/') {
            $cparts = array_filter(explode("/", $relative));
        }
        else {
            $aparts = array_filter(explode("/", $path));
            $rparts = array_filter(explode("/", $relative));
            $cparts = array_merge($aparts, $rparts);
            foreach($cparts as $i => $part) {
                if($part == '.') {
                    $cparts[$i] = null;
                }
                if($part == '..') {
                    $cparts[$i - 1] = null;
                    $cparts[$i] = null;
                }
            }
            $cparts = array_filter($cparts);
        }
        $path = implode("/", $cparts);
        $url = "";
        if($scheme) {
            $url = "$scheme://";
        }
        if(@$user) {
            $url .= "$user";
            if($pass) {
                $url .= ":$pass";
            }
            $url .= "@";
        }
        if($host) {
            $url .= "$host/";
        }
        $url .= $path;
        return $url;
    }
    
	function linkCSS($file, $absolute = false) {
		if(!$absolute) $absolute = "http://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"];
    	if(is_array($file)) {
    		$final = "";
    		foreach($file as $key => $val) {
    			$final .= '<link type="text/css" rel="stylesheet" href="'.$this->url($val, $absolute).'" />';
    		}
    	} else {
    		$final = '<link type="text/css" rel="stylesheet" href="'.$this->url($file, $absolute).'" />';
    	}
    	return $final;
    }
    
	function linkJS($file, $absolute = false) {
		if(!$absolute) $absolute = "http://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"];
    	if(is_array($file)) {
    		$final = "";
    		foreach($file as $key => $val) {
    			$final .= '<script language="javascript" src="'.$this->url($val, $absolute).'"></script>';
    		}
    	} else {
    		$final = '<script language="javascript" src="'.$this->url($file, $absolute).'"></script>';
    	}
    	return $final;
    }
}
?>
