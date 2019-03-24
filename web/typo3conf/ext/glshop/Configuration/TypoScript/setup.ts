
plugin.tx_glshop {
    view {
        templateRootPath = {$plugin.tx_glshop.view.templateRootPath}
        partialRootPath = {$plugin.tx_glshop.view.partialRootPath}
        layoutRootPath = {$plugin.tx_glshop.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_glshop.persistence.storagePid}
    }
    features {
        # uncomment the following line to enable the new Property Mapper.
        # rewrittenPropertyMapper = 1
    }
}

plugin.tx_glshop._CSS_DEFAULT_STYLE (
	textarea.f3-form-error {
		background-color:#FF9F9F;
		border: 1px #FF0000 solid;
	}

	input.f3-form-error {
		background-color:#FF9F9F;
		border: 1px #FF0000 solid;
	}

	.tx-glshop table {
		border-collapse:separate;
		border-spacing:10px;
	}

	.tx-glshop table th {
		font-weight:bold;
	}

	.tx-glshop table td {
		vertical-align:top;
	}

	.typo3-messages .message-error {
		color:red;
	}

	.typo3-messages .message-ok {
		color:green;
	}

)

# Module configuration
module.tx_glshop {
    persistence {
        storagePid = {$module.tx_glshop.persistence.storagePid}
    }
    view {
        templateRootPath = {$module.tx_glshop.view.templateRootPath}
        partialRootPath = {$module.tx_glshop.view.partialRootPath}
        layoutRootPath = {$module.tx_glshop.view.layoutRootPath}
    }
}

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

plugin.tx_glshop {
    settings {
        shopDataPid = {$plugin.tx_glshop.settings.shopDataPid}
        shopUserPid = {$plugin.tx_glshop.settings.shopUserPid}
        shopPage = {$plugin.tx_glshop.settings.shopPage}
        homePage = {$plugin.tx_glshop.settings.homePage}
        kontaktPage = {$plugin.tx_glshop.settings.kontaktPage}
        impressumPage = {$plugin.tx_glshop.settings.impressumPage}
        agbPage = {$plugin.tx_glshop.settings.agbPage}
        datenschutzPage = {$plugin.tx_glshop.settings.datenschutzPage}
    }
}

############################
## Page js / css includes ##
############################
[globalVar = TSFE:id={$plugin.tx_glshop.settings.shopPage}]

    ## Erstaufruf ##
[globalVar = GP:tx_glshop_glacrylshop|controller = Shop ] && [globalVar = TSFE:id = {$plugin.tx_glshop.settings.shopPage}]
    page.includeCSS {
        jQueryUi = EXT:glshop/Resources/Public/Css/smoothness/jquery-ui-1.10.4.custom.min.css
        #jQueryMobileStructure = EXT:glshop/Resources/Public/Css/jquery.mobile.custom.structure.min.css
        #jQueryMobileTheme = EXT:glshop/Resources/Public/Css/jquery.mobile.custom.theme.min.css
        shop = EXT:glshop/Resources/Public/Css/Konfigurator/Konfigurator.css
        qtipCss = EXT:glshop/Resources/Public/Css/jquery.qtip.css
    }

    page.includeJS {
        file1 = fileadmin/Glshop/Fluidtemplates/js/jquery-1.11.1.min.js
        file2 = fileadmin/Glshop/Fluidtemplates/Foundation/JS/modernizr.js
        file999991 = EXT:glshop/Resources/Public/Js/jquery-ui-1.11.1.custom.min.js
        file999992 = EXT:glshop/Resources/Public/Js/jquery-ui-1.11.1.custom.min.js
        file999993 = EXT:glshop/Resources/Public/Js/jquery.mobile.custom.min.js
        file999994 = EXT:glshop/Resources/Public/Js/jcanvas.min.js
        file999995 = EXT:glshop/Resources/Public/Js/jquery.qtip.min.js
        file999996 = EXT:glshop/Resources/Public/Js/schild.js
        file999997 = EXT:glshop/Resources/Public/Js/Konfigurator/Konfigurator.js
    }
[global]

