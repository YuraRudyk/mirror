<?php

namespace Glacryl\Glshop\ViewHelpers;

Class TimdataViewHelper Extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('user', 'object', '');
        $this->registerArgument('confirmation', 'object', '');
    }

	/**
	 * @return string
	 */
	Public Function render() {
        $user = $this->arguments['user'];
        $confirmation = $this->arguments['confirmation'];

		$html = '';
		if (isset($confirmation)) {
			foreach ($confirmation as $conf) {
				$html .= '<button class="glButton btn showTimDataBtn">Daten f&uuml;r TIM</button>';
				$html .= '<div class="show-tim-data-area" style="background-color: rgba(235,235,235,0.4);padding: 12px;display:none;">';
				$html .= 'Auftrag;I' . $conf->getUid() . ';I' . $conf->getUid() . ';' . $user->getCompany() . ';' . $user->getAdress() . ';' . $user->getZip() . ';' . $user->getCity() . ';' . $user->getUid() . ';Shop';
				$html .= '</div>';
			}
		}

		return $html;
	}

	public function debugTypo($data) {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
	}

}

?>
