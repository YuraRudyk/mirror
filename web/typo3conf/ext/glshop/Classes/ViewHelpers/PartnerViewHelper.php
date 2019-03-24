<?php

namespace Glacryl\Glshop\ViewHelpers;

Class PartnerViewHelper Extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    public function initializeArguments()
    {
        $this->registerArgument('userId', 'integer', '');
        $this->registerArgument('allePartner', 'array', '');
    }

	/**
	 * @return string
	 */
	Public Function render() {
        $userId = $this->arguments['userId'];
        $allePartner = $this->arguments['allePartner'];

		foreach ($allePartner as $partner) {
			if ($partner->isBestaetigt() && ($partner->getKunde() == $userId)) {
				return 'Werbeland; ' . $partner->getPartnernummer();
			}
		}

		return 'Nein';
	}

	public function debugTypo($data) {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
	}

}

?>