## Schilderkonfigurator ##
[globalVar = GP:tx_glshop_glacrylshop|controller = Shop] && [globalVar = GP:tx_glshop_glacrylshop|action = konfigurator]
    page.includeCSS {
        jQueryUi = EXT:glshop/Resources/Public/Css/smoothness/jquery-ui-1.10.4.custom.min.css
        shop = EXT:glshop/Resources/Public/Css/Konfigurator/Konfigurator.css
        qtipCss = EXT:glshop/Resources/Public/Css/jquery.qtip.css
    }

    page.includeJS {
        file999992 = EXT:glshop/Resources/Public/Js/jquery-ui-1.11.1.custom.min.js
        file999993 = EXT:glshop/Resources/Public/Js/jquery.mobile.custom.min.js
        file999994 = EXT:glshop/Resources/Public/Js/jcanvas.min.js
        file999995 = EXT:glshop/Resources/Public/Js/jquery.qtip.min.js
        file999996 = EXT:glshop/Resources/Public/Js/schild.js
        file999997 = EXT:glshop/Resources/Public/Js/Konfigurator/Konfigurator.js
    }
[global]

## Rahmenkonfigurator ##
[globalVar = GP:tx_glshop_glacrylshop|controller = Shop] && [globalVar = GP:tx_glshop_glacrylshop|action = rahmen]
    page.includeCSS {
        jQueryUi = EXT:glshop/Resources/Public/Css/smoothness/jquery-ui-1.10.4.custom.min.css
        shop = EXT:glshop/Resources/Public/Css/Konfigurator/Rahmen.css
        qtipCss = EXT:glshop/Resources/Public/Css/jquery.qtip.css
    }

    page.includeJS {
        file999992 = EXT:glshop/Resources/Public/Js/jquery-ui-1.11.1.custom.min.js
        file999993 = EXT:glshop/Resources/Public/Js/jquery.mobile.custom.min.js
        file999994 = EXT:glshop/Resources/Public/Js/jcanvas.min.js
        file999995 = EXT:glshop/Resources/Public/Js/jquery.qtip.min.js
        file999996 = EXT:glshop/Resources/Public/Js/Konfigurator/licht.js
        file999997 = EXT:glshop/Resources/Public/Js/Konfigurator/Rahmen.js
    }
[global]

## Rahmenkonfigurator Neu ##
[globalVar = GP:tx_glshop_glacrylshop|controller = Shop] && [globalVar = GP:tx_glshop_glacrylshop|action = rahmenNeu]
    page.includeCSS {
        jQueryUi = EXT:glshop/Resources/Public/Css/smoothness/jquery-ui-1.10.4.custom.min.css
        shop = EXT:glshop/Resources/Public/Css/Konfigurator/Rahmen.css
        qtipCss = EXT:glshop/Resources/Public/Css/jquery.qtip.css
    }

    page.includeJS {
        file999992 = EXT:glshop/Resources/Public/Js/jquery-ui-1.11.1.custom.min.js
        file999993 = EXT:glshop/Resources/Public/Js/jquery.mobile.custom.min.js
        file999994 = EXT:glshop/Resources/Public/Js/jcanvas.min.js
        file999995 = EXT:glshop/Resources/Public/Js/jquery.qtip.min.js
        file999996 = EXT:glshop/Resources/Public/Js/Konfigurator/licht.js
        file999997 = EXT:glshop/Resources/Public/Js/Konfigurator/Rahmen.js
    }
[global]



## Customer ##
[globalVar = GP:tx_glshop_glacrylshop|controller = Customer ]
    page.includeCSS {
        jQueryUi = EXT:glshop/Resources/Public/Css/smoothness/jquery-ui-1.10.4.custom.min.css
        shop = EXT:glshop/Resources/Public/Css/Customer/Customer.css
        qtipCss = EXT:glshop/Resources/Public/Css/jquery.qtip.css
    }

    page.includeJS {
        file999992 = EXT:glshop/Resources/Public/Js/jquery-ui-1.11.1.custom.min.js
        file999993 = EXT:glshop/Resources/Public/Js/jquery.qtip.min.js
        file999994 = EXT:glshop/Resources/Public/Js/jquery.dataTables.min.js
        file999995 = EXT:glshop/Resources/Public/Js/Backend/dataTables.natural.js
        file999996 = EXT:glshop/Resources/Public/Js/Backend/dataTables.date-de.js
        file999997 = EXT:glshop/Resources/Public/Js/Customer/Customer.js
    }
