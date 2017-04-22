<?php
use PHPUnit\Framework\TestCase;
use TASoft\MenuSystem as MS;


class MenuItemConsistencyTest extends TestCase {
	public function testMenuItemRefersToMenu() {
		$m = new MS\Menu("Menu");
		$mi1 = new MS\MenuItem("Item 1");
		
		$m->addItem($mi1);
		$this->assertEquals($m, $mi1->getMenu());
		
		$mi2 = new MS\MenuItem("Item 2");
		$m->insertItem($mi2, 0);
		$this->assertEquals($m, $mi2->getMenu());
	}
	
	public function testMenuItemDeleteReferenceToMenuOnRemove() {
		$m = new MS\Menu("Menu");
		$mi1 = new MS\MenuItem("Item 1");
		$m->addItem($mi1);
		
		$m->removeItem($mi1);
		$this->assertNull($mi1->getMenu());
	}
}