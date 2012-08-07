<?
class configuration {
	private $config;
	
	function __construct() {
		require_once(dirname(__FILE__)."/../general.settings.inc.php");
		$this->config = $generalSettings;
		unset($generalSettings);
	}
	
	function set($key, $val) {
		$this->config[$key] = $val;
	}
	
	function get($key) {
		return $this->config[$key];
	}
}
?>