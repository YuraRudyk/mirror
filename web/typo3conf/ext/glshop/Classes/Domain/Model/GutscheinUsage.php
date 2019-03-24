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
 * GutscheinUsage
 */
class GutscheinUsage extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * datum
	 *
	 * @var \DateTime
	 */
	protected $datum = NULL;

	/**
	 * gutschein
	 *
	 * @var \Glacryl\Glshop\Domain\Model\Gutschein
	 */
	protected $gutschein = NULL;

	/**
	 * Kunde
	 *
	 * @var integer
	 */
	protected $user = NULL;

	/**
	 * wert
	 *
	 * @var float
	 */
	protected $wert = 0.0;

	/**
	 * Returns the datum
	 *
	 * @return \DateTime datum
	 */
	public function getDatum() {
		return $this->datum;
	}

	/**
	 * Sets the datum
	 *
	 * @param \DateTime $datum
	 * @return \DateTime datum
	 */
	public function setDatum(\DateTime $datum) {
		$this->datum = $datum;
	}

	/**
	 * Returns the gutschein
	 *
	 * @return \Glacryl\Glshop\Domain\Model\Gutschein gutschein
	 */
	public function getGutschein() {
		return $this->gutschein;
	}

	/**
	 * Sets the gutschein
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Gutschein $gutschein
	 * @return \Glacryl\Glshop\Domain\Model\Gutschein gutschein
	 */
	public function setGutschein(\Glacryl\Glshop\Domain\Model\Gutschein $gutschein) {
		$this->gutschein = $gutschein;
	}

	/**
	 * Returns the user
	 *
	 * @return user
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Sets the user
	 *
	 * @param integer $user
	 * @return user
	 */
	public function setUser($user) {
		$this->user = $user;
	}

	/**
	 * Returns the wert
	 *
	 * @return float $wert
	 */
	public function getWert() {
		return $this->wert;
	}

	/**
	 * Sets the wert
	 *
	 * @param float $wert
	 * @return void
	 */
	public function setWert($wert) {
		$this->wert = $wert;
	}

}