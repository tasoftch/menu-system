<?php
namespace TASoft\MenuSystem\Menu\Factory;
use TASoft\MenuSystem\MenuItem\MenuItemInterface;

abstract class AbstractFactory implements FactoryInterface {
	private $policy;
	private $selector;
	private $translator;
	private $targetGenerator;
	
	public function getPolicy(): ?Policy\PolicyInterface {
		return $this->policy;
	}
	
	public function setPolicy(Policy\PolicyInterface $policy = NULL) {
		$this->policy = $policy;
	}
	
	public function getSelector(): ?Selection\SelectionInterface {
		return $this->selector;
	}
	
	public function setSelector(Selection\SelectionInterface $selector = NULL) {
		$this->selector = $selector;
	}
	
	public function setTranslator(Translation\TranslationInterface $translator = NULL) {
		$this->translator = $translator;
	}
	
	public function getTranslator(): ?Translation\TranslationInterface {
		return $this->translator;
	}
	
	public function setTargetGenerator(Target\TargetGeneratorInterface $gen = NULL) {
		$this->targetGenerator = $gen;
	}
	
	public function getTargetGenerator(): ?Target\TargetGeneratorInterface {
		return $this->targetGenerator;
	}
	
	
	
	protected function isItemSelected(MenuItemInterface $item) {
		if($this->selector)
			return $this->selector->shouldSelectMenuItem($item);
		return false;
	}
	
	protected function isItemEnabled(MenuItemInterface $item) {
		if($this->policy)
			return $this->policy->shouldEnableMenuItem($item);
		return true;
	}
	
	protected function isItemVisible(MenuItemInterface $item) {
		if($this->policy)
			return $this->policy->shouldShowMenuItem($item);
		return true;
	}
	
	protected function getLocalizedTitleFromList($list, $default) {
		if($this->translator)
			return $this->translator->translatedStringFromTitleList($list, $default);
			
		if(!$default)
			$default = array_shift($list);
		if(!$default)
			$default = '#Default!';
		return $default;
	}
}