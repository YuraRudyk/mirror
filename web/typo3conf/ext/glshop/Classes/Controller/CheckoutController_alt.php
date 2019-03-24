<?php

namespace Glacryl\Glshop\Controller;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Petro Dikij <petro.dikij@gmx.de>, Glacryl Hedel GmbH
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

class CheckoutController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	protected $debugMode = false;

	/**
	 * CartRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\CartRepository
	 * @inject
	 */
	protected $cartRepository;

	/**
	 * MaterialRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\MaterialRepository
	 * @inject
	 */
	protected $materialRepository;

	/**
	 * DrillRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\DrillRepository
	 * @inject
	 */
	protected $drillRepository;

	/**
	 * BordereditingRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\BordereditingRepository
	 * @inject
	 */
	protected $bordereditingRepository;

	/**
	 * CornereditingRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\CornereditingRepository
	 * @inject
	 */
	protected $cornereditingRepository;

	/**
	 * FixingRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\FixingRepository
	 * @inject
	 */
	protected $fixingRepository;

	/**
	 * CustomerRepository
	 * 
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\CustomerRepository
	 * @inject
	 */
	protected $customerRepository;

	/**
	 * ShippingaddressRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\ShippingaddressRepository
	 * @inject
	 */
	protected $shippingaddressRepository;
	
		/**
	 * ProduktartRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\ProduktartRepository
	 * @inject
	 */
	protected $produktartRepository = NULL;

	/**
	 * RahmenproduktRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\RahmenproduktRepository
	 * @inject
	 */
	protected $rahmenproduktRepository = NULL;

	/**
	 * RahmenproduktvarianteRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\RahmenproduktvarianteRepository
	 * @inject
	 */
	protected $rahmenproduktvarianteRepository = NULL;

	/**
	 * Material
	 * 
	 */
	protected $material;

	/**
	 * Kanten
	 * 
	 */
	protected $kanten;

	/**
	 * Ecken
	 * 
	 */
	protected $ecken;

	/**
	 * Bohrungen
	 * 
	 */
	protected $bohrungen;

	/**
	 * Halter
	 * 
	 */
	protected $halter;
	
	/**
	 * Produktart
	 * 
	 */
	protected $produktart;

	/**
	 * Rahmen
	 * 
	 */
	protected $rahmen;

	/**
	 * Rahmenvariante
	 * 
	 */
	protected $rahmenVarianten;

	/**
	 * CartItems
	 * 
	 */
	protected $cartItems;

	/**
	 * PriceController
	 *
	 * @var \Glacryl\Glshop\Controller\PriceController
	 * @inject
	 */
	protected $priceController;

	/**
	 * action index
	 *
	 * @return void
	 */
	public function indexAction() {
		$sess_id = $GLOBALS['TSFE']->fe_user->user['ses_id'];
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];

		if (intval($userId) == 1) {
			$this->debugMode = false;
		}

		$user = $this->customerRepository->findByUid($userId);
		$lieferadressen = $this->shippingaddressRepository->findByUser($userId);

		$this->material = $this->materialRepository->findAll();
		$this->kanten = $this->bordereditingRepository->findAll();
		$this->ecken = $this->cornereditingRepository->findAll();
		$this->bohrungen = $this->drillRepository->findAll();
		$this->halter = $this->fixingRepository->findAll();
		
		$this->produktart = $this->produktartRepository->findAll();
		$this->rahmen = $this->rahmenproduktRepository->findAll();
		$this->rahmenVarianten = $this->rahmenproduktvarianteRepository->findAll();

		$this->cartItems = $this->cartRepository->getCurrentCartItems($userId, $sess_id);

		$preise = $this->calculatePrices($this->cartItems);

		for ($i = 0; $i < count($this->cartItems); $i++) {
			$this->cartItems[$i]->setArticle(unserialize($this->cartItems[$i]->getArticle()));
		}

		$this->view->assign('user', $user);
		$this->view->assign('userGroup', $user->getUsergroup()->current()->getUid());
		$this->view->assign('lieferadressen', $lieferadressen);

		$this->view->assign('cartItems', $this->cartItems);
		$this->view->assign('material', $this->material);
		$this->view->assign('kanten', $this->kanten);
		$this->view->assign('ecken', $this->ecken);
		$this->view->assign('bohrungen', $this->bohrungen);
		$this->view->assign('halter', $this->halter);
		$this->view->assign('prices', $preise);
		$this->view->assign('produktart', $this->produktart);
		$this->view->assign('rahmen', $this->rahmen);
		$this->view->assign('rahmenVarianten', $this->rahmenVarianten);

		$this->view->assign('shipping', $this->priceController->calculateShipping($this->cartItems, $user));
	}

	public function calculatePrices($cartItems) {

		$this->priceController->init($cartItems);

		$prices = array(
			'positionen' => array(),
			'netto' => 0,
			'versand' => 0,
			'mwst' => 0,
			'brutto' => 0,
			'zwischen' => 0,
			'ewPalette' => $this->priceController->getEwPalette(),
			'rabatt' => $this->priceController->getRabatt()
		);

		foreach ($cartItems as $cartItem) {
			$positionSum = floatval($cartItem->getPrice()) * floatval($cartItem->getQty());
			array_push($prices['positionen'], array('positionNr' => $cartItem->getPosition(), 'stk' => $cartItem->getPrice(), 'summe' => $positionSum));
			$prices['netto'] += $positionSum;
		}

		$prices['zwischen'] = $prices['netto'] - $prices['rabatt'] + $prices['ewPalette'] + $prices['versand'];
		$prices['mwst'] = round(($prices['zwischen']) * 0.19, 2);
		$prices['brutto'] = $prices['zwischen'] + $prices['mwst'];

		return $prices;
	}

	public function debugTypo($data, $name, $print = false) {
		if (($this->debugMode) || ($print)) {
			\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data, $name);
		}
	}

}

?>