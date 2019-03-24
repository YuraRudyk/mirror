<?php

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$rootDir = dirname(dirname(__DIR__));
$confDir = $rootDir.'/conf';
$cacheDir = $rootDir.'/cache';
$cacheIdentifier = @md5($context . filemtime($rootDir.'/.env'));
$configLoader = new \Helhum\ConfigLoader\CachedConfigurationLoader(
    $cacheDir,
    $cacheIdentifier,
    function() use ($confDir) {
        return new \Helhum\ConfigLoader\ConfigurationLoader(
            array(
                new \Helhum\ConfigLoader\Reader\EnvironmentReader('TYPO3'),
            )
        );
    }
);


$additionalConfig = $configLoader->load();

if (isset($additionalConfig['EXT']['extConf'])) {
    foreach ($additionalConfig['EXT']['extConf'] as $key => $extConf) {
        if (!is_array($extConf)) {
            continue;
        }

        $additionalConfig['EXT']['extConf'][$key] = serialize(array_replace_recursive(
            unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$key]),
            $extConf
        ));
    }
}

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive(
    $GLOBALS['TYPO3_CONF_VARS'],
    $additionalConfig
);