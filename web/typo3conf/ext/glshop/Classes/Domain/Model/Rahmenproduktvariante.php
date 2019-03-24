<?php

namespace Glacryl\Glshop\Domain\Model;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Petro Dikij <petro.dikij@glacryl.de>, Glacryl Hedel GmbH
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
 * Rahmenproduktvariante
 */
class Rahmenproduktvariante extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * beschreibung
	 *
	 * @var string
	 */
	protected $beschreibung = '';

	/**
	 * bild
	 *
	 * @var string
	 */
	protected $bild = '';

	/**
	 * artNr
	 *
	 * @var string
	 */
	protected $artNr = '';

	/**
	 * laenge
	 *
	 * @var float
	 */
	protected $laenge = 0.0;

	/**
	 * dicke
	 *
	 * @var float
	 */
	protected $dicke = 0.0;

	/**
	 * sicherheit
	 *
	 * @var integer
	 */
	protected $sicherheit = 0;

	/**
	 * preis
	 *
	 * @var float
	 */
	protected $preis = 0.0;

	/**
	 * sonder
	 *
	 * @var integer
	 */
	protected $sonder = 0;

	/**
	 * hidden
	 *
	 * @var integer
	 */
	protected $hidden = 0;
	
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
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
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
	 * Returns the beschreibung
	 *
	 * @return string $beschreibung
	 */
	public function getBeschreibung() {
		return $this->beschreibung;
	}

	/**
	 * Sets the beschreibung
	 *
	 * @param string $beschreibung
	 * @return void
	 */
	public function setBeschreibung($beschreibung) {
		$this->beschreibung = $beschreibung;
	}

	/**
	 * Returns the bild
	 *
	 * @return string $bild
	 */
	public function getBild() {
		return $this->bild;
	}

	/**
	 * Sets the bild
	 *
	 * @param string $bild
	 * @return void
	 */
	public function setBild($bild) {
		$this->bild = $bild;
	}

	/**
	 * Returns the artNr
	 *
	 * @return string $artNr
	 */
	public function getArtNr() {
		return $this->artNr;
	}

	/**
	 * Sets the artNr
	 *
	 * @param string $artNr
	 * @return void
	 */
	public function setArtNr($artNr) {
		$this->artNr = $artNr;
	}

	/**
	 * Returns the laenge
	 *
	 * @return float $laenge
	 */
	public function getLaenge() {
		return $this->laenge;
	}

	/**
	 * Sets the laenge
	 *
	 * @param float $laenge
	 * @return void
	 */
	public function setLaenge($laenge) {
		$this->laenge = $laenge;
	}

	/**
	 * Returns the sicherheit
	 *
	 * @return integer $sicherheit
	 */
	public function getSicherheit() {
		return $this->sicherheit;
	}

	/**
	 * Sets the sicherheit
	 *
	 * @param integer $sicherheit
	 * @return void
	 */
	public function setSicherheit($sicherheit) {
		$this->sicherheit = $sicherheit;
	}

	/**
	 * Returns the dicke
	 *
	 * @return float $dicke
	 */
	public function getDicke() {
		return $this->dicke;
	}

	/**
	 * Sets the dicke
	 *
	 * @param float $dicke
	 * @return void
	 */
	public function setDicke($dicke) {
		$this->dicke = $dicke;
	}

	/**
	 * Returns the sonder
	 *
	 * @return integer $sonder
	 */
	public function getSonder() {
		return $this->sonder;
	}

	/**
	 * Sets the sonder
	 *
	 * @param integer $sonder
	 * @return void
	 */
	public function setSonder($sonder) {
		$this->sonder = $sonder;
	}
	
	/**
	 * Returns the hidden
	 *
	 * @return integer $hidden
	 */
	public function getHidden() {
		return $this->hidden;
	}

	/**
	 * Sets the hidden
	 *
	 * @param integer $hidden
	 * @return void
	 */
	public function setHidden($hidden) {
		$this->hidden = $hidden;
	}
	

	/**
	 * Returns the preis
	 *
	 * @return float $preis
	 */
	public function getPreis() {
		return $this->preis;
	}

	/**
	 * Sets the preis
	 *
	 * @param float $preis
	 * @return void
	 */
	public function setPreis($preis) {
		$this->preis = $preis;
	}

}
