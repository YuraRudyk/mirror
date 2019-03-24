<?php
namespace Glacryl\Glshop\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2018
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
 * PartnerlistenController
 */
class PartnerlistenController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * partnerlistenRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\PartnerlistenRepository
	 * @inject
	 */
	protected $partnerlistenRepository = NULL;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$partnerlistens = $this->partnerlistenRepository->findAll();
		$this->view->assign('partnerlistens', $partnerlistens);
	}

	/**
	 * action show
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Partnerlisten $partnerlisten
	 * @return void
	 */
	public function showAction(\Glacryl\Glshop\Domain\Model\Partnerlisten $partnerlisten) {
		$this->view->assign('partnerlisten', $partnerlisten);
	}

	/**
	 * action new
	 *
	 * @return void
	 */
	public function newAction() {
		
	}

	/**
	 * action create
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Partnerlisten $newPartnerlisten
	 * @return void
	 */
	public function createAction(\Glacryl\Glshop\Domain\Model\Partnerlisten $newPartnerlisten) {
		$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->partnerlistenRepository->add($newPartnerlisten);
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Partnerlisten $partnerlisten
	 * @ignorevalidation $partnerlisten
	 * @return void
	 */
	public function editAction(\Glacryl\Glshop\Domain\Model\Partnerlisten $partnerlisten) {
		$this->view->assign('partnerlisten', $partnerlisten);
	}

	/**
	 * action update
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Partnerlisten $partnerlisten
	 * @return void
	 */
	public function updateAction(\Glacryl\Glshop\Domain\Model\Partnerlisten $partnerlisten) {
		$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->partnerlistenRepository->update($partnerlisten);
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Partnerlisten $partnerlisten
	 * @return void
	 */
	public function deleteAction(\Glacryl\Glshop\Domain\Model\Partnerlisten $partnerlisten) {
		$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->partnerlistenRepository->remove($partnerlisten);
		$this->redirect('list');
	}

}