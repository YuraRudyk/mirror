<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

//\FluidTYPO3\Flux\Core::registerProviderExtensionKey('Glacryl.T3Glacryl', 'Page');
\FluidTYPO3\Flux\Core::registerProviderExtensionKey('Glacryl.T3Glacryl', 'Content');

$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'] = serialize([
    'loginLogo' => 'EXT:t3_glacryl/Resources/Public/Images/BeLogin/logo.png',
    'loginHighlightColor' => '#17385E',
    'loginBackgroundImage' => 'EXT:t3_glacryl/Resources/Public/Images/BeLogin/background-grey.jpg', // background.png
]);

// Copy all needed files into fileadmin/files when first install
if (defined('TYPO3_MODE') && TYPO3_MODE === 'BE') {
    /** @var $dispatcher \TYPO3\CMS\Extbase\SignalSlot\Dispatcher */
    $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\SignalSlot\Dispatcher');
    $dispatcher->connect(
        'TYPO3\CMS\Extensionmanager\Service\ExtensionManagementService',
        'hasInstalledExtensions',
        'Glacryl\T3Glacryl\Automation\Install',
        'InitializeInstaller'
    );
}

/***************
 * Add default RTE configuration
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:t3_glacryl/Configuration/BackendTS/CKEditor.txt">');
$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['t3_glacryl'] = 'EXT:t3_glacryl/Configuration/BackendTS/RTE.yaml';