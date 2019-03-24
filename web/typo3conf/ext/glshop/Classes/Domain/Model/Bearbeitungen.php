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
 * Bearbeitungen
 */
class Bearbeitungen extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * taetigkeit
	 *
	 * @var string
	 */
	protected $taetigkeit = '';

	/**
	 * haengtAbVon
	 *
	 * @var string
	 */
	protected $haengtAbVon = '';

	/**
	 * zeitvorgabe
	 *
	 * @var float
	 */
	protected $zeitvorgabe = 0.0;

	/**
	 * einheit
	 *
	 * @var string
	 */
	protected $einheit = '';

	/**
	 * minBerechnung
	 *
	 * @var float
	 */
	protected $minBerechnung = 0.0;

	/**
	 * Returns the taetigkeit
	 *
	 * @return string $taetigkeit
	 */
	public function getTaetigkeit() {
		return $this->taetigkeit;
	}

	/**
	 * Sets the taetigkeit
	 *
	 * @param string $taetigkeit
	 * @return void
	 */
	public function setTaetigkeit($taetigkeit) {
		$this->taetigkeit = $taetigkeit;
	}

	/**
	 * Returns the haengtAbVon
	 *
	 * @return string $haengtAbVon
	 */
	public function getHaengtAbVon() {
		return $this->haengtAbVon;
	}

	/**
	 * Sets the haengtAbVon
	 *
	 * @param string $haengtAbVon
	 * @return void
	 */
	public function setHaengtAbVon($haengtAbVon) {
		$this->haengtAbVon = $haengtAbVon;
	}

	/**
	 * Returns the zeitvorgabe
	 *
	 * @return float $zeitvorgabe
	 */
	public function getZeitvorgabe() {
		return $this->zeitvorgabe;
	}

	/**
	 * Sets the zeitvorgabe
	 *
	 * @param float $zeitvorgabe
	 * @return void
	 */
	public function setZeitvorgabe($zeitvorgabe) {
		$this->zeitvorgabe = $zeitvorgabe;
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
	 * Returns the minBerechnung
	 *
	 * @return float $minBerechnung
	 */
	public function getMinBerechnung() {
		return $this->minBerechnung;
	}

	/**
	 * Sets the minBerechnung
	 *
	 * @param float $minBerechnung
	 * @return void
	 */
	public function setMinBerechnung($minBerechnung) {
		$this->minBerechnung = $minBerechnung;
	}

}