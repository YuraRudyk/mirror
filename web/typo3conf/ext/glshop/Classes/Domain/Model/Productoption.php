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
 * Produktvarianten
 */
class Productoption extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * articleNr
     * 
     * @var string
     */
    protected $articleNr = '';

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
    protected $pic = '';

    /**
     * price
     * 
     * @var float
     */
    protected $price = 0.0;

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
     * width
     * 
     * @var float
     */
    protected $width = 0.0;

    /**
     * length
     * 
     * @var float
     */
    protected $length = 0.0;

    /**
     * height
     * 
     * @var float
     */
    protected $height = 0.0;

    /**
     * size
     * 
     * @var float
     */
    protected $size = 0.0;

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
     * Returns the width
     * 
     * @return float $width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Sets the width
     * 
     * @param float $width
     * @return void
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * Returns the length
     * 
     * @return float $length
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Sets the length
     * 
     * @param float $length
     * @return void
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * Returns the height
     * 
     * @return float $height
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Sets the height
     * 
     * @param float $height
     * @return void
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * Returns the size
     * 
     * @return float $size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Sets the size
     * 
     * @param float $size
     * @return void
     */
    public function setSize($size)
    {
        $this->size = $size;
    }
}
