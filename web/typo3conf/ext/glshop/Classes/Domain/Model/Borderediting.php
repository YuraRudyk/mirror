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
 * Kantenbearbeitung
 */
class Borderediting extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

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
     * bordereditingoption
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Bordereditingoption>
     * @cascade remove
     */
    protected $bordereditingoption = NULL;

    /**
     * __construct
     */
    public function __construct()
    {

        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     * 
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->bordereditingoption = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the name
     * 
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Adds a Bordereditingoption
     * 
     * @param \Glacryl\Glshop\Domain\Model\Bordereditingoption $bordereditingoption
     * @return void
     */
    public function addBordereditingoption(\Glacryl\Glshop\Domain\Model\Bordereditingoption $bordereditingoption)
    {
        $this->bordereditingoption->attach($bordereditingoption);
    }

    /**
     * Removes a Bordereditingoption
     * 
     * @param \Glacryl\Glshop\Domain\Model\Bordereditingoption $bordereditingoptionToRemove The Bordereditingoption to be removed
     * @return void
     */
    public function removeBordereditingoption(\Glacryl\Glshop\Domain\Model\Bordereditingoption $bordereditingoptionToRemove)
    {
        $this->bordereditingoption->detach($bordereditingoptionToRemove);
    }

    /**
     * Returns the bordereditingoption
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Bordereditingoption> $bordereditingoption
     */
    public function getBordereditingoption()
    {
        return $this->bordereditingoption;
    }

    /**
     * Sets the bordereditingoption
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Bordereditingoption> $bordereditingoption
     * @return void
     */
    public function setBordereditingoption(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $bordereditingoption)
    {
        $this->bordereditingoption = $bordereditingoption;
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
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $pic
     * @return string pic
     */
    public function setPic(\TYPO3\CMS\Extbase\Domain\Model\FileReference $pic)
    {
        $this->pic = $pic;
    }
}
