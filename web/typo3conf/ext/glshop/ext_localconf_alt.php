<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Glacryl.' . $_EXTKEY,
	'Glacrylshop',
	array(
		'Shop' => 'konfigurator, product, rahmen, rahmenNeu',
		'Cart' => 'index,clearCart',
		'Checkout' => 'index',
		'Price' => '',
		'Customer' => 'adress, customerData, noticelist, orders, clearFromNoticeList',
		'Aj' => 'ajax, rahmenKonfig, order, file, sendFile, userAdress, saveLieferAdresse, orderOverview, addToCart, getCurrentCartItems, createNoticeList, getNoticeDetail, orderFromNoticeList, placeOrder, editUser, uploadFile, getProductsAction, getCart, getNewShippingPrice',
	),
	// non-cacheable actions
	array(
		'Shop' => 'konfigurator, product, rahmen, rahmenNeu',
		'Cart' => 'index,clearCart',
		'Checkout' => 'index',
		'Price' => '',
		'Customer' => 'adress, customerData, noticelist, orders, clearFromNoticeList',
		'Aj' => 'ajax, rahmenKonfig, order, file, sendFile, userAdress, saveLieferAdresse, orderOverview, addToCart, getCurrentCartItems, createNoticeList, getNoticeDetail, orderFromNoticeList, placeOrder, editUser, uploadFile, getProductsAction, getCart, getNewShippingPrice',
	)
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

if (TYPO3_MODE == 'FE') {
	$TYPO3_CONF_VARS['FE']['eID_include']['ajaxDispatcher'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop') . 'Classes/AjaxDispatcher.php';
}