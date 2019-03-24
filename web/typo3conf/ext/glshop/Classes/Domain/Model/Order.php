<?php
namespace Glacryl\Glshop\Domain\Model;


/***************************************************************
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
 ***************************************************************/
/***
 *
 * This file is part of the "Glacryl Shop System" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Petro Dikij <petro.dikij@glacryl.de>, Glacryl Hedel GmbH
 *
 ***/
/**
 * Bestellungen
 */
class Order extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * date
     * 
     * @var \DateTime
     */
    protected $date = NULL;

    /**
     * article
     * 
     * @var string
     */
    protected $article = '';

    /**
     * comment
     * 
     * @var string
     */
    protected $comment = '';

    /**
     * formular
     * 
     * @var string
     */
    protected $formular = '';

    /**
     * Kunde
     * 
     * @var
     */
    protected $user = NULL;

    /**
     * Auftragsbestätigung
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Confirmation>
     * @cascade remove
     */
    protected $confirmation = NULL;

    /**
     * Fertigungsschein
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Production>
     * @cascade remove
     */
    protected $production = NULL;

    /**
     * Lieferschein
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Delivery>
     * @cascade remove
     */
    protected $delivery = NULL;

    /**
     * Rechnung
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Invoice>
     * @cascade remove
     */
    protected $invoice = NULL;

    /**
     * shippingaddress
     * 
     * @var \Glacryl\Glshop\Domain\Model\Shippingaddress
     */
    protected $shippingaddress = NULL;

    /**
     * Bestellstatus
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Orderstatus>
     * @cascade remove
     */
    protected $orderstatus = NULL;

    /**
     * conditions
     * 
     * @var \Glacryl\Glshop\Domain\Model\Conditions
     */
    protected $conditions = NULL;

    /**
     * __construct
     */
    public function __construct()
    {

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
    protected function initStorageObjects()
    {
        $this->confirmation = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->production = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->delivery = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->invoice = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->orderstatus = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the date
     * 
     * @return \DateTime $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the date
     * 
     * @param \DateTime $date
     * @return void
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Returns the article
     * 
     * @return string $article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Sets the article
     * 
     * @param string $article
     * @return void
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * Returns the comment
     * 
     * @return string $comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Sets the comment
     * 
     * @param string $comment
     * @return void
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Returns the formular
     * 
     * @return string $formular
     */
    public function getFormular()
    {
        return $this->formular;
    }

    /**
     * Sets the formular
     * 
     * @param string $formular
     * @return void
     */
    public function setFormular($formular)
    {
        $this->formular = $formular;
    }

    /**
     * Adds a Confirmation
     * 
     * @param \Glacryl\Glshop\Domain\Model\Confirmation $confirmation
     * @return void
     */
    public function addConfirmation(\Glacryl\Glshop\Domain\Model\Confirmation $confirmation)
    {
        $this->confirmation->attach($confirmation);
    }

    /**
     * Removes a Confirmation
     * 
     * @param \Glacryl\Glshop\Domain\Model\Confirmation $confirmationToRemove The Confirmation to be removed
     * @return void
     */
    public function removeConfirmation(\Glacryl\Glshop\Domain\Model\Confirmation $confirmationToRemove)
    {
        $this->confirmation->detach($confirmationToRemove);
    }

    /**
     * Returns the confirmation
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Confirmation> $confirmation
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }

    /**
     * Sets the confirmation
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Confirmation> $confirmation
     * @return void
     */
    public function setConfirmation(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $confirmation)
    {
        $this->confirmation = $confirmation;
    }

    /**
     * Adds a Production
     * 
     * @param \Glacryl\Glshop\Domain\Model\Production $production
     * @return void
     */
    public function addProduction(\Glacryl\Glshop\Domain\Model\Production $production)
    {
        $this->production->attach($production);
    }

    /**
     * Removes a Production
     * 
     * @param \Glacryl\Glshop\Domain\Model\Production $productionToRemove The Production to be removed
     * @return void
     */
    public function removeProduction(\Glacryl\Glshop\Domain\Model\Production $productionToRemove)
    {
        $this->production->detach($productionToRemove);
    }

    /**
     * Returns the production
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Production> $production
     */
    public function getProduction()
    {
        return $this->production;
    }

    /**
     * Sets the production
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Production> $production
     * @return void
     */
    public function setProduction(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $production)
    {
        $this->production = $production;
    }

    /**
     * Adds a Delivery
     * 
     * @param \Glacryl\Glshop\Domain\Model\Delivery $delivery
     * @return void
     */
    public function addDelivery(\Glacryl\Glshop\Domain\Model\Delivery $delivery)
    {
        $this->delivery->attach($delivery);
    }

    /**
     * Removes a Delivery
     * 
     * @param \Glacryl\Glshop\Domain\Model\Delivery $deliveryToRemove The Delivery to be removed
     * @return void
     */
    public function removeDelivery(\Glacryl\Glshop\Domain\Model\Delivery $deliveryToRemove)
    {
        $this->delivery->detach($deliveryToRemove);
    }

    /**
     * Returns the delivery
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Delivery> $delivery
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * Sets the delivery
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Delivery> $delivery
     * @return void
     */
    public function setDelivery(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $delivery)
    {
        $this->delivery = $delivery;
    }

    /**
     * Adds a Invoice
     * 
     * @param \Glacryl\Glshop\Domain\Model\Invoice $invoice
     * @return void
     */
    public function addInvoice(\Glacryl\Glshop\Domain\Model\Invoice $invoice)
    {
        $this->invoice->attach($invoice);
    }

    /**
     * Removes a Invoice
     * 
     * @param \Glacryl\Glshop\Domain\Model\Invoice $invoiceToRemove The Invoice to be removed
     * @return void
     */
    public function removeInvoice(\Glacryl\Glshop\Domain\Model\Invoice $invoiceToRemove)
    {
        $this->invoice->detach($invoiceToRemove);
    }

    /**
     * Returns the invoice
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Invoice> $invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Sets the invoice
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Invoice> $invoice
     * @return void
     */
    public function setInvoice(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Returns the shippingaddress
     * 
     * @return \Glacryl\Glshop\Domain\Model\Shippingaddress $shippingaddress
     */
    public function getShippingaddress()
    {
        return $this->shippingaddress;
    }

    /**
     * Sets the shippingaddress
     * 
     * @param \Glacryl\Glshop\Domain\Model\Shippingaddress $shippingaddress
     * @return void
     */
    public function setShippingaddress(\Glacryl\Glshop\Domain\Model\Shippingaddress $shippingaddress)
    {
        $this->shippingaddress = $shippingaddress;
    }

    /**
     * Adds a Orderstatus
     * 
     * @param \Glacryl\Glshop\Domain\Model\Orderstatus $orderstatu
     * @return void
     */
    public function addOrderstatu(\Glacryl\Glshop\Domain\Model\Orderstatus $orderstatu)
    {
        $this->orderstatus->attach($orderstatu);
    }

    /**
     * Removes a Orderstatus
     * 
     * @param \Glacryl\Glshop\Domain\Model\Orderstatus $orderstatuToRemove The Orderstatus to be removed
     * @return void
     */
    public function removeOrderstatu(\Glacryl\Glshop\Domain\Model\Orderstatus $orderstatuToRemove)
    {
        $this->orderstatus->detach($orderstatuToRemove);
    }

    /**
     * Returns the orderstatus
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Orderstatus> $orderstatus
     */
    public function getOrderstatus()
    {
        return $this->orderstatus;
    }

    /**
     * Sets the orderstatus
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Glacryl\Glshop\Domain\Model\Orderstatus> $orderstatus
     * @return void
     */
    public function setOrderstatus(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $orderstatus)
    {
        $this->orderstatus = $orderstatus;
    }

    /**
     * Returns the conditions
     * 
     * @return \Glacryl\Glshop\Domain\Model\Conditions $conditions
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Sets the conditions
     * 
     * @param \Glacryl\Glshop\Domain\Model\Conditions $conditions
     * @return void
     */
    public function setConditions(\Glacryl\Glshop\Domain\Model\Conditions $conditions)
    {
        $this->conditions = $conditions;
    }

    /**
     * Returns the user
     * 
     * @return integer user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the user
     * 
     * @param integer $user
     * @return void
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
