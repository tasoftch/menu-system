<?php
namespace TASoft\MenuSystem\Menu\Factory;
use TASoft\MenuSystem as MS;
use TASoft\MenuSystem\Exception;

class MenuFromXML extends AbstractFactory {
	private $menu;
	private $DOM;
	private $filename;
	
	public function getMenu(): MS\Menu\MenuInterface {
		if(!$this->menu) {
			if(!$this->DOM)
				throw new Exception("Can not create menu. No XML document loaded");
			$this->menu = $this->readMenuFromXMLElement($this->DOM->documentElement, basename($this->filename));
			
			$this->validateMenu($this->menu);
			
		}
		return $this->menu;
	}
	
	
	public function validateMenu($menu) {
		foreach($menu->getItemArray() as $mi) {
			$mi->setSelected( $this->isItemSelected($mi) );
			$mi->hidden = !$this->isItemVisible($mi);
			$mi->enabled = $this->isItemEnabled($mi);
			
			if($mi->hasSubmenu())
				$this->validateMenu($mi->getSubmenu());
			if($mi->hasSidemenu())
				$this->validateMenu($mi->getSidemenu());	
		}
	}
	
	
	public function __construct($filename) {
		if(!is_file($filename))
			throw new Exception("Can not open file `%s`", basename($filename));
		$dom = new \DOMDocument();
		if(! @$dom->load($filename)) {
			$error = libxml_get_last_error();
			throw new Exception($error->code, $error->message);
		}
		
		$test = new \DOMDocument();
		$test->load(__DIR__ . '/menu-system.dtd');

		$test->encoding = $dom->encoding;
		$test->version = $dom->version;
		
		
		$root = $test->documentElement;
		foreach($dom->documentElement->childNodes as $ch) {
			$node = $test->importNode($ch, true);
			$root->appendChild($node);
		}
		
		libxml_use_internal_errors(true);
		if(@$test->validate()) {
			$this->DOM = $test;
			$this->filename = $filename;
		}
		else {
			$error = libxml_get_errors()[0];
			throw new Exception($error->code, $error->message);
		}
	}
	
	public function readMenuFromXMLElement($element, $name = 'Menu') {
		$class = $element->getAttribute('class') ?: MS\Menu::class;
		$menu = new $class( $name );
		
		foreach($element->getElementsByTagName('item') as $item) {
			$mi = $this->readMenuItemFromXMLElement($item);
			$menu->addItem($mi);
		}
		
		return $menu;
	}
	
	public function readMenuItemFromXMLElement($element) {
		$link = $element->getElementsByTagName('link')[0];

		if(!$link)
			throw new Exception("Can not load menu item in %s at line %d. Missing title link element", basename($this->filename), $element->getLineNo());
		
		$class = $element->getAttribute('class');
		$menuItem = new $class();
		
		$menuItem->setTitle( $this->getLocalizedTitleFromItemElement($element) );
		
		
		$link = $this->createLink($link->getAttribute('type'), $link->textContent);
		$menuItem->setAction($link);
		$menuItem->tag = ((int)$element->getAttribute('tag'));
		
		$id = $element->getAttribute('id');
		if($id)
			$menuItem->setID($id);
		
		$icon = $element->getElementsByTagName('icon')[0];
		if($icon) {
			$menuItem->setIconFile($this->createLink($icon->getAttribute('type'), $icon->textContent));
		}
		
		$submenu = $element->getElementsByTagName('submenu')[0];
		if($submenu) {
			if($submenu->getAttribute('type') == 'local') {
				$menu = $this->readMenuFromXMLElement($submenu, $menuItem->getTitle());
				$menuItem->setSubmenu($menu);
			}
		}
		
		
		return $menuItem;
	}
	
	public function createLink($type, $content) {
		if($type == 'rel') {
			$src = dirname($this->filename) . "/$content";
			$src = realpath($src);
			if(!$src)
				return "#unreachable";

			$tg = $_SERVER['DOCUMENT_ROOT'] ?: $_SERVER['PWD'];
			return getRelativePath($tg, $src);
		}
		
		if($type == 'abs')
			return $content;
	}
	
	public function getLocalizedTitleFromItemElement($element) {
		$titles = [];
		$title = "";
		foreach($element->getElementsByTagName('title') as $t) {
			$lang = $t->getAttribute('lang');
			$v = $t->textContent;
			if(!$lang) {
				$title = $v;
				continue;
			}
			
			$titles[$lang] = $v;
		}
		
		return $this->getLocalizedTitleFromList($titles, $title);
	}
}





function getRelativePath($from, $to)
{
    // some compatibility fixes for Windows paths
    $from = is_dir($from) ? rtrim($from, '\/') . '/' : $from;
    $to   = is_dir($to)   ? rtrim($to, '\/') . '/'   : $to;
    $from = str_replace('\\', '/', $from);
    $to   = str_replace('\\', '/', $to);

    $from     = explode('/', $from);
    $to       = explode('/', $to);
    $relPath  = $to;

    foreach($from as $depth => $dir) {
        // find first non-matching dir
        if($dir === @$to[$depth]) {
            // ignore this directory
            array_shift($relPath);
        } else {
            // get number of remaining dirs to $from
            $remaining = count($from) - $depth;
            if($remaining > 1) {
                // add traversals up to first matching dir
                $padLength = (count($relPath) + $remaining - 1) * -1;
                $relPath = array_pad($relPath, $padLength, '..');
                break;
            }
        }
    }
    return implode('/', $relPath);
}