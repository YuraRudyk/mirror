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
 * Kategorie
 */
class Kategorie extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * bild
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $bild = NULL;

	/**
	 * produkte
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Produkt>
	 * @cascade remove
	 */
	protected $produkte = NULL;

	/**
	 * shopbereiche
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Shopbereiche>
	 */
	protected $shopbereiche = NULL;

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
		$this->produkte = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->shopbereiche = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Adds a Produkt
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produkt $produkte
	 * @return void
	 */
	public function addProdukte(\Glacryl\Glshop\Domain\Model\Produkt $produkte) {
		$this->produkte->attach($produkte);
	}

	/**
	 * Removes a Produkt
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produkt $produkteToRemove The Produkt to be removed
	 * @return void
	 */
	public function removeProdukte(\Glacryl\Glshop\Domain\Model\Produkt $produkteToRemove) {
		$this->produkte->detach($produkteToRemove);
	}

	/**
	 * Returns the produkte
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Produkt> $produkte
	 */
	public function getProdukte() {
		return $this->produkte;
	}

	/**
	 * Sets the produkte
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Produkt> $produkte
	 * @return void
	 */
	public function setProdukte(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $produkte) {
		$this->produkte = $produkte;
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
	 * Adds a Shopbereiche
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Shopbereiche $shopbereiche
	 * @return void
	 */
	public function addShopbereiche(\Glacryl\Glshop\Domain\Model\Shopbereiche $shopbereiche) {
		$this->shopbereiche->attach($shopbereiche);
	}

	/**
	 * Removes a Shopbereiche
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Shopbereiche $shopbereicheToRemove The Shopbereiche to be removed
	 * @return void
	 */
	public function removeShopbereiche(\Glacryl\Glshop\Domain\Model\Shopbereiche $shopbereicheToRemove) {
		$this->shopbereiche->detach($shopbereicheToRemove);
	}

	/**
	 * Returns the shopbereiche
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Shopbereiche> $shopbereiche
	 */
	public function getShopbereiche() {
		return $this->shopbereiche;
	}

	/**
	 * Sets the shopbereiche
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Shopbereiche> $shopbereiche
	 * @return void
	 */
	public function setShopbereiche(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $shopbereiche) {
		$this->shopbereiche = $shopbereiche;
	}

}