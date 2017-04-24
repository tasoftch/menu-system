<?php
namespace TASoft\MenuSystem\MenuItem;

use TASoft\MenuSystem as MS;

abstract class AbstractMenuItem implements MenuItemInterface {
	private $title;
	private $action;
	private $selected = false;
	private $id;
	
	private $menu;
	private $submenu, $sidemenu;
	
	public $tag;
	public $hidden = false;
	public $enabled = true;
	
	public function setSubmenu(MS\Menu\MenuInterface $menu = NULL) {
		$this->_maintainConsistencyOfSubmenu($this->submenu, $menu);
		$this->submenu = $menu;
	}
	public function getSubmenu(): ?MS\Menu\MenuInterface {
		return $this->submenu;
	}
	public function hasSubmenu(): bool {
		return $this->submenu instanceof MS\Menu\MenuInterface ? true : false;
	}
	
	public function setSidemenu(MS\Menu\MenuInterface $menu = NULL) {
		$this->_maintainConsistencyOfSubmenu($this->sidemenu, $menu);
		$this->sidemenu = $menu;
	}
	public function getSidemenu(): ?MS\Menu\MenuInterface {
		return $this->sidemenu;
	}
	public function hasSidemenu(): bool {
		return $this->sidemenu instanceof MS\Menu\MenuInterface ? true : false;
	}
	
	public function getTitle(): string {
		return $this->title;
	}
	public function setTitle(string $string) {
		$this->title = $string;
	}
	
	public function getID(): string {
		if(!$this->id)
			$this->id = uniqid();
		return $this->id;
	}
	
	public function setID(string $id) {
		$this->id = $id;
	}
	
	public function getAction() {
		return $this->action;
	}
	public function setAction($action) {
		$this->action = $action;
	}
	
	public function isSelected(): bool {
		return $this->selected;
	}
	
	public function setSelected(bool $flag) {
		$this->selected = $flag;
	}
	
	public function __construct($title="", $action="#", $selected = false) {
		$this->title = $title;
		$this->action = $action;
		$this->selected = $selected;
	}
	
	public function setMenu(MS\Menu\MenuInterface $menu = NULL) {
		$this->menu = $menu;
	}
	public function getMenu(): ?MS\Menu\MenuInterface {
		return $this->menu;
	}
	
	
	
	private function _maintainConsistencyOfSubmenu($oldMenu, $newMenu) {
		if($newMenu && !is_null($newMenu->getMenuItem()))
			throw new \TASoft\MenuSystem\ConsistencyException(sprintf("Menu %s already has a menu item", $newMenu->getName()));
		
		if($oldMenu) {
			$oldMenu->setMenuItem(NULL);
		}
		if($newMenu) {
			$newMenu->setMenuItem($this);
		}
	}
}