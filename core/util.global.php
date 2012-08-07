<?php
function get($id) {
    if(!isset($_GET[$id])) return false;
	return @$_GET[$id];
}

function post($id) {
    if(!isset($_POST[$id])) return false;
	return @$_POST[$id];
}

function gerencia_erro($level, $message, $file, $line, $context) {
	global $response;
    if($level === E_USER_ERROR || $level === E_USER_WARNING || $level === E_USER_NOTICE) {
        $response->send($message, "fatal_error");
        exit();
        return(true);
    }
    return(false);
}

function erro($message, $level = E_USER_ERROR) {
    $callee = next(debug_backtrace());
    trigger_error($message.' em <strong>'.end(explode("/", $callee['file'])).'</strong> na linha <strong>'.$callee['line'].'</strong>', $level);
}

/* Erros customizados */
set_error_handler('gerencia_erro');

function printMatrix($matrix){
	echo "<table width='200' border='1'>";
	foreach($matrix as $row => $rValue){
		echo "<tr>";
		if(is_array($rValue)) {
			foreach($rValue as $col => $cValue){
				if(is_array($cValue)) {
					echo "<td>";
					printMatrix($cValue);
					echo "</td>";
				} else {
					echo "<td>".$cValue."</td>";
				}
			}
		} else {
			echo "<td>".$rValue."</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}

function orderBy($data, $field) {
    $code = "return strnatcmp(\$a['$field'], \$b['$field']);";
    usort($data, create_function('$a,$b', $code));
    return $data;
}

function subval_sort( $a, $subkey, $order) {
	foreach( $a as $k=>$v )
		$b[$k] = strtolower( $v[$subkey] );
	if( $order === 'desc' )
		arsort( $b );
	else
		asort( $b );
	foreach( $b as $k=>$v )
		$c[] = $a[$k];
	return $c;
}

$GLOBALS['normalizeChars'] = array(
    'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 
    'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 
    'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 
    'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 
    'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 
    'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 
    'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f'
);

function cleanText($toClean) {
    return strtr($toClean, $GLOBALS['normalizeChars']);
}

function decimal_to_time($decimal) {
	$decimal = $decimal * 60;
    $hours = floor((int)$decimal / 60);
    $minutes = floor((int)$decimal % 60);
    $seconds = $decimal - (int)$decimal; 
    $seconds = round($seconds * 60); 
  
    return (($hours > 0) ? str_pad($hours, 2, "0", STR_PAD_LEFT). "h " : "") . str_pad($minutes, 2, "0", STR_PAD_LEFT)."min";
}

function bbcode($texto) {
  $texto = htmlentities(utf8_decode($texto)); 
  $tags = array(
          "/(?<!\\\\)\[color(?::\w+)?=(.*?)\](.*?)\[\/color(?::\w+)?\]/si"   => "<span style=\"color:\\1;\">\\2</span>",
          //'/(?<!\\\\)\[size(?::\w+)?=(.*?)\](.*?)\[\/size(?::\w+)?\]/si'     => "<span style=\"font-size:\\1;\">\\2</span>",
          '/(?<!\\\\)\[b(?::\w+)?\](.*?)\[\/b(?::\w+)?\]/si'                 => "<span style=\"font-weight:bold;\">\\1</span>",
         // '/(?<!\\\\)\[code(?::\w+)?\](.*?)\[\/code(?::\w+)?\]/si'           => "<span class=\"barra-code\">CÓDIGO</span><code class=\"code\">\\1</code>",
          '/(?<!\\\\)\[i(?::\w+)?\](.*?)\[\/i(?::\w+)?\]/si'                 => "<span style=\"font-style:italic;\">\\1</span>",
          '/(?<!\\\\)\[u(?::\w+)?\](.*?)\[\/u(?::\w+)?\]/si'                 => "<span style=\"text-decoration: underline;\">\\1</span>",
          '/(?<!\\\\)\[align(?::\w+)?=(.*?)\](.*?)\[\/align(?::\w+)?\]/si'   => "<span style=\"display:block;text-align:\\1\">\\2</span>",
          //'/(?<!\\\\)\[url(?::\w+)?\]www\.(.*?)\[\/url(?::\w+)?\]/si'        => "<a href=\"http://www.\\1\" onclick=\"window.open(this.href); return false;\">\\1</a>",
          //'/(?<!\\\\)\[url(?::\w+)?\](.*?)\[\/url(?::\w+)?\]/si'             => "<a href=\"\\1\" onclick=\"window.open(this.href); return false;\">\\1</a>",
          //'/(?<!\\\\)\[url(?::\w+)?=(.*?)?\](.*?)\[\/url(?::\w+)?\]/si'      => "<a href=\"\\1\" onclick=\"window.open(this.href); return false;\">\\2</a>",
          //'/(?<!\\\\)\[img(?::\w+)?\](.*?)\[\/img(?::\w+)?\]/si'             => "<a href=\"\\1\" title=\"Ampliar\" class=\"highslide\" onclick=\"return hs.expand (this)\"><img src=\"\\1\" alt=\"Imagem\" /></a>",
          '/\\\\(\[\/?\w+(?::\w+)*\])/'                                      => "\\1"

  );
  $texto = preg_replace(array_keys($tags), array_values($tags), $texto);
  return nl2br($texto);
}

function highlight($needle, $haystack){ 
    $ind = stripos($haystack, $needle); 
    $len = strlen($needle); 
    if($ind !== false){ 
        return substr($haystack, 0, $ind) . "<b>" . substr($haystack, $ind, $len) . "</b>" . 
            highlight($needle, substr($haystack, $ind + $len)); 
    } else return $haystack; 
} 
?>
