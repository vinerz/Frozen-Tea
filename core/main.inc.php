<?php
/* -============================================-
 * Main File - Connects Core and Modules
 * By Vinicius Tavares 2011/2012
 * vinerz@vinerz.net
 * CHANGELOG
 * 13/01/2012 - Added unset database config for
 *		security proposes.
 * -============================================-
 */

ini_set('display_errors', 0);

require_once(dirname(__FILE__) . "/config.inc.php");
require_once(dirname(__FILE__) . "/util.global.php");
require_once(dirname(__FILE__) . "/classes/manager.class.php");

$Manager = new Manager();
$Manager->load($_CONFIG["MODULES"]);

$database->login($_CONFIG["DATABASE"]["HOST"], $_CONFIG["DATABASE"]["USER"], $_CONFIG["DATABASE"]["PASSWORD"], $_CONFIG["DATABASE"]["NAME"]);
unset($_CONFIG["DATABASE"]);

header("Content-type: text/html; charset=UTF-8");

$loginCheckExceptions = array("index.php", "login.php", "doLogin.php", "404.php", "cadastro.php", "doRecoverPassword.php", "forgotPassword.php", "doSignup.php", "activateAccount.php");

$data = explode("/", $_SERVER["SCRIPT_NAME"]);
$scriptName = end($data);

$flag = (strstr($_SERVER["SCRIPT_NAME"], "admin")) ? true : false;
$redir = (strstr($_SERVER["SCRIPT_NAME"], "admin")) ? "/admin" : "";

if(!in_array($scriptName, $loginCheckExceptions) && !$session->isLogged($flag)) {
	header("Location: ".$_CONFIG["SITE"]["MAIN_URL"].$redir."/login.php?erro=notauthorized");
	exit();
}

register_shutdown_function(array($database, 'end'));
?>
