<?php
namespace Glacryl\Glshop\Domain\Model;


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
 * Warenkorb
 */
class Cart extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * notice
     * 
     * @var integer
     */
    protected $notice = 0;

    /**
     * sessionId
     * 
     * @var string
     */
    protected $sessionId = '';

    /**
     * position
     * 
     * @var int
     */
    protected $position = 0;

    /**
     * article
     * 
     * @var string
     */
    protected $article = '';

    /**
     * qty
     * 
     * @var int
     */
    protected $qty = 0;

    /**
     * price
     * 
     * @var float
     */
    protected $price = 0.0;

    /**
     * pic
     * 
     * @var string
     */
    protected $pic = NULL;

    /**
     * Kunde
     * 
     * @var
     */
    protected $user = NULL;

    /**
     * Returns the sessionId
     * 
     * @return string $sessionId
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Sets the sessionId
     * 
     * @param string $sessionId
     * @return void
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * Returns the position
     * 
     * @return integer $position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the position
     * 
     * @param integer $position
     * @return void
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Returns the article
     * 
     * @return string $article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Sets the article
     * 
     * @param string $article
     * @return void
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * Returns the qty
     * 
     * @return integer $qty
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Sets the qty
     * 
     * @param integer $qty
     * @return void
     */
    public function setQty($qty)
    {
        $this->qty = $qty;
    }

    /**
     * Returns the price
     * 
     * @return float $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets the price
     * 
     * @param float $price
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Returns the pic
     * 
     * @return string pic
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * Sets the pic
     * 
     * @param string $pic
     * @return string pic
     */
    public function setPic($pic)
    {
        $this->pic = $pic;
    }

    /**
     * Returns the user
     * 
     * @return integer user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the user
     * 
     * @param integer $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Returns the notice
     * 
     * @return integer $notice
     */
    public function getNotice()
    {
        return $this->notice;
    }

    /**
     * Sets the notice
     * 
     * @param integer $notice
     * @return void
     */
    public function setNotice($notice)
    {
        $this->notice = $notice;
    }
}
