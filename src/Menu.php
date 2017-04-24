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
 * Instantiable representation of AbstractMenu
 */
class Menu extends Menu\AbstractMenu {
	
	public function __debugInfo() {
		$data = [];
		$data['Name'] = $this->getName();
		return $data;
	}
}