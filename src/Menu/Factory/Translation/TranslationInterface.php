<?php
namespace TASoft\MenuSystem\Menu\Factory\Translation;

interface TranslationInterface {
	
	/**
	*	key is the value of attribute lang="" and the value of the array is the content of the title element.
	*/
	public function translatedStringFromTitleList(array $titles, string $defaultTitle): string;
	
}