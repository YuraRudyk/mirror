<?php
namespace Glacryl\Glshop\Domain\Model;

/***************************************************************
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
 ***************************************************************/

/**
 * Produktart
 */
class Produktart extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

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
	 * produkt
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Rahmenprodukt>
	 * @cascade remove
	 */
	protected $produkt = NULL;

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
		$this->produkt = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Adds a Rahmenprodukt
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Rahmenprodukt $produkt
	 * @return void
	 */
	public function addProdukt(\Glacryl\Glshop\Domain\Model\Rahmenprodukt $produkt) {
		$this->produkt->attach($produkt);
	}

	/**
	 * Removes a Rahmenprodukt
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Rahmenprodukt $produktToRemove The Rahmenprodukt to be removed
	 * @return void
	 */
	public function removeProdukt(\Glacryl\Glshop\Domain\Model\Rahmenprodukt $produktToRemove) {
		$this->produkt->detach($produktToRemove);
	}

	/**
	 * Returns the produkt
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Rahmenprodukt> $produkt
	 */
	public function getProdukt() {
		return $this->produkt;
	}

	/**
	 * Sets the produkt
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Rahmenprodukt> $produkt
	 * @return void
	 */
	public function setProdukt(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $produkt) {
		$this->produkt = $produkt;
	}

}