<?php
namespace TASoft\MenuSystem\Menu\Factory\Policy;

use TASoft\MenuSystem\MenuItem\MenuItemInterface;

interface PolicyInterface {
	
	public function shouldEnableMenuItem(MenuItemInterface $item): bool;
	public function shouldShowMenuItem(MenuItemInterface $item): bool;
	
}