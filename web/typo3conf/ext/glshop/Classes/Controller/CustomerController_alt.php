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
 * CustomerController
 */
class CustomerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * CustomerRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\CustomerRepository
	 * @inject
	 */
	protected $customerRepository = NULL;

	/**
	 * ShippingaddressRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\ShippingaddressRepository
	 * @inject
	 */
	protected $shippingaddressRepository = NULL;

	/**
	 * OrderRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\OrderRepository
	 * @inject
	 */
	protected $orderRepository = NULL;

	/**
	 * NoticelistRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\NoticelistRepository
	 * @inject
	 */
	protected $noticelistRepository = NULL;

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
	 * action orders
	 * 
	 * @return void
	 */
	public function ordersAction() {
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];
		$orders = $this->orderRepository->findByUser($userId);

		$this->view->assign('orders', $orders);
	}

	/**
	 * action orders
	 * 
	 * @return void
	 */
	public function noticelistAction() {
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];
		$notices = $this->noticelistRepository->findByUser($userId);

		for ($i = 0; $i < count($notices); $i++) {
			$notices[$i]->setDetails(unserialize($notices[$i]->getDetails()));
			$notices[$i]->setArticle(unserialize($notices[$i]->getArticle()));
		}

		$this->iniShopData();

		$this->view->assign('material', $this->material);
		$this->view->assign('kanten', $this->kanten);
		$this->view->assign('ecken', $this->ecken);
		$this->view->assign('bohrungen', $this->bohrungen);
		$this->view->assign('halter', $this->halter);
		$this->view->assign('notices', $this->getListForView($notices));
	}

	public function getListForView($notices) {
		$data = array();

		foreach ($notices as $notice) {
			if (!isset($data[$notice->getNoticeName()])) {
				$data[$notice->getNoticeName()] = array(
					'name' => $notice->getNoticeName(),
					'details' => $notice->getDetails(),
					'ids' => '',
					'positionen' => array()
				);
			}
			array_push($data[$notice->getNoticeName()]['positionen'], $notice);
			if ($data[$notice->getNoticeName()]['ids'] != '') {
				$data[$notice->getNoticeName()]['ids'] .= '_';
			}
			$data[$notice->getNoticeName()]['ids'] .= $notice->getUid();
		}
		return $data;
	}

	public function iniShopData() {
		$this->material = $this->materialRepository->findAll();
		$this->kanten = $this->bordereditingRepository->findAll();
		$this->ecken = $this->cornereditingRepository->findAll();
		$this->bohrungen = $this->drillRepository->findAll();
		$this->halter = $this->fixingRepository->findAll();
	}

	/**
	 * action customerData
	 *
	 * @return void
	 */
	public function customerDataAction() {
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];

		$customer = $this->customerRepository->findByUid($userId);
		$this->view->assign('customer', $customer);
	}

	/**
	 * action adress
	 *
	 * @return void
	 */
	public function adressAction() {
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];

		$adresses = $this->shippingaddressRepository->findByUser($userId);

		$this->view->assign('adresses', $adresses);
	}

	/**
	 * action backend
	 *
	 * @return void
	 */
	public function backendAction() {
		$customers = $this->customerRepository->findAll();

		$this->view->assign('customers', $customers);
	}

	/**
	 * User Bearbeiten
	 * 
	 * @return array
	 */
	public function editUserFunction($user, $args) {

		if ($args['firma'] != null) {
			$user->setCompany($args['firma']);
		}
		if ($args['ustId'] != null) {
			$user->setUstId($args['ustId']);
		}
		if ($args['str'] != null) {
			$user->setAdress($args['str']);
		}
		if ($args['plz'] != null) {
			$user->setZip($args['plz']);
		}
		if ($args['ort'] != null) {
			$user->setCity($args['ort']);
		}
		if ($args['sex'] != null) {
			$user->setGender($args['sex']);
		}
		if ($args['name'] != null) {
			$user->setLastName($args['name']);
		}
		if ($args['vorname'] != null) {
			$user->setFirstName($args['vorname']);
		}
		if ($args['mail'] != null) {
			$user->setEmail($args['mail']);
		}
		if ($args['tel'] != null) {
			$user->setTelephone($args['tel']);
		}
		if ($args['fax'] != null) {
			$user->setFax($args['fax']);
		}

		$saved = $this->customerRepository->updateCustomer($user);

		$result = array(
			'firma' => $saved->getCompany(),
			'name' => $saved->getLastName(),
			'vorname' => $saved->getFirstName(),
			'ustId' => $saved->getUstId(),
			'sex' => $saved->getGender(),
			'str' => $saved->getAdress(),
			'plz' => $saved->getZip(),
			'ort' => $saved->getCity(),
			'mail' => $saved->getEmail(),
			'tel' => $saved->getTelephone(),
			'fax' => $saved->getFax()
		);

		return $result;
	}

	/**
	 * @param $data
	 */
	public function debugTypo($data) {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
	}

}
