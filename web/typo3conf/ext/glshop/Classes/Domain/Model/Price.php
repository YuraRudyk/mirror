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

/**
 * Preisgestaltung
 */
class Price extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {


	/**
	 * uid
	 *
	 * @var integer
	 */
	protected $uid = 0;
	
	/**
	 * pid
	 *
	 * @var integer
	 */
	protected $pid = 0;
	
	/**
	 * fromEk
	 *
	 * @var float
	 */
	protected $fromEk = 0;

	/**
	 * toEk
	 *
	 * @var float
	 */
	protected $toEk = 0;

	/**
	 * factor
	 *
	 * @var float
	 */
	protected $factor = 0;

	/**
	 * feGroup
	 *
	 * @var integer
	 */
	protected $feGroup = NULL;

	/**
	 * Returns the Uid
	 *
	 * @return integer $uid
	 */
	public function getUid() {
		return $this->uid;
	}

	/**
	 * Sets the Uid
	 *
	 * @param integer $uid
	 * @return void
	 */
	public function setUid($uid) {
		$this->uid = $uid;
	}
	
	/**
	 * Returns the Pid
	 *
	 * @return integer $pid
	 */
	public function getPid() {
		return $this->pid;
	}

	/**
	 * Sets the Pid
	 *
	 * @param integer $pid
	 * @return void
	 */
	public function setPid($pid) {
		$this->pid = $pid;
	}
	
	/**
	 * Returns the fromEk
	 *
	 * @return float $fromEk
	 */
	public function getFromEk() {
		return $this->fromEk;
	}

	/**
	 * Sets the fromEk
	 *
	 * @param float $fromEk
	 * @return void
	 */
	public function setFromEck($fromEk) {
		$this->fromEk = $fromEk;
	}

	/**
	 * Returns the toEk
	 *
	 * @return float $toEk
	 */
	public function getToEk() {
		return $this->toEk;
	}

	/**
	 * Sets the toEk
	 *
	 * @param float $toEk
	 * @return void
	 */
	public function setToEk($toEk) {
		$this->toEk = $toEk;
	}
	
	/**
	 * Returns the Factor
	 *
	 * @return float $toEk
	 */
	public function getFactor() {
		return $this->factor;
	}

	/**
	 * Sets the Factor
	 *
	 * @param float $factor
	 * @return void
	 */
	public function setFactor($factor) {
		$this->factor = $factor;
	}
	
	/**
	 * Returns the feGroup
	 *
	 * @return integer feGroup
	 */
	public function getFeGroup() {
		return $this->feGroup;
	}

	/**
	 * Sets the feGroup
	 *
	 * @param integer $feGroup
	 * @return void
	 */
	public function setFeGroup($feGroup) {
		$this->feGroup = $feGroup;
	}

}