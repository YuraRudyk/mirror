<?php

namespace Glacryl\Glshop\ViewHelpers;

Class UserGroupViewHelper Extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * 
	 * @return string
	 */
	Public Function render() {
		
		$group = intval($GLOBALS['TSFE']->fe_user->user['usergroup']);
		
		return ''. $group;
	}

	
	public function debugTypo($data) {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
	}
}

?>
