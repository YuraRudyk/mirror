<?php

namespace Glacryl\Glshop\Domain\Repository;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Petro Dikij <petro.dikij@glacryl.de>, Glacryl Hedel GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * The repository for Requests
 */
class BereichRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * Initialize the repository
	 *
	 * @return void
	 */
	public function initializeObject() {
		$querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		$querySettings->setRespectStoragePage(FALSE);
		$this->setDefaultQuerySettings($querySettings);
	}

	/*public function getPriceFactorByGroup($group) {
		$array = array();
		$query = $this->createQuery();

		$prices = $query->execute();
		
		if(intval($group) == 4){
			$group = 2;
		}

		foreach ($prices as $price) {

			if (intval($price->getFeGroup()) == intval($group)) {
				array_push($array, array(
					"uid" => $price->getUid(),
					"pid" => $price->getPid(),
					"from" => $price->getFromEk(),
					"to" => $price->getToEk(),
					"factor" => $price->getFactor(),
					"group" => $price->getFeGroup()
				));
			}
		}
		return $array;
	}*/

	public function debugTypo($data) {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
	}

}
