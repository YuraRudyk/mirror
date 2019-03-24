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
 * CartController
 */
class CartController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	protected $debugMode = false;

	/**
	 * ShopRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\ShopRepository
	 * @inject
	 */
	protected $shopRepository;

	/**
	 * PriceRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\PriceRepository
	 * @inject
	 */
	protected $priceRepository;

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
	 * PriceController
	 *
	 * @var \Glacryl\Glshop\Controller\PriceController
	 * @inject
	 */
	protected $priceController;

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
	 * action index
	 *
	 * @return void
	 */
	public function indexAction() {
		$sess_id = $GLOBALS['TSFE']->fe_user->user['ses_id'];
		$user_id = $GLOBALS['TSFE']->fe_user->user['uid'];


		if (intval($user_id) == 1) {
			$this->debugMode = false;
		}


		$args = $this->request->getArguments();

		$this->debugTypo($args, 'Anfrage: ');

		$this->iniShopData();

		if ($args['qty'] > 9999) {
			$args['qty'] = 9999;
		} else if ($args['qty'] < 1) {
			$args['qty'] = 1;
		}

		if ($args['positionAction'] == 'update') {
			$this->updatePosition($args['positionNr'], $args['qty'], $sess_id, $user_id);
		} else if ($args['positionAction'] == 'delete') {
			$this->deletePosition($args['positionNr'], $sess_id, $user_id);
		}

		$cartItems = $this->cartRepository->getCurrentCartItems($user_id, $sess_id);

		$this->calculatePositionPrices($cartItems);

		$preise = $this->calculatePrices($cartItems);

		for ($i = 0; $i < count($cartItems); $i++) {
			$cartItems[$i]->setArticle(unserialize($cartItems[$i]->getArticle()));
		}

		$this->debugTypo($preise, 'Preise');

		$this->view->assign('cartItems', $cartItems);
		$this->view->assign('material', $this->material);
		$this->view->assign('kanten', $this->kanten);
		$this->view->assign('ecken', $this->ecken);
		$this->view->assign('bohrungen', $this->bohrungen);
		$this->view->assign('halter', $this->halter);
		$this->view->assign('prices', $preise);
		$this->view->assign('produktart', $this->produktart);
		$this->view->assign('rahmen', $this->rahmen);
		$this->view->assign('rahmenVarianten', $this->rahmenVarianten);

		$this->view->assign('sess', $sess_id);
	}

	/**
	 * action index
	 *
	 * @return void
	 */
	public function clearCartAction() {
		$sess_id = $GLOBALS['TSFE']->fe_user->user['ses_id'];
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];

		if (intval($userId) == 1) {
			$this->debugMode = false;
		}

		$cartItems = $this->cartRepository->getCurrentCartItems($userId, $sess_id);

		foreach ($cartItems as $cartItem) {
			$this->cartRepository->deleteCart($cartItem);
		}

		$this->redirect('index');
	}

	public function iniShopData() {
		$this->material = $this->materialRepository->findAll();
		$this->kanten = $this->bordereditingRepository->findAll();
		$this->ecken = $this->cornereditingRepository->findAll();
		$this->bohrungen = $this->drillRepository->findAll();
		$this->halter = $this->fixingRepository->findAll();

		$this->produktart = $this->produktartRepository->findAll();
		$this->rahmen = $this->rahmenproduktRepository->findAll();
		$this->rahmenVarianten = $this->rahmenproduktvarianteRepository->findAll();

		/* $this->debugTypo($this->material, 'Material');
		  $this->debugTypo($this->kanten, 'Kanten');
		  $this->debugTypo($this->ecken, 'Ecken');
		  $this->debugTypo($this->bohrungen, 'Bohrungen');
		  $this->debugTypo($this->halter, 'Halter'); */
	}

	public function updatePosition($posNr, $qty, $sess_id, $user_id) {
		$changedCart = null;
		$cartItems = $this->cartRepository->getCurrentCartItems($user_id, $sess_id);

		$this->debugTypo($cartItems, 'Update Cart Items:');

		foreach ($cartItems as $cartItem) {
			if ($cartItem->getPosition() == $posNr) {
				$article = unserialize($cartItem->getArticle());
				if (isset($article['material'])) {
					$article['materialConfig']['qty'] = $qty;
				}
				$newArticle = serialize($article);
				$cartItem->setQty($qty);
				$cartItem->setArticle($newArticle);
				$cartItem->setNotice(0);
				$changedCart = $this->cartRepository->updateCart($cartItem);
			}
		}

		$this->debugTypo($changedCart, 'Aktualisierte Position: ');

		return true;
	}

	public function deletePosition($posNr, $sess_id, $user_id) {
		$cartItems = $this->cartRepository->getCurrentCartItems($user_id, $sess_id);

		foreach ($cartItems as $cartItem) {
			if ($cartItem->getPosition() == $posNr) {
				$this->cartRepository->deleteCart($cartItem);
			}
		}
		$this->refactorPositionNumber($user_id, $sess_id);
		return true;
	}

	public function refactorPositionNumber($user_id, $sess_id) {
		$cartItems = $this->cartRepository->getCurrentCartItems($user_id, $sess_id);

		for ($i = 0; $i < count($cartItems); $i++) {
			$newPosNumber = $i + 1;
			$cartItems[$i]->setPosition($newPosNumber);
			$this->cartRepository->updateCart($cartItems[$i]);
		}


		$this->debugTypo($cartItems, 'Cart Items nach Löschen');
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

	public function calculatePositionPrices($cartItems) {

		//$this->priceController->setDebugMode(true); 
		$this->priceController->init($cartItems);
		$prices = $this->priceController->getPrices();

		$this->debugTypo($prices, 'Preise nach der neuen Kalkulation');

		foreach ($cartItems as $cartItem) {
			$newPrice = 0;
			foreach ($prices as $uid => $price) {
				if ($cartItem->getUid() == $uid) {
					$newPrice = $price;
				}
			}
			if ($cartItem->getNotice() != 1) {
				$cartItem->setPrice($newPrice);
				$this->cartRepository->updateCart($cartItem);
			}
		}
	}

	public function debugTypo($data, $name) {
		if ($this->debugMode) {
			\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data, $name);
		}
	}

	public function debugT($data, $name) {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data, $name);
	}

}
