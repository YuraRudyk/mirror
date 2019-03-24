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
 * Eigenschaften
 */
class Eigenschaften extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

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
	 * einheit
	 *
	 * @var string
	 */
	protected $einheit = '';

	/**
	 * datentyp
	 *
	 * @var \Glacryl\Glshop\Domain\Model\Datentypen
	 */
	protected $datentyp = NULL;

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
	 * Returns the einheit
	 *
	 * @return string $einheit
	 */
	public function getEinheit() {
		return $this->einheit;
	}

	/**
	 * Sets the einheit
	 *
	 * @param string $einheit
	 * @return void
	 */
	public function setEinheit($einheit) {
		$this->einheit = $einheit;
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
	 * Returns the datentyp
	 *
	 * @return \Glacryl\Glshop\Domain\Model\Datentypen datentyp
	 */
	public function getDatentyp() {
		return $this->datentyp;
	}

	/**
	 * Sets the datentyp
	 *
	 * @param string $datentyp
	 * @return \Glacryl\Glshop\Domain\Model\Datentypen datentyp
	 */
	public function setDatentyp($datentyp) {
		$this->datentyp = $datentyp;
	}

}