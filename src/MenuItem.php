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
namespace TASoft\MenuSystem;

/**
 * MenuItem is an instantiable class of AbstractMenuItem.
 * It also implements separator menu items.
 */
class MenuItem extends MenuItem\AbstractMenuItem {
	private $isSeparator = false;
	private $iconFile;
	
	/**
	* Generally, a menu item can hold a representing object.
	* @type mixed
	*/
	public $representedObject;
	
	/**
	* Creates an instance of a separator item.
	*/
	public static function separatorItem() {
		$mi = new static();
		$mi->isSeparator = true;
		return $mi;
	}
	
	/**
	*	Returns true whether an item is a separator
	*	@return bool
	*/
	public function isSeparatorItem() {
		return $this->isSeparator;
	}
	
	/**
	* @inheritDoc
	*/
	public function setTitle(string $string) {
		if($this->isSeparator)
			throw new Exception("Separator item can not set title");
		parent::setTitle($string);
	}
	
	/**
	* @inheritDoc
	*/
	public function setAction($string) {
		if($this->isSeparator)
			throw new Exception("Separator item can not set action");
		parent::setAction($string);
	}
	
	/**
	* @inheritDoc
	*/
	public function setSelected(bool $flag) {
		if($this->isSeparator)
			throw new Exception("Separator item can not set action");
		parent::setSelected($flag);
	}
	
	/**
	* @inheritDoc
	*/
	public function setIconFile(string $file) {
		if(!is_file($file))
			throw new Exception("File `$file` does not exist");
		$this->iconFile = $file;
	}
	
	/**
	* @inheritDoc
	*/
	public function setSidemenu(Menu\MenuInterface $menu = NULL) {
		if($this->isSeparator)
			throw new Exception("Separator item must not contain a sidemenu");
		parent::setSidemenu($menu);
	}
	
	/**
	* @inheritDoc
	*/
	public function setSubmenu(Menu\MenuInterface $menu = NULL) {
		if($this->isSeparator)
			throw new Exception("Separator item must not contain a submenu");
		
		parent::setSubmenu($menu);
	}
	
	/**
	* @inheritDoc
	*/
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