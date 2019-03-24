<?php
namespace Glacryl\Glshop\Domain\Repository;


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
 * The repository for Carts
 */
class CartRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * PersistenceManager
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager = null;

    /**
     * Initialize the repository
     * 
     * @return void
     */
    public function initializeObject()
    {
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(FALSE);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * Funciton SaveOrder
     * 
     * @param \Glacryl\Glshop\Domain\Model\Cart $cart
     * @return \Glacryl\Glshop\Domain\Model\Cart $cart
     */
    public function save($cart)
    {
        $this->add($cart);
        $this->persistenceManager->persistAll();
        return $cart;
    }

    /**
     * UpdateCart
     * 
     * @param \Glacryl\Glshop\Domain\Model\Cart $cart
     * @return \Glacryl\Glshop\Domain\Model\Cart $cart
     */
    public function updateCart($cart)
    {
        $this->update($cart);
        $this->persistenceManager->persistAll();
        return $cart;
    }

    /**
     * DeleteCart
     * 
     * @param \Glacryl\Glshop\Domain\Model\Cart $cart
     */
    public function deleteCart($cart)
    {
        $this->remove($cart);
        $this->persistenceManager->persistAll();
    }

    /**
     * Get current Cart Items for User
     * 
     * @param Integer $userId
     * @param String $sessId
     * @return \Glacryl\Glshop\Domain\Model\Cart
     */
    public function getCurrentCartItems($userId, $sessId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        $query->matching(
        $query->logicalAnd($query->equals('session_id', $sessId), $query->equals('user', $userId), $query->logicalNot($query->equals('deleted', '1')))
        );
        return $query->execute();
    }

    /**
     * Funciton getNextPositionNr
     * 
     * @param \String $sess_id
     * @return \integer Next free Position Nr.
     */
    public function getNextPositionNr($sess_id)
    {
        $cartData = $this->findBySessionId($sess_id);
        return intval(count($cartData) + 1);
    }

    /**
     * @param $data
     */
    public function debugTypo($data)
    {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
    }
}
