<?php
use PHPUnit\Framework\TestCase;
use TASoft\MenuSystem as MS;

class SubmenuTest extends TestCase {
	public function testSubmenuAddition() {
		$m = new MS\Menu("Menu");
		$mi1 = new MS\MenuItem("Item 1");
		
		$m->addItem($mi1);
		
		$mi2 = new MS\MenuItem("Parent Item");
		$mi2->setSubmenu($m);
		$this->assertEquals($m, $mi2->getSubmenu());
	}
	
	
	public function testSubmenuWithParentItem() {
		$m = new MS\Menu("Menu");
		$mi1 = new MS\MenuItem("Item 1");
		$mi2 = new MS\MenuItem("Parent Item");
		$mi2->setSubmenu($m);
		
		$this->assertEquals($mi2, $m->getMenuItem());
		
		$mi2->setSubmenu(NULL);
		$this->assertNull($m->getMenuItem());
	}
	
	public function testSidemenuWithParentItem() {
		$m = new MS\Menu("Menu");
		$mi1 = new MS\MenuItem("Item 1");
		$mi2 = new MS\MenuItem("Parent Item");
		$mi2->setSidemenu($m);
		
		$this->assertEquals($mi2, $m->getMenuItem());
	}
	
	/**
	@expectedException TASoft\MenuSystem\ConsistencyException
	*/
	public function testMenuAddingConsistency() {
		$m1 = new MS\Menu("Menu 1");
		$m2 = new MS\Menu("Menu 2");
		
		$mi1 = new MS\MenuItem("Item 1");
		$mi2 = new MS\MenuItem("Item 2");
		
		$mi1->setSubmenu($m1);
		$mi2->setSubmenu($m2);
		
		$m1->addItem($mi2); // Still ok
		
		$this->assertEquals($m1, $mi2->getMenu());
		$this->assertEquals($mi1, $m1->getMenuItem());
		
		$m2->addItem($mi2); // Does not work
	}
	
	/**
	@expectedException TASoft\MenuSystem\ConsistencyException
	*/
	public function testSubmenuAddingConsistency() {
		$m1 = new MS\Menu("Menu 1");
		$mi1 = new MS\MenuItem("Item 1");
		$mi2 = new MS\MenuItem("Item 2");
		
		$mi1->setSubmenu($m1); // ok
		
		$mi2->setSubmenu($m1); // Does not work	
	}
	
	public function testSubmenuAddingConsistencyThatWorks() {
		$m1 = new MS\Menu("Menu 1");
		$mi1 = new MS\MenuItem("Item 1");
		$mi2 = new MS\MenuItem("Item 2");
		
		$mi1->setSubmenu($m1); // ok
		
		$mi1->setSubmenu(NULL);
		
		$mi2->setSubmenu($m1); // Now it works
		$this->assertEquals($mi2, $m1->getMenuItem());
	}
}