[global]

## Request ##
[globalVar = GP:tx_glshop_glacrylshop|controller = Request ]
    page.includeCSS {
        jQueryUi = EXT:glshop/Resources/Public/Css/smoothness/jquery-ui-1.10.4.custom.min.css
        shop = EXT:glshop/Resources/Public/Css/shop.css
        qtipCss = EXT:glshop/Resources/Public/Css/jquery.qtip.css
        uploadFile = EXT:glshop/Resources/Public/Css/uploadfile.css
    }

    page.includeJS {
        file999992 = EXT:glshop/Resources/Public/Js/jquery-ui-1.11.1.custom.min.js
        file999993 = EXT:glshop/Resources/Public/Js/jcanvas.min.js
        file999994 = EXT:glshop/Resources/Public/Js/jquery.dataTables.min.js
        file999995 = EXT:glshop/Resources/Public/Js/schild.js
        file999996 = EXT:glshop/Resources/Public/Js/Customer/Customer.js
        file999997 = EXT:glshop/Resources/Public/Js/jquery.qtip.min.js
        file999998 = EXT:glshop/Resources/Public/Js/jquery.uploadfile.min.js
    }
[global]

## Products ##
[globalVar = GP:tx_glshop_glacrylshop|controller = Shop] && [globalVar = GP:tx_glshop_glacrylshop|action = product]
    page.includeCSS {
        jQueryUi = EXT:glshop/Resources/Public/Css/smoothness/jquery-ui-1.10.4.custom.min.css
        shop = EXT:glshop/Resources/Public/Css/Product/Product.css
        qtipCss = EXT:glshop/Resources/Public/Css/jquery.qtip.css
    }

    page.includeJS {
        file999992 = EXT:glshop/Resources/Public/Js/jquery-ui-1.11.1.custom.min.js
        file999993 = EXT:glshop/Resources/Public/Js/jquery.qtip.min.js
        file999996 = EXT:glshop/Resources/Public/Js/Product/Product.js
    }
[global]

## Cart ##
[globalVar = GP:tx_glshop_glacrylshop|controller = Cart] || [globalVar = GP:tx_glshop_glacrylshop|controller = Checkout]
    page.includeCSS {
        jQueryUi = EXT:glshop/Resources/Public/Css/smoothness/jquery-ui-1.10.4.custom.min.css
        shop = EXT:glshop/Resources/Public/Css/Cart/Cart.css
        qtipCss = EXT:glshop/Resources/Public/Css/jquery.qtip.css
    }

    page.includeJS {
        file999992 = EXT:glshop/Resources/Public/Js/jquery-ui-1.11.1.custom.min.js
        file999993 = EXT:glshop/Resources/Public/Js/jquery.qtip.min.js
        file999996 = EXT:glshop/Resources/Public/Js/Cart/Cart.js
    }
[global]

#[global]

test = PAGE
test {
    typeNum = 1812
    10 = USER
    10 {
        userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
        extensionName = Glshop
        pluginName = Glacrylshop
        vendorName = Glacryl
        controller = Aj

        switchableControllerActions {
            Aj {
                0 = ajax
                1 = rahmenKonfig
                2 = getProducts
                3 = userAdress
                4 = saveLieferAdresse
                5 = saveLieferAdresse
                6 = editOrder
                7 = checkAB
                8 = getDxf
                9 = getOrder
                10 = getAbschluss
                11 = file
                12 = sendFile
                13 = order
                14 = orderOverview
                15 = getCart
                16 = addToCart
                17 = getCurrentCartItems
                18 = orderFromNoticeList
                19 = clearFromNoticeList
                20 = createNoticeList
                21 = getNoticeDetail
                22 = getNewShippingPrice
                23 = placeOrder
                24 = uploadFile
            }
        }
    }
    config {
        admPanel = 0
        no_cache = 1
        additionalHeaders = Content-type:application/json
        disableAllHeaderCode = 1
        xhtml_cleaning = 0
    }
}