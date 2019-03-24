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
 * Lieferschein
 */
class Delivery extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * file
     * 
     * @var string
     */
    protected $file = NULL;

    /**
     * date
     * 
     * @var \DateTime
     */
    protected $date = NULL;

    /**
     * send
     * 
     * @var int
     */
    protected $send = 0;

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
     * Returns the send
     * 
     * @return integer $send
     */
    public function getSend()
    {
        return $this->send;
    }

    /**
     * Sets the send
     * 
     * @param integer $send
     * @return void
     */
    public function setSend($send)
    {
        $this->send = $send;
    }

    /**
     * Returns the file
     * 
     * @return string file
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sets the file
     * 
     * @param string $file
     * @return void
     */
    public function setFile($file)
    {
        $this->file = $file;
    }
}
