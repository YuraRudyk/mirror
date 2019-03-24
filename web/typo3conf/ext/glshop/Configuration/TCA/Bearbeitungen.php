<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_glshop_domain_model_bearbeitungen'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_glshop_domain_model_bearbeitungen']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, taetigkeit, haengt_ab_von, zeitvorgabe, einheit, min_berechnung',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, taetigkeit, haengt_ab_von, zeitvorgabe, einheit, min_berechnung, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
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
				'foreign_table' => 'tx_glshop_domain_model_bearbeitungen',
				'foreign_table_where' => 'AND tx_glshop_domain_model_bearbeitungen.pid=###CURRENT_PID### AND tx_glshop_domain_model_bearbeitungen.sys_language_uid IN (-1,0)',
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

		'taetigkeit' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_bearbeitungen.taetigkeit',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'haengt_ab_von' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_bearbeitungen.haengt_ab_von',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'zeitvorgabe' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_bearbeitungen.zeitvorgabe',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
		'einheit' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_bearbeitungen.einheit',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'min_berechnung' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_bearbeitungen.min_berechnung',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
		
	),
);
