<?php
namespace TASoft\MenuSystem\Menu\Factory\Target;

interface TargetGeneratorInterface {
	
	public function generateTargetWithString(string $string, &$type = 'rel'): string;
	
}