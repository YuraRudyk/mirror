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
 * Eigenschaftenset
 */
class Eigenschaftenset extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * wert
	 *
	 * @var string
	 */
	protected $wert = '';

	/**
	 * eigenschaften
	 *
	 * @var \Glacryl\Glshop\Domain\Model\Eigenschaften
	 */
	protected $eigenschaften = NULL;

	/**
	 * Returns the wert
	 *
	 * @return string $wert
	 */
	public function getWert() {
		return $this->wert;
	}

	/**
	 * Sets the wert
	 *
	 * @param string $wert
	 * @return void
	 */
	public function setWert($wert) {
		$this->wert = $wert;
	}

	/**
	 * Returns the eigenschaften
	 *
	 * @return \Glacryl\Glshop\Domain\Model\Eigenschaften $eigenschaften
	 */
	public function getEigenschaften() {
		return $this->eigenschaften;
	}

	/**
	 * Sets the eigenschaften
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Eigenschaften $eigenschaften
	 * @return void
	 */
	public function setEigenschaften(\Glacryl\Glshop\Domain\Model\Eigenschaften $eigenschaften) {
		$this->eigenschaften = $eigenschaften;
	}

}