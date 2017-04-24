<?php
namespace TASoft\MenuSystem\Menu\Factory\Selection;
use TASoft\MenuSystem\MenuItem\MenuItemInterface;

interface SelectionInterface {
	
	public function shouldSelectMenuItem(MenuItemInterface $item): bool;
	
}