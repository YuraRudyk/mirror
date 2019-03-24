<?php
namespace Glacryl\Glshop\Controller;


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
 * CartController
 */
class CartController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    protected $debugMode = false;

    /**
     * ShopRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\ShopRepository
     * @inject
     */
    protected $shopRepository = null;

    /**
     * PriceRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\PriceRepository
     * @inject
     */
    protected $priceRepository = null;

    /**
     * CartRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\CartRepository
     * @inject
     */
    protected $cartRepository = null;

    /**
     * MaterialRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\MaterialRepository
     * @inject
     */
    protected $materialRepository = null;

    /**
     * DrillRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\DrillRepository
     * @inject
     */
    protected $drillRepository = null;

    /**
     * BordereditingRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\BordereditingRepository
     * @inject
     */
    protected $bordereditingRepository = null;

    /**
     * CornereditingRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\CornereditingRepository
     * @inject
     */
    protected $cornereditingRepository = null;

    /**
     * FixingRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\FixingRepository
     * @inject
     */
    protected $fixingRepository = null;

    /**
     * ProduktartRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\ProduktartRepository
     * @inject
     */
    protected $produktartRepository = NULL;

    /**
     * RahmenproduktRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\RahmenproduktRepository
     * @inject
     */
    protected $rahmenproduktRepository = NULL;

    /**
     * RahmenproduktvarianteRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\RahmenproduktvarianteRepository
     * @inject
     */
    protected $rahmenproduktvarianteRepository = NULL;

    /**
     * PriceController
     * 
     * @var \Glacryl\Glshop\Controller\PriceController
     * @inject
     */
    protected $priceController = null;

    /**
     * Material
     */
    protected $material = null;

    /**
     * Kanten
     */
    protected $kanten = null;

    /**
     * Ecken
     */
    protected $ecken = null;

    /**
     * Bohrungen
     */
    protected $bohrungen = null;

    /**
     * Halter
     */
    protected $halter = null;

    /**
     * Produktart
     */
    protected $produktart = null;

    /**
     * Rahmen
     */
    protected $rahmen = null;

    /**
     * Rahmenvariante
     */
    protected $rahmenVarianten = null;

    /**
     * CartItems
     */
    protected $cartItems = null;

    /**
     * GutscheinRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\GutscheinRepository
     * @inject
     */
    protected $gutscheinRepository = null;

    /**
     * GutscheinUsageRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\GutscheinUsageRepository
     * @inject
     */
    protected $gutscheinUsageRepository = null;

    /**
     * action index
     * 
     * @return void
     */
    public function indexAction()
    {
        $sess_id = $GLOBALS['TSFE']->fe_user->user['ses_id'];
        $user_id = $GLOBALS['TSFE']->fe_user->user['uid'];
        if (intval($user_id) == 1) {
            $this->debugMode = false;
        }
        $args = $this->request->getArguments();
        $error = $args['error'];
        $voucherNotice = $this->createVoucherNotice($error);

        //$this->debugTypo($args, 'Anfrage: ', true);
        $this->iniShopData();
        if ($args['qty'] > 9999) {
            $args['qty'] = 9999;
        } else {
            if ($args['qty'] < 1) {
                $args['qty'] = 1;
            }
        }
        if ($args['positionAction'] == 'update') {
            $this->updatePosition($args['positionNr'], $args['qty'], $sess_id, $user_id);
        } else {
            if ($args['positionAction'] == 'delete') {
                $this->deletePosition($args['positionNr'], $sess_id, $user_id);
            }
        }
        $cartItems = $this->cartRepository->getCurrentCartItems($user_id, $sess_id);
        $this->calculatePositionPrices($cartItems);
        $preise = $this->calculatePrices($cartItems);
        for ($i = 0; $i < count($cartItems); $i++) {
            $cartItems[$i]->setArticle(unserialize($cartItems[$i]->getArticle()));
        }

        //$this->debugTypo($preise, 'Preise');
        $this->view->assign('cartItems', $cartItems);
        $this->view->assign('material', $this->material);
        $this->view->assign('kanten', $this->kanten);
        $this->view->assign('ecken', $this->ecken);
        $this->view->assign('bohrungen', $this->bohrungen);
        $this->view->assign('halter', $this->halter);
        $this->view->assign('prices', $preise);
        $this->view->assign('produktart', $this->produktart);
        $this->view->assign('rahmen', $this->rahmen);
        $this->view->assign('rahmenVarianten', $this->rahmenVarianten);
        if ($voucherNotice['text'] != null && $voucherNotice['text'] != '') {
            $this->view->assign('info', $voucherNotice);
        }
        $this->view->assign('sess', $sess_id);
    }

    /**
     * @param $error
     */
    public function createVoucherNotice($error)
    {
        $text = [
    'text' => null,
'error' => false
];

        //$this->debugTypo($error, 'errr', true);
        if ($error['error'] == '1') {

            //Fehler Meldungen
            if ($error['gSet'] == '1') {
                $text['text'] = 'Bitte prüfen Sie Ihre Eingabe!';
            } else {
                if ($error['gSet'] != null && $error['gSet'] == '') {
                    $text['text'] = 'Der von Ihnen eingegebene Gutscheincode ist nicht richtig!';
                } else {
                    if ($error['exp'] == '1') {
                        $text['text'] = 'Der von Ihnen eingegebene Gutscheincode wurde bereits verwendet oder ist nicht mehr gültig!';
                    } else {
                        if ($error['gAbWert'] != null) {
                            $text['text'] = 'Der von Ihnen eingegebene Gutscheincode ist ab einem Warenkorbwert von ' . number_format(floatval($error['gAbWert']), 2, ',', '') . ' € gültig!';
                        }
                    }
                }
            }
            $text['error'] = true;
        } else {

            //Erfolgsmeldungen
            if ($error['gWert'] != null) {
                $text['text'] = 'Ihr Gutschein hat noch einen Restwert von ' . number_format(floatval($error['gWert']), 2, ',', '') . ' €!';
            }
        }
        return $text;
    }

    /**
     * action clearCart
     * 
     * @return void
     */
    public function clearCartAction()
    {
        $sess_id = $GLOBALS['TSFE']->fe_user->user['ses_id'];
        $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
        if (intval($userId) == 1) {
            $this->debugMode = false;
        }
        $cartItems = $this->cartRepository->getCurrentCartItems($userId, $sess_id);
        foreach ($cartItems as $cartItem) {
            $this->cartRepository->deleteCart($cartItem);
        }
        $this->redirect('index');
    }
    public function addVoucherAction()
    {
        $sess_id = $GLOBALS['TSFE']->fe_user->user['ses_id'];
        $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
        $args = $this->request->getArguments();
        $voucher = $args['code'];
        $gData = $this->getVoucher($voucher);
        if ($gData['error'] && isset($gData['gutschein'])) {

            // Gutschein existiert aber falsch eingegeben
            $this->redirect('index', 'Cart', 'Glshop', ['error' => ['error' => true, 'gSet' => true]]);
        } else {
            if ($gData['error'] && !isset($gData['gutschein'])) {

                // Gutschein komplett falsch eingegeben
                $this->redirect('index', 'Cart', 'Glshop', ['error' => ['error' => true, 'gSet' => false]]);
            }
        }
        $gutschein = $gData['gutschein'];
        if ($gutschein->isAbgelaufen() || $gutschein->getBis()->getTimestamp() < time()) {

            // Gutschein ist abgelaufen oder auf abgelaufen gesetzt
            $this->redirect('index', 'Cart', 'Glshop', ['error' => ['error' => true, 'exp' => true]]);
        }
        if ($gutschein->getUser() == null || $gutschein->getUser() == 0) {

            // Gutschein ist fuer viele Kunden gültig
            $this->checkGutscheinForManyUser($gutschein, $userId, $sess_id);
        } else {

            // Gutschein ist fuer genau einen Kunden gültig
            $this->checkGutscheinForOneUser($gutschein, $userId, $sess_id);
        }
    }

    /**
     * @param $gutschein
     * @param $userId
     * @param $sessId
     */
    public function checkGutscheinForOneUser($gutschein, $userId, $sessId)
    {

        //$this->debugTypo($gutschein, 'Gutschein fuer Einen', true);
        $used = $this->getVoucherUsage($gutschein);
        if ($gutschein->getUser() == $userId) {
            $this->checkAndSaveGutschein($gutschein, $userId, $sessId, $used);
        } else {

            // Gutschein ist nicht fuer diesen User
            $this->redirect('index', 'Cart', 'Glshop', ['error' => ['error' => true, 'exp' => true]]);
        }
    }

    /**
     * @param $gutschein
     * @param $userId
     * @param $sessId
     */
    public function checkGutscheinForManyUser($gutschein, $userId, $sessId)
    {

        //$this->debugTypo($gutschein, 'Gutschein fuer Viele', true);
        $used = $this->getVoucherUsage($gutschein);

        //$this->debugTypo($used, 'Gutschein bereits verwendet', true);
        if (count($used['gutscheinUsed']) >= $gutschein->getAnzahl() && !$gutschein->isUnbegrenzt()) {

            // Anzahl der Gutscheine bereits erreicht und nicht unbegrenzte Anzahl
            $this->redirect('index', 'Cart', 'Glshop', ['error' => ['error' => true, 'exp' => true]]);
        } else {
            $this->checkAndSaveGutschein($gutschein, $userId, $sessId, $used);
        }
    }

    /**
     * @param $gutschein
     * @param $userId
     * @param $sessId
     * @param $used
     */
    public function checkAndSaveGutschein($gutschein, $userId, $sessId, $used)
    {
        $gutscheinRestwert = 0;
        if (count($used['gutscheinUsed']) > 0) {
            if (!$gutschein->isRestWert()) {

                // Gutschein bereits verwendet und es ist kein Restwertgutschein
                //$this->debugTypo('Gutschein bereits verwendet und es ist kein Restwertgutschein', 'Restwert', true);
                $this->redirect('index', 'Cart', 'Glshop', ['error' => ['error' => true, 'exp' => true]]);
            } else {
                $restwert = $this->getRestWertForVoucher($gutschein, $used, $userId);
                if ($restwert == 0) {

                    // Es ist kein Restwert für den Kunden mehr vorhanden
                    $this->redirect('index', 'Cart', 'Glshop', ['error' => ['error' => true, 'exp' => true]]);
                } else {
                    $cartWert = $this->getCartWert($userId, $sessId);
                    $gutscheinWert = 0;
                    if ($restwert > $cartWert) {
                        $gutscheinRestwert = $restwert - $cartWert;
                        $gutscheinWert = $cartWert;
                    } else {
                        $gutscheinWert = $restwert;
                    }
                    $this->addVoucherToCart($gutschein, $userId, $sessId, $gutscheinWert, $gutscheinRestwert);
                    $this->redirect('index', 'Cart', 'Glshop', ['error' => ['error' => false]]);
                }
            }
        } else {
            $cartWert = $this->getCartWert($userId, $sessId);
            $gutscheinWert = 0;
            if ($cartWert >= $gutschein->getAbWert()) {
                if ($gutschein->getWert() <= $cartWert) {
                    $gutscheinWert = $gutschein->getWert();
                    $gutscheinRestwert = 0;
                    $this->addVoucherToCart($gutschein, $userId, $sessId, $gutscheinWert, $gutscheinRestwert);
                    $this->redirect('index', 'Cart', 'Glshop', ['error' => ['error' => false]]);
                } else {
                    if ($gutschein->isRestWert()) {

                        //Speichern mit Restwert
                        $gutscheinRestwert = $gutschein->getWert() - $cartWert;
                    } else {

                        //Speichern ohne Restwert (einmalig)
                        $gutscheinRestwert = 0;
                    }
                    $gutscheinWert = $cartWert;
                    $this->addVoucherToCart($gutschein, $userId, $sessId, $gutscheinWert, $gutscheinRestwert);
                    $this->redirect('index', 'Cart', 'Glshop', ['error' => ['error' => false, 'gWert' => $gutscheinRestwert]]);
                }
            } else {

                //Fehler Gutschein ist erst ab einem Warenkorbwert von .... gueltig
                $this->redirect('index', 'Cart', 'Glshop', ['error' => ['error' => true, 'gAbWert' => $gutschein->getAbWert()]]);
            }
        }
    }

    /**
     * @param $gutschein
     * @param $userId
     * @param $sessId
     * @param $gutscheinWert
     * @param $gutscheinRestwert
     */
    public function addVoucherToCart($gutschein, $userId, $sessId, $gutscheinWert, $gutscheinRestwert)
    {

        //$this->debugTypo($gutscheinRestwert, 'Restwert 1', true);
        $error = false;
        $cart = $this->objectManager->get('\\Glacryl\\Glshop\\Domain\\Model\\Cart');

        //PID auf 117 ändern
        $cart->setPid(intval('4'));
        $cart->setUser($userId);
        $cart->setSessionId($sessId);
        $cart->setPosition($this->cartRepository->getNextPositionNr($sessId));
        $artikel = [
    'voucher' => $gutschein->getName(),
'used' => []
];
        $cart->setArticle(serialize($artikel));
        $cart->setQty(1);
        $cart->setPrice(-1 * $gutscheinWert);

        //$cart->setPic($fileName);
        $cartItem = $this->cartRepository->save($cart);
        if ($cartItem->getUid() != null && $cartItem->getUid() != 0) {
            $usage = $this->objectManager->get('\\Glacryl\\Glshop\\Domain\\Model\\GutscheinUsage');
            $usage->setPid(117);
            $usage->setDatum(new \DateTime('now'));
            $usage->setGutschein($gutschein);
            $usage->setWert($cartItem->getPrice());
            $usage->setUser($cartItem->getUser());
            $usedItem = $this->gutscheinUsageRepository->save($usage);
            if ($usedItem->getUid() == null || $usedItem->getUid() == 0) {

                //Fehler beim Speichern der Verwendung vom Gutschein aufgetreten
                //$this->redirect('index', 'Cart', 'Glshop', array('error' => array('error' => true, 'usageSave' => true)));
            } else {
                $usedId = $usedItem->getUid();
                $cartArticle = unserialize($cartItem->getArticle());
                array_push($cartArticle['used'], $usedId);
                $cartItem->setArticle(serialize($cartArticle));
                $updatedCartItem = $this->cartRepository->updateCart($cartItem);
                return $error;
            }
        } else {
            $error = true;
            return $error;
        }
    }

    /**
     * @param $gutschein
     * @param $used
     * @param $userId
     */
    public function getRestWertForVoucher($gutschein, $used, $userId)
    {
        $wert = $gutschein->getWert();
        $summeUsed = 0;
        $gUsed = $used['gutscheinUsed'];
        for ($i = 0; $i < count($gUsed); $i++) {
            if ($gUsed[$i]->getUser() == $userId) {
                $summeUsed += abs($gUsed[$i]->getWert());
            }
        }

        //$this->debugTypo($wert, 'Gutscheinwert', true);
        //$this->debugTypo($summeUsed, 'Summe verwendet', true);
        return $wert - $summeUsed;
    }

    /**
     * @param $userId
     * @param $sess_id
     */
    public function getCartWert($userId, $sess_id)
    {
        $wert = [
    'wert' => 0,
'gutscheinSet' => 0
];
        $db = $this->cartRepository->getCurrentCartItems($userId, $sess_id);
        $this->priceController->init($db);
        $details = [
    'rabatt' => round($this->priceController->getRabatt(), 2),
'ewPalette' => $this->priceController->getEwPalette(),
'werbelandRabatt' => $this->priceController->getWerbelandRabatt()
];
        foreach ($db as $key => $position) {
            $wert['wert'] += floatval($position->getPrice()) * $position->getQty();
            $artikel = unserialize($position->getArticle());

            //$this->debugTypo($artikel, 'Artikel', true);
        }
        $wert['wert'] -= $details['rabatt'];
        return $wert['wert'];
    }

    /**
     * @param $voucher
     */
    public function getVoucher($voucher)
    {
        $data = [
    'gutschein' => null,
'error' => false
];
        $data['gutschein'] = $this->gutscheinRepository->findByCode($voucher)->getFirst();
        if (!isset($data['gutschein'])) {
            $data['error'] = true;

            //$this->debugTypo('Nicht gesetzt', 'Gutscheinfehler', true);
        } else {
            if ($data['gutschein']->getCode() != $voucher) {
                $data['error'] = true;

                //$this->debugTypo('Gutschein wurde falsch eingegeben', 'Gutscheinfehler', true);
            }
        }
        return $data;
    }

    /**
     * @param $voucher
     */
    public function getVoucherUsage($voucher)
    {
        $data = [
    'gutscheinUsed' => null,
'wert' => null,
'error' => false
];
        $data['gutscheinUsed'] = $this->gutscheinUsageRepository->findByGutschein($voucher);
        return $data;
    }
    public function iniShopData()
    {
        $this->material = $this->materialRepository->findAll();
        $this->kanten = $this->bordereditingRepository->findAll();
        $this->ecken = $this->cornereditingRepository->findAll();
        $this->bohrungen = $this->drillRepository->findAll();
        $this->halter = $this->fixingRepository->findAll();
        $this->produktart = $this->produktartRepository->findAll();
        $this->rahmen = $this->rahmenproduktRepository->findAll();
        $this->rahmenVarianten = $this->rahmenproduktvarianteRepository->findAll();

        /* $this->debugTypo($this->material, 'Material');
        	  $this->debugTypo($this->kanten, 'Kanten');
        	  $this->debugTypo($this->ecken, 'Ecken');
        	  $this->debugTypo($this->bohrungen, 'Bohrungen');
        	  $this->debugTypo($this->halter, 'Halter'); */
    }

    /**
     * @param $posNr
     * @param $qty
     * @param $sess_id
     * @param $user_id
     */
    public function updatePosition($posNr, $qty, $sess_id, $user_id)
    {
        $changedCart = null;
        $cartItems = $this->cartRepository->getCurrentCartItems($user_id, $sess_id);
        $this->debugTypo($cartItems, 'Update Cart Items:');
        foreach ($cartItems as $cartItem) {
            if ($cartItem->getPosition() == $posNr) {
                $article = unserialize($cartItem->getArticle());
                if (isset($article['material'])) {
                    $article['materialConfig']['qty'] = $qty;
                }
                $newArticle = serialize($article);
                $cartItem->setQty($qty);
                $cartItem->setArticle($newArticle);
                $cartItem->setNotice(0);
                $changedCart = $this->cartRepository->updateCart($cartItem);
            }
        }
        $this->debugTypo($changedCart, 'Aktualisierte Position: ');
        return true;
    }

    /**
     * @param $posNr
     * @param $sess_id
     * @param $user_id
     */
    public function deletePosition($posNr, $sess_id, $user_id)
    {
        $cartItems = $this->cartRepository->getCurrentCartItems($user_id, $sess_id);
        $usedGutscheinUid = 0;
        foreach ($cartItems as $cartItem) {
            if ($cartItem->getPosition() == $posNr) {
                $article = unserialize($cartItem->getArticle());

                //$this->debugTypo($article, 'Artikel to delete', true);
                if ($article['voucher'] != null) {
                    $usedGutscheinUid = $article['used'][0];

                    //$this->debugTypo($usedGutscheinUid , 'Used UiD', true);
                }
                $this->cartRepository->deleteCart($cartItem);
            }
        }
        if ($usedGutscheinUid != 0) {
            $usedGutschein = $this->gutscheinUsageRepository->findByUid($usedGutscheinUid);
            if ($usedGutschein != null) {
                $this->gutscheinUsageRepository->deleteGutscheinUsage($usedGutschein);
            }
        }
        $this->refactorPositionNumber($user_id, $sess_id);
        return true;
    }

    /**
     * @param $user_id
     * @param $sess_id
     */
    public function refactorPositionNumber($user_id, $sess_id)
    {
        $cartItems = $this->cartRepository->getCurrentCartItems($user_id, $sess_id);
        for ($i = 0; $i < count($cartItems); $i++) {
            $newPosNumber = $i + 1;
            $cartItems[$i]->setPosition($newPosNumber);
            $this->cartRepository->updateCart($cartItems[$i]);
        }
        $this->debugTypo($cartItems, 'Cart Items nach Löschen');
    }

    /**
     * @param $cartItems
     */
    public function calculatePrices($cartItems)
    {
        $this->priceController->init($cartItems);
        $prices = [
    'positionen' => [],
'netto' => 0,
'versand' => 0,
'mwst' => 0,
'brutto' => 0,
'zwischen' => 0,
'ewPalette' => $this->priceController->getEwPalette(),
'rabatt' => $this->priceController->getRabatt(),
'werbelandRabatt' => $this->priceController->getWerbelandRabatt(),
'werbelandRabattSumme' => 0,
'zwischenNachWerbeland' => 0
];

        //$this->debugTypo($cartItems, 'Cart Items', true);
        foreach ($cartItems as $cartItem) {
            $positionSum = floatval($cartItem->getPrice()) * floatval($cartItem->getQty());

            //$this->debugTypo($cartItem->getPrice(), 'Position Nr. ' . $cartItem->getPosition() . ' Preis', true);
            //$this->debugTypo($positionSum, 'Position Nr. ' . $cartItem->getPosition(), true);
            array_push($prices['positionen'], ['positionNr' => $cartItem->getPosition(), 'stk' => $cartItem->getPrice(), 'summe' => $positionSum]);
            $prices['netto'] += $positionSum;
        }
        $prices['zwischen'] = $prices['netto'] - $prices['rabatt'] + $prices['ewPalette'];

        // + $prices['versand'];
        $prices['werbelandRabattSumme'] = round($prices['zwischen'] * $prices['werbelandRabatt'] / 100, 2);
        $prices['zwischenNachWerbeland'] = $prices['zwischen'] - $prices['werbelandRabattSumme'];
        $prices['mwst'] = round(($prices['werbelandRabattSumme'] != 0 ? $prices['zwischenNachWerbeland'] : $prices['zwischen']) * 0.19, 2);
        $prices['brutto'] = ($prices['werbelandRabattSumme'] != 0 ? $prices['zwischenNachWerbeland'] : $prices['zwischen']) + $prices['mwst'];
        return $prices;
    }

    /**
     * @param $cartItems
     */
    public function calculatePositionPrices($cartItems)
    {

        //$this->priceController->setDebugMode(true);
        $this->priceController->init($cartItems);
        $prices = $this->priceController->getPrices();

        //$this->debugTypo($prices, 'Preise', true);
        //$this->debugTypo($prices, 'Preise nach der neuen Kalkulation');
        foreach ($cartItems as $cartItem) {
            $newPrice = 0;
            foreach ($prices as $uid => $price) {
                if ($cartItem->getUid() == $uid) {
                    $newPrice = $price;
                }
            }
            if ($cartItem->getNotice() != 1) {
                $cartItem->setPrice($newPrice);
                $this->cartRepository->updateCart($cartItem);
            }
        }
    }

    /**
     * @param $data
     * @param $name
     * @param $print
     */
    public function debugTypo($data, $name, $print = false)
    {
        if ($this->debugMode || $print) {
            \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data, $name);
        }
    }

    /**
     * @param $data
     * @param $name
     */
    public function debugT($data, $name)
    {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data, $name);
    }

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $carts = $this->cartRepository->findAll();
        $this->view->assign('carts', $carts);
    }

    /**
     * action show
     * 
     * @param \Glacryl\Glshop\Domain\Model\Cart $cart
     * @return void
     */
    public function showAction(\Glacryl\Glshop\Domain\Model\Cart $cart)
    {
        $this->view->assign('cart', $cart);
    }

    /**
     * action new
     * 
     * @return void
     */
    public function newAction()
    {
    }

    /**
     * action create
     * 
     * @param \Glacryl\Glshop\Domain\Model\Cart $newCart
     * @return void
     */
    public function createAction(\Glacryl\Glshop\Domain\Model\Cart $newCart)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->cartRepository->add($newCart);
        $this->redirect('list');
    }

    /**
     * action edit
     * 
     * @param \Glacryl\Glshop\Domain\Model\Cart $cart
     * @ignorevalidation $cart
     * @return void
     */
    public function editAction(\Glacryl\Glshop\Domain\Model\Cart $cart)
    {
        $this->view->assign('cart', $cart);
    }

    /**
     * action update
     * 
     * @param \Glacryl\Glshop\Domain\Model\Cart $cart
     * @return void
     */
    public function updateAction(\Glacryl\Glshop\Domain\Model\Cart $cart)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->cartRepository->update($cart);
        $this->redirect('list');
    }

    /**
     * action delete
     * 
     * @param \Glacryl\Glshop\Domain\Model\Cart $cart
     * @return void
     */
    public function deleteAction(\Glacryl\Glshop\Domain\Model\Cart $cart)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->cartRepository->remove($cart);
        $this->redirect('list');
    }
}
