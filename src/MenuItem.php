<?php
namespace TASoft\MenuSystem;

class MenuItem extends MenuItem\AbstractMenuItem {
	private $isSeparator = false;
	private $iconFile;
	
	public $representedObject;
	
	public static function separatorItem() {
		$mi = new static();
		$mi->isSeparator = true;
		return $mi;
	}
	
	public function isSeparatorItem() {
		return $this->isSeparator;
	}
	
	public function setTitle(string $string) {
		if($this->isSeparator)
			throw new Exception("Separator item can not set title");
		parent::setTitle($string);
	}
	
	public function setAction($string) {
		if($this->isSeparator)
			throw new Exception("Separator item can not set action");
		parent::setAction($string);
	}
	
	public function setSelected(bool $flag) {
		if($this->isSeparator)
			throw new Exception("Separator item can not set action");
		parent::setSelected($flag);
	}
	
	public function setIconFile(string $file) {
		if(!is_file($file))
			throw new Exception("File `$file` does not exist");
		$this->iconFile = $file;
	}
	
	public function setSidemenu(Menu\MenuInterface $menu = NULL) {
		if($this->isSeparator)
			throw new Exception("Separator item must not contain a sidemenu");
		parent::setSidemenu($menu);
	}
	
	public function setSubmenu(Menu\MenuInterface $menu = NULL) {
		if($this->isSeparator)
			throw new Exception("Separator item must not contain a submenu");
		
		parent::setSubmenu($menu);
	}
	
	public function getIconFile() {
		return $this->iconFile;
	}
	
	
	public function __debugInfo() {
		$data = [];
		if($this->isSeparatorItem()) {
			$data['Name'] = "-- SEPARATOR --";
		} else {
			$data['Name'] = $this->getTitle();
			$data['Action'] = $this->getAction();
			$data['Selected'] = $this->isSelected();
		}
		
		if(isset($this->submenu))
			$data['Submenu'] = $this->submenu;
		if(isset($this->sidemenu))
			$data['Sidemenu'] = $this->sidemenu;
		return $data;
	}
}