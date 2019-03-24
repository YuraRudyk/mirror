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
 * Rechnungsbuch
 */
class Rechnungsbuch extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * pid
	 *
	 * @var integer
	 */
	protected $pid = 0;

	/**
	 * Status
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Status>
	 * @cascade remove
	 */
	protected $status = NULL;

	/**
	 * Order
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Order>
	 * @cascade remove
	 */
	protected $bestellung = NULL;

	/**
	 * termin
	 *
	 * @var \DateTime
	 */
	protected $termin = NULL;

	/**
	 * netto
	 *
	 * @var float
	 */
	protected $netto = 0.0;

	/**
	 * steuer
	 *
	 * @var float
	 */
	protected $steuer = 0.0;

	/**
	 * brutto
	 *
	 * @var float
	 */
	protected $brutto = 0.0;

	/**
	 * eingangZahlung
	 *
	 * @var \DateTime
	 */
	protected $eingangZahlung = NULL;

	/**
	 * abschluss
	 *
	 * @var integer
	 */
	protected $abschluss = 0;	
	
	/**
	 * arbeitszeit
	 *
	 * @var float
	 */
	protected $arbeitszeit = 0.0;	
	
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
		$this->bestellung = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->status = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * Returns the Status
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Status> $status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Returns the Bestellung
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Order> $bestellung
	 */
	public function getBestellung() {
		return $this->bestellung;
	}

	/**
	 * Returns the termin
	 * 
	 * @return \DateTime $termin
	 */
	public function getTermin() {
		return $this->termin;
	}

	/**
	 * Returns the netto
	 * 
	 * @return float $netto
	 */
	public function getNetto() {
		return $this->netto;
	}
	
	/**
	 * Returns the steuer
	 * 
	 * @return float $steuer
	 */
	public function getSteuer() {
		return $this->steuer;
	}

	/**
	 * Returns the brutto
	 * 
	 * @return float $brutto
	 */
	public function getBrutto() {
		return $this->brutto;
	}

	/**
	 * Returns the eingangZahlung
	 * 
	 * @return \DateTime $eingangZahlung
	 */
	public function getEingangZahlung() {
		return $this->eingangZahlung;
	}

	/**
	 * Returns the abschlusss
	 * @return integer $abschluss
	 */
	public function getAbschluss() {
		return $this->abschluss;
	}
	
	/**
	 * Returns the arbeitszeit
	 * @return float $arbeitszeit
	 */
	public function getArbeitszeit() {
		return $this->arbeitszeit; 
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
	 * Adds a Status
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Status $status
	 * @return void
	 */
	public function addStatus(\Glacryl\Glshop\Domain\Model\Status $status) {
		$this->status->attach($status);
	}

	/**
	 * Removes a Status
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Status $statusToRemove The Status to be removed
	 * @return void
	 */
	public function removeStatus(\Glacryl\Glshop\Domain\Model\Status $statusToRemove) {
		$this->status->detach($statusToRemove);
	}
	
	/**
	 * Adds an Bestellung
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Order $bestellung
	 * @return void
	 */
	public function addBestellung(\Glacryl\Glshop\Domain\Model\Order $bestellung) {
		$this->bestellung->attach($bestellung);
	}

	/**
	 * Removes an Bestellung
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Order $bestellungToRemove The Order to be removed
	 * @return void
	 */
	public function removeBestellung(\Glacryl\Glshop\Domain\Model\Order $bestellungToRemove) {
		$this->bestellung->detach($bestellungToRemove);
	}

	/**
	 * Sets the termin
	 *
	 * @param \DateTime $termin
	 * @return void
	 */
	public function setTermin(\DateTime $termin) {
		$this->termin = $termin;
	}

	/**
	 * Sets the netto
	 *
	 * @param float $netto
	 * @return void
	 */
	public function setNetto($netto) {
		$this->netto = $netto;
	}

	/**
	 * Sets the steuer
	 *
	 * @param float $steuer
	 * @return void
	 */
	public function setSteuer($steuer) {
		$this->steuer = $steuer;
	}

	/**
	 * Sets the brutto
	 *
	 * @param float $brutto
	 * @return void
	 */
	public function setBrutto($brutto) {
		$this->brutto = $brutto;
	}

	/**
	 * Sets the eingangZahlung
	 *
	 * @param \DateTime $eingangZahlung
	 * @return void
	 */
	public function setEingangZahlung(\DateTime $eingangZahlung) {
		$this->eingangZahlung = $eingangZahlung;
	}

	/**
	 * Sets the abschluss
	 *
	 * @param integer $abschluss
	 * @return void
	 */
	public function setAbschluss($abschluss) {
		$this->abschluss = $abschluss;
	}
	
	/**
	 * Sets the arbeitszeit
	 *
	 * @param float $arbeitszeit
	 * @return void
	 */
	public function setArbeitszeit($arbeitszeit) {
		$this->arbeitszeit = $arbeitszeit;
	}
}
