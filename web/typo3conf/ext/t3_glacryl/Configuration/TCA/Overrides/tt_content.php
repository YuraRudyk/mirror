<?php
defined('TYPO3_MODE') || die();

$fields = array (
    'tx_t3glacryl_header_css' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:t3_glacryl/Resources/Private/Language/locallang.xlf:tt_content.header_css',
        'config' => array(
            'type' => 'select',
            'items' => array(
                array('LLL:EXT:t3_glacryl/Resources/Private/Language/locallang.xlf:tt_content.header_css.0', 0),
            ),
        ),
    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    $fields,
    true
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'header',
    'tx_t3glacryl_header_css',
    'after:header_layout'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'headers',
    'tx_t3glacryl_header_css',
    'after:header_layout'
);


