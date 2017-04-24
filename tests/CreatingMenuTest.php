<?php
use PHPUnit\Framework\TestCase;

use TASoft\MenuSystem as MS;
use TASoft\MenuSystem\Menu\Factory as FA;

class CreatingMenuTest extends TestCase {
	public function testXMLFileCreation() {
		$f = new MS\Menu\Factory\MenuFromXML('tests/XML/TestMenu.xml');
		$menu = $f->getMenu();
		
		$this->assertCount(1, $menu->getItemArray());
		$this->assertEquals('A title', $menu->itemAtIndex(0)->getTitle());
		
		$this->assertEquals('https://www.tasoft.ch/', $menu->itemAtIndex(0)->getAction());
		$this->assertEquals('current/MSMenuSystem.php', $menu->itemAtIndex(0)->getIconFile());
	}
	
	public function testXMLFileCreationWithSubmenus() {
		$f = new MS\Menu\Factory\MenuFromXML('tests/XML/TestMenuWithSubmenu.xml');
		$menu = $f->getMenu();
		
		$mi = $menu->itemAtIndex(1);
		$this->assertTrue($mi->hasSubmenu());
		
		$me = $mi->getSubmenu();
		$this->assertEquals("Test Submenu", $me->itemAtIndex(0)->getTitle());
		
		$this->assertEquals($menu, $mi->getMenu());
	}
	
	public function testXMLMenuCreationWithTranslator() {
		$f = new MS\Menu\Factory\MenuFromXML('tests/XML/TestMenu.xml');
		$f->setTranslator(new class implements FA\Translation\TranslationInterface {
			public function translatedStringFromTitleList(array $titles, string $defaultTitle): string {
				return $titles['de'] ?? $defaultTitle;
			}
		});
		$menu = $f->getMenu();
		$this->assertEquals('Mein Titel', $menu->itemAtIndex(0)->getTitle());
	}
	
	public function testXMLMenuCreationWithSelection() {
		$f = new MS\Menu\Factory\MenuFromXML('tests/XML/TestMenu.xml');
		
		$f->setSelector(new class implements FA\Selection\SelectionInterface {
			public function shouldSelectMenuItem(MS\MenuItem\MenuItemInterface $item): bool {
				return $item->tag == 15 ? true : false;
			}
		});
		
		$menu = $f->getMenu();
		$this->assertTrue($menu->itemAtIndex(0)->isSelected());
	}
	
	public function testXMLMenuCreationSelectorFromURL() {
		$f = new MS\Menu\Factory\MenuFromXML('tests/XML/TestMenuWithSubmenu.xml');
		$urlSel = new FA\Selection\IDPathSelector();
		$urlSel->setIDPath("test-2/other-test");
		$f->setSelector($urlSel);
		
		$menu = $f->getMenu();
		$mi = $menu->itemAtIndex(1);
		$this->assertTrue($mi->isSelected());
		
		$me = $mi->getSubmenu();
		$mi = $me->itemAtIndex(0);
		$this->assertTrue($mi->isSelected());
	}
	
	public function testMenuCreationEnabling() {
		$f = new MS\Menu\Factory\MenuFromXML('tests/XML/TestMenuWithSubmenu.xml');
		
		$f->setPolicy(new class implements MS\Menu\Factory\Policy\PolicyInterface {
			public function shouldEnableMenuItem(MS\MenuItem\MenuItemInterface $item): bool {
				if($item->tag == 16)
					return false;
				return true;
			}
			
			public function shouldShowMenuItem(MS\MenuItem\MenuItemInterface $item): bool {
				if($item->tag == 32)
					return false;
				return true;
			}
		});
		
		$menu = $f->getMenu();
		$this->assertTrue($menu->itemAtIndex(0)->enabled);
		$this->assertFalse($menu->itemAtIndex(1)->enabled);
		
		$this->assertFalse($menu->itemAtIndex(1)->hidden);
		
		$this->assertTrue($menu->itemAtIndex(1)->getSubmenu()->itemAtIndex(0)->hidden);
	}
}