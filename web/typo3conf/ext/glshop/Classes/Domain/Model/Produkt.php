<?php
namespace Glacryl\Glshop\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Petro Dikij <petro.dikij@glacryl.de>, Glacryl Hedel GmbH
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
 * Produkt
 */
class Produkt extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * anzeigeName
	 *
	 * @var string
	 */
	protected $anzeigeName = '';

	/**
	 * bild
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $bild = NULL;

	/**
	 * einzelVerkauf
	 *
	 * @var boolean
	 */
	protected $einzelVerkauf = FALSE;

	/**
	 * eigenschaften
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaften>
	 * @cascade remove
	 */
	protected $eigenschaften = NULL;

	/**
	 * produktvarianten
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Produktvarianten>
	 * @cascade remove
	 */
	protected $produktvarianten = NULL;

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
	 * Returns the anzeigeName
	 *
	 * @return string $anzeigeName
	 */
	public function getAnzeigeName() {
		return $this->anzeigeName;
	}

	/**
	 * Sets the anzeigeName
	 *
	 * @param string $anzeigeName
	 * @return void
	 */
	public function setAnzeigeName($anzeigeName) {
		$this->anzeigeName = $anzeigeName;
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
		$this->eigenschaften = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->produktvarianten = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Adds a Produktvarianten
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produktvarianten $produktvarianten
	 * @return void
	 */
	public function addProduktvarianten(\Glacryl\Glshop\Domain\Model\Produktvarianten $produktvarianten) {
		$this->produktvarianten->attach($produktvarianten);
	}

	/**
	 * Removes a Produktvarianten
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produktvarianten $produktvariantenToRemove The Produktvarianten to be removed
	 * @return void
	 */
	public function removeProduktvarianten(\Glacryl\Glshop\Domain\Model\Produktvarianten $produktvariantenToRemove) {
		$this->produktvarianten->detach($produktvariantenToRemove);
	}

	/**
	 * Returns the produktvarianten
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Produktvarianten> $produktvarianten
	 */
	public function getProduktvarianten() {
		return $this->produktvarianten;
	}

	/**
	 * Sets the produktvarianten
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Produktvarianten> $produktvarianten
	 * @return void
	 */
	public function setProduktvarianten(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $produktvarianten) {
		$this->produktvarianten = $produktvarianten;
	}

	/**
	 * Returns the bild
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $bild
	 */
	public function getBild() {
		return $this->bild;
	}

	/**
	 * Sets the bild
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $bild
	 * @return void
	 */
	public function setBild(\TYPO3\CMS\Extbase\Domain\Model\FileReference $bild) {
		$this->bild = $bild;
	}

	/**
	 * Adds a Produkteigenschaften
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Eigenschaften $eigenschaften
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaften> eigenschaften
	 */
	public function addEigenschaften(\Glacryl\Glshop\Domain\Model\Eigenschaften $eigenschaften) {
		$this->eigenschaften->attach($eigenschaften);
	}

	/**
	 * Removes a Produkteigenschaften
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Eigenschaften $eigenschaftenToRemove The Eigenschaften to be removed
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaften> eigenschaften
	 */
	public function removeEigenschaften(\Glacryl\Glshop\Domain\Model\Eigenschaften $eigenschaftenToRemove) {
		$this->eigenschaften->detach($eigenschaftenToRemove);
	}

	/**
	 * Returns the eigenschaften
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaften> eigenschaften
	 */
	public function getEigenschaften() {
		return $this->eigenschaften;
	}

	/**
	 * Sets the eigenschaften
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaften> $eigenschaften
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaften> eigenschaften
	 */
	public function setEigenschaften(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $eigenschaften) {
		$this->eigenschaften = $eigenschaften;
	}

	/**
	 * Returns the einzelVerkauf
	 *
	 * @return boolean $einzelVerkauf
	 */
	public function getEinzelVerkauf() {
		return $this->einzelVerkauf;
	}

	/**
	 * Sets the einzelVerkauf
	 *
	 * @param boolean $einzelVerkauf
	 * @return void
	 */
	public function setEinzelVerkauf($einzelVerkauf) {
		$this->einzelVerkauf = $einzelVerkauf;
	}

	/**
	 * Returns the boolean state of einzelVerkauf
	 *
	 * @return boolean
	 */
	public function isEinzelVerkauf() {
		return $this->einzelVerkauf;
	}

}