<?php
namespace Glacryl\Glshop\Domain\Model;


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
 * Merkliste
 */
class Noticelist extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * noticeName
     * 
     * @var string
     */
    protected $noticeName = '';

    /**
     * position
     * 
     * @var integer
     */
    protected $position = 0;

    /**
     * pic
     * 
     * @var string
     */
    protected $pic = NULL;

    /**
     * price
     * 
     * @var float
     */
    protected $price = 0.0;

    /**
     * qty
     * 
     * @var integer
     */
    protected $qty = 0;

    /**
     * details
     * 
     * @var string
     */
    protected $details = '';

    /**
     * date
     * 
     * @var \DateTime
     */
    protected $date = NULL;

    /**
     * article
     * 
     * @var string
     */
    protected $article = '';

    /**
     * expire
     * 
     * @var \DateTime
     */
    protected $expire = NULL;

    /**
     * Kunde
     * 
     * @var
     */
    protected $user = NULL;

    /**
     * noticeNr
     * 
     * @var int
     */
    protected $noticeNr = 0;

    /**
     * Returns the noticeName
     * 
     * @return string $noticeName
     */
    public function getNoticeName()
    {
        return $this->noticeName;
    }

    /**
     * Sets the noticeName
     * 
     * @param string $noticeName
     * @return void
     */
    public function setNoticeName($noticeName)
    {
        $this->noticeName = $noticeName;
    }

    /**
     * Returns the date
     * 
     * @return \DateTime $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the date
     * 
     * @param \DateTime $date
     * @return void
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
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
     * Returns the details
     * 
     * @return string $details
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Sets the details
     * 
     * @param string $details
     * @return void
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * Returns the expire
     * 
     * @return \DateTime $expire
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * Sets the expire
     * 
     * @param \DateTime $expire
     * @return void
     */
    public function setExpire(\DateTime $expire)
    {
        $this->expire = $expire;
    }

    /**
     * Returns the user
     * 
     * @return integer $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the user
     * 
     * @param integer $user
     * @return void
     */
    public function setUser($user)
    {
        $this->user = $user;
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
}
