<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Glacryl.Glshop',
            'Glacrylshop',
            [
                'Shop' => 'konfigurator, product, rahmen, rahmenNeu',
                'Cart' => 'index,clearCart,addVoucher',
                'Checkout' => 'index',
                'Price' => '',
                'Customer' => 'adress, customerData, noticelist, orders, clearFromNoticeList',
                'Aj' => 'ajax, rahmenKonfig, order, file, sendFile, userAdress, saveLieferAdresse, orderOverview, addToCart, getCurrentCartItems, createNoticeList, getNoticeDetail, orderFromNoticeList, placeOrder, editUser, uploadFile, getProductsAction, getCart, getNewShippingPrice',

//                'Material' => 'list, show, new, create, edit, update, delete',
//                'Materialoption' => 'list, show, new, create, edit, update, delete',
//                'Materialoptiontype' => 'list, show, new, create, edit, update, delete',
//                'Conditions' => 'list, show, new, create, edit, update, delete',
//                'Fixing' => 'list, show, new, create, edit, update, delete',
//                'Fixingoption' => 'list, show, new, create, edit, update, delete',
//                'Borderediting' => 'list, show, new, create, edit, update, delete',
//                'Bordereditingoption' => 'list, show, new, create, edit, update, delete',
//                'Noticelist' => 'list, show, new, create, delete',
//                'Cornerediting' => 'list, show, new, create, edit, update, delete',
//                'Cornereditingoption' => 'list, show, new, create, edit, update, delete',
//                'Bevel' => 'list, show, new, create, edit, update, delete',
//                'Drill' => 'list, show, new, create, edit, update, delete',
//                'Drilloption' => 'list, show, new, create, edit, update, delete',
//                'Order' => 'list, show, new, create, edit, update',
//                'Orderstatus' => 'list, show, new, create, edit, update, delete',
//                'Orderstate' => 'list, show, new, create, edit, update, delete',
//                'Shippingaddress' => 'list, show, new, create, edit, update, delete',
//                'Confirmation' => 'list, new, create, edit, update, delete',
//                'Production' => 'list, new, create, edit, update, delete',
//                'Delivery' => 'list, new, create, edit, update, delete',
//                'Invoice' => 'list, new, create, edit, update, delete',
//                'Cart' => 'list, show, new, create, edit, update, delete',
//                'Request' => 'list, show, new, create, edit, update, delete',
//                'Product' => 'list, show, new, create, edit, update, delete',
//                'Productoption' => 'list, show, new, create, edit, update, delete'
            ],
            // non-cacheable actions
            [
                'Shop' => 'konfigurator, product, rahmen, rahmenNeu',
                'Cart' => 'index,clearCart,addVoucher',
                'Checkout' => 'index',
                'Price' => '',
                'Customer' => 'adress, customerData, noticelist, orders, clearFromNoticeList',
                'Aj' => 'ajax, rahmenKonfig, order, file, sendFile, userAdress, saveLieferAdresse, orderOverview, addToCart, getCurrentCartItems, createNoticeList, getNoticeDetail, orderFromNoticeList, placeOrder, editUser, uploadFile, getProductsAction, getCart, getNewShippingPrice',
//
//
//                'Material' => 'create, update, delete',
//                'Materialoption' => 'create, update, delete',
//                'Materialoptiontype' => 'create, update, delete',
//                'Conditions' => 'create, update, delete',
//                'Fixing' => 'create, update, delete',
//                'Fixingoption' => 'create, update, delete',
//                'Borderediting' => 'create, update, delete',
//                'Bordereditingoption' => 'create, update, delete',
//                'Noticelist' => 'create, delete',
//                'Cornerediting' => 'create, update, delete',
//                'Cornereditingoption' => 'create, update, delete',
//                'Bevel' => 'create, update, delete',
//                'Drill' => 'create, update, delete',
//                'Drilloption' => 'create, update, delete',
//                'Order' => 'create, update',
//                'Orderstatus' => 'create, update, delete',
//                'Orderstate' => 'create, update, delete',
//                'Shippingaddress' => 'create, update, delete',
//                'Confirmation' => 'create, update, delete',
//                'Production' => 'create, update, delete',
//                'Delivery' => 'create, update, delete',
//                'Invoice' => 'create, update, delete',
//                'Cart' => 'create, update, delete',
//                'Request' => 'create, update, delete',
//                'Shop' => '',
//                'Product' => 'create, update, delete',
//                'Productoption' => 'create, update, delete'
            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    glacrylshop {
                        iconIdentifier = glshop-plugin-glacrylshop
                        title = LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_glacrylshop.name
                        description = LLL:EXT:glshop/Resources/Private/Language/locallang_db.xlf:tx_glshop_glacrylshop.description
                        tt_content_defValues {
                            CType = list
                            list_type = glshop_glacrylshop
                        }
                    }
                }
                show = *
            }
       }'
    );
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		
			$iconRegistry->registerIcon(
				'glshop-plugin-glacrylshop',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:glshop/Resources/Public/Icons/user_plugin_glacrylshop.svg']
			);
		
    }
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

if (TYPO3_MODE == 'FE') {
    $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['ajaxDispatcher'] = Glacryl\Glshop\Eid\TestEid::class . '::processRequest';
}

//$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['myEid'] = \MyVendor\MyExt\Controller\MyEidController::class . '::myMethod';