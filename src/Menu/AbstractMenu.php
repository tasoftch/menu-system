<?php
/*
 * This file is part of MenuSystem
 *
 * @author Th. Abplanalp <info@tasoft.ch>
 * @copyright (c) 2017 by TASoft Applications, Th. Abplanalp
 * @package MenuSystem
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TASoft\MenuSystem\Menu;
use TASoft\MenuSystem\MenuItem\MenuItemInterface;

abstract class AbstractMenu implements MenuInterface {
	private $name;
	private $hidden = false;
	private $parentItem;
	private $itemArray = [];
	
	public function __construct(string $name, MenuItemInterface $parentItem = NULL) {
		$this->name = $name;
		$this->parentItem = $parentItem;
	}
	
	public function getName(): string {
		return $this->name;
	}
	
	public function setHidden(bool $flag) {
		$this->hidden = $flag;
	}
	public function isHidden(): bool {
		return $this->hidden;
	}
	
	public function getItemArray(): array {
		return $this->itemArray;
	}
	
	public function setMenuItem(MenuItemInterface $menuItem = NULL) {
		$this->parentItem = $menuItem;
	}
	
	public function getMenuItem(): ?MenuItemInterface {
		return $this->parentItem;
	}
	
	//! Getting Menu Items
	public function numberOfItems() {
		return count($this->itemArray);
	}
	
	public function itemAtIndex($index) {
		return $this->itemArray[$index];
	}
	
	public function itemWithTitle($title) {
		foreach($this->itemArray as $item) {
			if($item->getTitle() == $title)
				return $item;
		}
		return NULL;
	}
	
	public function itemWithTag($tag) {
		foreach($this->itemArray as $item) {
			if($item->tag == $tag)
				return $item;
		}
		return NULL;
	}
	
	// Getting indexes of items
	public function indexOfItem(MenuItemInterface $item) {
		return ($idx = array_search($item, $this->itemArray)) !== false ? $idx : -1;
	}
	
	public function indexOfItemWithTitle($title) {
		for($e=0;$e < $this->numberOfItems();$e++) {
			if($this->itemArray[$e]->getTitle() == $title)
				return $e;
		}
		return -1;
	}
	
	public function indexOfItemWithTag($tag) {
		for($e=0;$e < $this->numberOfItems();$e++) {
			if($this->itemArray[$e]->tag == $tag)
				return $e;
		}
		return -1;
	}
	
	//! Adding and Insenting Items
	public function addItem(MenuItemInterface $item) {
		$this->_maintainConsistencyOfItem($item);
		
		$this->itemArray[] = $item;
		return $this;
	}
	
	public function addItemWithTitle(string $title) {
		$item = new \TASoft\MenuSystem\MenuItem($title);
		$this->addItem($item);
	}
	
	public function insertItem(MenuItemInterface $item, int $index) {
		$this->_maintainConsistencyOfItem($item);
		
		$array1 = array_slice($this->itemArray, 0, $index);
		$array2 = array_slice($this->itemArray, $index);
		
		$array1[] = $item;
		
		$this->itemArray = array_merge($array1, $array2);
		return $this;
	}
	
	public function insertItemWithTitle(string $title, int $index) {
		$item = new \TASoft\MenuSystem\MenuItem($title);
		$this->insertItem($item, $index);
	}
	
	public function containsItem(MenuItemInterface $item): bool {
		return array_search($item, $this->itemArray) !== false ? true : false;
	}
	
	public function removeItem(MenuItemInterface $item) {
		if(($idx = array_search($item, $this->itemArray)) !== false) {
			$item->setMenu(NULL);
			array_splice($this->itemArray, $idx, 1);
		}
	}
	
	public function removeItemAtIndex(int $index) {
		$item = $this->itemAtIndex($index);
		if($item) {
			$item->setMenu(NULL);
			array_splice($this->itemArray, $index, 1);
		}
	}
	
	public function removeAllItems() {
		$this->itemArray = [];
	}
	
	
	
	
	private function _maintainConsistencyOfItem($newItem) {
		if($newItem) {
			if(!is_null($newItem->getMenu()))
				throw new \TASoft\MenuSystem\ConsistencyException(sprintf("Menu item %s already has a menu", $newItem->getTitle()));
			$newItem->setMenu($this);
		}
	}
}