<?php
namespace Glacryl\Glshop\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
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
 * ShopController
 */
class ShopController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * shopRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\ShopRepository
     * @inject
     */
    protected $shopRepository = NULL;

    /**
     * materialRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\MaterialRepository
     * @inject
     */
    protected $materialRepository = NULL;

    /**
     * fixingRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\FixingRepository
     * @inject
     */
    protected $fixingRepository = NULL;

    /**
     * cornereditingRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\CornereditingRepository
     * @inject
     */
    protected $cornereditingRepository = NULL;

    /**
     * drillRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\DrillRepository
     * @inject
     */
    protected $drillRepository = NULL;

    /**
     * bordereditingRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\BordereditingRepository
     * @inject
     */
    protected $bordereditingRepository = NULL;

    /**
     * customerRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\CustomerRepository
     * @inject
     */
    protected $customerRepository = NULL;

    /**
     * cartRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\CartRepository
     * @inject
     */
    protected $cartRepository = NULL;

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
     * KategorieRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\KategorieRepository
     * @inject
     */
    protected $kategorieRepository = NULL;

    /**
     * DatentypenRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\DatentypenRepository
     * @inject
     */
    protected $datentypenRepository = NULL;

    /**
     * action konfigurator
     * 
     * @return void
     */
    public function konfiguratorAction()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $uriBuilder = $this->objectManager->get(\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder::class);

        $uri = $uriBuilder
            ->reset()
            ->setTargetPageUid(4)
            ->setTargetPageType(1812)
            ->uriFor('ajax', [], 'Aj', 'Glshop', 'Glacrylshop');


        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($uri);exit;



        $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
        $sessId = $GLOBALS['TSFE']->fe_user->user['ses_id'];
        $extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop');
        $args = $this->request->getArguments();
        $shopConfig = $this->shopRepository->findAll();
        $material = $this->materialRepository->findAll();
        $fixing = $this->fixingRepository->findAll();
        $border = $this->bordereditingRepository->findAll();
        $corner = $this->cornereditingRepository->findAll();
        $drill = $this->drillRepository->findAll();
        $customer = $this->customerRepository->findByUid($userId);
        $tempern = $this->shopRepository->findByAKey('tempern');
        $this->view->assign('args', $args);
        $this->view->assign('material', $material);
        $this->view->assign('fixing', $fixing);
        $this->view->assign('border', $border);
        $this->view->assign('corner', $corner);
        $this->view->assign('drill', $drill);
        $this->view->assign('customer', $customer);
        $this->view->assign('shopConfig', $shopConfig);
        $this->view->assign('tempern', $tempern->getFirst()->getAValue());
        if (isset($args['positionNr'])) {
            $cartItems = $this->cartRepository->getCurrentCartItems($userId, $sessId);
            foreach ($cartItems as $cartItem) {
                if (intval($cartItem->getPosition()) == intval($args['positionNr'])) {
                    $this->view->assign('edit', unserialize($cartItem->getArticle()));
                }
            }
        }
    }

    /**
     * action rahmen
     * 
     * @return void
     */
    public function rahmenAction()
    {
        $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
        $sessId = $GLOBALS['TSFE']->fe_user->user['ses_id'];
        $extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop');
        $args = $this->request->getArguments();
        $shopConfig = $this->shopRepository->findAll();
        $rahmen = $this->produktartRepository->findByName('Rahmen');
        $frontscheiben = $this->produktartRepository->findByName('Frontscheibe');
        $streuplatten = $this->produktartRepository->findByName('Streuplatte');
        $leds = $this->produktartRepository->findByName('LED');
        $montagen = $this->produktartRepository->findByName('Montage');
        $anschlusse = $this->produktartRepository->findByName('Anschluss');
        $customer = $this->customerRepository->findByUid($userId);
        $this->view->assign('args', $args);
        $this->view->assign('rahmen', $rahmen[0]->getProdukt());
        $this->view->assign('frontscheiben', $frontscheiben[0]->getProdukt());
        $this->view->assign('streuplatten', $streuplatten[0]->getProdukt());
        $this->view->assign('leds', $leds[0]->getProdukt());
        $this->view->assign('montagen', $montagen[0]->getProdukt());
        $this->view->assign('anschlusse', $anschlusse[0]->getProdukt());
        $this->view->assign('customer', $customer);
        $this->view->assign('shopConfig', $shopConfig);
        if (isset($args['positionNr'])) {
            $cartItems = $this->cartRepository->getCurrentCartItems($userId, $sessId);
            foreach ($cartItems as $cartItem) {
                if (intval($cartItem->getPosition()) == intval($args['positionNr'])) {
                    $this->view->assign('edit', unserialize($cartItem->getArticle()));
                }
            }
        }
    }

    /**
     * action rahmenNeu
     * 
     * @return void
     */
    public function rahmenNeuAction()
    {
        $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
        $sessId = $GLOBALS['TSFE']->fe_user->user['ses_id'];
        $extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop');
        $args = $this->request->getArguments();
        $shopConfig = $this->shopRepository->findAll();
        $kategorien = $this->kategorieRepository->findAll();
        $rahmen = $this->produktartRepository->findByName('Rahmen');
        $frontscheiben = $this->produktartRepository->findByName('Frontscheibe');
        $streuplatten = $this->produktartRepository->findByName('Streuplatte');
        $leds = $this->produktartRepository->findByName('LED');
        $montagen = $this->produktartRepository->findByName('Montage');
        $anschlusse = $this->produktartRepository->findByName('Anschluss');
        $customer = $this->customerRepository->findByUid($userId);
        $this->view->assign('args', $args);
        $this->view->assign('kategorien', $kategorien);
        $this->view->assign('rahmen', $rahmen[0]->getProdukt());
        $this->view->assign('frontscheiben', $frontscheiben[0]->getProdukt());
        $this->view->assign('streuplatten', $streuplatten[0]->getProdukt());
        $this->view->assign('leds', $leds[0]->getProdukt());
        $this->view->assign('montagen', $montagen[0]->getProdukt());
        $this->view->assign('anschlusse', $anschlusse[0]->getProdukt());
        $this->view->assign('customer', $customer);
        $this->view->assign('shopConfig', $shopConfig);
        if (isset($args['positionNr'])) {
            $cartItems = $this->cartRepository->getCurrentCartItems($userId, $sessId);
            foreach ($cartItems as $cartItem) {
                if (intval($cartItem->getPosition()) == intval($args['positionNr'])) {
                    $this->view->assign('edit', unserialize($cartItem->getArticle()));
                }
            }
        }
    }

    /**
     * action product
     * 
     * @return void
     */
    public function productAction()
    {
        $halter = $this->fixingRepository->findAll();
        $this->view->assign('Halter', $halter);
    }

    /**
     * @param $data
     */
    public function debugTypo($data)
    {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
    }

    /**
     * @param $data
     * @param $functions
     * @param $vars
     * @param $fluid
     */
    public function debug($data, $functions = false, $vars = false, $fluid = false)
    {
        if ($fluid) {
            $this->view->assign('debug', $data);
        } else {
            echo '<pre>';
            if ($functions) {
                $class_methods = get_class_methods($data);
                foreach ($class_methods as $method_name) {
                    echo "{$method_name}\n";
                }
            } else {
                if ($vars) {
                    var_dump(get_object_vars($data));
                } else {
                    var_dump($data);
                }
            }
            echo '</pre>';
        }
    }

    /**
     * action index
     * 
     * @return void
     */
    public function indexAction()
    {
    }
}
