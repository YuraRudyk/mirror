<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied!');
}

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Glacryl website');

//# Add page TSConfig
$pageTsConfig = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl(
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/BackendTS/Page.txt');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig($pageTsConfig);

// # Add user TSConfig
$userTsConfig = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl(
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/BackendTS/User.txt');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig($userTsConfig);

// # Add BackendLayouts
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="DIR:EXT:t3_glacryl/Configuration/BackendTS/BackendLayouts" extensions="txt,ts">');
$beLayoutsTsConfig = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl(
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/BackendTS/BackendLayouts.txt');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig($beLayoutsTsConfig);

//# Add plugins TSConfig
$pluginsTsConfig = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl(
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/BackendTS/Plugins.txt');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig($pluginsTsConfig);

/**
 * Available TSConfig files in page properties
 */
$pagesTS = 'Configuration/BackendTS/PagesTS/';
$dirToScan = array_diff(
   scandir(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . $pagesTS),
   array('..', '.')
);
foreach ($dirToScan as $file) {
   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
       $_EXTKEY,
       $pagesTS . $file,
       str_replace(
           array('_', '.txt'),
           array(' ', ''),
           $file
       )
   );
}
unset($dirToScan);

/**
 * Custom TYPO3 skins
 */
// Register as a skin
$GLOBALS['TBE_STYLES']['skins'][$_EXTKEY] = array(
    'name' => 't3_glacryl',
    'stylesheetDirectories' => array(
        //'sprites' => 'EXT:t3_glacryl/stylesheets/sprites/',
        'css' => 'EXT:t3_glacryl/Resources/Public/Css/'
    )
);

/* New label and sorting for frontend users in BE */
$GLOBALS['TCA']['fe_users']['ctrl']['label'] = 'first_name';
$GLOBALS['TCA']['fe_users']['ctrl']['label_alt'] = 'last_name, email, country, company';
$GLOBALS['TCA']['fe_users']['ctrl']['label_alt_force'] = 1;
$GLOBALS['TCA']['fe_users']['ctrl']['default_sortby'] = ' ORDER BY first_name,last_name';

