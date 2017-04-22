<?php
use PHPUnit\Framework\TestCase;

use TASoft\MenuSystem as MS;

class MenuTest extends TestCase {
	public function testMenuCreation() {
		$m = new MS\Menu("Menu");
		$this->assertInstanceOf(MS\Menu::class, $m);
		$this->assertEquals('Menu', $m->getName());
		
		$m->setHidden(true);
		$this->assertTrue($m->isHidden());
		
		$this->assertCount(0, $m->getItemArray());
	}
	
	public function testMenuAddItems() {
		$m = new MS\Menu("Menu");
		
		$mi1 = new MS\MenuItem("Item 1");
		$mi2 = new MS\MenuItem("Item 2");
		$mi3 = new MS\MenuItem("Item 3");
		
		$m->addItem($mi2);
		$m->addItem($mi1)->addItem($mi3);
		
		$this->assertEquals([$mi2, $mi1, $mi3], $m->getItemArray());
	}
	
	public function testMenuInsertItems() {
		$m = new MS\Menu("Menu");
		
		$mi1 = new MS\MenuItem("Item 1");
		$mi2 = new MS\MenuItem("Item 2");
		$mi3 = new MS\MenuItem("Item 3");
		
		$m->addItem($mi1)->addItem($mi3);
		$m->insertItem($mi2, 1);
		
		$this->assertEquals([$mi1, $mi2, $mi3], $m->getItemArray());
		
		$m->addItemWithTitle('Test');
		
		$this->assertEquals('Test', $m->itemAtIndex(3)->getTitle());
		
		$m->insertItemWithTitle('My Name', 1);
		$this->assertEquals('Test', $m->itemAtIndex(4)->getTitle());
		$this->assertEquals('My Name', $m->itemAtIndex(1)->getTitle());
	}
	
	public function testMenuRemoveItems() {
		$m = new MS\Menu("Menu");
		
		$mi1 = new MS\MenuItem("Item 1");
		$mi2 = new MS\MenuItem("Item 2");
		$mi3 = new MS\MenuItem("Item 3");
		
		$m->addItem($mi1)->addItem($mi3);
		
		$this->assertFalse($m->containsItem($mi2));
		
		$m->insertItem($mi2, 1);
		
		$this->assertTrue($m->containsItem($mi2));
		
		
		$m->removeItem($mi1);
		$this->assertEquals([$mi2, $mi3], $m->getItemArray());
		
		$m->removeAllItems();
		$this->assertEquals([], $m->getItemArray());
	}
	
	public function testMenuObtainingIndexes() {
		$m = new MS\Menu("Menu");
		
		$mi1 = new MS\MenuItem("Item 1");
		$mi2 = new MS\MenuItem("Item 2");
		$mi3 = new MS\MenuItem("Item 3");
		
		$mi2->tag = 23;
		
		$m->addItem($mi1)->addItem($mi3)->addItem($mi2);
		$this->assertEquals(1, $m->indexOfItem($mi3));
		
		$this->assertEquals(0, $m->indexOfItemWithTitle('Item 1'));
		
		$this->assertEquals(2, $m->indexOfItemWithTag(23));
	}
	
	public function testMenuObtainingItems() {
		$m = new MS\Menu("Menu");
		
		$mi1 = new MS\MenuItem("Item 1");
		$mi2 = new MS\MenuItem("Item 2");
		$mi3 = new MS\MenuItem("Item 3");
		
		$mi2->tag = 23;
		
		$m->addItem($mi1)->addItem($mi3)->addItem($mi2);
		
		$this->assertEquals($mi3, $m->itemWithTitle('Item 3'));
		
		$this->assertEquals($mi2, $m->itemWithTag(23));
	}
}