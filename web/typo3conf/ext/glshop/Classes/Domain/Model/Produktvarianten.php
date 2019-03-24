<?php
namespace Glacryl\Glshop\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017
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
 * Produkteigenschaften
 */
class Produktvarianten extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

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
	 * bilder
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $bilder = NULL;

	/**
	 * eingeschaftenset
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaftenset>
	 * @cascade remove
	 */
	protected $eingeschaftenset = NULL;

	/**
	 * bearbeitungen
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Bearbeitungen>
	 */
	protected $bearbeitungen = NULL;

	/**
	 * Zwingender Ausschluss für Konfigurator
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Kategorie>
	 */
	protected $ausschlussKategorie = NULL;

	/**
	 * Zwingender Ausschluss für Konfigurator
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Produkt>
	 */
	protected $ausschlussProdukt = NULL;

	/**
	 * Zwingender Ausschluss für Konfigurator
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Produktvarianten>
	 */
	protected $ausschlussVariante = NULL;

	/**
	 * Zwingendes Zubehör für Konfigurator
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Produkt>
	 */
	protected $zubehoer = NULL;

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
		$this->eingeschaftenset = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->bearbeitungen = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->ausschlussKategorie = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->ausschlussProdukt = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->ausschlussVariante = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->zubehoer = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Adds a Eigenschaftenset
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Eigenschaftenset $eingeschaftenset
	 * @return void
	 */
	public function addEingeschaftenset(\Glacryl\Glshop\Domain\Model\Eigenschaftenset $eingeschaftenset) {
		$this->eingeschaftenset->attach($eingeschaftenset);
	}

	/**
	 * Removes a Eigenschaftenset
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Eigenschaftenset $eingeschaftensetToRemove The Eigenschaftenset to be removed
	 * @return void
	 */
	public function removeEingeschaftenset(\Glacryl\Glshop\Domain\Model\Eigenschaftenset $eingeschaftensetToRemove) {
		$this->eingeschaftenset->detach($eingeschaftensetToRemove);
	}

	/**
	 * Returns the eingeschaftenset
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaftenset> $eingeschaftenset
	 */
	public function getEingeschaftenset() {
		return $this->eingeschaftenset;
	}

	/**
	 * Sets the eingeschaftenset
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaftenset> $eingeschaftenset
	 * @return void
	 */
	public function setEingeschaftenset(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $eingeschaftenset) {
		$this->eingeschaftenset = $eingeschaftenset;
	}

	/**
	 * Returns the bilder
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $bilder
	 */
	public function getBilder() {
		return $this->bilder;
	}

	/**
	 * Sets the bilder
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $bilder
	 * @return void
	 */
	public function setBilder(\TYPO3\CMS\Extbase\Domain\Model\FileReference $bilder) {
		$this->bilder = $bilder;
	}

	/**
	 * Adds a Bearbeitungen
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Bearbeitungen $bearbeitungen
	 * @return void
	 */
	public function addBearbeitungen(\Glacryl\Glshop\Domain\Model\Bearbeitungen $bearbeitungen) {
		$this->bearbeitungen->attach($bearbeitungen);
	}

	/**
	 * Removes a Bearbeitungen
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Bearbeitungen $bearbeitungenToRemove The Bearbeitungen to be removed
	 * @return void
	 */
	public function removeBearbeitungen(\Glacryl\Glshop\Domain\Model\Bearbeitungen $bearbeitungenToRemove) {
		$this->bearbeitungen->detach($bearbeitungenToRemove);
	}

	/**
	 * Returns the bearbeitungen
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Bearbeitungen> $bearbeitungen
	 */
	public function getBearbeitungen() {
		return $this->bearbeitungen;
	}

	/**
	 * Sets the bearbeitungen
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Bearbeitungen> $bearbeitungen
	 * @return void
	 */
	public function setBearbeitungen(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $bearbeitungen) {
		$this->bearbeitungen = $bearbeitungen;
	}

	/**
	 * Adds a Produktvarianten
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Kategorie $ausschlussKategorie
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Kategorie> ausschlussKategorie
	 */
	public function addAusschlussKategorie(\Glacryl\Glshop\Domain\Model\Kategorie $ausschlussKategorie) {
		$this->ausschlussKategorie->attach($ausschlussKategorie);
	}

	/**
	 * Removes a Produktvarianten
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Kategorie $ausschlussKategorieToRemove The Kategorie to be removed
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Kategorie> ausschlussKategorie
	 */
	public function removeAusschlussKategorie(\Glacryl\Glshop\Domain\Model\Kategorie $ausschlussKategorieToRemove) {
		$this->ausschlussKategorie->detach($ausschlussKategorieToRemove);
	}

	/**
	 * Returns the ausschlussKategorie
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Kategorie> ausschlussKategorie
	 */
	public function getAusschlussKategorie() {
		return $this->ausschlussKategorie;
	}

	/**
	 * Sets the ausschlussKategorie
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Kategorie> $ausschlussKategorie
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Kategorie> ausschlussKategorie
	 */
	public function setAusschlussKategorie(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $ausschlussKategorie) {
		$this->ausschlussKategorie = $ausschlussKategorie;
	}

	/**
	 * Adds a Produkt
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produkt $ausschlussProdukt
	 * @return void
	 */
	public function addAusschlussProdukt(\Glacryl\Glshop\Domain\Model\Produkt $ausschlussProdukt) {
		$this->ausschlussProdukt->attach($ausschlussProdukt);
	}

	/**
	 * Removes a Produkt
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produkt $ausschlussProduktToRemove The Produkt to be removed
	 * @return void
	 */
	public function removeAusschlussProdukt(\Glacryl\Glshop\Domain\Model\Produkt $ausschlussProduktToRemove) {
		$this->ausschlussProdukt->detach($ausschlussProduktToRemove);
	}

	/**
	 * Returns the ausschlussProdukt
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Produkt> $ausschlussProdukt
	 */
	public function getAusschlussProdukt() {
		return $this->ausschlussProdukt;
	}

	/**
	 * Sets the ausschlussProdukt
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Produkt> $ausschlussProdukt
	 * @return void
	 */
	public function setAusschlussProdukt(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $ausschlussProdukt) {
		$this->ausschlussProdukt = $ausschlussProdukt;
	}

	/**
	 * Adds a Produktvarianten
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produktvarianten $ausschlussVariante
	 * @return void
	 */
	public function addAusschlussVariante(\Glacryl\Glshop\Domain\Model\Produktvarianten $ausschlussVariante) {
		$this->ausschlussVariante->attach($ausschlussVariante);
	}

	/**
	 * Removes a Produktvarianten
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produktvarianten $ausschlussVarianteToRemove The Produktvarianten to be removed
	 * @return void
	 */
	public function removeAusschlussVariante(\Glacryl\Glshop\Domain\Model\Produktvarianten $ausschlussVarianteToRemove) {
		$this->ausschlussVariante->detach($ausschlussVarianteToRemove);
	}

	/**
	 * Returns the ausschlussVariante
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Produktvarianten> $ausschlussVariante
	 */
	public function getAusschlussVariante() {
		return $this->ausschlussVariante;
	}

	/**
	 * Sets the ausschlussVariante
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Produktvarianten> $ausschlussVariante
	 * @return void
	 */
	public function setAusschlussVariante(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $ausschlussVariante) {
		$this->ausschlussVariante = $ausschlussVariante;
	}

	/**
	 * Adds a Produkt
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produkt $zubehoer
	 * @return void
	 */
	public function addZubehoer(\Glacryl\Glshop\Domain\Model\Produkt $zubehoer) {
		$this->zubehoer->attach($zubehoer);
	}

	/**
	 * Removes a Produkt
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produkt $zubehoerToRemove The Produkt to be removed
	 * @return void
	 */
	public function removeZubehoer(\Glacryl\Glshop\Domain\Model\Produkt $zubehoerToRemove) {
		$this->zubehoer->detach($zubehoerToRemove);
	}

	/**
	 * Returns the zubehoer
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Produkt> $zubehoer
	 */
	public function getZubehoer() {
		return $this->zubehoer;
	}

	/**
	 * Sets the zubehoer
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Produkt> $zubehoer
	 * @return void
	 */
	public function setZubehoer(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $zubehoer) {
		$this->zubehoer = $zubehoer;
	}

}