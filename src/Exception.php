<?php
namespace TASoft\MenuSystem;

class Exception extends \Exception {
	public function __construct() {
		$args = func_get_args();
		$code = array_shift($args);
		if(is_integer($code))
			$msg = array_shift($args);
		else {
			$msg = $code;
			$code = 0;
		}
		
		$message = vsprintf($msg, $args);
		parent::__construct($message, $code);
	}
}