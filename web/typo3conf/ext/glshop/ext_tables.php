<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Glacryl.Glshop',
            'Glacrylshop',
            'Glacryl Shop'
        );

        if (TYPO3_MODE === 'BE') {

            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'Glacryl.Glshop',
                'web', // Make module a submodule of 'web'
                'glacrylshop', // Submodule key
                '', // Position
                [
                    'Material' => 'list, show, new, create, edit, update, delete','Materialoption' => 'list, show, new, create, edit, update, delete','Materialoptiontype' => 'list, show, new, create, edit, update, delete','Conditions' => 'list, show, new, create, edit, update, delete','Fixing' => 'list, show, new, create, edit, update, delete','Fixingoption' => 'list, show, new, create, edit, update, delete','Borderediting' => 'list, show, new, create, edit, update, delete','Bordereditingoption' => 'list, show, new, create, edit, update, delete','Noticelist' => 'list, show, new, create, delete','Cornerediting' => 'list, show, new, create, edit, update, delete','Cornereditingoption' => 'list, show, new, create, edit, update, delete','Bevel' => 'list, show, new, create, edit, update, delete','Drill' => 'list, show, new, create, edit, update, delete','Drilloption' => 'list, show, new, create, edit, update, delete','Order' => 'list, show, new, create, edit, update','Orderstatus' => 'list, show, new, create, edit, update, delete','Orderstate' => 'list, show, new, create, edit, update, delete','Shippingaddress' => 'list, show, new, create, edit, update, delete','Confirmation' => 'list, new, create, edit, update, delete','Production' => 'list, new, create, edit, update, delete','Delivery' => 'list, new, create, edit, update, delete','Invoice' => 'list, new, create, edit, update, delete','Cart' => 'list, show, new, create, edit, update, delete','Request' => 'list, show, new, create, edit, update, delete','Shop' => 'index','Product' => 'list, show, new, create, edit, update, delete','Productoption' => 'list, show, new, create, edit, update, delete',
                ],
                [
                    'access' => 'user,group',
                    'icon'   => 'EXT:glshop/Resources/Public/Icons/user_mod_glacrylshop.svg',
                    'labels' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_glacrylshop.xlf',
                ]
            );

        }

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('glshop', 'Configuration/TypoScript', 'Glacryl Shop System');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_material', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_material.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_material');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_materialoption', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_materialoption.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_materialoption');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_materialoptiontype', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_materialoptiontype.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_materialoptiontype');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_conditions', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_conditions.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_conditions');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_fixing', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_fixing.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_fixing');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_fixingoption', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_fixingoption.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_fixingoption');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_borderediting', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_borderediting.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_borderediting');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_bordereditingoption', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_bordereditingoption.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_bordereditingoption');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_noticelist', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_noticelist.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_noticelist');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_cornerediting', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_cornerediting.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_cornerediting');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_cornereditingoption', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_cornereditingoption.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_cornereditingoption');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_bevel', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_bevel.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_bevel');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_drill', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_drill.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_drill');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_drilloption', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_drilloption.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_drilloption');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_order', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_order.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_order');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_orderstatus', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_orderstatus.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_orderstatus');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_orderstate', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_orderstate.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_orderstate');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_shippingaddress', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_shippingaddress.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_shippingaddress');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_confirmation', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_confirmation.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_confirmation');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_production', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_production.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_production');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_delivery', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_delivery.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_delivery');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_invoice', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_invoice.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_invoice');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_cart', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_cart.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_cart');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_request', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_request.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_request');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_shop', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_shop.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_shop');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_product', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_product.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_product');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_glshop_domain_model_productoption', 'EXT:glshop/Resources/Private/Language/locallang_csh_tx_glshop_domain_model_productoption.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_glshop_domain_model_productoption');

    }
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

if (TYPO3_MODE === 'BE') {
	// Register AJAX

//    I have added this comment
//	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
//			'Glshop::getFileAction', 'Glacryl\\Glshop\\Controller\\AjController->fileAction'
//	);
//	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
//			'Glshop::sendFileAction', 'Glacryl\\Glshop\\Controller\\AjController->sendFileAction'
//	);
//	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
//			'Glshop::getOrderAction', 'Glacryl\\Glshop\\Controller\\AjController->getOrderAction'
//	);
//	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
//			'Glshop::editOrderAction', 'Glacryl\\Glshop\\Controller\\AjController->editOrderAction'
//	);
//	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
//			'Glshop::checkABAction', 'Glacryl\\Glshop\\Controller\\AjController->checkABAction'
//	);
//	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
//			'Glshop::getDxfAction', 'Glacryl\\Glshop\\Controller\\AjController->getDxfAction'
//	);
//	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
//			'Glshop::getAbschlussAction', 'Glacryl\\Glshop\\Controller\\AjController->getAbschlussAction'
//	);
}

//\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('fe_users');
// End of my comment

$TCA['fe_users']['ctrl']['type'] = 'tx_extbase_type';
$tmpFeUsersColumns = array(
	'payCondition' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_domain_model_customer.payCondition',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'tx_glshop_domain_model_conditions',
			'minitems' => 0,
			'maxitems' => 1,
			'appearance' => array(
				'collapseAll' => 0,
				'levelLinksPosition' => 'top',
				'showSynchronizationLink' => 1,
				'showPossibleLocalizationRecords' => 1,
				'showAllLocalizationLink' => 1
			),
			'default' => 1
		),
	),
	'tx_extbase_type' => array(
		'config' => array(
			'type' => 'input',
			'default' => '0'
		)
	)
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $tmpFeUsersColumns, 1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'payCondition');