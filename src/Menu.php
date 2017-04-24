<?php
namespace TASoft\MenuSystem;

class Menu extends Menu\AbstractMenu {
	
	public function __debugInfo() {
		$data = [];
		$data['Name'] = $this->getName();
		return $data;
	}
}