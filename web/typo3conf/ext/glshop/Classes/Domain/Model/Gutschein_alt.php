<?php

namespace Glacryl\Glshop\Domain\Model;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Petro Dikij <petro.dikij@glacryl.de>, Glacryl Hedel GmbH
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
 * ************************************************************* */

/**
 * Preisgestaltung
 */
class Gutschein extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * uid
	 *
	 * @var integer
	 */
	protected $uid = 0;

	/**
	 * pid
	 *
	 * @var integer
	 */
	protected $pid = 0;

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
	protected $wert = 0;

	/**
	 * prozent
	 *
	 * @var integer
	 */
	protected $prozent = 0;

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
	 * kundenId
	 *
	 * @var integer
	 */
	protected $kundenId = 0;

	/**
	 * abgelaufen
	 *
	 * @var integer
	 */
	protected $abgelaufen = 0;

	/**
	 * Returns the uid
	 *
	 * @return integer $uid
	 */
	public function getUid() {
		return $this->uid;
	}

	/**
	 * Returns the pid
	 *
	 * @return integer $pid
	 */
	public function getPid() {
		return $this->pid;
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
	 * Returns the code
	 *
	 * @return string $code
	 */
	public function getCode() {
		return $this->code;
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
	 * Returns the prozent
	 *
	 * @return integer $prozent
	 */
	public function getProzent() {
		return $this->prozent;
	}

	/**
	 * Returns the ab
	 *
	 * @return \DateTime $ab
	 */
	public function getAb() {
		return $this->ab;
	}

	/**
	 * Returns the bis
	 *
	 * @return \DateTime $bis
	 */
	public function getBis() {
		return $this->bis;
	}

	/**
	 * Returns the anzahl
	 *
	 * @return integer $anzahl
	 */
	public function getAnzahl() {
		return $this->anzahl;
	}

	/**
	 * Returns the kundenId
	 *
	 * @return integer $kundenId
	 */
	public function getKundenId() {
		return $this->kundenId;
	}

	/**
	 * Returns the abgelaufen
	 *
	 * @return integer $abgelaufen
	 */
	public function getAbgelaufen() {
		return $this->abgelaufen;
	}

	/**
	 * Sets the uid
	 *
	 * @param integer $uid
	 * @return void
	 */
	public function setUid($uid) {
		$this->uid = $uid;
	}

	/**
	 * Sets the pid
	 *
	 * @param integer $pid
	 * @return void
	 */
	public function setPid($pid) {
		$this->pid = $pid;
	}

	/**
	 * Sets the name
	 *
	 * @param String $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Sets the code
	 *
	 * @param String $code
	 * @return void
	 */
	public function setCode($code) {
		$this->code = $code;
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

	/**
	 * Sets the prozent
	 *
	 * @param integer $prozent
	 * @return void
	 */
	public function setProzent($prozent) {
		$this->prozent = $prozent;
	}

	/**
	 * Sets the ab
	 *
	 * @param \DateTime $ab
	 * @return void
	 */
	public function setAb(\DateTime $ab) {
		$this->ab = $ab;
	}

	/**
	 * Sets the bis
	 *
	 * @param \DateTime $bis
	 * @return void
	 */
	public function setBis(\DateTime $bis) {
		$this->bis = $bis;
	}

	/**
	 * Sets the anzahl
	 *
	 * @param integer $anzahl
	 * @return void
	 */
	public function setAnzahl($anzahl) {
		$this->anzahl = $anzahl;
	}

	/**
	 * Sets the kundenId
	 *
	 * @param integer $kundenId
	 * @return void
	 */
	public function setKundenId($kundenId) {
		$this->kundenId = $kundenId;
	}

	/**
	 * Sets the abgelaufen
	 *
	 * @param integer $abgelaufen
	 * @return void
	 */
	public function setAbgelaufen($abgelaufen) {
		$this->abgelaufen = $abgelaufen;
	}

}
