<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_glshop_domain_model_produktvarianten'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_glshop_domain_model_produktvarianten']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, anzeige_name, bilder, eingeschaftenset, bearbeitungen, ausschluss_kategorie, ausschluss_produkt, ausschluss_variante, zubehoer',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, name, anzeige_name, bilder, eingeschaftenset, bearbeitungen, ausschluss_kategorie, ausschluss_produkt, ausschluss_variante, zubehoer, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_glshop_domain_model_produktvarianten',
				'foreign_table_where' => 'AND tx_glshop_domain_model_produktvarianten.pid=###CURRENT_PID### AND tx_glshop_domain_model_produktvarianten.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
	
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),

		'name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_produktvarianten.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'anzeige_name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_produktvarianten.anzeige_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'bilder' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_produktvarianten.bilder',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'bilder',
				array('maxitems' => 1),
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),
		),
		'eingeschaftenset' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_produktvarianten.eingeschaftenset',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_glshop_domain_model_eigenschaftenset',
				'foreign_field' => 'produktvarianten',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),

		),
		'bearbeitungen' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_produktvarianten.bearbeitungen',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_glshop_domain_model_bearbeitungen',
				'MM' => 'tx_glshop_produktvarianten_bearbeitungen_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_glshop_domain_model_bearbeitungen',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),
		'ausschluss_kategorie' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_produktvarianten.ausschluss_kategorie',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_glshop_domain_model_kategorie',
				'MM' => 'tx_glshop_produktvarianten_kategorie_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_glshop_domain_model_kategorie',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),
		'ausschluss_produkt' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_produktvarianten.ausschluss_produkt',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_glshop_domain_model_produkt',
				'MM' => 'tx_glshop_produktvarianten_produkt_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_glshop_domain_model_produkt',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),
		'ausschluss_variante' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_produktvarianten.ausschluss_variante',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_glshop_domain_model_produktvarianten',
				'MM' => 'tx_glshop_produktvarianten_produktvarianten_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_glshop_domain_model_produktvarianten',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),
		'zubehoer' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_produktvarianten.zubehoer',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_glshop_domain_model_produkt',
				'MM' => 'tx_glshop_produktvarianten_zubehoer_produktvarianten_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_glshop_domain_model_produkt',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),
		
		'produkt' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);
