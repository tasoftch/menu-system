<?php
/*
 * This file is part of MenuSystem
 *
 * @author Th. Abplanalp <info@tasoft.ch>
 * @copyright (c) 2017 by TASoft Applications, Th. Abplanalp
 * @package MenuSystem
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TASoft\MenuSystem;

/**
 * Marker class for MenuSystem exceptions.
 */
class Exception extends \Exception {

/**
 * Designated initializer
 *
 * Creates an exception
 */
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