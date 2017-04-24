<?php
namespace TASoft\MenuSystem\Menu\Factory;

interface FactoryInterface {
	
	public function getMenu(): \TASoft\MenuSystem\Menu\MenuInterface;
	
}