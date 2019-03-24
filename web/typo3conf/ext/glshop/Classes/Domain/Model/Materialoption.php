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
 * Materialvarianten
 */
class Materialoption extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * description
     * 
     * @var string
     */
    protected $description = '';

    /**
     * pic
     * 
     * @var string
     */
    protected $pic = NULL;

    /**
     * materialoptiontype
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Materialoptiontype>
     * @cascade remove
     */
    protected $materialoptiontype = NULL;

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
        $this->materialoptiontype = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the description
     * 
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     * 
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Adds a Materialoptiontype
     * 
     * @param \Glacryl\Glshop\Domain\Model\Materialoptiontype $materialoptiontype
     * @return void
     */
    public function addMaterialoptiontype(\Glacryl\Glshop\Domain\Model\Materialoptiontype $materialoptiontype)
    {
        $this->materialoptiontype->attach($materialoptiontype);
    }

    /**
     * Removes a Materialoptiontype
     * 
     * @param \Glacryl\Glshop\Domain\Model\Materialoptiontype $materialoptiontypeToRemove The Materialoptiontype to be removed
     * @return void
     */
    public function removeMaterialoptiontype(\Glacryl\Glshop\Domain\Model\Materialoptiontype $materialoptiontypeToRemove)
    {
        $this->materialoptiontype->detach($materialoptiontypeToRemove);
    }

    /**
     * Returns the materialoptiontype
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Materialoptiontype> $materialoptiontype
     */
    public function getMaterialoptiontype()
    {
        return $this->materialoptiontype;
    }

    /**
     * Sets the materialoptiontype
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Materialoptiontype> $materialoptiontype
     * @return void
     */
    public function setMaterialoptiontype(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $materialoptiontype)
    {
        $this->materialoptiontype = $materialoptiontype;
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
