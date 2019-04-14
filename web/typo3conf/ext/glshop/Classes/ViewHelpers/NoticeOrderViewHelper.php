<?php

namespace Glacryl\Glshop\ViewHelpers;

Class NoticeOrderViewHelper Extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	protected $escapeOutput = false;

	public function initializeArguments()
    {
        $this->registerArgument('order', 'object', '');
    }

	/**
	 * @return string
	 */
	public function render() {
        $order = $this->arguments['order'];

		$bemerkungen = unserialize($order->getComment());
		$html = '';
		
		if ($bemerkungen['versand']['art'] == '') {
			$html .= '<p><b>Lieferart:</b> Selbstabholung</p>';
		} else {
			$html .= '<p><b>Lieferart:</b> Versand</p>';
		}

		$html .= '<p><b>Zahlungsart:</b> ' . $bemerkungen['zahlung']['art'] . '</p>';
		
		if ($bemerkungen['bemerkung']['kommission'] != '') {
			$html .= '<p><b>Kommission:</b> ' . $bemerkungen['bemerkung']['kommission'] . '</p>';
		}
		if ($bemerkungen['bemerkung']['bemerkung'] != '') {
			$html .= '<p><b>Bemerkung:</b> ' . $bemerkungen['bemerkung']['bemerkung'] . '</p>';
		}

		return $html;
	}

	public function debugTypo($data) {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
	}

}

?>
