<?php
namespace TASoft\MenuSystem\MenuItem;
use TASoft\MenuSystem as MS;

interface MenuItemInterface {
	
	public function getTitle(): string;
	public function getAction();
	public function isSelected(): bool;
	public function getID(): string;
	
	public function setMenu(MS\Menu\MenuInterface $menu = NULL);
	public function getMenu(): ?MS\Menu\MenuInterface;
	
	public function getSubmenu(): ?MS\Menu\MenuInterface;
	public function getSidemenu(): ?MS\Menu\MenuInterface;
}