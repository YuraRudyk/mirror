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
 * Produktsets
 */
class Produktsets extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

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
	 * produkte
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Produkt>
	 */
	protected $produkte = NULL;

	/**
	 * eigenschaften
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaften>
	 */
	protected $eigenschaften = NULL;

	/**
	 * eigenschaftenset
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaftenset>
	 * @cascade remove
	 */
	protected $eigenschaftenset = NULL;

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
		$this->eigenschaften = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->eigenschaftenset = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * Adds a Eigenschaften
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Eigenschaften $eigenschaften
	 * @return void
	 */
	public function addEigenschaften(\Glacryl\Glshop\Domain\Model\Eigenschaften $eigenschaften) {
		$this->eigenschaften->attach($eigenschaften);
	}

	/**
	 * Removes a Eigenschaften
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Eigenschaften $eigenschaftenToRemove The Eigenschaften to be removed
	 * @return void
	 */
	public function removeEigenschaften(\Glacryl\Glshop\Domain\Model\Eigenschaften $eigenschaftenToRemove) {
		$this->eigenschaften->detach($eigenschaftenToRemove);
	}

	/**
	 * Returns the eigenschaften
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaften> $eigenschaften
	 */
	public function getEigenschaften() {
		return $this->eigenschaften;
	}

	/**
	 * Sets the eigenschaften
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaften> $eigenschaften
	 * @return void
	 */
	public function setEigenschaften(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $eigenschaften) {
		$this->eigenschaften = $eigenschaften;
	}

	/**
	 * Adds a Produktseteingeschaftenset
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Eigenschaftenset $eigenschaftenset
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaftenset> eigenschaftenset
	 */
	public function addEigenschaftenset(\Glacryl\Glshop\Domain\Model\Eigenschaftenset $eigenschaftenset) {
		$this->eigenschaftenset->attach($eigenschaftenset);
	}

	/**
	 * Removes a Produktseteingeschaftenset
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Eigenschaftenset $eigenschaftensetToRemove The Eigenschaftenset to be removed
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaftenset> eigenschaftenset
	 */
	public function removeEigenschaftenset(\Glacryl\Glshop\Domain\Model\Eigenschaftenset $eigenschaftensetToRemove) {
		$this->eigenschaftenset->detach($eigenschaftensetToRemove);
	}

	/**
	 * Returns the eigenschaftenset
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaftenset> eigenschaftenset
	 */
	public function getEigenschaftenset() {
		return $this->eigenschaftenset;
	}

	/**
	 * Sets the eigenschaftenset
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaftenset> $eigenschaftenset
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Eigenschaftenset> eigenschaftenset
	 */
	public function setEigenschaftenset(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $eigenschaftenset) {
		$this->eigenschaftenset = $eigenschaftenset;
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

}