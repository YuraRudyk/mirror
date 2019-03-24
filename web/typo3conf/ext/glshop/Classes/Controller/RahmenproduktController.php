<?php
namespace Glacryl\Glshop\Controller;

/***************************************************************
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
 ***************************************************************/

/**
 * RahmenproduktController
 */
class RahmenproduktController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * rahmenproduktRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\RahmenproduktRepository
	 * @inject
	 */
	protected $rahmenproduktRepository = NULL;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$rahmenprodukts = $this->rahmenproduktRepository->findAll();
		$this->view->assign('rahmenprodukts', $rahmenprodukts);
	}

	/**
	 * action show
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Rahmenprodukt $rahmenprodukt
	 * @return void
	 */
	public function showAction(\Glacryl\Glshop\Domain\Model\Rahmenprodukt $rahmenprodukt) {
		$this->view->assign('rahmenprodukt', $rahmenprodukt);
	}

	/**
	 * action new
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Rahmenprodukt $newRahmenprodukt
	 * @ignorevalidation $newRahmenprodukt
	 * @return void
	 */
	public function newAction(\Glacryl\Glshop\Domain\Model\Rahmenprodukt $newRahmenprodukt = NULL) {
		$this->view->assign('newRahmenprodukt', $newRahmenprodukt);
	}

	/**
	 * action create
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Rahmenprodukt $newRahmenprodukt
	 * @return void
	 */
	public function createAction(\Glacryl\Glshop\Domain\Model\Rahmenprodukt $newRahmenprodukt) {
		$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->rahmenproduktRepository->add($newRahmenprodukt);
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Rahmenprodukt $rahmenprodukt
	 * @ignorevalidation $rahmenprodukt
	 * @return void
	 */
	public function editAction(\Glacryl\Glshop\Domain\Model\Rahmenprodukt $rahmenprodukt) {
		$this->view->assign('rahmenprodukt', $rahmenprodukt);
	}

	/**
	 * action update
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Rahmenprodukt $rahmenprodukt
	 * @return void
	 */
	public function updateAction(\Glacryl\Glshop\Domain\Model\Rahmenprodukt $rahmenprodukt) {
		$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->rahmenproduktRepository->update($rahmenprodukt);
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Rahmenprodukt $rahmenprodukt
	 * @return void
	 */
	public function deleteAction(\Glacryl\Glshop\Domain\Model\Rahmenprodukt $rahmenprodukt) {
		$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->rahmenproduktRepository->remove($rahmenprodukt);
		$this->redirect('list');
	}

}