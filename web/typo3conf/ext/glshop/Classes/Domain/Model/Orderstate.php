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
 * Orderstate
 */
class Orderstate extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * label
     * 
     * @var string
     */
    protected $label = '';

    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * value
     * 
     * @var int
     */
    protected $value = 0;

    /**
     * acr
     * 
     * @var string
     */
    protected $acr = '';

    /**
     * prefix
     * 
     * @var string
     */
    protected $prefix = '';

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
     * Returns the value
     * 
     * @return integer $value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value
     * 
     * @param integer $value
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Returns the acr
     * 
     * @return string $acr
     */
    public function getAcr()
    {
        return $this->acr;
    }

    /**
     * Sets the acr
     * 
     * @param string $acr
     * @return void
     */
    public function setAcr($acr)
    {
        $this->acr = $acr;
    }

    /**
     * Returns the prefix
     * 
     * @return string $prefix
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Sets the prefix
     * 
     * @param string $prefix
     * @return void
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Returns the Label
     * 
     * @return string $label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Sets the Label
     * 
     * @param string $label
     * @return void
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }
}
