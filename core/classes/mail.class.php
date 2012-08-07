<?php
/* -==========================================-
 * PapercutMailer 1.2.1 extending PHPMailer
 * VinerzZ 2011
 * vinerz@vinerz.net
 * 
 * CHANGELOG:
 * 10/10/11 - Added Polimorfism in Send method
 *            Supports multiple receivers
 *            
 * 13/10/11 - UTF8-decode Mail Title
 * 			  Supports accentuation
 * 
 * 25/11/11 - Disabled multiple receivers
 * 			  Added mail queue
 * -==========================================-
 */
class mail {
	function __construct() {
		require_once(dirname(__FILE__) . "/../libraries/phpmailer/class.phpmailer.php");
	}
	
	function send($title, $message, $to, $name = false, $extramails = false) {
		$mail = new PHPMailer();
		
		$mail->AddReplyTo('contato@site.com', 'Frozen Tea');
		
		if(is_array($to)) {
			if(!@is_array($to[0])) {
				$mail->AddAddress($to[0], $to[1]);
			}
		} else {
			if(!$name) $name = $to;
			$mail->AddAddress($to, $name);
		}
		
		$mail->SetFrom("contato@site.com", "Frozen Tea");
		$mail->Subject = utf8_decode($title);
		$mail->AltBody = 'Para visualizar o conteúdo da mensagem, você precisa utilizar um visualizador compatível com HTML';
		$mail->MsgHTML($message);
		
		if($mail->Send()) {
			return true;
		} else {
			return false;
		}
	}
	
	function format($file, $strings) {
		if(is_file($file)) {
			$buffer = file_get_contents($file);
			foreach($strings as $key => $val) {
				$buffer = str_replace("{".strtoupper($key)."}", $val, $buffer);
			}
			return $buffer;
		} else {
			return "";
		}
	}
}
?>
