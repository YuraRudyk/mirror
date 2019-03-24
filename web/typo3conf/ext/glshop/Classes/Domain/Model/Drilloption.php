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
 * Bohrvarianten
 */
class Drilloption extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * fromSize
     * 
     * @var float
     */
    protected $fromSize = 0.0;

    /**
     * toSize
     * 
     * @var float
     */
    protected $toSize = 0.0;

    /**
     * price
     * 
     * @var float
     */
    protected $price = 0.0;

    /**
     * Returns the fromSize
     * 
     * @return float $fromSize
     */
    public function getFromSize()
    {
        return $this->fromSize;
    }

    /**
     * Sets the fromSize
     * 
     * @param float $fromSize
     * @return void
     */
    public function setFromSize($fromSize)
    {
        $this->fromSize = $fromSize;
    }

    /**
     * Returns the toSize
     * 
     * @return float $toSize
     */
    public function getToSize()
    {
        return $this->toSize;
    }

    /**
     * Sets the toSize
     * 
     * @param float $toSize
     * @return void
     */
    public function setToSize($toSize)
    {
        $this->toSize = $toSize;
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
}