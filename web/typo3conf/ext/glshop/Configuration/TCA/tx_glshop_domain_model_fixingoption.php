<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_fixingoption',
        'label' => 'article_nr',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'article_nr,name,description,position,pic',
        'iconfile' => 'EXT:glshop/Resources/Public/Icons/tx_glshop_domain_model_fixingoption.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, article_nr, name, description, projection, from_size, to_size, drill_downside, border_length, position, diameter, price, pic',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, article_nr, name, description, projection, from_size, to_size, drill_downside, border_length, position, diameter, price, pic, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_glshop_domain_model_fixingoption',
                'foreign_table_where' => 'AND {#tx_glshop_domain_model_fixingoption}.{#pid}=###CURRENT_PID### AND {#tx_glshop_domain_model_fixingoption}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'article_nr' => [
            'exclude' => true,
            'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_fixingoption.article_nr',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_fixingoption.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_fixingoption.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'projection' => [
            'exclude' => true,
            'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_fixingoption.projection',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'from_size' => [
            'exclude' => true,
            'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_fixingoption.from_size',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'to_size' => [
            'exclude' => true,
            'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_fixingoption.to_size',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'drill_downside' => [
            'exclude' => true,
            'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_fixingoption.drill_downside',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'border_length' => [
            'exclude' => true,
            'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_fixingoption.border_length',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'position' => [
            'exclude' => true,
            'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_fixingoption.position',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'diameter' => [
            'exclude' => true,
            'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_fixingoption.diameter',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'price' => [
            'exclude' => true,
            'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_fixingoption.price',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'pic' => [
            'exclude' => true,
            'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_fixingoption.pic',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
    
        'fixing' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder