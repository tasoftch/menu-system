<?php
use PHPUnit\Framework\TestCase;
use TASoft\MenuSystem as MS;

class MenuItemTest extends TestCase {
	public function testMenuItemCreation() {
		$mi = new MS\MenuItem();
		$this->assertInstanceOf(MS\MenuItem::class, $mi);
		
		$this->assertEquals("", $mi->getTitle());
		$this->assertEquals("#", $mi->getAction());
		$this->assertFalse($mi->isSelected());
		
		$mi = new MS\MenuItem("Hello World");
		$this->assertEquals("Hello World", $mi->getTitle());
		$this->assertEquals("#", $mi->getAction());
		$this->assertFalse($mi->isSelected());
		
		$mi = new MS\MenuItem("Hello World", 'https://www.tasoft.ch/projects');
		$this->assertEquals("Hello World", $mi->getTitle());
		$this->assertEquals("https://www.tasoft.ch/projects", $mi->getAction());
		$this->assertFalse($mi->isSelected());
		
		$mi = new MS\MenuItem("Hello World", 'https://www.tasoft.ch/projects', true);
		$this->assertEquals("Hello World", $mi->getTitle());
		$this->assertEquals("https://www.tasoft.ch/projects", $mi->getAction());
		$this->assertTrue($mi->isSelected());
		
		$mi->setIconFile('Tests/TestIconFile');
		$this->assertEquals('Tests/TestIconFile', $mi->getIconFile());
	}
	
	public function testSeparatorItemCreation() {
		$sep = MS\MenuItem::separatorItem();
		$this->assertInstanceOf(MS\MenuItem::class, $sep);
		
		$this->assertTrue($sep->isSeparatorItem());
	}
	
/**
*	@expectedException TASoft\MenuSystem\Exception
*/
	public function testSeparatorItemTitleSetter() {
		$sep = MS\MenuItem::separatorItem();
		$sep->setTitle("Does not work");
	}
	
/**
*	@expectedException TASoft\MenuSystem\Exception
*/
	public function testSeparatorItemActionSetter() {
		$sep = MS\MenuItem::separatorItem();
		$sep->setAction("Does not work");
	}
	
/**
*	@expectedException TASoft\MenuSystem\Exception
*/
	public function testSeparatorItemSelectedSetter() {
		$sep = MS\MenuItem::separatorItem();
		$sep->setSelected(true);
	}
	
/**
*	@expectedException TASoft\MenuSystem\Exception
*/
	public function testMenuItemIconFileUnexisting() {
		$mi = new MS\MenuItem();
		$mi->setIconFile('Tests/FileThatDoesNotExist');
	}
}