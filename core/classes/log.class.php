<?php
class log {
    function __construct() {
    }
    
    function add($uid, $msg) {
        global $database;
        return $database->saveData("INSERT INTO log VALUES (null, '".$uid."', '".utf8_decode($msg)."', '".time()."');");
    }
    
    function get($uid = false) {
        global $database;
        return $database->listAll($database->query("SELECT * FROM log ".(($uid) ? "WHERE log_user_id='".$uid."'" : "")." ORDER BY log_date DESC"));
    }
}
?>
