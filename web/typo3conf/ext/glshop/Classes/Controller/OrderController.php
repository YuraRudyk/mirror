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
 * OrderController
 */
class OrderController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * orderRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\OrderRepository
     * @inject
     */
    protected $orderRepository = NULL;

    /**
     * CustomerRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\CustomerRepository
     * @inject
     */
    protected $customerRepository = NULL;

    /**
     * OrderstateRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\OrderstateRepository
     * @inject
     */
    protected $orderstateRepository = NULL;

    /**
     * PartnerRepository
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
    public function listAction()
    {
        $orders = $this->orderRepository->findAll()->getQuery()->setOrderings(["uid" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING])->setLimit(50)->execute();

        //$orders = $this->orderRepository->findAll();
        $feUser = $this->customerRepository->findAll();
        $orderstates = $this->orderstateRepository->findAll();
        $partner = $this->partnerRepository->findAll();
        $this->view->assign('feUser', $feUser);
        $this->view->assign('orders', $orders);
        $this->view->assign('orderstates', $orderstates);
        $this->view->assign('partner', $partner);
    }

    /**
     * action getAbschlussFunction
     * 
     * @param $args
     * @return array
     */
    public function getAbschlussFunction($args)
    {
        $von = $args['von'] . ' 00:00';
        $bis = $args['bis'] . ' 23:59';

        //$this->debugTypo($von . " - " . $bis);
        $abschluss = $this->orderRepository->getAbschlussOrders($von, $bis);
        return $abschluss;
    }

    /**
     * action show
     * 
     * @param \Glacryl\Glshop\Domain\Model\Order $order
     * @return void
     */
    public function showAction(\Glacryl\Glshop\Domain\Model\Order $order)
    {
        $this->view->assign('order', $order);
    }

    /**
     * action new
     * 
     * @param \Glacryl\Glshop\Domain\Model\Order $newOrder
     * @ignorevalidation $newOrder
     * @return void
     */
    public function newAction(\Glacryl\Glshop\Domain\Model\Order $newOrder = NULL)
    {
        $this->view->assign('newOrder', $newOrder);
    }

    /**
     * action create
     * 
     * @param \Glacryl\Glshop\Domain\Model\Order $newOrder
     * @return void
     */
    public function createAction(\Glacryl\Glshop\Domain\Model\Order $newOrder)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->orderRepository->add($newOrder);
        $this->redirect('list');
    }

    /**
     * action edit
     * 
     * @param \Glacryl\Glshop\Domain\Model\Order $order
     * @ignorevalidation $order
     * @return void
     */
    public function editAction(\Glacryl\Glshop\Domain\Model\Order $order)
    {
        $this->view->assign('order', $order);
    }

    /**
     * action update
     * 
     * @param \Glacryl\Glshop\Domain\Model\Order $order
     * @return void
     */
    public function updateAction(\Glacryl\Glshop\Domain\Model\Order $order)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->orderRepository->update($order);
        $this->redirect('list');
    }

    /**
     * @param $data
     */
    public function debugTypo($data)
    {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
    }
}
