<?php

namespace Glacryl\Glshop\Domain\Model;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2018
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
 * Partner
 */
class Partner extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Kunde
	 *
	 * @var integer
	 */
	protected $kunde = NULL;

	/**
	 * pid
	 *
	 * @var integer
	 */
	protected $pid = 0;

	/**
	 * firmenname
	 *
	 * @var string
	 */
	protected $firmenname = '';

	/**
	 * partnernummer
	 *
	 * @var string
	 */
	protected $partnernummer = '';

	/**
	 * partnerliste
	 *
	 * @var \Glacryl\Glshop\Domain\Model\Partnerlisten
	 */
	protected $partnerliste = NULL;

	/**
	 * bestaetigt
	 *
	 * @var bool
	 */
	protected $bestaetigt = FALSE;

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
		
	}

	/**
	 * Returns the firmenname
	 *
	 * @return string $firmenname
	 */
	public function getFirmenname() {
		return $this->firmenname;
	}

	/**
	 * Sets the firmenname
	 *
	 * @param string $firmenname
	 * @return void
	 */
	public function setFirmenname($firmenname) {
		$this->firmenname = $firmenname;
	}

	/**
	 * Returns the partnernummer
	 *
	 * @return string $partnernummer
	 */
	public function getPartnernummer() {
		return $this->partnernummer;
	}

	/**
	 * Sets the partnernummer
	 *
	 * @param string $partnernummer
	 * @return void
	 */
	public function setPartnernummer($partnernummer) {
		$this->partnernummer = $partnernummer;
	}

	/**
	 * Returns the partnerliste
	 *
	 * @return \Glacryl\Glshop\Domain\Model\Partnerlisten $partnerliste
	 */
	public function getPartnerliste() {
		return $this->partnerliste;
	}

	/**
	 * Sets the partnerliste
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Partnerlisten $partnerliste
	 * @return void
	 */
	public function setPartnerliste(\Glacryl\Glshop\Domain\Model\Partnerlisten $partnerliste) {
		$this->partnerliste = $partnerliste;
	}

	/**
	 * Returns the kunde
	 *
	 * @return integer kunde
	 */
	public function getKunde() {
		return $this->kunde;
	}

	/**
	 * Sets the kunde
	 *
	 * @param integer $kunde
	 */
	public function setKunde($kunde) {
		$this->kunde = $kunde;
	}

	/**
	 * Returns the bestaetigt
	 *
	 * @return bool $bestaetigt
	 */
	public function getBestaetigt() {
		return $this->bestaetigt;
	}

	/**
	 * Sets the bestaetigt
	 *
	 * @param bool $bestaetigt
	 * @return void
	 */
	public function setBestaetigt($bestaetigt) {
		$this->bestaetigt = $bestaetigt;
	}

	/**
	 * Returns the boolean state of bestaetigt
	 *
	 * @return bool
	 */
	public function isBestaetigt() {
		return $this->bestaetigt;
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
	 * Sets the pid
	 *
	 * @param integer $pid
	 * @return void
	 */
	public function setPid($pid) {
		$this->pid = $pid;
	}

}
