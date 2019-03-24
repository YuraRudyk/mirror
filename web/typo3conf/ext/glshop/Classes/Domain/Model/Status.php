<?php

namespace Glacryl\Glshop\Domain\Model;

/* * *************************************************************
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
 * ************************************************************* */

/**
 * Status
 */
class Status extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

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
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * farbe
	 *
	 * @var string
	 */
	protected $farbe = '';

	/**
	 * bereich
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Bereich>
	 * @cascade remove
	 */
	protected $bereich = '';

	/**
	 * __construct
	 */
	public function __construct() {
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
	protected function initStorageObjects() {
		$this->bereich = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the Bereich
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Bereich> $bereich
	 */
	public function getBereich() {
		return $this->bereich;
	}

	/**
	 * Adds a Bereich
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Bereich $bereich
	 * @return void
	 */
	public function addBereich(\Glacryl\Glshop\Domain\Model\Bereich $bereich) {
		$this->bereich->attach($bereich);
	}
 
	/**
	 * Removes a Bereich
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Bereich $bereichToRemove The Bereich to be removed
	 * @return void
	 */
	public function removeBereich(\Glacryl\Glshop\Domain\Model\Bereich $bereichToRemove) {
		$this->bereich->detach($bereichToRemove);
	}
	
	/**
	 * Returns the uid
	 * 
	 * @return integer $uid
	 */
	public function getUid() {
		return $this->uid;
	}

	/**
	 * Returns the pid
	 * 
	 * @return integer $pid
	 */	
	public function getPid() {
		return $this->pid;
	}

	/**
	 * Returns the name
	 * 
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns the farbe
	 * 
	 * @return string $farbe
	 */
	public function getFarbe() {
		return $this->farbe;
	}

	/**
	 * Sets the uid
	 * 
	 * @param integer $uid
	 * @return void
	 */
	public function setUid($uid) {
		$this->uid = $uid;
	}

	/**
	 * Sets the pid
	 * 
	 * @param integer $pid
	 * @return void
	 */
	public function setPid($pid) {
		$this->pid = $pid;
	}

	/**
	 * Sets the name
	 * 
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Sets the farbe
	 * 
	 * @param string $farbe
	 * @return void
	 */
	public function setFarbe($farbe) {
		$this->farbe = $farbe;
	}



}
