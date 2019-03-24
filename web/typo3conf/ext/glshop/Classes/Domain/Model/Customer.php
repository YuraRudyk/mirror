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
 * Kunden
 */
class Customer extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser {

	/**
	 * Nachname
	 * 
	 * @var string
	 */
	protected $lastName;

	/**
	 * Vorname
	 * 
	 * @var string
	 */
	protected $firstName;

	/**
	 *  Strasse
	 * 
	 * @var string
	 */
	protected $address;

	/**
	 *  Telefon
	 * 
	 * @var string
	 */
	protected $telephone;

	/**
	 *  Fax
	 * 
	 * @var string
	 */
	protected $fax;

	/**
	 *  email
	 * 
	 * @var string
	 */
	protected $email;

	/**
	 *  PLZ
	 * 
	 * @var string
	 */
	protected $zip;

	/**
	 *  Stadt
	 * 
	 * @var string
	 */
	protected $city;

	/**
	 *  Firma
	 * 
	 * @var string
	 */
	protected $company;

	/**
	 *  Geschlecht 0-Mann, 1 Frau
	 * 
	 * @var string
	 */
	protected $gender;

	/**
	 *  UstIdNr
	 * 
	 * @var string
	 */
	protected $ustId;
	
	/**
	 *  werbelandId
	 * 
	 * @var string
	 */
	protected $werbelandId;
	
	

	/**
	 *  Creation Day
	 * 
	 * @var \DateTime
	 */
	protected $created;

	/**
	 * PayCondition
	 *
	 * @var \Glacryl\Glshop\Domain\Model\Conditions
	 */
	protected $payCondition;
	
	/**
	 * Partner
	 *
	 * @var \Glacryl\Glshop\Domain\Model\Partner
	 */
	protected $partner;

	/**
	 * Get Nachname
	 * 
	 * @return string Last Name
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * Get Vorname
	 * 
	 * @return string First Name
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * Get Strasse
	 * 
	 * @return string Strasse
	 */
	public function getAdress() {
		return $this->address;
	}

	/**
	 * Get Telefon
	 * 
	 * @return string Telephone
	 */
	public function getTelephone() {
		return $this->telephone;
	}

	/**
	 * Get Fax
	 * 
	 * @return string Fax
	 */
	public function getFax() {
		return $this->fax;
	}

	/**
	 * Get email
	 * 
	 * @return string Email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Get PLZ
	 * 
	 * @return string PLZ
	 */
	public function getZip() {
		return $this->zip;
	}

	/**
	 * Get Stadt
	 * 
	 * @return string Stadt
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * Get Firma
	 * 
	 * @return string Firma
	 */
	public function getCompany() {
		return $this->company;
	}

	/**
	 * Get Geschlecht
	 * 
	 * @return string Geschlecht
	 */
	public function getGender() {
		return $this->gender;
	}

	/**
	 * Get UstId
	 *  
	 * @return string UstId
	 */
	public function getUstId() {
		return $this->ustId;
	}
	
	/**
	 * Get WerbelandId
	 *  
	 * @return string WerbelandId
	 */
	public function getWerbelandId() {
		return $this->werbelandId;
	}

	/**
	 * Get Created
	 *  
	 * @return \DateTime Created
	 */
	public function getCreated() {
		return $this->created;
	}

	/**
	 * Returns the PayCondition
	 *
	 * @return \Glacryl\Glshop\Domain\Model\Conditions $payCondition
	 */
	public function getPayCondition() {
		return $this->payCondition;
	}

	/**
	 * Sets the PayCondition
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Conditions $payCondition
	 * @return void
	 */
	public function setPayCondition(\Glacryl\Glshop\Domain\Model\Conditions $payCondition) {
		$this->payCondition = $payCondition;
	}
	
	/**
	 * Returns the Partner
	 *
	 * @return \Glacryl\Glshop\Domain\Model\Partner $partner
	 */
	public function getPartner() {
		return $this->partner;
	}

	/**
	 * Set Nachname
	 * 
	 * @var string
	 */
	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	/**
	 * Set Vorname
	 *
	 * @var string  
	 */
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}

	/**
	 * Set Strasse
	 * 
	 * @var string
	 */
	public function setAdress($adress) {
		$this->address = $adress;
	}

	/**
	 * Set Telefon
	 * 
	 * @var string
	 */
	public function setTelephone($telephone) {
		$this->telephone = $telephone;
	}

	/**
	 * Set Fax
	 * 
	 * @var string
	 */
	public function setFax($fax) {
		$this->fax = $fax;
	}

	/**
	 * Set email
	 * 
	 * @var string
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Set PLZ
	 * 
	 * @var string
	 */
	public function setZip($zip) {
		$this->zip = $zip;
	}

	/**
	 * Set Stadt
	 * 
	 * @var string
	 */
	public function setCity($city) {
		$this->city = $city;
	}

	/**
	 * Set Firma
	 * 
	 * @var string
	 */
	public function setCompany($company) {
		$this->company = $company;
	}

	/**
	 * Set Geschlecht
	 * 
	 * @var string
	 */
	public function setGender($gender) {
		$this->gender = $gender;
	}

	/**
	 * Set UstId
	 *  
	 * @var string
	 */
	public function setUstId($ustId) {
		$this->ustId = $ustId;
	}

	/**
	 * Set WerbelandId
	 *  
	 * @var string
	 */
	public function setWerbelandId($werbelandId) {
		$this->werbelandId = $werbelandId;
	}

	public function __construct() {

		$this->initStorageObjects();

		parent::__construct();
	}

}

?>
