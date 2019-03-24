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
 * Befestigungsvarianten
 */
class Fixingoption extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * material
     * 
     * @var string
     */
    protected $material = '';

    /**
     * fix
     * 
     * @var string
     */
    protected $fix = '';

    /**
     * head
     * 
     * @var string
     */
    protected $head = '';

    /**
     * leange
     * 
     * @var float
     */
    protected $leange = 0.0;

    /**
     * headsize
     * 
     * @var float
     */
    protected $headsize = 0.0;

    /**
     * sandwitch
     * 
     * @var integer
     */
    protected $sandwitch = 0.0;

    /**
     * weight
     * 
     * @var float
     */
    protected $weight = 0.0;

    /**
     * articleNr
     * 
     * @var string
     */
    protected $articleNr = '';

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
     * projection
     * 
     * @var float
     */
    protected $projection = 0.0;

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
     * drillDownside
     * 
     * @var float
     */
    protected $drillDownside = 0.0;

    /**
     * borderLength
     * 
     * @var float
     */
    protected $borderLength = 0.0;

    /**
     * position
     * 
     * @var string
     */
    protected $position = '';

    /**
     * diameter
     * 
     * @var float
     */
    protected $diameter = 0.0;

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
     * Returns the articleNr
     * 
     * @return string $articleNr
     */
    public function getArticleNr()
    {
        return $this->articleNr;
    }

    /**
     * Sets the articleNr
     * 
     * @param string $articleNr
     * @return void
     */
    public function setArticleNr($articleNr)
    {
        $this->articleNr = $articleNr;
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
     * Returns the material
     * 
     * @return string $material
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Sets the material
     * 
     * @param string $material
     * @return void
     */
    public function setMaterial($material)
    {
        $this->material = $material;
    }

    /**
     * Returns the fix
     * 
     * @return string $fix
     */
    public function getFix()
    {
        return $this->fix;
    }

    /**
     * Sets the fix
     * 
     * @param string $fix
     * @return void
     */
    public function setFix($fix)
    {
        $this->fix = $fix;
    }

    /**
     * Returns the head
     * 
     * @return string $head
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Sets the head
     * 
     * @param string $head
     * @return void
     */
    public function setHead($head)
    {
        $this->head = $head;
    }

    /**
     * Returns the leange
     * 
     * @return float $leange
     */
    public function getLeange()
    {
        return $this->leange;
    }

    /**
     * Sets the leange
     * 
     * @param float $leange
     * @return void
     */
    public function setLeange($leange)
    {
        $this->leange = $leange;
    }

    /**
     * Returns the headsize
     * 
     * @return float $headsize
     */
    public function getHeadsize()
    {
        return $this->headsize;
    }

    /**
     * Sets the headsize
     * 
     * @param float $headsize
     * @return void
     */
    public function setHeadsize($headsize)
    {
        $this->headsize = $headsize;
    }

    /**
     * Returns the sandwitch
     * 
     * @return integer $sandwitch
     */
    public function getSandwitch()
    {
        return $this->sandwitch;
    }

    /**
     * Sets the sandwitch
     * 
     * @param integer $sandwitch
     * @return void
     */
    public function setSandwitch($sandwitch)
    {
        $this->sandwitch = $sandwitch;
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
     * Returns the projection
     * 
     * @return float $projection
     */
    public function getProjection()
    {
        return $this->projection;
    }

    /**
     * Sets the projection
     * 
     * @param float $projection
     * @return void
     */
    public function setProjection($projection)
    {
        $this->projection = $projection;
    }

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
     * Returns the drillDownside
     * 
     * @return float $drillDownside
     */
    public function getDrillDownside()
    {
        return $this->drillDownside;
    }

    /**
     * Sets the drillDownside
     * 
     * @param float $drillDownside
     * @return void
     */
    public function setDrillDownside($drillDownside)
    {
        $this->drillDownside = $drillDownside;
    }

    /**
     * Returns the borderLength
     * 
     * @return float $borderLength
     */
    public function getBorderLength()
    {
        return $this->borderLength;
    }

    /**
     * Sets the borderLength
     * 
     * @param float $borderLength
     * @return void
     */
    public function setBorderLength($borderLength)
    {
        $this->borderLength = $borderLength;
    }

    /**
     * Returns the position
     * 
     * @return string $position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the position
     * 
     * @param string $position
     * @return void
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Returns the diameter
     * 
     * @return float $diameter
     */
    public function getDiameter()
    {
        return $this->diameter;
    }

    /**
     * Sets the diameter
     * 
     * @param float $diameter
     * @return void
     */
    public function setDiameter($diameter)
    {
        $this->diameter = $diameter;
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
     * Returns the weight
     * 
     * @return float $weight
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Sets the weight
     * 
     * @param float $weight
     * @return void
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
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
