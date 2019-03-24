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
 * Produktbeziehungen
 */
class Produktbeziehungen extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * minAnzahl
	 *
	 * @var integer
	 */
	protected $minAnzahl = 0;

	/**
	 * bestellungVon
	 *
	 * @var \Glacryl\Glshop\Domain\Model\Produkt
	 */
	protected $bestellungVon = NULL;

	/**
	 * bestellungMit
	 *
	 * @var \Glacryl\Glshop\Domain\Model\Produkt
	 */
	protected $bestellungMit = NULL;

	/**
	 * Returns the bestellungVon
	 *
	 * @return \Glacryl\Glshop\Domain\Model\Produkt $bestellungVon
	 */
	public function getBestellungVon() {
		return $this->bestellungVon;
	}

	/**
	 * Sets the bestellungVon
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produkt $bestellungVon
	 * @return void
	 */
	public function setBestellungVon(\Glacryl\Glshop\Domain\Model\Produkt $bestellungVon) {
		$this->bestellungVon = $bestellungVon;
	}

	/**
	 * Returns the bestellungMit
	 *
	 * @return \Glacryl\Glshop\Domain\Model\Produkt $bestellungMit
	 */
	public function getBestellungMit() {
		return $this->bestellungMit;
	}

	/**
	 * Sets the bestellungMit
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Produkt $bestellungMit
	 * @return void
	 */
	public function setBestellungMit(\Glacryl\Glshop\Domain\Model\Produkt $bestellungMit) {
		$this->bestellungMit = $bestellungMit;
	}

	/**
	 * Returns the minAnzahl
	 *
	 * @return integer $minAnzahl
	 */
	public function getMinAnzahl() {
		return $this->minAnzahl;
	}

	/**
	 * Sets the minAnzahl
	 *
	 * @param integer $minAnzahl
	 * @return void
	 */
	public function setMinAnzahl($minAnzahl) {
		$this->minAnzahl = $minAnzahl;
	}

}