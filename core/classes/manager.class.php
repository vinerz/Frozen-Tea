<?php
/* ----------------------------------------------------- *
 * Main Class. Calls the another classes, and so on.
 * By VinerzZ 2011 (c)
 * Do not redistribute it without proper authorization
 * ----------------------------------------------------- *
 */
class Manager {
	private $_path;
	var $loadedClasses;
	
	public function __construct($work_path = false) {
		if($work_path) {
			$this->_path = $work_path;
		} else {
			$this->_path = dirname(__FILE__);
		}
		
		$this->loadedClasses = Array();
	}
	
	private function _loadClass($className) {
		global $$className;
		if(!is_file($this->_path."/".$className.".class.php")) return false;
		require_once($this->_path."/".$className.".class.php");
		$$className = new $className();
		array_push($this->loadedClasses, $className);
		return true;
	}
	
	public function load($class) {
		if(is_array($class)) {
			foreach($class as $cls) {
				$this->_loadClass($cls);
			}
			return true;
		} else {
			return $this->_loadClass($class);
		}
	}
}
?>