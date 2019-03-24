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
 * PartnerController
 */
class PartnerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * partnerRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\PartnerRepository
	 * @inject
	 */
	protected $partnerRepository = NULL;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$partners = $this->partnerRepository->findAll();
		$this->view->assign('partners', $partners);
	}

	/**
	 * action show
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Partner $partner
	 * @return void
	 */
	public function showAction(\Glacryl\Glshop\Domain\Model\Partner $partner) {
		$this->view->assign('partner', $partner);
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
	 * @param \Glacryl\Glshop\Domain\Model\Partner $newPartner
	 * @return void
	 */
	public function createAction(\Glacryl\Glshop\Domain\Model\Partner $newPartner) {
		$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->partnerRepository->add($newPartner);
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Partner $partner
	 * @ignorevalidation $partner
	 * @return void
	 */
	public function editAction(\Glacryl\Glshop\Domain\Model\Partner $partner) {
		$this->view->assign('partner', $partner);
	}

	/**
	 * action update
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Partner $partner
	 * @return void
	 */
	public function updateAction(\Glacryl\Glshop\Domain\Model\Partner $partner) {
		$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->partnerRepository->update($partner);
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Partner $partner
	 * @return void
	 */
	public function deleteAction(\Glacryl\Glshop\Domain\Model\Partner $partner) {
		$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->partnerRepository->remove($partner);
		$this->redirect('list');
	}

	/**
	 * @param $data
	 */
	public function debugTypo($data) {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
	}

	/**
	 * @param $data
	 * @param $functions
	 * @param $vars
	 * @param $fluid
	 */
	public function debug($data, $functions = false, $vars = false, $fluid = false) {
		if ($fluid) {
			$this->view->assign('debug', $data);
		} else {
			echo '<pre>';
			if ($functions) {
				$class_methods = get_class_methods($data);
				foreach ($class_methods as $method_name) {
					echo "{$method_name}\n";
				}
			} else {
				if ($vars) {
					var_dump(get_object_vars($data));
				} else {
					var_dump($data);
				}
			}
			echo '</pre>';
		}
	}

}
