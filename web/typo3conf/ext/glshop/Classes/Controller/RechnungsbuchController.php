<?php

namespace Glacryl\Glshop\Controller;

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
 * ProductController
 */
class RechnungsbuchController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	protected $debugMode = false;

	/**
	 * rechnungsbuchRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\RechnungsbuchRepository
	 * @inject
	 */
	protected $rechnungsbuchRepository = NULL;

	/**
	 * CustomerRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\CustomerRepository
	 * @inject
	 */
	protected $customerRepository = NULL;
	
	public function indexAction() {
		$rechnungsbuch = $this->rechnungsbuchRepository->findAll();
		$customers = $this->customerRepository->findAll();

		$this->view->assign('customers', $customers);
		$this->view->assign('rechnungsbuch', $rechnungsbuch);
	}

	public function setDebugMode($on) {
		$this->debugMode = $on;
	}

	public function debugTypo($data, $name, $print) {
		if (($this->debugMode) || $print) {
			\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data, $name);
		}
	}

}