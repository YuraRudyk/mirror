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
 * Gutschein
 */
class Gutschein extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * code
	 *
	 * @var string
	 */
	protected $code = '';

	/**
	 * wert
	 *
	 * @var float
	 */
	protected $wert = 0.0;

	/**
	 * prozent
	 *
	 * @var boolean
	 */
	protected $prozent = FALSE;

	/**
	 * ab
	 *
	 * @var \DateTime
	 */
	protected $ab = NULL;

	/**
	 * bis
	 *
	 * @var \DateTime
	 */
	protected $bis = NULL;

	/**
	 * anzahl
	 *
	 * @var integer
	 */
	protected $anzahl = 0;

	/**
	 * unbegrenzt
	 *
	 * @var boolean
	 */
	protected $unbegrenzt = FALSE;

	/**
	 * abgelaufen
	 *
	 * @var boolean
	 */
	protected $abgelaufen = FALSE;

	/**
	 * abWert
	 *
	 * @var float
	 */
	protected $abWert = 0.0;

	/**
	 * kundeBeliebig
	 *
	 * @var boolean
	 */
	protected $kundeBeliebig = FALSE;

	/**
	 * kundeBeliebigFest
	 *
	 * @var boolean
	 */
	protected $kundeBeliebigFest = FALSE;

	/**
	 * Kunde
	 *
	 * @var integer
	 */
	protected $user = NULL;

	/**
	 * restWert
	 *
	 * @var boolean
	 */
	protected $restWert = FALSE;

	/**
	 * Returns the boolean state of prozent
	 *
	 * @return boolean
	 */
	public function isProzent() {
		return $this->prozent;
	}

	/**
	 * Returns the boolean state of unbegrenzt
	 *
	 * @return boolean
	 */
	public function isUnbegrenzt() {
		return $this->unbegrenzt;
	}

	/**
	 * Returns the boolean state of abgelaufen
	 *
	 * @return boolean
	 */
	public function isAbgelaufen() {
		return $this->abgelaufen;
	}

	/**
	 * Returns the boolean state of kundeBeliebig
	 *
	 * @return boolean
	 */
	public function isKundeBeliebig() {
		return $this->kundeBeliebig;
	}

	/**
	 * Returns the boolean state of kundeBeliebigFest
	 *
	 * @return boolean
	 */
	public function isKundeBeliebigFest() {
		return $this->kundeBeliebigFest;
	}

	/**
	 * Returns the name
	 *
	 * @return string name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return string name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the code
	 *
	 * @return string code
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * Sets the code
	 *
	 * @param string $code
	 * @return string code
	 */
	public function setCode($code) {
		$this->code = $code;
	}

	/**
	 * Returns the wert
	 *
	 * @return float wert
	 */
	public function getWert() {
		return $this->wert;
	}

	/**
	 * Sets the wert
	 *
	 * @param float $wert
	 * @return float wert
	 */
	public function setWert($wert) {
		$this->wert = $wert;
	}

	/**
	 * Returns the prozent
	 *
	 * @return boolean prozent
	 */
	public function getProzent() {
		return $this->prozent;
	}

	/**
	 * Sets the prozent
	 *
	 * @param boolean $prozent
	 * @return boolean prozent
	 */
	public function setProzent($prozent) {
		$this->prozent = $prozent;
	}

	/**
	 * Returns the ab
	 *
	 * @return \DateTime ab
	 */
	public function getAb() {
		return $this->ab;
	}

	/**
	 * Sets the ab
	 *
	 * @param \DateTime $ab
	 * @return \DateTime ab
	 */
	public function setAb(\DateTime $ab) {
		$this->ab = $ab;
	}

	/**
	 * Returns the bis
	 *
	 * @return \DateTime bis
	 */
	public function getBis() {
		return $this->bis;
	}

	/**
	 * Sets the bis
	 *
	 * @param \DateTime $bis
	 * @return \DateTime bis
	 */
	public function setBis(\DateTime $bis) {
		$this->bis = $bis;
	}

	/**
	 * Returns the anzahl
	 *
	 * @return integer anzahl
	 */
	public function getAnzahl() {
		return $this->anzahl;
	}

	/**
	 * Sets the anzahl
	 *
	 * @param integer $anzahl
	 * @return integer anzahl
	 */
	public function setAnzahl($anzahl) {
		$this->anzahl = $anzahl;
	}

	/**
	 * Returns the unbegrenzt
	 *
	 * @return boolean unbegrenzt
	 */
	public function getUnbegrenzt() {
		return $this->unbegrenzt;
	}

	/**
	 * Sets the unbegrenzt
	 *
	 * @param boolean $unbegrenzt
	 * @return boolean unbegrenzt
	 */
	public function setUnbegrenzt($unbegrenzt) {
		$this->unbegrenzt = $unbegrenzt;
	}

	/**
	 * Returns the abgelaufen
	 *
	 * @return boolean abgelaufen
	 */
	public function getAbgelaufen() {
		return $this->abgelaufen;
	}

	/**
	 * Sets the abgelaufen
	 *
	 * @param boolean $abgelaufen
	 * @return boolean abgelaufen
	 */
	public function setAbgelaufen($abgelaufen) {
		$this->abgelaufen = $abgelaufen;
	}

	/**
	 * Returns the abWert
	 *
	 * @return float abWert
	 */
	public function getAbWert() {
		return $this->abWert;
	}

	/**
	 * Sets the abWert
	 *
	 * @param float $abWert
	 * @return float abWert
	 */
	public function setAbWert($abWert) {
		$this->abWert = $abWert;
	}

	/**
	 * Returns the kundeBeliebig
	 *
	 * @return boolean kundeBeliebig
	 */
	public function getKundeBeliebig() {
		return $this->kundeBeliebig;
	}

	/**
	 * Sets the kundeBeliebig
	 *
	 * @param boolean $kundeBeliebig
	 * @return boolean kundeBeliebig
	 */
	public function setKundeBeliebig($kundeBeliebig) {
		$this->kundeBeliebig = $kundeBeliebig;
	}

	/**
	 * Returns the kundeBeliebigFest
	 *
	 * @return boolean kundeBeliebigFest
	 */
	public function getKundeBeliebigFest() {
		return $this->kundeBeliebigFest;
	}

	/**
	 * Sets the kundeBeliebigFest
	 *
	 * @param boolean $kundeBeliebigFest
	 * @return boolean kundeBeliebigFest
	 */
	public function setKundeBeliebigFest($kundeBeliebigFest) {
		$this->kundeBeliebigFest = $kundeBeliebigFest;
	}

	/**
	 * Returns the user
	 *
	 * @return $user
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Sets the user
	 *
	 * @param integer $user
	 * @return void
	 */
	public function setUser($user) {
		$this->user = $user;
	}

	/**
	 * Returns the restWert
	 *
	 * @return boolean $restWert
	 */
	public function getRestWert() {
		return $this->restWert;
	}

	/**
	 * Sets the restWert
	 *
	 * @param boolean $restWert
	 * @return void
	 */
	public function setRestWert($restWert) {
		$this->restWert = $restWert;
	}

	/**
	 * Returns the boolean state of restWert
	 *
	 * @return boolean
	 */
	public function isRestWert() {
		return $this->restWert;
	}

}