<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$GLOBALS['TCA']['tx_glshop_domain_model_rechnungsbuch'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_glshop_domain_model_rechnungsbuch']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, status,bestellung,termin,netto,steuer,brutto,eingangZahlung,abschluss,arbeitszeit,',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, status,bestellung,termin,netto,steuer,brutto,eingangZahlung,abschluss,arbeitszeit, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
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
				'foreign_table' => 'tx_glshop_domain_model_rechnungsbuch',
				'foreign_table_where' => 'AND tx_glshop_domain_model_rechnungsbuch.pid=###CURRENT_PID### AND tx_glshop_domain_model_rechnungsbuch.sys_language_uid IN (-1,0)',
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
		'status' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_rechnungsbuch.status',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_glshop_domain_model_status',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'bestellung' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_rechnungsbuch.bestellung',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_glshop_domain_model_order',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'termin' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_rechnungsbuch.termin',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'netto' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_rechnungsbuch.netto',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
		'steuer' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_rechnungsbuch.steuer',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
		'brutto' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_rechnungsbuch.brutto',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
		'eingang_zahlung' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_rechnungsbuch.eingangZahlung',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'abschluss' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_rechnungsbuch.abschluss',
			'config' => array(
				'type' => 'check',
			),
		),
		'arbeitszeit' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_rechnungsbuch.arbeitszeit',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
	),
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder