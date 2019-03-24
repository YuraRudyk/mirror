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
 * Rahmenprodukt
 */
class Rahmenprodukt extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

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
	 * frontscheibe
	 *
	 * @var integer
	 */
	protected $frontscheibe = 0;

	/**
	 * preis
	 *
	 * @var float
	 */
	protected $preis = 0.0;

	/**
	 * variante
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Rahmenproduktvariante>
	 * @cascade remove
	 */
	protected $variante = NULL;

	/**
	 * hidden
	 *
	 * @var integer
	 */
	protected $hidden = 0;

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
	 * Returns the frontscheibe
	 *
	 * @return integer $frontscheibe
	 */
	public function getFrontscheibe() {
		return $this->frontscheibe;
	}

	/**
	 * Sets the frontscheibe
	 *
	 * @param integer $frontscheibe
	 * @return void
	 */
	public function setFrontscheibe($frontscheibe) {
		$this->frontscheibe = $frontscheibe;
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
		$this->variante = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Adds a Rahmenproduktvariante
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Rahmenproduktvariante $variante
	 * @return void
	 */
	public function addVariante(\Glacryl\Glshop\Domain\Model\Rahmenproduktvariante $variante) {
		$this->variante->attach($variante);
	}

	/**
	 * Removes a Rahmenproduktvariante
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Rahmenproduktvariante $varianteToRemove The Rahmenproduktvariante to be removed
	 * @return void
	 */
	public function removeVariante(\Glacryl\Glshop\Domain\Model\Rahmenproduktvariante $varianteToRemove) {
		$this->variante->detach($varianteToRemove);
	}

	/**
	 * Returns the variante
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Rahmenproduktvariante> $variante
	 */
	public function getVariante() {
		return $this->variante;
	}

	/**
	 * Sets the variante
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Rahmenproduktvariante> $variante
	 * @return void
	 */
	public function setVariante(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $variante) {
		$this->variante = $variante;
	}

}
