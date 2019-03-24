<?php

namespace Glacryl\Glshop\Eid;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Glacryl\Glshop\Controller\AjController;
use TYPO3\CMS\Extbase\Object\ObjectManager;
/**
 * Class TestEi
 */
class TestEid
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;


    public function processRequest() {
        die('test in eid');
        $ajax = GeneralUtility::_GP('$ajax');

        $ajController = GeneralUtility::makeInstance(AjController::class);
        $test = $ajController->ajaxAction();

        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($test);exit;

        /**
         * Set Vendor and Extension Name
         *
         * Vendor Name like your Vendor Name in namespaces
         * ExtensionName in upperCamelCase
         */
        $ajax['vendor'] = 'Glacryl';
        $ajax['extensionName'] = 'Glshop';
        /**
         * @var $TSFE \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
         */
        $TSFE = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController', $GLOBALS['TYPO3_CONF_VARS'], 0, 0);
        \TYPO3\CMS\Frontend\Utility\EidUtility::initLanguage();
        // Get FE User Information
        $TSFE->initFEuser();
        \TYPO3\CMS\Frontend\Utility\EidUtility::initTCA(); // Neu
        // Important: no Cache for Ajax stuff
        $TSFE->set_no_cache();
        //$TSFE->checkAlternativCoreMethods();
        $TSFE->checkAlternativeIdMethods();
        $TSFE->determineId();
        $TSFE->initTemplate();
        $TSFE->getConfigArray();
        \TYPO3\CMS\Core\Core\Bootstrap::getInstance();
        $TSFE->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
        $TSFE->settingLanguage();
        $TSFE->settingLocale();
        /**
         * Initialize Database
         */
//        \TYPO3\CMS\Frontend\Utility\EidUtility::connectDB();
        /**
         * @var $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager
         */
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
        /**
         * Initialize Extbase bootstap
         */
        $bootstrapConf['extensionName'] = $ajax['extensionName'];
        $bootstrapConf['pluginName'] = $ajax['pluginName'];
        $bootstrap = new TYPO3\CMS\Extbase\Core\Bootstrap();
        $bootstrap->initialize($bootstrapConf);
        $bootstrap->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tslib_cObj');
        /**
         * Build the request
         */
        $request = $objectManager->get('TYPO3\CMS\Extbase\Mvc\Request');
        $request->setControllerVendorName($ajax['vendor']);
        $request->setcontrollerExtensionName($ajax['extensionName']);
        $request->setPluginName($ajax['pluginName']);
        $request->setControllerName($ajax['controller']);
        $request->setControllerActionName($ajax['action']);
        $request->setArguments($ajax['arguments']);

        $response = $objectManager->get('TYPO3\CMS\Extbase\Mvc\ResponseInterface');
        $dispatcher = $objectManager->get('TYPO3\CMS\Extbase\Mvc\Dispatcher');
        $dispatcher->dispatch($request, $response);
        echo $response->getContent();
    }
}