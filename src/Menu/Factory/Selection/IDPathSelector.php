<?php
namespace TASoft\MenuSystem\Menu\Factory\Selection;
use TASoft\MenuSystem\MenuItem\MenuItemInterface;

class IDPathSelector implements SelectionInterface {
	private $path;
	
	public function setIDPath($path) {
		$this->path = $path;
	}
	public function getURL() {
		return $this->path;
	}
	
	public function shouldSelectMenuItem(MenuItemInterface $item): bool {
		$ids = [];
		
		do {
			$ids[] = $item->getID();
			$menu = $item->getMenu();
			$item = $menu->getMenuItem();
		} while($item);
		
		$ids = array_reverse($ids);
		$selector = explode("/", $this->path);
		
		for($e=0;$e<count($ids);$e++) {
			$ref = $selector[$e] ?? false;
			if($ids[$e] != $ref)
				return false;
		}
		
		return true;
	}
}