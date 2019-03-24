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
 * Senkungen
 */
class Bevel extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * thread
     * 
     * @var float
     */
    protected $thread = 0.0;

    /**
     * drill
     * 
     * @var float
     */
    protected $drill = 0.0;

    /**
     * bevel
     * 
     * @var float
     */
    protected $bevel = 0.0;

    /**
     * depth
     * 
     * @var float
     */
    protected $depth = 0.0;

    /**
     * Returns the thread
     * 
     * @return float $thread
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Sets the thread
     * 
     * @param float $thread
     * @return void
     */
    public function setThread($thread)
    {
        $this->thread = $thread;
    }

    /**
     * Returns the drill
     * 
     * @return float $drill
     */
    public function getDrill()
    {
        return $this->drill;
    }

    /**
     * Sets the drill
     * 
     * @param float $drill
     * @return void
     */
    public function setDrill($drill)
    {
        $this->drill = $drill;
    }

    /**
     * Returns the depth
     * 
     * @return float $depth
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Sets the depth
     * 
     * @param float $depth
     * @return void
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
    }

    /**
     * Returns the bevel
     * 
     * @return float bevel
     */
    public function getBevel()
    {
        return $this->bevel;
    }

    /**
     * Sets the bevel
     * 
     * @param float $bevel
     * @return float bevel
     */
    public function setBevel($bevel)
    {
        $this->bevel = $bevel;
    }
}
