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
 * Produkte
 */
class Product extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * pic
     * 
     * @var string
     */
    protected $pic = '';

    /**
     * productoption
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Productoption>
     * @cascade remove
     */
    protected $productoption = NULL;

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
        $this->productoption = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the pic
     * 
     * @return string $pic
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * Sets the pic
     * 
     * @param string $pic
     * @return void
     */
    public function setPic($pic)
    {
        $this->pic = $pic;
    }

    /**
     * Adds a Productoption
     * 
     * @param \Glacryl\Glshop\Domain\Model\Productoption $productoption
     * @return void
     */
    public function addProductoption(\Glacryl\Glshop\Domain\Model\Productoption $productoption)
    {
        $this->productoption->attach($productoption);
    }

    /**
     * Removes a Productoption
     * 
     * @param \Glacryl\Glshop\Domain\Model\Productoption $productoptionToRemove The Productoption to be removed
     * @return void
     */
    public function removeProductoption(\Glacryl\Glshop\Domain\Model\Productoption $productoptionToRemove)
    {
        $this->productoption->detach($productoptionToRemove);
    }

    /**
     * Returns the productoption
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Productoption> $productoption
     */
    public function getProductoption()
    {
        return $this->productoption;
    }

    /**
     * Sets the productoption
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Productoption> $productoption
     * @return void
     */
    public function setProductoption(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $productoption)
    {
        $this->productoption = $productoption;
    }
}
