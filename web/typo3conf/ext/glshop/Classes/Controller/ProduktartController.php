<?php

namespace Glacryl\Glshop\Controller;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Petro Dikij <petro.dikij@glacryl.de>, Glacryl Hedel GmbH
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
 * ProduktartController
 */
class ProduktartController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * produktartRepository
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
	 * ShopRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\ShopRepository
	 * @inject
	 */
	protected $shopRepository;

	/**
	 * Usergroup
	 * 
	 * @var int $userGroup Usergruppe
	 */
	protected $userGroup = 4;

	/**
	 * Faktor
	 * 
	 * @var int $faktor Faktor
	 */
	protected $faktor = 1;

	/**
	 * action getDataForRahmenKonfigurator
	 *
	 * @return array 
	 */
	public function getDataForRahmenKonfigurator() {

		$this->userGroup = intval($GLOBALS['TSFE']->fe_user->user['usergroup']);
		
		$faktor = $this->shopRepository->findByAKey('demoFactor');
		$this->faktor = intval($faktor->getFirst()->getAValue());

		$data = array(
			'profile' => $this->createKonfigDataArray('Rahmen'),
			'frontscheiben' => $this->createKonfigDataArray('Frontscheibe'),
			'streuplatten' => $this->createKonfigDataArray('Streuplatte'),
			'leds' => $this->createKonfigDataArray('LED'),
			'montage' => $this->createKonfigDataArray('Montage'),
			'anschluss' => $this->createKonfigDataArray('Anschluss'),
			'rueckwand' => $this->createKonfigDataArray('Rueckwand'),
			'zubehoer' => $this->createKonfigDataArray('Zubehoer')
		);

		//$this->debugTypo($data, 'Rahmenkonfig Datens:');

		return $data;
	}

	public function createKonfigDataArray($produktArt) {
		$data = $this->produktartRepository->findByName($produktArt)->getFirst()->getProdukt();

		$arr = array();
		foreach ($data as $prod) {
			$variante = array();
			foreach ($prod->getVariante() as $var) {
				if ($var->getHidden() != 1) {
					array_push($variante, $this->getVariantenData($var));
				}
			}
			if ($prod->getHidden() != 1) {
				array_push($arr, $this->getProductData($prod, $variante));
			}
		}
		return $arr;
	}

	public function getProductData($prod, $variante) {
		$preis = $prod->getPreis();
		if ($this->userGroup == 4) {
			$preis = $preis * $this->faktor * 1.5;
		}

		return array(
			'uid' => $prod->getUid(),
			'pid' => $prod->getPid(),
			'name' => $prod->getName(),
			'beschreibung' => $prod->getBeschreibung(),
			'bild' => $prod->getBild(),
			'artNr' => $prod->getArtNr(),
			'frontscheibe' => $prod->getFrontscheibe(),
			'preis' => $preis,
			'variante' => $variante,
			'hidden' => $prod->getHidden()
		);
	}

	public function getVariantenData($var) {
		$preis = $var->getPreis();
		if ($this->userGroup == 4) {
			$preis = $preis * $this->faktor * 1.5;
		}
		return array(
			'uid' => $var->getUid(),
			'pid' => $var->getPid(),
			'name' => $var->getName(),
			'beschreibung' => $var->getBeschreibung(),
			'bild' => $var->getBild(),
			'artNr' => $var->getArtNr(),
			'laenge' => $var->getLaenge(),
			'dicke' => $var->getDicke(),
			'sicherheit' => $var->getSicherheit(),
			'preis' => $preis,
			'sonder' => $var->getSonder(),
			'hidden' => $var->getHidden()
		);
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$produktarts = $this->produktartRepository->findAll();
		$this->view->assign('produktarts', $produktarts);
	}

	/**
	 * action show
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produktart $produktart
	 * @return void
	 */
	public function showAction(\Glacryl\Glshop\Domain\Model\Produktart $produktart) {
		$this->view->assign('produktart', $produktart);
	}

	/**
	 * action new
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produktart $newProduktart
	 * @ignorevalidation $newProduktart
	 * @return void
	 */
	public function newAction(\Glacryl\Glshop\Domain\Model\Produktart $newProduktart = NULL) {
		$this->view->assign('newProduktart', $newProduktart);
	}

	/**
	 * action create
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produktart $newProduktart
	 * @return void
	 */
	public function createAction(\Glacryl\Glshop\Domain\Model\Produktart $newProduktart) {
		$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->produktartRepository->add($newProduktart);
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produktart $produktart
	 * @ignorevalidation $produktart
	 * @return void
	 */
	public function editAction(\Glacryl\Glshop\Domain\Model\Produktart $produktart) {
		$this->view->assign('produktart', $produktart);
	}

	/**
	 * action update
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produktart $produktart
	 * @return void
	 */
	public function updateAction(\Glacryl\Glshop\Domain\Model\Produktart $produktart) {
		$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->produktartRepository->update($produktart);
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produktart $produktart
	 * @return void
	 */
	public function deleteAction(\Glacryl\Glshop\Domain\Model\Produktart $produktart) {
		$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->produktartRepository->remove($produktart);
		$this->redirect('list');
	}

	public function debugTypo($data, $name = '') {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data, $name);
	}

	public function debug($data, $functions = false, $vars = false, $fluid = false) {
		if ($fluid) {
			$this->view->assign('debug', $data);
		} else {
			echo "<pre>";
			if ($functions) {
				$class_methods = get_class_methods($data);
				foreach ($class_methods as $method_name) {
					echo "$method_name\n";
				}
			} else if ($vars) {
				var_dump(get_object_vars($data));
			} else {
				var_dump($data);
			}
			echo "</pre>";
		}
	}

}
