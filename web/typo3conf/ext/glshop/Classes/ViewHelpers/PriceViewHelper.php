<?php

namespace Glacryl\Glshop\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

Class PriceViewHelper Extends AbstractViewHelper {

    public function initializeArguments()
    {
        $this->registerArgument('price', 'float', '');
        $this->registerArgument('tempern', 'bool', '');
    }
	/**
	 * @return string
	 */
	public function render() {
        $price = $this->arguments['price'];
        $tempern = $this->arguments['tempern'];

		if ($price) {
            $p = floatval($price);
            if(!$tempern){
                return '<span>' . number_format(round($p, 2), 2, ',', '.') . '</span> &euro;';
            } else {
                return number_format(round($p, 2), 2, ',', '.') . '&euro;';
            }
		}
		return '';
	}
}

