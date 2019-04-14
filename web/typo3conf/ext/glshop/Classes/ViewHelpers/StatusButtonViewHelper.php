<?php

namespace Glacryl\Glshop\ViewHelpers;

Class StatusButtonViewHelper Extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	protected $debugMode = true;
	protected $escapeOutput = false;


	public function initializeArguments()
    {
        $this->registerArgument('states', 'object', '');
        $this->registerArgument('order', 'object', '');
    }

	/**
	 * @return string
	 */
	public function render() {
        $states = $this->arguments['states'];
        $order = $this->arguments['order'];

		$html = '';
		$html .= '<div class="btn-group">';
		$btnColor = '';
		$btnTitle = '';
		$orderId = $order->getUid();

		foreach ($order->getOrderstatus() as $status) {
			if ($status->getOrderstate()->getValue() == 0) {
				$btnColor = 'btn-danger';
				$btnTitle = $status->getOrderstate()->getName();
			} else if ($status->getOrderstate()->getValue() == 1) {
				$btnColor = 'btn-default';
				$btnTitle = $status->getOrderstate()->getName();
			} else if ($status->getOrderstate()->getValue() == 2) {
				$btnColor = 'btn-primary';
				$btnTitle = $status->getOrderstate()->getName();
			} else if ($status->getOrderstate()->getValue() == 3) {
				$btnColor = 'btn-warning';
				$btnTitle = $status->getOrderstate()->getName();
			} else if ($status->getOrderstate()->getValue() == 4) {
				$btnColor = 'btn-info';
				$btnTitle = $status->getOrderstate()->getName();
			} else if ($status->getOrderstate()->getValue() == 5) {
				$btnColor = 'btn-success';
				$btnTitle = $status->getOrderstate()->getName();
			}
		}
		$html .= '<button type="button" title="' . $btnTitle . '" class="btn ' . $btnColor . ' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';

		$html .= 'Aktionen <span class="caret"></span>';
		$html .= '</button>';
		$html .= '<ul class="dropdown-menu">';
		$htmlLast = '';

		//$this->debugTypo($order, 'Bestellung');
		//$this->debugTypo($states, 'States');

		foreach ($states as $state) {
//			debug($state->getLabel());
			$statusColor = 'style="background-color:#ffffff;"';
			
			foreach ($order->getOrderstatus() as $status) {
				if ($status->getOrderstate()->getUid() == $state->getUid()) {
					$statusColor = 'style="background-color:rgba(155,255,196,0.8);"';		
				}
			}

			if ($state->getValue() != 0) {
				if ($state->getValue() != 1) {
					$html .= '<li ' . $statusColor . '><a href="#" class="' . $state->getAcr() . 'Button">' . $state->getLabel() . '<span style="display:none;">' . $orderId . '</span></a></li>';
				}
			} else {
				$htmlLast .= '<li role="separator" class="divider"></li>';
				$htmlLast .= '<li ' . $statusColor . '><a href="#" class="' . $state->getAcr() . 'Button">' . $state->getLabel() . '<span style="display:none;">' . $orderId . '</span></a></li>';
			}


		}
		$html .= '<li><a href="#" class="dxfButton">DXF Zeichnung<span style="display:none;">' . $orderId . '</span></a></li>';
		$html .= $htmlLast;
		$html .= '</ul>';
		$html .= '</div>';
		return $html;
	}

	public function debugTypo($data, $name) {
		if ($this->debugMode) {
			\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data, $name);
		}
	}

}

?>
