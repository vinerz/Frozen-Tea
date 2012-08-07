<?php
/* -==========================================================-
 * Class Response - Send server response to client
 * JSON format
 * Revision 1.1
 * 
 * 
 * CHANGELOG: 14/10/11 - Added nextAction support for notice
 *                       messages.
 * -==========================================================-
 */
class response {
	function send($content, $type = 'success', $nextAction = false) {
		if($type == 'notice') {
			if($nextAction) {
				echo json_encode(array("status" => $type, "content" => $content, "nextAction" => $nextAction));
			} else {
				echo json_encode(array("status" => $type, "content" => $content));
			}
		} else {
			echo json_encode(array("status" => $type, "content" => $content));
		}
	}
}
?>