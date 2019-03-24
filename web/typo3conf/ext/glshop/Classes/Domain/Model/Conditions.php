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
 * Zahlungskonditionen
 */
class Conditions extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * days
     * 
     * @var int
     */
    protected $days = 0;

    /**
     * reduction
     * 
     * @var int
     */
    protected $reduction = 0;

    /**
     * netto
     * 
     * @var int
     */
    protected $netto = 0;

    /**
     * Kundenzahlungskondition
     * 
     * @var
     */
    protected $user = NULL;

    /**
     * Returns the days
     * 
     * @return integer $days
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Sets the days
     * 
     * @param integer $days
     * @return void
     */
    public function setDays($days)
    {
        $this->days = $days;
    }

    /**
     * Returns the reduction
     * 
     * @return integer $reduction
     */
    public function getReduction()
    {
        return $this->reduction;
    }

    /**
     * Sets the reduction
     * 
     * @param integer $reduction
     * @return void
     */
    public function setReduction($reduction)
    {
        $this->reduction = $reduction;
    }

    /**
     * Returns the netto
     * 
     * @return integer $netto
     */
    public function getNetto()
    {
        return $this->netto;
    }

    /**
     * Sets the netto
     * 
     * @param integer $netto
     * @return void
     */
    public function setNetto($netto)
    {
        $this->netto = $netto;
    }

    /**
     * Returns the user
     * 
     * @return integer user
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
}
