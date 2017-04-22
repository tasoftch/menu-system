<?php
namespace TASoft\MenuSystem\Menu;

use TASoft\MenuSystem as MS;

interface MenuInterface {
	public function getName(): string;
	
	public function isHidden(): bool;
	
	public function getItemArray(): array;
	
	public function setMenuItem(MS\MenuItem\MenuItemInterface $menuItem = NULL);
	public function getMenuItem(): ?MS\MenuItem\MenuItemInterface;
}