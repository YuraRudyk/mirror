<?php
namespace Glacryl\Glshop\Controller;


/***************************************************************
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
 ***************************************************************/
/***
 *
 * This file is part of the "Glacryl Shop System" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Petro Dikij <petro.dikij@glacryl.de>, Glacryl Hedel GmbH
 *
 ***/
/**
 * CornereditingController
 */
class CornereditingController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * cornereditingRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\CornereditingRepository
     * @inject
     */
    protected $cornereditingRepository = NULL;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $cornereditings = $this->cornereditingRepository->findAll();
        $this->view->assign('cornereditings', $cornereditings);
    }

    /**
     * action show
     * 
     * @param \Glacryl\Glshop\Domain\Model\Cornerediting $cornerediting
     * @return void
     */
    public function showAction(\Glacryl\Glshop\Domain\Model\Cornerediting $cornerediting)
    {
        $this->view->assign('cornerediting', $cornerediting);
    }

    /**
     * action new
     * 
     * @param \Glacryl\Glshop\Domain\Model\Cornerediting $newCornerediting
     * @ignorevalidation $newCornerediting
     * @return void
     */
    public function newAction(\Glacryl\Glshop\Domain\Model\Cornerediting $newCornerediting = NULL)
    {
        $this->view->assign('newCornerediting', $newCornerediting);
    }

    /**
     * action create
     * 
     * @param \Glacryl\Glshop\Domain\Model\Cornerediting $newCornerediting
     * @return void
     */
    public function createAction(\Glacryl\Glshop\Domain\Model\Cornerediting $newCornerediting)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->cornereditingRepository->add($newCornerediting);
        $this->redirect('list');
    }

    /**
     * action edit
     * 
     * @param \Glacryl\Glshop\Domain\Model\Cornerediting $cornerediting
     * @ignorevalidation $cornerediting
     * @return void
     */
    public function editAction(\Glacryl\Glshop\Domain\Model\Cornerediting $cornerediting)
    {
        $this->view->assign('cornerediting', $cornerediting);
    }

    /**
     * action update
     * 
     * @param \Glacryl\Glshop\Domain\Model\Cornerediting $cornerediting
     * @return void
     */
    public function updateAction(\Glacryl\Glshop\Domain\Model\Cornerediting $cornerediting)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->cornereditingRepository->update($cornerediting);
        $this->redirect('list');
    }

    /**
     * action delete
     * 
     * @param \Glacryl\Glshop\Domain\Model\Cornerediting $cornerediting
     * @return void
     */
    public function deleteAction(\Glacryl\Glshop\Domain\Model\Cornerediting $cornerediting)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->cornereditingRepository->remove($cornerediting);
        $this->redirect('list');
    }
}
