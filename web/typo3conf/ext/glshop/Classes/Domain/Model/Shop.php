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
 * Shopeinstieg
 */
class Shop extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * aKey
     * 
     * @var string
     */
    protected $aKey = '';

    /**
     * aValue
     * 
     * @var string
     */
    protected $aValue = '';

    /**
     * userUploadPath
     *
     * @var string
     */
    protected $userUploadPath = '';

    /**
     * confirmationPath
     *
     * @var string
     */
    protected $confirmationPath = '';

    /**
     * productionPath
     *
     * @var string
     */
    protected $productionPath = '';

    /**
     * deliveryPath
     *
     * @var string
     */
    protected $deliveryPath = '';

    /**
     * invoicePath
     *
     * @var string
     */
    protected $invoicePath = '';

    /**
     * materialImgPath
     *
     * @var string
     */
    protected $materialImgPath = '';

    /**
     * productImgPath
     *
     * @var string
     */
    protected $productImgPath = '';

    /**
     * editImgPath
     *
     * @var string
     */
    protected $editImgPath = '';

    /**
     * materialFactor
     *
     * @var float
     */
    protected $materialFactor = 0.0;

    /**
     * productFactor
     *
     * @var float
     */
    protected $productFactor = 0.0;

    /**
     * editFactor
     *
     * @var float
     */
    protected $editFactor = 0.0;

    /**
     * materialPrivatFactor
     *
     * @var float
     */
    protected $materialPrivatFactor = 0.0;

    /**
     * productPrivatFactor
     *
     * @var float
     */
    protected $productPrivatFactor = 0.0;

    /**
     * editPrivatFactor
     *
     * @var float
     */
    protected $editPrivatFactor = 0.0;

    /**
     * cruserId
     *
     * @var int
     */
    protected $cruserId = null;

    /**
     * Sets the cruserId
     *
     * @param string $cruserId
     * @return void
     */
    public function setCruserId($cruserId)
    {
        die('test');
        $this->cruserId = $cruserId;
    }

    /**
     * Returns the cruserId
     *
     * @return int $cruserId
     */
    public function getCruserId()
    {
        die('test');
        return $this->cruserId;
    }


    /**
     * Returns the aKey
     *
     * @return string $aKey
     */
    public function getAKey()
    {
        return $this->aKey;
    }

    /**
     * Sets the aKey
     *
     * @param string $aKey
     * @return void
     */
    public function setAKey($aKey)
    {
        $this->aKey = $aKey;
    }

    /**
     * Returns the aValue
     *
     * @return string $aValue
     */
    public function getAValue()
    {
        return $this->aValue;
    }

    /**
     * Sets the value
     *
     * @param string $aValue
     * @return void
     */
    public function setAValue($aValue)
    {
        $this->aValue = $aValue;
    }
}
