<?php

namespace Glacryl\Glshop\ViewHelpers;

Class CartViewHelper Extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	public function initializeArguments()
    {
        $this->registerArgument('obj', 'array', '');
        $this->registerArgument('dbData', 'array', '');
        $this->registerArgument('halterV', 'object', '');
        $this->registerArgument('halter', 'bool', '');
        $this->registerArgument('dicke', 'bool', '');
    }

	/**
	 * @return string
	 */
	Public Function render() {

		$obj = $this->arguments['obj'];
        $dbData = $this->arguments['dbData'];
        $halterV = $this->arguments['halterV'];
        $halter = $this->arguments['halter'];
        $dicke = $this->arguments['dicke'];

		if ($halter) {
			return $this->getHalter($obj, $dbData);
		} else if($dicke){
			return $this->getMaterialDicke($halterV);
		}
		
		return '';
	}
	
	public function getMaterialDicke($halter){
		$passtFuer = '';
			if ($halter->getSandwitch() != 1) {
				if (($halter->getFromSize() == -1) && ($halter->getToSize() == -1)) {
					$passtFuer = 'variabel';
				} else {
					$passtFuer = 'von ' . ($halter->getFromSize() == -1 ? 'variabel' : $halter->getFromSize() . ' mm') . ' bis ' . ($halter->getToSize() == -1 ? 'variabel' : $halter->getToSize() . ' mm');
				}
			} else {
				$passtFuer = '2 x ' . $halter->getFromSize() . ' mm';
			}
		return $passtFuer;
	}

	public function getHalter($obj, $halter) {
		$html = '';
		$html .= '<dl class="cart-detail-dl">';
		$html .= '<dt class="cart-detail-header">Befestigung</dt>';
		
		$mHalter = array();
		for ($j = 0; $j < count($obj); $j++) {
			foreach ($halter as $h){
				if ($h->getUid() == $obj[$j]['hid']) {
					$varianten = $h->getFixingoption();
					foreach($varianten as $v){
						if ($v->getUid() == $obj[$j]['vid']) {
							if (!array_key_exists($v->getArticleNr(), $mHalter)) {
								$mHalter[$v->getArticleNr()] = array(
									'qty' => 1,
									'halter' => $v
								);
							} else {
								$mHalter[$v->getArticleNr()]['qty'] = $mHalter[$v->getArticleNr()]['qty'] + 1;
							}
						}
					}
				}
			}
		}

		$countMHalter = count($mHalter);
		foreach ($mHalter as $art => $data) {
			$html .= '<dd class="cart-detail-dd" style="margin-bottom:6px !important;">';
			$html .= '<span><b>' . $data['qty'] . ' Stück ' . $data['halter']->getName() . ':</b></span><br />';
			$html .= '<span style="width:24px;"></span><span><b>Art.Nr.:</b> ' . $data['halter']->getArticleNr() . '</span><br />';
			$html .= '</dd>';
		}
		$html .= '</dl>';
		return $html;
	}

	public function debugTypo($data) {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
	}

}

?>
