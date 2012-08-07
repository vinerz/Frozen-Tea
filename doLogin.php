<?
require_once("./core/main.inc.php");

if(isset($_GET["cmd"]) AND get("cmd") == "logout") {
	$session->destroy();
	header("Location: ./acesso?msg=desconectado");
}

if(post("userName") == "" or post("userPass") == "") {
	header("Location: ./login.php");
	exit();
}

$userEmail = post("userName");
$userPassword = sha1(post("userPass"));

if($res = $database->searchDB("SELECT user_id, user_password, user_habilitado FROM mc_users WHERE user_email='".$userEmail."' LIMIT 1")) {
    if($res["user_habilitado"] == "0") {
        header("Location: ./acesso?erro=2");
        exit();
    }
    
	if($userPassword == $res["user_password"]) {
		$session->set("uid", $res["user_id"]);
		header("Location: ./home.php");
	} else {
		header("Location: ./login.php?erro=1");
	}
} else {
	header("Location: ./login.php?erro=1");
}
?>
