<?php

namespace Glacryl\Glshop\ViewHelpers;

Class RahmeninnenmassViewHelper Extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    public function initializeArguments()
    {
        $this->registerArgument('w', 'float', '');
        $this->registerArgument('h', 'float', '');
        $this->registerArgument('b', 'float', '');
    }

	/**
	 * @return string
	 */
	Public Function render() {
        $w = $this->arguments['w'];
        $h = $this->arguments['h'];
        $b = $this->arguments['b'];

		$w = floatval($w);
		$h = floatval($h);
		$b = floatval($b);
		
		return ($w - 2 * $b) . ' x ' . ($h - 2 * $b) . ' mm';
	}

	
	public function debugTypo($data) {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
	}
}

?>
