function log() {
    if (typeof console != 'undefined') {
        console.log(arguments);
    }
}

(function ($) {


    /**
     * @ToDo:
     *
     * Überarbeiten
     */

    var InputFieldTest = {
        start: function () {
            var inputFields = $(document).find('input[type=text]');
            var desktop = API.isDesktopTest();
            $.each(inputFields, function (el, value) {
                if (desktop) {
                    if (($(value).attr('id') == 'filter-halterMitBohrung-artikel') || ($(value).attr('id') == 'filter-halterOhneBohrung-artikel')) {
                        $(value).attr('type', 'text').attr('maxlength', 8);
                    } else if ($(value).attr('id') == 'user') {
                        $(value).attr('type', 'text').removeAttr('maxlength');
                    } else if ($(value).hasClass('login-input')) {
                        $(value).attr('type', 'text').removeAttr('maxlength');
                    } else {
                        $(value).attr('type', 'text').attr('maxlength', 4);
                    }
                } else {
                    if (($(value).attr('id') == 'view-configuration-width') || ($(value).attr('id') == 'view-configuration-height')) {
                        $(value).attr('type', 'number').removeAttr('maxlength').attr('max', '9999');
                    } else if ($(value).attr('id') == 'user') {
                        $(value).attr('type', 'text').removeAttr('maxlength');
                    } else if ($(value).hasClass('login-input')) {
                        $(value).attr('type', 'text').removeAttr('maxlength');
                    } else {
                        $(value).attr('type', 'number').removeAttr('maxlength');
                    }
                }
            });
        }
    };
    var Tooltips = {
        tips: {
            '.right.info-icon.hOb': '#halter-ohneBohrung-info-tooltip',
            '.right.info-icon.hMb': '#halter-mitBohrung-info-tooltip',
            '.right.info-icon.bE': '#ecken-info-tooltip',
            '.right.info-icon.bB': '#bohrung-info-tooltip',
            '.right.info-icon.bS': '#senkung-info-tooltip',
            '.right.info-icon.bK': '#kanten-info-tooltip',
            '.info-icon-halter.eHoB': '#einzel-Halter-info-oB-tooltip',
            '.info-icon-halter.eHmB': '#einzel-Halter-info-mB-tooltip',
            '.right.info-icon.mat': '#material-info-tooltip',
            '.ui-icon.ui-icon-info.ecken-info-btn': '#eckBearbeitung-info-tooltip'
        },
        initialize: function () {
            $('.info-icon, .info-icon-halter, .ecken-info-btn').each(function () {
                $(this).qtip({
                    overwrite: false,
                    position: {
                        my: 'top right', // Position my top right...
                        at: 'center left', // at the center left of...
                        //target: 'mouse', // Position it where the click was...
                        //adjust: {mouse: false} // ...but don't follow the mouse
                        adjust: {
                            method: 'shift',
                            resize: true,
                            scroll: false
                        },
                        viewport: $(window)
                    },
                    style: {
                        widget: true, // Use the jQuery UI widget classes
                        def: false // Remove the default styling (usually a good idea, see below)
                    },
                    content: {
                        text: $(Tooltips.getTooltipId($(this))).html(),
                        button: true
                    },
                    hide: {
                        event: function () {
                            Tooltips.clearInfo();
                            if (API.MobileCheck()) {
                                return false;
                            } else {
                                return 'mouseleave';
                            }
                        }()
                    },
                    events: {
                        show: function (event, api) {
                            var el = '.' + $(event.originalEvent.target).attr('class').replace(' ', '.').replace(' ', '.');
                            if (el == '.right.info-icon.mat') {
                                var icon = $(event.originalEvent.target);
                                Tooltips.insertInfo(el, icon);
                            } else {
                                Tooltips.insertInfo(el);
                            }
                        }
                    }
                });
            });
        },
        getTooltipId: function (el) {
            var id = '.' + el.attr('class').replace(' ', '.').replace(' ', '.');
            return Tooltips.tips[id];
        },
        clearInfo: function () {
            $('span.tooltip-halter-name').html('');
            $('span.tooltip-halter-variante').html('');
            $('span.tooltip-halter-artNr').html('');
            $('span.tooltip-halter-preis').html('');
            $('span.tooltip-halter-wa').html('');
            $('span.tooltip-halter-material').html('');
            $('span.tooltip-halter-mas').html('');
            $('span.tooltip-halter-bohrung').html('');
            $('p.tooltip-material-info').html('');
            $('span.tooltip-material-name').html('');
        },
        insertInfo: function (el, icon) {
            switch (el) {
                case '.right.info-icon.mat':
                    var mId = icon.parent('div').next('div').find('div').find('input[name=materialUid]').val();
                    var vId = icon.parent('div').next('div').find('div').find('input[name=variantenUid]').val();
                    if (!API.isset(vId)) {
                        vId = icon.parent('div').next('div').find('div').find('select').val();
                    }
                    //log(mId, vId);
                    var material = Konfigurator.helper.getMaterial(mId, vId);
                    $('span.tooltip-material-name').html(material.material.name);
                    $('p.tooltip-material-info').html(material.material.desc);
                    break;
                case '.info-icon-halter.eHmB':
                    var hId = $('#view-halterMitBohrung-auswahl select').val();
                    var vId = $('#view-halterMitBohrung-variantenId').val();
                    var halter = Konfigurator.helper.getHalter(hId, vId);
                    //log(halter.variante);
                    var mas = (halter.variante.durchmesser != '0.00' ? '&Oslash; ' + API.dotToComma(halter.variante.durchmesser) : API.dotToComma(halter.variante.halterkantenlaenge) + ' x ' + API.dotToComma(halter.variante.halterkantenlaenge));
                    var material = (halter.variante.materialVon != '-1.00' && halter.variante.materialBis != '-1.00' ? 'von ' + API.dotToComma(halter.variante.materialVon) + ' bis ' + API.dotToComma(halter.variante.materialBis) + ' mm' : 'alle');
                    $('span.tooltip-halter-name').html(halter.halter.name);
                    $('span.tooltip-halter-variante').html(halter.variante.name);
                    $('span.tooltip-halter-artNr').html(halter.variante.artnr);
                    $('span.tooltip-halter-preis').html(API.dotToComma(halter.variante.preis));
                    $('span.tooltip-halter-wa').html(API.dotToComma(halter.variante.wandabstand));
                    $('span.tooltip-halter-material').html(material);
                    $('span.tooltip-halter-mas').html(mas);
                    $('span.tooltip-halter-bohrung').html(API.dotToComma(halter.variante.plattenbohrungUnterseite));
                    break;
                case '.info-icon-halter.eHoB':
                    var hId = $('#view-halterOhneBohrung-auswahl select').val();
                    var vId = $('#view-halterOhneBohrung-variantenId').val();
                    var halter = Konfigurator.helper.getHalter(hId, vId);
                    var mas = (halter.variante.durchmesser != '0.00' ? '&Oslash; ' + API.dotToComma(halter.variante.durchmesser) : API.dotToComma(halter.variante.halterkantenlaenge) + ' x ' + API.dotToComma(halter.variante.halterkantenlaenge));
                    var material = (halter.variante.materialVon != '-1.00' && halter.variante.materialBis != '-1.00' ? 'von ' + API.dotToComma(halter.variante.materialVon) + ' bis ' + API.dotToComma(halter.variante.materialBis) + ' mm' : 'alle');
                    $('span.tooltip-halter-name').html(halter.halter.name);
                    $('span.tooltip-halter-variante').html(halter.variante.name);
                    $('span.tooltip-halter-artNr').html(halter.variante.artnr);
                    $('span.tooltip-halter-preis').html(API.dotToComma(halter.variante.preis));
                    $('span.tooltip-halter-wa').html(API.dotToComma(halter.variante.wandabstand));
                    $('span.tooltip-halter-material').html(material);
                    $('span.tooltip-halter-mas').html(mas);
                    break;
            }
        }
    };
    var Dispatcher = {
        Type: {
            Material: 1,
            Halter: 2,
            Bearbeitung: 3
        },
        errorFields: {
            Material: new Array(),
            Halter: new Array(),
            Bearbeitung: new Array()
        },
        addErrorField: function (errorType, field) {
            switch (errorType) {
                case 1:
                    this.errorFields.Material.push(field);
                    break;
                case 2:
                    this.errorFields.Halter.push(field);
                    break;
                case 3:
                    this.errorFields.Bearbeitung.push(field);
                    break;
            }
            return this;
        },
        clearErrorFields: function (errorType) {
            switch (errorType) {
                case 1:
                    $.each(this.errorFields.Material, function (i, el) {
                        $(el).html('');
                    });
                    this.errorFields.Material = new Array();
                    break;
                case 2:
                    $.each(this.errorFields.Halter, function (i, el) {
                        $(el).html('');
                    });
                    this.errorFields.Halter = new Array();
                    break;
                case 3:
                    $.each(this.errorFields.Bearbeitung, function (i, el) {
                        $(el).html('');
                    });
                    this.errorFields.Bearbeitung = new Array();
                    break;
            }
            return this;
        },
        transition: {
            ecken: []
        },
        clearTransition: function () {
            this.transition.ecken = [];
        }
    };
    var API = {
        usedIds: new Array(),
        isMobile: window.matchMedia("only screen and (max-width: 750px)").matches,
        isTablet: window.matchMedia("only screen and (max-width: 974px)").matches,
        isDesktop: window.matchMedia("only screen and (min-width: 975px)").matches,
        MobileCheck: function () {
            return this.isMobileNew.any() && this.isMobileEvent();
        },
        isMobileEvent: function () {
            try {
                document.createEvent("TouchEvent");
                return true;
            } catch (e) {
                return false;
            }
        },
        isMobileNew: {
            Android: function () {
                return navigator.userAgent.match(/Android/i);
            },
            BlackBerry: function () {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            iOS: function () {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Opera: function () {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            Windows: function () {
                return navigator.userAgent.match(/IEMobile/i);
            },
            any: function () {
                return (API.isMobileNew.Android() || API.isMobileNew.BlackBerry() || API.isMobileNew.iOS() || API.isMobileNew.Opera() || API.isMobileNew.Windows());
            }
        },
        isMobileTest: function () {
            var width = parseInt($(window).width());
            if (width <= 750) {
                return true;
            }
            return false;
        },
        isTabletTest: function () {
            var width = parseInt($(window).width());
            if (width <= 974) {
                return true;
            }
            return false;
        },
        isDesktopTest: function () {
            var width = parseInt($(window).width());
            if (width >= 975) {
                return true;
            }
            return false;
        },
        createRandomNumber: function () {
            var number = Math.floor(Math.random() * (10000 - 1 + 3) + 1);
            if ($.inArray(number, this.usedIds) == -1) {
                this.usedIds.push(number);
                return number;
            } else {
                return this.createRandomNumber();
            }
        },
        ajax: function (async, data, type, dataType, sMsg, eMsg) {

            //$('#debugTail pre.pre1').html(JSON.stringify(data, null, 2));

            var res = $.ajax({
                url: 'index.php',
                async: async,
                global: false,
                data: data,
                type: type,
                dataType: dataType,
                success: function () {
                    if (sMsg != null) {
                        alert(sMsg);
                    }
                },
                error: function () {
                    if (eMsg != null) {
                        alert(eMsg);
                    }
                }
            }).responseText;
            //$('#debugTail pre.pre3').html(res);

            if ((dataType == 'json') && (res != '') && (res != null) && (res.length > 0)) {
                res = eval("(" + res + ")");
            }

            //$('#debugTail pre.pre2').html(JSON.stringify(res, null, 2));

            return res;
        },
        dotToComma: function (string) {
            string = string + "";
            string = string.replace(".", ",");
            return string;
        },
        commaToDot: function (string) {
            string = string + "";
            string = string.replace(".", ".");
            string = string.replace(",", ".");
            return string;
        },
        inList: function (val, list) {
            for (var i = 0; i < list.length; i++)
                if (list[i] == val) {
                    return true;
                }
            return false;
        },
        markEckenOption: function (allElementsSelect, el) {
            //log("Alle Elemente", allElementsSelect);
            //log("Gecklickt", el);

            var allElements = allElementsSelect.find('option');
            var elCorner = el.val();
            //log("Ecke gewählt: " + elCorner);
            if (elCorner == 'ALLE') {
                //log('Element bereits Aktiv: ' + $(el)[0].selected);

                if ($(el)[0].selected) {
                    $.each(allElements, function (i, element) {
                        var elValue = $(element).val();
                        if (elValue != 'ALLE') {
                            $(element).removeAttr('selected');
                            allElementsSelect.selectmenu("refresh", true);
                        }
                    });
                } else {
                    $.each(allElements, function (i, element) {
                        var elValue = $(element).val();
                        if ((elValue != 'ALLE') && (elValue != 'FREI')) {
                            if (!API.isset($(element).attr('disabled'))) {
                                $(element).attr('selected', 'selected');
                            }
                        } else if (elValue == 'FREI') {
                            $(element).removeAttr('selected');
                        }
                    });
                }
            } else if (elCorner == 'FREI') {
                $.each(allElements, function (i, element) {
                    if ($(element).val() != 'FREI') {
                        $(element).removeAttr('selected');
                    }
                });
            } else if ((elCorner != 'ALLE') && (elCorner != 'FREI')) {
                $.each(allElements, function (i, element) {
                    if (($(element).val() == 'ALLE') || ($(element).val() == 'FREI')) {
                        $(element).removeAttr('selected');
                    }
                });
            }
        },
        markEckenCheckboxElementByLabel: function (allElements, el) {
            var elements = allElements.find('label');
            $.each(elements, function (i, element) {
                var elValue = $(element).find('input').val();
                if ((elValue == el)) {
                    $(element).addClass('active');
                }
            });
        },
        markEckenCheckbox: function (e) {
            var allElements = $(e.target.parentElement).find('label');
            var el = $(e.target);
            var elCorner = el.find('input').val();
            if (elCorner == 'ALLE') {
                var activeTest = false;
                if (API.MobileCheck()) {
                    if (el.hasClass('active')) {
                        activeTest = true;
                    }
                } else {
                    if (!el.hasClass('active')) {
                        activeTest = true;
                    }
                }

                if (activeTest) {
                    $.each(allElements, function (i, element) {
                        var elValue = $(element).find('input').val();
                        if (elValue != 'ALLE') {
                            $(element).removeClass('active');
                        }
                    });
                } else {
                    $.each(allElements, function (i, element) {
                        var elValue = $(element).find('input').val();
                        if ((elValue != 'ALLE') && (elValue != 'FREI')) {
                            if (!API.isset($(element).attr('disabled'))) {
                                $(element).addClass('active');
                            }
                        } else if (elValue == 'FREI') {
                            $(element).removeClass('active');
                        }
                    });
                }
            } else if (elCorner == 'FREI') {
                $.each(allElements, function (i, element) {
                    if ($(element).find('input').val() != 'FREI') {
                        $(element).removeClass('active');
                    }
                });
            } else if ((elCorner != 'ALLE') && (elCorner != 'FREI')) {
                $.each(allElements, function (i, element) {
                    if (($(element).find('input').val() == 'ALLE') || ($(element).find('input').val() == 'FREI')) {
                        $(element).removeClass('active');
                    }
                });
            }
        },
        disableOption: function (el) {
            $(el).attr('disabled', 'disabled');
        },
        disableCheckBox: function (el) {
            $(el).attr('disabled', 'disabled');
        },
        disableButton: function (button) {
            $(button).prop('disabled', true);
        },
        enableButton: function (button) {
            $(button).prop('disabled', false);
        },
        round: function (x, n) {
            if ((n < 1) || (n > 14))
                return false;
            var e = Math.pow(10, n);
            var k = (Math.round(x * e) / e).toString();
            if (k.indexOf('.') == -1)
                k += '.';
            k += e.toString().substring(1);
            return parseFloat(k.substring(0, k.indexOf('.') + n + 1));
        },
        priceView: function (price) {
            var decPoint = ',';
            var thousand_sep = '.';
            function format(x, k, fixLength) {
                if (!k)
                    k = 0;
                var neu = '';
                var sign = x < 0 ? '-' : '';
                // Runden
                var f = Math.pow(10, k);
                var zahl = Math.abs(x);
                zahl = '' + parseInt(zahl * f + .5) / f;
                // Komma ermittlen
                var idx = zahl.indexOf('.');
                // fehlende Nullen einfÃ¼gen
                if (fixLength && k) {
                    zahl += (idx == -1 ? '.' : '') + f.toString().substring(1);
                }

                // Nachkommastellen ermittlen
                idx = zahl.indexOf('.');
                if (idx == -1)
                    idx = zahl.length;
                else
                    neu = decPoint + zahl.substr(idx + 1, k);
                // Tausendertrennzeichen
                while (idx > 0) {
                    if (idx - 3 > 0)
                        neu = thousand_sep + zahl.substring(idx - 3, idx) + neu;
                    else
                        neu = zahl.substring(0, idx) + neu;
                    idx -= 3;
                }
                return sign + neu;
            }
            ;
            return format(price, 2, true);
            //return this.dotToComma(this.round(price, 2));
        },
        isset: function (data) {
            if ((typeof data != 'undefined') && (data != null)) {
                return true;
            }
            return false;
        }
    };
    var Validate = {
        config: {
            regexp: {
                ganzeZahl: {
                    exp: /^([0-9_])+$/i,
                    text: "Dieses Feld darf nur ganze Zahlen enthalten!"
                },
                float: {
                    exp: /^([,.0-9_])+$/i,
                    text: "Dieses Feld darf nur Kommazahlen enthalten!"
                }
            },
            material: {
                laser: {
                    max: 2000,
                    min: 1500
                },
                sonst: {
                    max: 3000,
                    min: 2000
                }
            },
            facette: {
                max: 20,
                min: 0
            },
            maxQty: 100
        },
        updateText: function (o, t) {
            if (t) {
                $(o).show().html(t);
            } else {
                $(o).hide().html('');
            }
        },
        addErrorStyle: function (o) {
            o.attr('style', 'border: 1px solid #A51107 !important; color: #A51107 !important; overflow:hidden; padding:0px !important;'); //padding-left:4px !important;');
        },
        removeErrorStyle: function (o) {
            o.removeAttr('style');
        },
        emptyField: function (fields, errorField) {
            var emptyFields = [];
            for (var field in fields) {
                if (fields[field].val() == '') {
                    emptyFields.push(field);
                }
            }
            if (emptyFields.length > 1) {
                var text = 'Die Felder ';
                for (var i = 0; i < emptyFields.length; i++) {
                    if (i == 0) {
                        text += '"' + emptyFields[i] + '"';
                    } else {
                        text += ', "' + emptyFields[i] + '"';
                    }
                }
                text += ' d&uuml;rfen nicht leer sein!';
                this.updateText(errorField, text);
                return false;
            } else if (emptyFields.length == 1) {
                this.updateText(errorField, 'Das Feld "' + emptyFields[0] + '" darf nicht leer sein!');
                return false;
            } else {
                this.updateText(errorField, '');
                return true;
            }
        },
        checkRegexp: function (o, errorField, type) {
            var regexp = null, n = null;
            if (typeof type == 'undefined') {
                regexp = this.config.regexp.ganzeZahl.exp;
                n = this.config.regexp.ganzeZahl.text;
            } else {
                if (type == 'float') {
                    regexp = this.config.regexp.float.exp;
                    n = this.config.regexp.float.text;
                }
            }
            if (o.is(':visible')) {
                if (!(regexp.test(o.val()))) {
                    this.addErrorStyle(o);
                    this.updateText(errorField, n);
                    return false;
                } else {
                    this.removeErrorStyle(o);
                    this.updateText(errorField, '');
                    return true;
                }
            } else {
                this.removeErrorStyle(0);
                this.updateText(errorField, '');
                return true;
            }
        },
        checkNumber: function (o, errorField, nullAllowd) {
            if (o.is(':visible')) {
                var number = o.val();
                if (isNaN(number)) {
                    this.addErrorStyle(o);
                    this.updateText(errorField, 'Bitte geben Sie in das markierte Feld eine Zahl ein!');
                    return false;
                } else if ((number == 0) && (!nullAllowd)) {
                    this.addErrorStyle(o);
                    this.updateText(errorField, 'Das markierte Feld  darf nicht "0" sein!');
                    return false;
                } else {
                    this.removeErrorStyle(o);
                    this.updateText(errorField, '');
                    return true;
                }
            } else {
                this.removeErrorStyle(0);
                this.updateText(errorField, '');
                return true;
            }
        },
        isRadioSelected: function (o, errorField) {
            if (o.is(':visible')) {
                if ((o.find(":radio:checked").val() == '') || (typeof o.find(":radio:checked").val() == 'undefined')) {
                    this.addErrorStyle(o);
                    this.updateText(errorField, 'Bitte w&auml;hlen Sie einen Wert im markierten Bereich aus!');
                    return false;
                } else {
                    this.removeErrorStyle(o);
                    this.updateText(errorField);
                    return true;
                }
            } else {
                return true;
            }
        },
        isButtonSelected: function (o, errorField) {
            if (o.is(':visible')) {
                if ((o.find("button.active").val() == '') || (typeof o.find("button.active").val() == 'undefined')) {
                    this.addErrorStyle(o);
                    this.updateText(errorField, 'Bitte w&auml;hlen Sie einen Wert im markierten Bereich aus!');
                    return false;
                } else {
                    this.removeErrorStyle(o);
                    this.updateText(errorField);
                    return true;
                }
            } else {
                return true;
            }
        },
        isCheckboxSelected: function (o, errorField) {
            if (o.is(':visible')) {
                if ((o.find("label.active").length == 0) || (typeof o.find("label.active") == 'undefined')) {
                    this.addErrorStyle(o);
                    this.updateText(errorField, 'Bitte w&auml;hlen Sie einen Wert im markierten Bereich aus!');
                    return false;
                } else {
                    this.removeErrorStyle(o);
                    this.updateText(errorField);
                    return true;
                }
            } else {
                return true;
            }
        },
        checkFacettenEingabe: function (F, deg, check, errorField) {
            var res = null, fIsVisible = false, facette = null, check = check || false, size = Number(Material.getCurrentConfiguration().size);
            var max = this.config.facette.max, min = this.config.facette.min;
            if (typeof F == 'object') {
                fIsVisible = F.is(':visible');
                facette = F.val();
            }

            if (fIsVisible || check) {
                if (deg == '12') {
                    if (check) {
                        res = size - Number(F) * 0.213;
                    } else {
                        res = size - facette * 0.213;
                    }
                } else if (deg == '45') {
                    if (check) {
                        res = size - Number(F);
                    } else {
                        res = size - facette;
                    }
                }

                if (Number(facette) > max) {
                    if (!check) {
                        this.addErrorStyle(F);
                        this.updateText(errorField, 'Die maximal m&ouml;gliche Facettenbreite von ' + max + ' mm darf nicht &uuml;berschritten werden!');
                    }
                    return false;
                } else if (Number(facette) < min) {
                    if (!check) {
                        this.addErrorStyle(F);
                        this.updateText(errorField, 'Die minimal m&ouml;gliche Facettenbreite von ' + min + ' mm darf nicht unterschritten werden!');
                    }
                    return false;
                }
                if ((res != null) && (Number(res) < 1)) {
                    if (!check) {
                        this.addErrorStyle(F);
                        this.updateText(errorField, 'Die gew&uuml;nschte Facettenbreite ist bei gew&auml;hlter Materialst&auml;rke nicht m&ouml;glich. Bitte reduzieren Sie die Facettenbreite oder erh&ouml;hen Sie die Materialst&auml;rke.');
                    }
                    return false;
                }
            }
            this.removeErrorStyle(F);
            this.updateText(errorField);
            return true;
        },
        checkEckRadius: function (o, check, errorField) {
            var width = Number(Grundeinstellung.getCurrentConfiguration().width), height = Number(Grundeinstellung.getCurrentConfiguration().height);
            var minKante = Number(Math.min(width, height)), check = check || false, isOVisible = false, oVal = null;
            if (typeof o == 'object') {
                isOVisible = o.is(':visible');
                oVal = Number(o.val());
            } else {
                oVal = o;
            }
            if (isOVisible || check) {
                if (oVal > minKante) {
                    if (!check) {
                        this.addErrorStyle(o);
                        this.updateText(errorField, 'Die Gr&ouml;&szlig;e vom Eckradius darf die kleinste Kante nicht &uuml;berschreiten (' + minKante + ' mm)!');
                    }
                    return false;
                }
            }
            this.removeErrorStyle(o);
            this.updateText(errorField);
            return true;
        },
        materialSet: function (errorField) {
            var size = Material.getCurrentConfiguration().size;
            if (API.isset(errorField)) {
                if (!API.isset(size)) {
                    this.updateText(errorField, 'Bitte w&auml;hlen Sie zuerst eine Materialvariante aus!');
                    return false;
                }
                this.updateText(errorField);
            } else {
                if (!API.isset(size)) {
                    return false;
                }
            }
            return true;
        },
        material: function (width, height, errorField, kId) {
            var w = Number(width.val()), h = Number(height.val()), max = 0, min = 0, kanten = null;
            if (typeof kId == 'undefined') {
                kanten = Bearbeitungen.Kanten.getCurrentConfiguration();
            } else {
                kanten = {uid: kId};
            }

            if ((kanten.uid == 2) || (kanten.uid == 4)) {
                max = this.config.material.laser.max;
                min = this.config.material.laser.min;
            } else {
                max = this.config.material.sonst.max;
                min = this.config.material.sonst.min;
            }

            if ((w != 0) && (h != 0)) {
                if (w > h) {
                    if (w > max) {
                        this.updateText(errorField, 'Das Feld "Breite" darf den Maximalwert von ' + max + ' mm nicht &uuml;bersreiten!');
                        this.addErrorStyle(width);
                        this.removeErrorStyle(height);
                        return false;
                    } else if (w < 10) {
                        this.updateText(errorField, 'Das Feld "Breite" darf den Minimalwert von 10 mm nicht unterschreiten!');
                        this.addErrorStyle(width);
                        this.removeErrorStyle(height);
                        return false;
                    }
                    if (h > min) {
                        this.updateText(errorField, 'Das Feld "H&ouml;he" darf den Maximalwert von ' + min + ' mm nicht &uuml;berschreiten!');
                        this.addErrorStyle(height);
                        this.removeErrorStyle(width);
                        return false;
                    } else if (h < 10) {
                        this.updateText(errorField, 'Das Feld "H&ouml;he" darf den Minimalwert von 10 mm nicht unterschreiten!');
                        this.addErrorStyle(height);
                        this.removeErrorStyle(width);
                        return false;
                    }
                } else {
                    if (h > max) {
                        this.updateText(errorField, 'Das Feld "H&ouml;he" darf den Maximalwert von ' + max + ' mm nicht &uuml;berschreiten!');
                        this.addErrorStyle(height);
                        this.removeErrorStyle(width);
                        return false;
                    } else if (h < 10) {
                        this.updateText(errorField, 'Das Feld "H&ouml;he" darf den Minimalwert von 10 mm nicht unterschreiten!');
                        this.addErrorStyle(height);
                        this.removeErrorStyle(width);
                        return false;
                    }
                    if (w > min) {
                        this.updateText(errorField, 'Das Feld "Breite" darf den Maximalwert von ' + min + ' mm nicht &uuml;berschreiten!');
                        this.addErrorStyle(width);
                        this.removeErrorStyle(height);
                        return false;
                    } else if (w < 10) {
                        this.updateText(errorField, 'Das Feld "Breite" darf den Minimalwert von 10 mm nicht unterschreiten!');
                        this.addErrorStyle(width);
                        this.removeErrorStyle(height);
                        return false;
                    }
                }
            } else {
                if (w == 0) {
                    this.addErrorStyle(width);
                    this.removeErrorStyle(height);
                    this.updateText(errorField, 'Bitte geben Sie eine Zahl ein!');
                    return false;
                } else {
                    if (h == 0) {
                        this.addErrorStyle(height);
                        this.removeErrorStyle(width);
                        this.updateText(errorField, 'Bitte geben Sie eine Zahl ein!');
                        return false;
                    }
                }
            }
            this.removeErrorStyle(height);
            this.removeErrorStyle(width);
            this.updateText(errorField, '');
            return true;
        }
    };
    var Price = {
        rabatt: {
            product: {
                0: {
                    preisVon: 0,
                    preisBis: 100,
                    rabatt: 1
                },
                1: {
                    preisVon: 100,
                    preisBis: 250,
                    rabatt: 0.89
                },
                2: {
                    preisVon: 250,
                    preisBis: 500,
                    rabatt: 0.85
                },
                3: {
                    preisVon: 500,
                    preisBis: 1000,
                    rabatt: 0.81
                },
                4: {
                    preisVon: 1000,
                    preisBis: 2500,
                    rabatt: 0.79
                },
                5: {
                    preisVon: 2500,
                    preisBis: -1,
                    rabatt: 0.76
                }
            }
        },
        konstanten: {
            arbeitsfaktor: 0.8,
            //Koefizienten aus Gnuplot
            kZuschnitt1: 0.000000219748,
            kZuschnitt2: 0.000495982,
            kZuschnitt3: 16.4172,
            kSchwabeln1: 0.00000000123527,
            kSchwabeln2: 0.00479476,
            kSchwabeln3: 2,
            kFassen1: 0.00099607182,
            kFassen2: 0.2,
            kFacette1: 0.003,
            kPacket1: 0.3934,
            kPacket2: 4,
            kPallete1: 0.35, // €/kg
            kPallete2: 4,
            //wie Hoch man stapeln kann in mm
            sZuschnitt: 30,
            sMacryl: 60,
            sSchwabeln: 30,
            sLaser: 100,
            sBohrungen: 30,
            // Zuschnitt
            minZuschnitt: 5, // Zeit zum Holen des Materials
            vZuschnitt1: 2000, // 1. Schnitt: Geschwindigkeit in mm/min
            vZuschnitt2: 1500, // 2. Schnitt: Geschwindigkeit in mm/min
            segeBlattZuschnitt: 3, // Dicke des Sägeblattes
            plattenBreite: 2030, // Breite der Platte

            //Schwabeln
            vSchwabeln: 1200, // Schwabeln: Geschwindigkeit in mm/min

            //restliche Sachens
            vMacryl: 200, //Macryl geschwindichkeit in Milimeter/Minute
            tMacryl: 2, // Zeit zum wenden in Minuten
            tFacette: 20, //Zeit zum Rüsten der Facette
            rLaser: 13, // Zeit zum Rüsten
            tLaser1: 3, //Zeit zum auflegen einer Plate auf den Lasertisch
            tLaser2: 1, //Zeit zum Nehmen eines Stückes vom Laser in Sekunden
            tLaser3: 10, //Zeit zum ablegen eines Stapels vom Laser in Sekunden
            aLaser: 3.35, // Flächeninhalt einer Platte in m^2 = 1620 x 2070 Maximalmaße auf der Platte
            tBSLaser: 10, //Zeit zum Einstellen von einem Bohrung/Senkung am Laser in Sekunden
            tBSEinstellen: 180, //Zeit zum Einstellen von einem Bohrung/Senkung in Sekunden 3 * 60
            tBohrungen: 15, //Zeit zum Bohren eines Bohrlochs in Sekunden
            tSenkungen: 10, //Zeit zum Senken in Sekunden
            tLREcken1: 15, //Zeit zum Rundecken einrüsten vom Laser pro Ecke in Sekunden
            tLREcken2: 2, //Zeit zum Rundecken schneiden in Sekunden
            tLSEcken1: 15, //Zeit zum Schrägecken einrüsten vom Laser pro Ecke in Sekunden
            tLSEcken2: 2, //Zeit zum Schrägecken schneiden in Sekunden
            tZSEcken1: 60, //Zeit zum Schrägecken einrüsten vom Zuschnitt pro Ecke in Sekunden
            tZSEcken2: 1.5 //Zeit zum Schrägecken schneiden in Sekunden
        },
        laserzeit: [
            {dicke: 1, v: 3750},
            {dicke: 2, v: 3250},
            {dicke: 2.5, v: 2500},
            {dicke: 3, v: 2200},
            {dicke: 4, v: 1800},
            {dicke: 5, v: 1600},
            {dicke: 6, v: 1400},
            {dicke: 8, v: 600},
            {dicke: 10, v: 500},
            {dicke: 12, v: 400},
            {dicke: 15, v: 300},
            {dicke: 20, v: 230}
        ],
        bearbeitungen: [
            {
                label: "ges&auml;gte Kante",
                functions: ['berechneZuschnitt']
            }, {
                label: "ges&auml;gte Kante",
                functions: ['berechneZuschnitt']
            }, {
                label: "Laserkante",
                functions: ['berechneLaser']
            }, {
                label: "ges&auml;gt &amp; gefasst",
                functions: ['berechneZuschnitt', 'berechneKantenFasen']
            }, {
                label: "Laserkante gefasst",
                functions: ['berechneLaser', 'berechneKantenFasen']
            }, {
                label: "diamantpoliert &amp; gefasst",
                functions: ['berechneZuschnitt', 'berechneMacryl', 'berechneSchwabeln', 'berechneKantenFasen']
            }, {
                label: "facettiert &amp; poliert",
                functions: ['berechneZuschnitt', 'berechneMacryl', 'berechneSchwabeln', 'berechneKantenFasen', 'berechneFacette']
            }, {
                label: "diamantpoliert nicht gefasst",
                functions: ['berechneZuschnitt', 'berechneMacryl', 'berechneSchwabeln']
            }
        ],
        createPriceView: function () {
            var qty = parseInt(Grundeinstellung.getCurrentConfiguration().qty);
            var preis = parseFloat(this.calculate());
            //console.log('Berechneter Preis: ' + preis);

            var preisProStueck = API.round(preis / qty, 2);
            $('#cart-configuration-qty').html(qty + ' Stk.');
            $('#cart-configuration-onePrice').html('&aacute;  ' + API.priceView(preisProStueck) + ' &euro; netto');
            $('.cart-configuration-sumPrice').html(API.priceView(preisProStueck * qty) + ' &euro;');
        },
        calculate: function () {
            var mPreis = 0;
            var bPreis = 0;
            var hPreis = 0;
            var shop = Konfigurator.prepareDataForImg();
            var config = shop.configuration;
            var material = shop.material;
            var shildSize = shop.materialConfig;
            var kanten = shop.bearbeitungen.kanten;
            var ecken = shop.bearbeitungen.ecken;
            var bohrungen = shop.bearbeitungen.bohrungen;
            var senkungen = shop.bearbeitungen.senkungen;
            var tempern = shop.bearbeitungen.tempern;
            var halter = shop.halter;
            var qty = Number(Grundeinstellung.getCurrentConfiguration().qty);
            var mFactor = Konfigurator.data.mFactor;
            var mFactorInflation = parseFloat(Konfigurator.data.mFactorInflation);
            var pFactorInflation = parseFloat(Konfigurator.data.pFactorInflation);
            var eFactorInflation = parseFloat(Konfigurator.data.eFactorInflation);
            var cutoff = parseFloat(Konfigurator.data.cutoff) / 100 + 1;
            var gesamtKosten = 0;
            var materialGesPreis = 0;
            var temperKilo = 0;
            for (var i = 0; i < config.material.length; i++) {
                if (config.material[i].uid == material.uid) {
                    for (var j = 0; j < config.material[i].varianten.length; j++) {
                        if (config.material[i].varianten[j].uid == material.vid) {
                            for (var k = 0; k < config.material[i].varianten[j].formen.length; k++) {
                                if (parseFloat(config.material[i].varianten[j].formen[k].dicke) == parseFloat(material.size)) {
                                    materialGesPreis += cutoff * parseFloat(shildSize.height) * parseFloat(shildSize.width) * qty * parseFloat(config.material[i].varianten[j].formen[k].preis) / 1000000 * mFactorInflation;
                                }
                            }
                        }
                    }
                }
            }

            if (tempern.tempern) {
                temperKilo += parseFloat(shildSize.height) * parseFloat(shildSize.width) / 1000000 * 1.2 * parseFloat(material.size) * qty;
            }

            materialGesPreis = API.round(materialGesPreis, 2);
            //console.log('GesamtmaterialPreis inkl. Verschnitt: ' + materialGesPreis);

            for (var i = 0; i < mFactor.length; i++) {
                if ((materialGesPreis > mFactor[i].from) && (materialGesPreis <= mFactor[i].to)) {
                    mPreis += materialGesPreis * mFactor[i].factor;
                    //console.log('Materialaufschlag: ' + mFactor[i].factor);
                }
            }

            //console.log('Materialpreis inkl. Aufschlag: ' + mPreis);

            var defaultKantenConfig = 4;
            var editId = defaultKantenConfig;
            var bZeit = 0;
            // Kantenbearbeitungspreis
            if (API.isset(kanten)) {
                for (var j = 0; j < config.kanten.length; j++) {
                    if (kanten.uid == parseInt(config.kanten[j].uid)) {
                        editId = kanten.uid;
                    }
                }
            }


            var eckenQty = this.getEckenQty(ecken);
            var daten = {
                l: parseFloat(shildSize.height),
                b: parseFloat(shildSize.width),
                t: parseFloat(material.size),
                qty: parseInt(qty),
                bearbeitung: parseInt(editId),
                drill: this.getBohrQty(bohrungen),
                senk: this.getSenkQty(senkungen),
                rundecken: eckenQty.rund,
                schraegeecken: eckenQty.schraeg,
                halter: halter
            };
            for (var j = 0; j < Price.bearbeitungen.length; j++) {
                if (j == editId) {
                    for (var k = 0; k < Price.bearbeitungen[j].functions.length; k++) {
                        var execFunction = eval('this.' + Price.bearbeitungen[j].functions[k]);
                        bZeit += execFunction(daten);
                    }
                    break;
                }
            }

            //console.log('Gesamtarbeitszeit für Kantenbearbeitung: ' + bZeit);

            bZeit += Price.berechneBohrungen(daten);
            bZeit += Price.berechneRundEcken(daten);
            bZeit += Price.berechneSchraegEcken(daten);
            //console.log('Bearbeitungszeit vor Packen: ' + bZeit);
            bZeit += Price.berechnePacken(daten);
            //console.log('Bearbeitungszeit nach Packen: ' + bZeit);

            //console.log('Zeit zum Verpacken: ' + Price.berechnePacken(daten));

            bPreis = Price.konstanten.arbeitsfaktor * bZeit * eFactorInflation;
            //console.log('Gesamtbearbeitungszeit: ' + bZeit + ' min');
            bPreis = API.round(bPreis, 2);
            //console.log('Gesamtbearbeitungspreis: ' + bPreis + ' €');

            // Halter
            if (API.isset(halter) && (halter.length > 0)) {
                var halterGesamtPreis = 0;
                for (var i = 0; i < halter.length; i++) {
                    var realQty = halter[i].qty * qty;
                    var halterEinzelPreis = this.getProductPrice(halter[i].hid, halter[i].vid, 'halter') * pFactorInflation;
                    halterGesamtPreis += (halterEinzelPreis * realQty);
                }

                hPreis += API.round(halterGesamtPreis, 2);
            }

            //console.log('Bearbeitungspreis: ' + bPreis);
            //console.log('Halterpreis: ' + hPreis);
            //console.log('Materialpreis: ' + mPreis);

            gesamtKosten = API.round(bPreis + hPreis + mPreis, 2);
            var temperPreis = (tempern.tempern ? this.getTemperPrice(parseInt(qty), temperKilo) : 0);
            return gesamtKosten + temperPreis;
        },
        getTemperPrice: function (qty, temperKilo) {
            var preis = 0;
            var aufpreisStk = 1;
            var stkOhneAufpreis = 5;
            var tempern = parseFloat(Konfigurator.data.tempern);
            var aufpreis = (qty > stkOhneAufpreis ? ((temperKilo / qty * (qty - stkOhneAufpreis)) * aufpreisStk) : 0);
            preis = tempern + aufpreis;
            return API.round(preis / qty, 2) * qty;
        },
        getEckenQty: function (ecken) {
            var qty = {rund: 0, schraeg: 0};
            if (API.isset(ecken) && (ecken.length > 0)) {
                for (var i = 0; i < ecken.length; i++) {
                    if (!API.isset(ecken[i].radius) || (ecken[i].radius == '')) {
                        qty.schraeg += (ecken[i].corner == 'ALLE' ? 4 : 1);
                    } else {
                        qty.rund += (ecken[i].corner == 'ALLE' ? 4 : 1);
                    }
                }
            }
            return qty;
        },
        getBohrQty: function (bohrungen) {
            var qty = 0;
            if (API.isset(bohrungen) && (bohrungen.length > 0)) {
                for (var i = 0; i < bohrungen.length; i++) {
                    qty += (bohrungen[i].corner == 'ALLE' ? 4 : 1);
                }
            }
            return qty;
        },
        getSenkQty: function (senkungen) {
            var qty = 0;
            if (API.isset(senkungen) && (senkungen.length > 0)) {
                for (var i = 0; i < senkungen.length; i++) {
                    qty += (senkungen[i].corner == 'ALLE' ? 4 : 1);
                }
            }
            return qty;
        },
        getProductPrice: function (uid, vid, type) {
            var halter = Konfigurator.data.halter, price = 0;
            if (type == 'halter') {
                for (var i = 0; i < halter.length; i++) {
                    if (halter[i].uid == uid) {
                        for (var j = 0; j < halter[i].varianten.length; j++) {
                            if (halter[i].varianten[j].uid == vid) {
                                price = halter[i].varianten[j].preis;
                            }
                        }
                    }
                }
            }
            return API.round(price, 2);
        },
        getRabattForProduct: function (gesSumme) {
            var pRabatt = this.rabatt.product, faktor = 1;
            for (var gr in pRabatt) {
                if ((parseFloat(gesSumme) >= parseFloat(pRabatt[gr].preisVon)) && (parseFloat(gesSumme) < parseFloat(pRabatt[gr].preisBis))) {
                    faktor = pRabatt[gr].rabatt;
                } else if ((parseFloat(gesSumme) >= parseFloat(pRabatt[gr].preisVon)) && (parseInt(pRabatt[gr].preisBis) == -1)) {
                    faktor = pRabatt[gr].rabatt;
                }
            }
            return faktor;
        },
        getSchwabelStapel: function (daten) {
            var h = 0;
            var A = daten.b * daten.l / 1000000;
            if (daten.t > 10) {
                h = daten.t;
            } else if ((daten.t > 5) && (daten.t <= 10)) {
                if (A <= 0.3) {
                    h = daten.t * 2;
                } else {
                    h = daten.t;
                }
            } else if ((daten.t > 0) && (daten.t <= 5)) {
                if (A <= 0.3) {
                    h = daten.t * 4;
                } else {
                    h = daten.t;
                }
            }
            //console.log('Schwabelstapel: ' + h);
            return h;
        },
        getZuschnittStapel: function (daten) {
            var h = 0;
            var A = daten.b * daten.l / 1000000;
            if (daten.t > 10) {
                h = daten.t;
            } else if ((daten.t >= 6) && (daten.t <= 10)) {
                if (A <= 0.3) {
                    h = 30;
                } else {
                    h = daten.t;
                }
            } else if ((daten.t > 0) && (daten.t < 5)) {
                if (A <= 0.06) {
                    h = 25;
                } else {
                    h = daten.t;
                }
            } else if (daten.t == 5) {
                if (A <= 0.06) {
                    h = 60;
                } else if (A <= 0.08) {
                    h = 30;
                } else {
                    h = daten.t;
                }
            }

            //console.log('Höhe vom Zuschnittstapel');
            //console.log(h);

            return h;
        },
        berechneZuschnitt: function (daten) {
            var zeit = 0;
            var l = daten.l, b = daten.b;
            if (b > Price.konstanten.plattenBreite) {
                b = daten.l;
                l = daten.b;
            }

            zeit += Price.konstanten.minZuschnitt + (Price.konstanten.plattenBreite / Price.konstanten.vZuschnitt1 * Math.ceil(daten.qty / Math.floor(Price.konstanten.plattenBreite / (b + Price.konstanten.segeBlattZuschnitt)))) + ((((l + Price.konstanten.segeBlattZuschnitt) / Price.konstanten.vZuschnitt2) * Math.min((daten.qty + 1), (Math.floor(Price.konstanten.plattenBreite / (b + Price.konstanten.segeBlattZuschnitt)) + 1))) * Math.ceil(Math.ceil(daten.qty / Math.floor(Price.konstanten.plattenBreite / (b + Price.konstanten.segeBlattZuschnitt))) * daten.t / Price.getZuschnittStapel(daten)));
            /*console.log('Formel: ' + Price.konstanten.minZuschnitt + ' + ' + '(' + Price.konstanten.plattenBreite + ' / ' + Price.konstanten.vZuschnitt1);
             console.log(' * ceil ( ' + daten.qty + ' / floor(' + Price.konstanten.plattenBreite + ' / (' + daten.b + ' + ' + Price.konstanten.segeBlattZuschnitt);
             console.log(')))) + ((((' + daten.l + ' + ' + Price.konstanten.segeBlattZuschnitt+ ') / ' + Price.konstanten.vZuschnitt2 + ') * min((' + daten.qty );
             console.log(' + 1), (floor(' + Price.konstanten.plattenBreite + ' / (' + daten.b + ' + ' + Price.konstanten.segeBlattZuschnitt);
             console.log(')) + 1))) * ceil(ceil(' + daten.qty + ' / floor(' + Price.konstanten.plattenBreite + ' / (' + daten.b + ' + ' );
             console.log(Price.konstanten.segeBlattZuschnitt + '))) * ' + daten.t + ' / ' + Price.getZuschnittStapel(daten) + '))');
             console.log('Zuschnittszeit: ' + zeit);*/
            //console.log('Zuschnittszeit: ' + API.round(zeit, 2));
            return API.round(zeit, 2);
        },
        berechneMacryl: function (daten) {
            var U = (daten.l + daten.b) * 2;
            var zeit = 0;
            zeit = (U / Price.konstanten.vMacryl + Price.konstanten.tMacryl) * Math.ceil(daten.t * daten.qty / Price.konstanten.sMacryl);
            if (API.isset(daten.schraegeecken) && (daten.schraegeecken > 0)) {
                zeit += (40 * daten.schraegeecken / Price.konstanten.vMacryl + Price.konstanten.tMacryl) * Math.ceil(daten.t * daten.qty / Price.konstanten.sMacryl);
            }

            //console.log('Macryl polieren: ' + API.round(zeit, 2));
            return API.round(zeit, 2);
        },
        berechneSchwabeln: function (daten) {
            var U = (daten.l + daten.b) * 2;
            var zeit = 0;
            zeit += U / Price.konstanten.vSchwabeln * Math.ceil(daten.t * daten.qty / Price.getSchwabelStapel(daten));
            //console.log('Formelschwabel:');
            //console.log(U + ' / ' + Price.konstanten.vSchwabeln + ' * ceil(' + daten.t + ' * ' + daten.qty + ' / ' + Price.getSchwabelStapel(daten));
            //console.log('Schwabeln: ' + API.round(zeit, 2));
            return API.round(zeit, 2);
        },
        berechneKantenFasen: function (daten) {
            var U = (daten.l + daten.b) * 2;
            var zeit = 0;
            zeit += Price.konstanten.kFassen1 * U * daten.qty + Price.konstanten.kFassen2;
            //console.log('Fasenzeit: ' + API.round(zeit, 2));
            return API.round(zeit, 2);
        },
        berechneFacette: function (daten) {
            var zeit = 0;
            var U = (daten.l + daten.b) * 2;
            zeit += Price.konstanten.tFacette + Price.konstanten.kFacette1 * U * daten.qty;
            return API.round(zeit, 2);
        },
        berechneLaser: function (daten) {
            var zeit = 0;
            var U = (daten.l + daten.b) * 2;
            var A = daten.l * daten.b / 1000000;
            //console.log('Fläche des Laserteils: ' + A);

            var qtyProPlatte = Math.floor(Price.konstanten.aLaser / A);
            //console.log('QTY / Platte: ' + qtyProPlatte);

            var platten = API.round(daten.qty / qtyProPlatte, 4);
            //console.log('Anzahl der Platten: ' + platten);
            var stapelProPlatte = (qtyProPlatte * daten.t / Price.konstanten.sLaser);
            zeit += Price.konstanten.rLaser;
            //Auflegen
            zeit += 3 + Price.konstanten.tLaser1 * platten;
            //console.log('Auflegen Laser in min: ' + zeit);

            //Laser laufzeit
            for (var i = 0; i < Price.laserzeit.length; i++) {
                if (daten.t <= parseFloat(Price.laserzeit[i].dicke)) {
                    zeit += U * daten.qty / Price.laserzeit[i].v; //* 8;
                    break;
                }
            }

            //console.log('Auflegen + Lasern in min: ' + zeit);
            //Abräumen
            zeit += (daten.qty * Price.konstanten.tLaser2 + (stapelProPlatte * (platten - 1) + Math.ceil((daten.qty - (qtyProPlatte * (platten - 1))) * daten.t / Price.konstanten.sLaser)) * Price.konstanten.tLaser3) / 60;
            //console.log('Laserzeit in min: ' + API.round(zeit,2));

            return API.round(zeit, 2);
        },
        berechneBohrungen: function (daten) {
            var zeitb = 0;
            var zeits = 0;
            //console.log('Bohrungen Anzahl: ' + daten.drill);
            //console.log('Senkungen Anzahl: ' + daten.senk);

            if ((daten.bearbeitung == 2) || (daten.bearbeitung == 4)) {
                if (daten.drill != 0)
                    zeitb = Price.konstanten.tBSLaser + daten.drill * Price.konstanten.tBohrungen * daten.qty;
                if (daten.senk != 0)
                    zeits = Price.konstanten.tBSLaser + daten.senk * (Price.konstanten.tBohrungen + Price.konstanten.tSenkungen) * daten.qty;
            } else {
                if (daten.drill != 0)
                    zeitb = Price.konstanten.tBSEinstellen + daten.drill * Math.ceil(daten.t * daten.qty / Price.konstanten.sBohrungen) * Price.konstanten.tBohrungen;
                //console.log('Bohrformel: ' + Price.konstanten.tBSEinstellen + ' + ' + daten.drill + ' * Math.ceil(' + daten.t + ' * ' + daten.qty + ' / ' + Price.konstanten.sBohrungen + ') * ' + Price.konstanten.tBohrungen);

                if (daten.senk != 0)
                    zeits = Price.konstanten.tBSEinstellen + daten.senk * Math.ceil(daten.t * daten.qty / Price.konstanten.sBohrungen) * Price.konstanten.tBohrungen + daten.senk * Price.konstanten.tSenkungen * daten.qty;
            }
            //console.log('Bohrzeit: ' + API.round((zeitb + zeits) / 60, 2));
            return API.round((zeitb + zeits) / 60, 2);
        },
        berechneRundEcken: function (daten) {
            var zeit = 0;
            if ((daten.bearbeitung == 2) || (daten.bearbeitung == 4)) {
                zeit = Price.konstanten.tLREcken1 * daten.rundecken * (1 + (daten.qty + 1) * Price.konstanten.tLREcken2);
            }
            //console.log('Rundecken: ' + API.round((zeit) / 60, 2));
            return API.round((zeit / 60), 2);
        },
        berechneSchraegEcken: function (daten) {
            var zeit = 0;
            if ((daten.bearbeitung == 2) || (daten.bearbeitung == 4)) {
                zeit = Price.konstanten.tLSEcken1 * daten.schraegeecken * (1 + (daten.qty + 1) * Price.konstanten.tLSEcken2);
            } else if ((daten.bearbeitung != 5) && (daten.bearbeitung != 6)) {
                zeit = Price.konstanten.tZSEcken1 * daten.schraegeecken * (0.5 + (daten.qty + 1) * Price.konstanten.tZSEcken2);
            } else {
                zeit = (Price.konstanten.tZSEcken1 * daten.schraegeecken * (0.5 + (daten.qty + 1) * Price.konstanten.tZSEcken2)) / 60;
                // 40 Länge der Polierten Ecke
                zeit += (40 * daten.schraegeecken / Price.konstanten.vMacryl + Price.konstanten.tMacryl) * Math.ceil(daten.t * daten.qty / Price.konstanten.sMacryl);
                return zeit;
            }
            return API.round((zeit / 60), 2);
        },
        berechnePacken: function (position) {
            var zeit = 0;
            var kilo = 0;
            var laenge = 0;
            var breite = 0;
            var dicke = 0;
            var qty = 0;
            var halterWeight = 0.05;
            //console.log(position);

            kilo += 1.2 * position['l'] * position['b'] * position['t'] * position['qty'] / 1000000;
            if (API.isset(position.halter)) {
                var qtyHalter = position['qty'] * position.halter.length;
                kilo += halterWeight * qtyHalter;
            }

            if (position['l'] > position['b']) {
                if (position['l'] > laenge)
                    laenge = position['l'];
                if (position['b'] > breite)
                    breite = position['b'];
            } else {
                if (position['b'] > laenge)
                    laenge = position['b'];
                if (position['l'] > breite)
                    breite = position['l'];
            }
            dicke += position['t'] * position['qty'];
            qty += position['qty'];
            var ewPalette = false;
            var kostenEwPalette = 0;
            if (kilo > 40) {
                if ((laenge > 1200) || (breite > 800)) {
                    ewPalette = true;
                    kostenEwPalette = Price.konstanten.arbeitsfaktor * 40;
                }
                zeit += Price.konstanten.kPallete1 * kilo;
            } else {
                if (laenge < 600 && breite < 600) {
                    zeit = Price.konstanten.kPacket1 * qty * (laenge * breite / 1000000);
                } else {
                    if ((laenge + 2 * breite + 2 * dicke) > 3000) {
                        zeit += Price.konstanten.kPallete1 * kilo;
                    } else {
                        zeit = Price.konstanten.kPacket1 * qty * (laenge * breite / 1000000);
                    }
                }
            }

            return API.round(zeit, 2);
        }

    };
    function Corner() {
        this.corner = ['E1', 'E2', 'E3', 'E4'];
        var E1 = false;
        var E2 = false;
        var E3 = false;
        var E4 = false;
        this.setCorner = function (corner) {
            switch (corner) {
                case 'E1':
                    E1 = true;
                    break;
                case 'E2':
                    E2 = true;
                    break;
                case 'E3':
                    E3 = true;
                    break;
                case 'E4':
                    E4 = true;
                    break;
            }
        };
        this.isCornerSet = function (corner) {
            switch (corner) {
                case 'E1':
                    return E1;
                    break;
                case 'E2':
                    return E2;
                    break;
                case 'E3':
                    return E3;
                    break;
                case 'E4':
                    return E4;
                    break;
            }
        };
        function areSomeCornerSet() {
            var set = false;
            if (E1) {
                set = true;
            }
            if (E2) {
                set = true;
            }
            if (E3) {
                set = true;
            }
            if (E4) {
                set = true;
            }
            return set;
        }

        this.unSetCorner = function (corner) {
            switch (corner) {
                case 'E1':
                    E1 = false;
                    break;
                case 'E2':
                    E2 = false;
                    break;
                case 'E3':
                    E3 = false;
                    break;
                case 'E4':
                    E4 = false;
                    break;
            }
        };
    }

    var Material = {
        current: {
            uid: null,
            vid: null,
            size: null
        },
        checkedVariante: null,
        getCurrentConfiguration: function () {
            return this.current;
        },
        setMaterial: function (uid) {
            this.current.uid = uid;
            return this;
        },
        setVariante: function (vid) {
            this.current.vid = vid;
            return this;
        },
        setSize: function (size) {
            this.current.size = size;
            return this;
        },
        clearCurrentConfiguration: function () {
            this.setMaterial(null).setVariante(null).setSize(null);
            if (this.checkedVariante != null) {
                $(this.checkedVariante).prop('checked', false);
                this.checkedVariante = null;
            }
            return this;
        }
    };
    var Bearbeitungen = {
        Tempern: {
            current: {
                tempern: false
            },
            getCurrentConfiguration: function () {
                return this.current;
            },
            setTempern: function (tempern) {
                this.current.tempern = tempern;
                return this;
            },
            clearCurrentConfiguration: function () {
                this.setTempern(false);
                return this;
            }
        },
        Kanten: {
            current: {
                uid: 1,
                facette: null,
                angle: null
            },
            getCurrentConfiguration: function () {
                return this.current;
            },
            setBearbeitung: function (uid) {
                this.current.uid = uid;
                return this;
            },
            setFacette: function (facette) {
                this.current.facette = facette;
                return this;
            },
            setAngle: function (angle) {
                this.current.angle = angle;
                return this;
            },
            clearCurrentConfiguration: function () {
                var defaultConfig = 4;
                this.setBearbeitung(defaultConfig).setFacette(null).setAngle(null);
                return this;
            }
        },
        Ecken: {
            current: [],
            corner: new Corner(),
            getCurrentConfiguration: function () {
                return this.current;
            },
            addConfiguration: function (bearbeitung, corner, radius, x, y) {
                var configuration = {
                    uid: bearbeitung,
                    corner: corner,
                    radius: radius,
                    x: x,
                    y: y
                };
                this.current.push(configuration);
                this.corner.setCorner(corner);
                return this;
            },
            editConfiguration: function (bearbeitung, corner, radius, x, y, oldCorner) {
                this.removeConfiguration(oldCorner);
                this.addConfiguration(bearbeitung, corner, radius, x, y);
            },
            removeConfiguration: function (corner) {
                var current = [];
                for (var i = 0; i < this.current.length; i++) {
                    if (this.current[i].corner != corner) {
                        current.push(this.current[i]);
                    } else {
                        this.corner.unSetCorner(corner);
                    }
                }

                this.clearCurrentConfiguration(false).setCurrentConfiguration(current);
                return this;
            },
            setCurrentConfiguration: function (current) {
                this.current = current;
            },
            clearCurrentConfiguration: function (corner) {
                this.current = [];
                if (corner) {
                    this.corner = new Corner();
                }
                return this;
            }
        },
        Bohrungen: {
            current: [],
            corner: new Corner(),
            getCurrentConfiguration: function () {
                return this.current;
            },
            getConfiguration: function (index) {
                var config = null;
                for (var i = 0; i < this.current.length; i++) {
                    if (this.current[i].index == index) {
                        config = this.current[i];
                    }
                }
                return config;
            },
            addConfiguration: function (bearbeitung, corner, d, x, y, index, halter) {
                if (!API.isset(index)) {
                    index = API.createRandomNumber();
                }
                var configuration = {
                    index: index,
                    uid: bearbeitung,
                    corner: corner,
                    dB: d,
                    x: x,
                    y: y
                };
                this.current.push(configuration);
                this.corner.setCorner(corner);
                if (halter) {
                    return index;
                } else {
                    return this;
                }
            },
            editConfiguration: function (index, bearbeitung, corner, d, x, y, halter) {
                this.removeConfiguration(index);
                if (halter) {
                    return this.addConfiguration(bearbeitung, corner, d, x, y, index, halter);
                } else {
                    this.addConfiguration(bearbeitung, corner, d, x, y, index);
                }
            },
            removeConfiguration: function (index) {
                var current = [];
                for (var i = 0; i < this.current.length; i++) {
                    if (this.current[i].index != index) {
                        current.push(this.current[i]);
                    } else {
                        this.corner.unSetCorner(this.current[i].corner);
                    }
                }
                this.clearCurrentConfiguration(false).setCurrentConfiguration(current);
                return this;
            },
            setCurrentConfiguration: function (current) {
                this.current = current;
            },
            clearCurrentConfiguration: function (corner) {
                this.current = [];
                if (corner) {
                    this.corner = new Corner();
                }
                return this;
            }
        },
        Senkungen: {
            current: [],
            corner: new Corner(),
            getCurrentConfiguration: function () {
                return this.current;
            },
            getConfiguration: function (index) {
                var config = null;
                for (var i = 0; i < this.current.length; i++) {
                    if (this.current[i].index == index) {
                        config = this.current[i];
                    }
                }
                return config;
            },
            addConfiguration: function (bearbeitung, corner, m, dB, dS, x, y, index, halter) {
                if (!API.isset(index)) {
                    index = API.createRandomNumber();
                }
                var configuration = {
                    index: index,
                    uid: bearbeitung,
                    corner: corner,
                    m: m,
                    dB: dB,
                    dS: dS,
                    x: x,
                    y: y
                };
                this.current.push(configuration);
                this.corner.setCorner(corner);
                if (halter) {
                    return index;
                } else {
                    return this;
                }
            },
            editConfiguration: function (index, bearbeitung, corner, m, x, y, halter) {
                this.removeConfiguration(index);
                var dB = 0, dS = 0;
                var senkungen = Konfigurator.data.senkungen;
                for (var i = 0; i < senkungen.length; i++) {
                    if (parseFloat(senkungen[i].gewinde) == parseFloat(m)) {
                        dB = parseFloat(senkungen[i].bohrung);
                        dS = parseFloat(senkungen[i].senkung);
                    }
                }
                if (halter) {
                    return this.addConfiguration(bearbeitung, corner, m, dB, dS, x, y, index, halter);
                } else {
                    this.addConfiguration(bearbeitung, corner, m, dB, dS, x, y, index);
                }
            },
            removeConfiguration: function (index) {
                var current = [];
                for (var i = 0; i < this.current.length; i++) {
                    if (this.current[i].index != index) {
                        current.push(this.current[i]);
                    } else {
                        this.corner.unSetCorner(this.current[i].corner);
                    }
                }
                this.clearCurrentConfiguration(false).setCurrentConfiguration(current);
                return this;
            },
            setCurrentConfiguration: function (current) {
                this.current = current;
            },
            clearCurrentConfiguration: function (corner) {
                this.current = [];
                if (corner) {
                    this.corner = new Corner();
                }
                return this;
            }
        }
    };
    var Halter = {
        current: [],
        currentEditing: null,
        corner: new Corner(),
        getCurrentConfiguration: function () {
            return this.current;
        },
        addConfiguration: function (halter, variante, corner, x, y, index, qty, bohrIndex) {
            if (!API.isset(index)) {
                index = API.createRandomNumber();
            }

            if (corner == 'ALLE') {
                qty = 4;
            } else if (corner != null) {
                qty = 1;
            }

            var configuration = {
                index: index,
                hid: halter,
                vid: variante,
                corner: corner,
                x: x,
                y: y,
                qty: qty,
                bohrIndex: bohrIndex
            };
            this.current.push(configuration);
            this.corner.setCorner(corner);
            return this;
        },
        getConfiguration: function (index) {
            for (var i = 0; i < this.current.length; i++) {
                if (this.current[i].index == index) {
                    return this.current[i];
                }
            }
        },
        getHalterByBohrIndex: function (index) {
            for (var i = 0; i < this.current.length; i++) {
                if (this.current[i].bohrIndex == index) {
                    return this.current[i];
                }
            }
        },
        editConfiguration: function (index, halter, variante, corner, x, y, qty, bohrIndex) {
            var oldConfig = Halter.getConfiguration(index);
            var newConfig = Konfigurator.helper.getHalter(halter, variante);
            //log(newConfig);
            //var bohrIndex = null;
            var dB = newConfig.variante.plattenbohrungUnterseite, m = 0, dS = 0;
            var senkungen = Konfigurator.data.senkungen;
            for (var i = 0; i < senkungen.length; i++) {
                if (parseFloat(senkungen[i].bohrung) == parseFloat(dB)) {
                    m = parseFloat(senkungen[i].gewinde);
                    dS = parseFloat(senkungen[i].senkung);
                }
            }
            if (!API.isset(bohrIndex)) {
                if (!API.isset(qty)) {
                    if (oldConfig.hid == "7") {
                        if (newConfig.halter.uid != "7") {
                            Bearbeitungen.Senkungen.removeConfiguration(oldConfig.bohrIndex);
                            bohrIndex = Bearbeitungen.Bohrungen.addConfiguration(1, corner, dB, x, y, null, true);
                        } else {
                            bohrIndex = Bearbeitungen.Senkungen.editConfiguration(oldConfig.bohrIndex, 2, corner, m, x, y, true);
                        }
                    } else {
                        if (newConfig.halter.uid == "7") {
                            Bearbeitungen.Bohrungen.removeConfiguration(oldConfig.bohrIndex);
                            bohrIndex = Bearbeitungen.Senkungen.addConfiguration(2, corner, m, dB, dS, x, y, null, true);
                        } else {
                            bohrIndex = Bearbeitungen.Bohrungen.editConfiguration(oldConfig.bohrIndex, 1, corner, dB, x, y, true);
                        }
                    }
                }
            }

            this.removeConfiguration(index);
            if (API.isset(qty)) {
                this.addConfiguration(halter, variante, corner, x, y, index, qty, bohrIndex);
            } else {
                this.addConfiguration(halter, variante, corner, x, y, index, null, bohrIndex);
            }
        },
        removeConfiguration: function (index) {
            var current = [];
            for (var i = 0; i < this.current.length; i++) {
                if (this.current[i].index != index) {
                    current.push(this.current[i]);
                } else {
                    this.corner.unSetCorner(this.current[i].corner);
                }
            }
            this.clearCurrentConfiguration(false).setCurrentConfiguration(current);
            return this;
        },
        setCurrentConfiguration: function (current) {
            this.current = current;
        },
        clearCurrentConfiguration: function (corner) {
            this.current = [];
            if (corner) {
                this.corner = new Corner();
            }
            return this;
        },
        checkConfiguration: function () {
            var current = this.current;
            var currentLength = this.current.length;
            for (var i = 0; i < currentLength; i++) {
                var halter = Konfigurator.helper.getHalter(current[i].hid, current[i].vid);
                //log('i: ' + i, halter);
                if (halter.variante.position == 'kante') {
                    if (!View.Halter.ohneBohrung.istHalterErlaubt(current[i].hid)) {
                        this.removeConfiguration(current[i].index);
                        View.Halter.ohneBohrung.createSelectionView();
                        View.Configuration.createView.initialize();
                    }
                } else {
                    if (!View.Halter.mitBohrung.istHalterErlaubt(current[i].hid)) {
                        // für Senkungen auch erfassen
                        Bearbeitungen.Bohrungen.removeConfiguration(current[i].bohrIndex);
                        this.removeConfiguration(current[i].index);
                        View.Halter.mitBohrung.createSelectionView();
                        View.Halter.mitBohrung.createEckSelectionView();
                        View.Bearbeitungen.Bohrungen.createEckSelectionView();
                        View.Bearbeitungen.Bohrungen.createSelectionView();
                        View.Configuration.createView.initialize();
                        Konfigurator.helper.drawCADImg();
                    }
                }
            }
        }
    };
    var Grundeinstellung = {
        current: {
            qty: 0,
            width: 0,
            height: 0
        },
        setQty: function (qty) {
            this.current.qty = qty;
            return this;
        },
        setWidth: function (width) {
            this.current.width = width;
            return this;
        },
        setHeight: function (height) {
            this.current.height = height;
            return this;
        },
        clearCurrentConfiguration: function () {
            this.setQty(0).setWidth(0).setHeight(0);
            return this;
        },
        getCurrentConfiguration: function () {
            return this.current;
        }
    };
    var Konfigurator = {
        data: null,
        schild: null,
        mobileSchild: null,
        dependencies: {
            kanten: [{
                uid: 1,
                material: [1, 2, 3]
            }, {
                uid: 2,
                material: [1, 2]
            }, {
                uid: 3,
                material: [1, 2, 3]
            }, {
                uid: 4,
                material: [1, 2]
            }, {
                uid: 5,
                material: [1, 2, 3]
            }, {
                uid: 6,
                material: [1, 2, 3]
            }, {
                uid: 7,
                material: [1, 2, 3]
            }],
            ecken: [{
                uid: 1,
                kanten: [1, 2, 3, 4, 5, 6]
            }, {
                uid: 2,
                kanten: [2, 4]
            }]
        },
        config: {
            materialImgPfad: 'typo3conf/ext/glshop/Resources/Public/Img/Material/',
            halterImgPfad: 'typo3conf/ext/glshop/Resources/Public/Img/Products/',
            bearbeitungImgPfad: 'typo3conf/ext/glshop/Resources/Public/Img/Editing/',
            imgsUrl: 'typo3conf/ext/glshop/Resources/Public/Img/'
        },
        initialize: function () {

            $(window).resize(function () {
                InputFieldTest.start();
            });
            var data = new Object();
            data.eID = 'ajaxDispatcher';
            data.request = {
                pluginName: 'Glacrylshop',
                controller: 'Aj',
                action: 'ajax',
                arguments: {
                    'uid': '',
                    'positionNr': $('#edit-position-nr').val()
                }
            };
            this.data = API.ajax(false, data, 'GET', 'json');
            this.schild = new Schild();
            //log(this.data);
            return this;

            // var test = '';
            // $.ajax({
            //     method: 'post',
            //     url: 'search-results?tx_glshop_glacrylshop%5Baction%5D=ajax&tx_glshop_glacrylshop%5Bcontroller%5D=Aj&type=1812&cHash=bf1cef8f5dab05ff682d09e5bcf26d75',
            //     dataType: 'json',
            //     data: form.serializeArray(),
            //     success: function (value) {
            //         test = value
            //     }
            // });

            console.log('and test');
            // this.data = API.ajax(false, data, 'GET', 'json');
            // this.data = test;
        },
        createView: function () {
            if (API.isset(this.data.edit)) {
                if (this.data.edit.length != 0) {
                    this.fillEditData();
                    $('#editCartBtn').show();
                    $('#editCartMobileBtn').show();
                    $('#addToCartBtn').hide();
                    $('#addToCartMobileBtn').hide();
                    //if (API.isMobileTest() || API.isTabletTest()) {
                    if (API.MobileCheck()) {
                        $('#mobile-footer-data').show();
                    } else {
                        $('#mobile-footer-data').hide();
                    }
                }
            }
            View.initializeFrontEnd();
            return this;
        },
        fillEditData: function () {

            //console.log(this.data.edit);

            if (API.isset(this.data.edit.article)) {
                var material = this.data.edit.article.material;
                Material.setMaterial(material.uid);
                Material.setVariante(material.vid);
                Material.setSize(material.size);
                var config = this.data.edit.article.materialConfig;
                Grundeinstellung.setQty(this.data.edit.qty);
                Grundeinstellung.setWidth(config.width);
                Grundeinstellung.setHeight(config.height);
                var kanten = this.data.edit.article.bearbeitungen.kanten;
                Bearbeitungen.Kanten.setBearbeitung(kanten.uid);
                Bearbeitungen.Kanten.setFacette(kanten.facette);
                Bearbeitungen.Kanten.setAngle(kanten.angle);
                var ecken = this.data.edit.article.bearbeitungen.ecken;
                if (API.isset(ecken)) {
                    for (var i = 0; i < ecken.length; i++) {
                        Bearbeitungen.Ecken.addConfiguration(ecken[i].uid, ecken[i].corner, ecken[i].radius, ecken[i].x, ecken[i].y);
                    }
                }
                var bohrungen = this.data.edit.article.bearbeitungen.bohrungen;
                if (API.isset(bohrungen)) {
                    for (var i = 0; i < bohrungen.length; i++) {
                        Bearbeitungen.Bohrungen.addConfiguration(bohrungen[i].uid, bohrungen[i].corner, bohrungen[i].dB, bohrungen[i].x, bohrungen[i].y, bohrungen[i].index);
                    }
                    View.Bearbeitungen.Bohrungen.createSelectionView();
                }
                var senkungen = this.data.edit.article.bearbeitungen.senkungen;
                if (API.isset(senkungen)) {
                    for (var i = 0; i < senkungen.length; i++) {
                        Bearbeitungen.Senkungen.addConfiguration(senkungen[i].bearbeitung, senkungen[i].corner, senkungen[i].m, senkungen[i].dB, senkungen[i].dS, senkungen[i].x, senkungen[i].y, senkungen[i].index);
                    }
                    View.Bearbeitungen.Senkungen.createSelectionView();
                }
                var halter = this.data.edit.article.halter;
                if (API.isset(halter)) {
                    for (var i = 0; i < halter.length; i++) {
                        if (API.isset(halter[i].corner) && (halter[i].corner != '')) {
                            Halter.addConfiguration(halter[i].hid, halter[i].vid, halter[i].corner, halter[i].x, halter[i].y, halter[i].index, halter[i].qty, halter[i].bohrIndex);
                        } else {
                            Halter.addConfiguration(halter[i].hid, halter[i].vid, null, null, null, halter[i].index, halter[i].qty);
                        }
                    }
                    View.Halter.ohneBohrung.createSelectionView();
                    View.Halter.mitBohrung.createSelectionView();
                }
                var tempern = this.data.edit.article.bearbeitungen.tempern;
                if (API.isset(tempern)) {
                    if (tempern.tempern == 'true') {
                        Bearbeitungen.Tempern.setTempern(true);
                        setTimeout(function () {
                            $('#configuration-tempern').prop('checked', true);
                        }, 150);
                    }
                }

                $('#view-konfigurator-img').show();
                Konfigurator.helper.drawCADImg();
                this.iniEditFields();
                Price.createPriceView();
                $('#view-configuration-priceview').show();
            }
        },
        iniEditFields: function () {
            $('#view-configuration-qty').val(Grundeinstellung.getCurrentConfiguration().qty);
            if (parseInt(Grundeinstellung.getCurrentConfiguration().qty) > 5) {
                var shop = Konfigurator.prepareDataForImg();
                var material = shop.material;
                var shildSize = shop.materialConfig;
                var temperKilo = parseFloat(shildSize.height) * parseFloat(shildSize.width) / 1000000 * 1.2 * parseFloat(material.size) * Grundeinstellung.getCurrentConfiguration().qty;
                var temperHtml = '<input type="checkbox" id="configuration-tempern">+' + API.priceView(Price.getTemperPrice(parseInt(Grundeinstellung.getCurrentConfiguration().qty), temperKilo)) + '€';
                $('#view-configuration-tempern span label').html(temperHtml);
            }
            $('#view-configuration-width').val(Grundeinstellung.getCurrentConfiguration().width);
            $('#view-configuration-height').val(Grundeinstellung.getCurrentConfiguration().height);
        },
        resetKonfiguratorView: function () {
            Material.clearCurrentConfiguration();
            Bearbeitungen.Kanten.clearCurrentConfiguration();
            Bearbeitungen.Ecken.clearCurrentConfiguration(true);
            Bearbeitungen.Bohrungen.clearCurrentConfiguration(true);
            Bearbeitungen.Senkungen.clearCurrentConfiguration(true);
            Bearbeitungen.Tempern.clearCurrentConfiguration();
            Halter.clearCurrentConfiguration(true);
            this.resetKonfiguratorInputs();
            $('#view-konfigurator-img').hide();
            $('#view-configuration-priceview').hide();
            this.createView();
            return this;
        },
        resetKonfiguratorInputs: function () {
            $('#view-configuration-qty').val('1');
            var temperHtml = '<input type="checkbox" id="configuration-tempern">+' + API.priceView(Price.getTemperPrice(parseInt(1), 0)) + '€';
            $('#view-configuration-tempern span label').html(temperHtml);
            $('#view-configuration-width').val('');
            $('#view-configuration-height').val('');
            $('#configuration-tempern').prop('checked', false);
            $('#view-halterMitBohrung-x').val('');
            $('#view-halterMitBohrung-y').val('');
            $('#view-halterOhneBohrung-qty').val('');
            $('#view-kanten-facette').val('');
            $('#view-kanten-angle').val('45');
            $('#view-eckbearbeitung-x').val('');
            $('#view-eckbearbeitung-y').val('');
            $('#view-eckbearbeitung-radius').val('');
            $('#view-bohrungen-d').val('');
            $('#view-bohrungen-x').val('');
            $('#view-bohrungen-y').val('');
            $('#view-senkungen-x').val('');
            $('#view-senkungen-y').val('');
        },
        clearEditState: function () {
            Konfigurator.data.edit = null;
            $('#edit-position-nr').val('');
        },
        prepareDataForImg: function () {
            var data = {
                configuration: Konfigurator.data,
                material: Material.getCurrentConfiguration(),
                materialConfig: Grundeinstellung.getCurrentConfiguration(),
                bearbeitungen: {
                    kanten: Bearbeitungen.Kanten.getCurrentConfiguration(),
                    ecken: Bearbeitungen.Ecken.getCurrentConfiguration(),
                    bohrungen: Bearbeitungen.Bohrungen.getCurrentConfiguration(),
                    senkungen: Bearbeitungen.Senkungen.getCurrentConfiguration(),
                    tempern: Bearbeitungen.Tempern.getCurrentConfiguration()
                },
                halter: Halter.getCurrentConfiguration()
            };
            return data;
        },
        getDataForCart: function () {
            var data = {
                material: Material.getCurrentConfiguration(),
                materialConfig: Grundeinstellung.getCurrentConfiguration(),
                bearbeitungen: {
                    kanten: Bearbeitungen.Kanten.getCurrentConfiguration(),
                    ecken: Bearbeitungen.Ecken.getCurrentConfiguration(),
                    bohrungen: Bearbeitungen.Bohrungen.getCurrentConfiguration(),
                    senkungen: Bearbeitungen.Senkungen.getCurrentConfiguration(),
                    tempern: Bearbeitungen.Tempern.getCurrentConfiguration()
                },
                halter: Halter.getCurrentConfiguration()
            };
            return data;
        },
        helper: {
            drawCADImg: function () {
                var konfiguratorData = Konfigurator.prepareDataForImg();
                Konfigurator.schild.initialize('view-konfigurator-img', konfiguratorData).draw();
                // Evtl check ob mobile
                //Konfigurator.mobileSchild.initialize('view-konfigurator-img-mobile', konfiguratorData).draw();
                var img = $('#view-konfigurator-img').getCanvasImage('png');
                $('#konfigurator-img-mobile').attr('src', img);
                img = null;
            },
            getMiniImgData: function (type, imgName) {
                switch (type) {
                    case 'path':
                        return 'mini/';
                        break;
                    case 'name':
                        var name = imgName.split(".");
                        return name[0] + 'Mini.jpg';
                        break;
                }
            },
            isEckeForKanteEnabled: function (eId, kId) {
                var dependencies = Konfigurator.dependencies.ecken;
                if (kId != null) {
                    for (var i = 0; i < dependencies.length; i++) {
                        if (dependencies[i].uid == eId) {
                            if ($.inArray(parseInt(kId), dependencies[i].kanten) > -1) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                }
            },
            getMaterial: function (mId, vId) {
                var material = Konfigurator.data.material;
                var data = {
                    material: null,
                    variante: null
                };
                for (var i = 0; i < material.length; i++) {
                    if (material[i].uid == mId) {
                        data.material = material[i];
                        if (API.isset(vId)) {
                            for (var j = 0; j < material[i].varianten.length; j++) {
                                if (material[i].varianten[j].uid == vId) {
                                    data.variante = material[i].varianten[j];
                                }
                            }
                        }
                    }
                }
                return data;
            },
            getKanten: function (kId) {
                var kanten = Konfigurator.data.kanten;
                var data = null;
                for (var i = 0; i < kanten.length; i++) {
                    if (kanten[i].uid == kId) {
                        data = kanten[i];
                    }
                }
                return data;
            },
            getEcken: function (eId) {
                var ecken = Konfigurator.data.ecken;
                var data = null;
                for (var i = 0; i < ecken.length; i++) {
                    if (ecken[i].uid == eId) {
                        data = ecken[i];
                    }
                }
                return data;
            },
            getBohrungen: function (bId) {
                var bohrungen = Konfigurator.data.bohrungen;
                var data = null;
                for (var i = 0; i < bohrungen.length; i++) {
                    if (bohrungen[i].uid == bId) {
                        data = bohrungen[i];
                    }
                }
                return data;
            },
            getSenkungen: function (gewinde) {
                var senkungen = Konfigurator.data.senkungen;
                var data = null;
                for (var i = 0; i < senkungen.length; i++) {
                    if (parseFloat(senkungen[i].gewinde) == parseFloat(gewinde)) {
                        data = senkungen[i];
                    }
                }
                return data;
            },
            getHalter: function (hId, vId) {
                var halter = Konfigurator.data.halter;
                var data = {
                    halter: null,
                    variante: null
                };
                for (var i = 0; i < halter.length; i++) {
                    if (halter[i].uid == hId) {
                        data.halter = {
                            uid: halter[i].uid,
                            pid: halter[i].pid,
                            name: halter[i].name,
                            bild: halter[i].bild,
                        };
                        if (API.isset(vId)) {
                            for (var j = 0; j < halter[i].varianten.length; j++) {
                                if (halter[i].varianten[j].uid == vId) {
                                    data.variante = halter[i].varianten[j];
                                }
                            }
                        }
                    }
                }
                return data;
            }
        }
    };
    var HalterFilter = {
        on: false,
        onMit: false,
        onOhne: false,
        config: {
            mit: {
                normalerBereich: '.view-vorschau-mBohrung',
                filterBereich: '.view-halterAuswahl-mBohrung',
                container: '#filter-halterMitBohrung-Container',
                filter: {
                    verwendung: {
                        type: 'select',
                        id: '#filter-halterMitBohrung-verwendung'
                    },
                    material: {
                        type: 'select',
                        id: '#filter-halterMitBohrung-material'
                    },
                    artNr: {
                        type: 'input',
                        id: '#filter-halterMitBohrung-artikel'
                    }
                }
            },
            ohne: {
                normalerBereich: '.view-vorschau-oBohrung',
                filterBereich: '.view-halterAuswahl-oBohrung',
                container: '#filter-halterOhneBohrung-Container',
                filter: {
                    verwendung: {
                        type: 'select',
                        id: '#filter-halterOhneBohrung-verwendung'
                    },
                    material: {
                        type: 'select',
                        id: '#filter-halterOhneBohrung-material'
                    },
                    artNr: {
                        type: 'input',
                        id: '#filter-halterOhneBohrung-artikel'
                    }
                }
            }
        },
        data: null,
        mSize: null,
        halter: null,
        iniFirst: function () {
            this.iniActions();
        },
        initialize: function (data, mSize) {
            this.data = data;
            this.mSize = mSize;
            this.halter = [];
            this.iniHalterObjects();
            this.iniFilter();
            this.createMitView();
            this.createOhneView();
        },
        iniFilter: function () {
            $(this.config.mit.filter.material.id).html(this.getMaterialFilterContent(false));
            $(this.config.mit.filter.verwendung.id).html(this.getVerwendungFilterContent(false));
            $(this.config.ohne.filter.material.id).html(this.getMaterialFilterContent(true));
            $(this.config.ohne.filter.verwendung.id).html(this.getVerwendungFilterContent(true));
        },
        getMaterialFilterContent: function (kante) {
            var materialMit = [], materialOhne = [];
            for (var i = 0; i < this.halter.length; i++) {
                if (this.halter[i].kante) {
                    if ($.inArray(this.halter[i].material, materialOhne) == -1) {
                        materialOhne.push(this.halter[i].material);
                    }
                } else {
                    if ($.inArray(this.halter[i].material.trim(), materialMit) == -1) {
                        materialMit.push(this.halter[i].material.trim());
                    }
                }
            }

            var html = '', material = (kante ? materialOhne : materialMit);
            html += '<option value="choose">Bitte w&auml;hlen</option>';
            for (var i = 0; i < material.length; i++) {
                html += '<option value="' + material[i] + '">' + material[i] + '</option>';
            }
            return html;
        },
        getVerwendungFilterContent: function (kante) {
            var verwendungMit = [], verwendungOhne = [];
            for (var i = 0; i < this.halter.length; i++) {
                if (this.halter[i].kante) {
                    if ($.inArray(this.halter[i].verwendung, verwendungOhne) == -1) {
                        verwendungOhne.push(this.halter[i].verwendung);
                    }
                } else {
                    if ($.inArray(this.halter[i].verwendung, verwendungMit) == -1) {
                        verwendungMit.push(this.halter[i].verwendung);
                    }
                }
            }

            var html = '', verwendung = (kante ? verwendungOhne : verwendungMit);
            html += '<option value="choose">Bitte w&auml;hlen</option>';
            for (var i = 0; i < verwendung.length; i++) {
                html += '<option value="' + verwendung[i] + '">' + verwendung[i] + '</option>';
            }
            return html;
        },
        iniHalterObjects: function () {
            for (var i = 0; i < this.data.length; i++) {
                for (var j = 0; j < this.data[i].varianten.length; j++) {
                    if (((parseFloat(this.mSize) >= parseFloat(this.data[i].varianten[j].materialVon)) || (parseFloat(this.data[i].varianten[j].materialVon) == -1)) && ((parseFloat(this.mSize) <= parseFloat(this.data[i].varianten[j].materialBis)) || (parseFloat(this.data[i].varianten[j].materialBis) == -1))) {
                        this.objToHtml(this.data[i].varianten[j], this.data[i].uid);
                    }
                }
            }
        },
        filterVerwendungMitHalter: function () {
            var verwendung = $(this).val();
            for (var i = 0; i < HalterFilter.halter.length; i++) {
                if (verwendung != 'choose') {
                    if (HalterFilter.halter[i].verwendung.indexOf(verwendung) == -1) {
                        HalterFilter.halter[i].show = false;
                    } else {
                        HalterFilter.halter[i].show = true;
                    }
                } else {
                    HalterFilter.halter[i].show = true;
                }
            }
            HalterFilter.createMitView();
        },
        filterArtNrMitHalter: function () {
            var artnr = $(this).val();
            for (var i = 0; i < HalterFilter.halter.length; i++) {
                if (artnr != '') {
                    if (HalterFilter.halter[i].artnr.indexOf(artnr) == -1) {
                        HalterFilter.halter[i].show = false;
                    } else {
                        HalterFilter.halter[i].show = true;
                    }
                } else {
                    HalterFilter.halter[i].show = true;
                }
            }
            HalterFilter.createMitView();
        },
        filterMaterialMitHalter: function () {
            var material = $(this).val();
            for (var i = 0; i < HalterFilter.halter.length; i++) {
                if (material != 'choose') {
                    if (HalterFilter.halter[i].material != material) {
                        HalterFilter.halter[i].show = false;
                    } else {
                        HalterFilter.halter[i].show = true;
                    }
                } else {
                    HalterFilter.halter[i].show = true;
                }
            }
            HalterFilter.createMitView();
        },
        filterVerwendungOhneHalter: function () {
            var verwendung = $(this).val();
            for (var i = 0; i < HalterFilter.halter.length; i++) {
                if (verwendung != 'choose') {
                    if (HalterFilter.halter[i].verwendung.indexOf(verwendung) == -1) {
                        HalterFilter.halter[i].show = false;
                    } else {
                        HalterFilter.halter[i].show = true;
                    }
                } else {
                    HalterFilter.halter[i].show = true;
                }
            }
            HalterFilter.createOhneView();
        },
        filterArtNrOhneHalter: function () {
            var artnr = $(this).val();
            for (var i = 0; i < HalterFilter.halter.length; i++) {
                if (artnr != '') {
                    if (HalterFilter.halter[i].artnr.indexOf(artnr) == -1) {
                        HalterFilter.halter[i].show = false;
                    } else {
                        HalterFilter.halter[i].show = true;
                    }
                } else {
                    HalterFilter.halter[i].show = true;
                }
            }
            HalterFilter.createOhneView();
        },
        filterMaterialOhneHalter: function () {
            var material = $(this).val();
            for (var i = 0; i < HalterFilter.halter.length; i++) {
                if (material != 'choose') {
                    if (HalterFilter.halter[i].material != material) {
                        HalterFilter.halter[i].show = false;
                    } else {
                        HalterFilter.halter[i].show = true;
                    }
                } else {
                    HalterFilter.halter[i].show = true;
                }
            }
            HalterFilter.createOhneView();
        },
        iniActions: function () {
            var that = this;
            $('body').on('click', '#filter-view', that.showFilterFunction);
            $('body').on('click', '#filter-view-ohne', that.showFilterFunction);
            $('body').on('click', '#close-product-mitB-Filter', that.closeFilterFunction);
            $('body').on('click', '#close-product-ohneB-Filter', that.closeFilterFunction);
            $('body').on('click', '.addFilterHalterMitToAuswahlBtn', that.addHalterToAuswahl);
            $('body').on('click', '.addFilterHalterOhneToAuswahlBtn', that.addHalterToAuswahl);
            //console.log(that.halter);
            $('body').on('keyup', this.config.mit.filter.artNr.id, that.filterArtNrMitHalter);
            $('body').on('change', this.config.mit.filter.material.id, that.filterMaterialMitHalter);
            $('body').on('change', this.config.mit.filter.verwendung.id, that.filterVerwendungMitHalter);
            $('body').on('keyup', this.config.ohne.filter.artNr.id, that.filterArtNrOhneHalter);
            $('body').on('change', this.config.ohne.filter.material.id, that.filterMaterialOhneHalter);
            $('body').on('change', this.config.ohne.filter.verwendung.id, that.filterVerwendungOhneHalter);
        },
        closeFilterFunction: function (e) {
            var ctxMit = ($(this).attr('id') == 'close-product-mitB-Filter' ? true : false);
            if (ctxMit) {
                if (HalterFilter.onMit) {
                    HalterFilter.onMit = false;
                    HalterFilter.hideMitFilter();
                }
            } else {
                if (HalterFilter.onOhne) {
                    HalterFilter.onOhne = false;
                    HalterFilter.hideOhneFilter();
                }
            }
        },
        showFilterFunction: function (e, ctxMit) {
            if (!API.isset(ctxMit)) {
                var ctxMit = ($(this).attr('id') == 'filter-view' ? true : false);
            }
            if (API.isset(Material.getCurrentConfiguration().size)) {
                HalterFilter.initialize(Konfigurator.data.halter, Material.getCurrentConfiguration().size);
                if (ctxMit) {
                    if (!HalterFilter.onMit) {
                        HalterFilter.onMit = true;
                        HalterFilter.showMitFilter();
                        HalterFilter.createMitView();
                        $('#halter-mitBohrung-AbstandEdit').show();
                    } else {
                        HalterFilter.onMit = false;
                        HalterFilter.hideMitFilter();
                    }
                } else {
                    if (!HalterFilter.onOhne) {
                        HalterFilter.onOhne = true;
                        HalterFilter.showOhneFilter();
                        HalterFilter.createOhneView();
                    } else {
                        HalterFilter.onOhne = false;
                        HalterFilter.hideOhneFilter();
                    }
                }
            }
        },
        addHalterToAuswahl: function (e) {
            var ctxMit = ($(this).hasClass('addFilterHalterMitToAuswahlBtn') ? true : false);
            //log('Add Halter To Auswahl CTX: ', ctxMit);

            var hId = $(this).parent('div').find('input[name="hId"]').val();
            var vId = $(this).parent('div').find('input[name="vId"]').val();
            var halter = Konfigurator.helper.getHalter(hId, vId);
            if (ctxMit) {
                $('#view-halterMitBohrung-auswahlHId').val(hId);
                $('#view-halterMitBohrung-variantenId').val(vId);
                $('.view-halterMitBohrung-HalterAuswahlPreview').html(halter.variante.name);
                $('.view-halterMitBohrung-HalterAuswahlMaterial').html(halter.variante.material);
                $('.view-halterMitBohrung-HalterAuswahlArtNr').html(halter.variante.artnr);
                $('.view-halterMitBohrung-HalterAuswahlWand').html(API.dotToComma(halter.variante.wandabstand));
                $('.view-halterMitBohrung-HalterAuswahlSize').html((halter.variante.halterkantenlaenge == 0 ? '&Oslash;' + API.dotToComma(halter.variante.durchmesser) : API.dotToComma(halter.variante.halterkantenlaenge) + ' x ' + API.dotToComma(halter.variante.halterkantenlaenge)));
                $('.view-halterMitBohrung-HalterAuswahlKopf').html(halter.variante.kopfform);
                $('.view-halterMitBohrung-HalterAuswahlPreis').html(API.priceView(halter.variante.preis));
                $('.halterMBohrungAuswahl').show();

                $('.view-halterMitBohrung-selection').show();
                var srcImg = Konfigurator.config.halterImgPfad + halter.variante.bild;
                var srcPreview = Konfigurator.config.halterImgPfad + Konfigurator.helper.getMiniImgData('path') + Konfigurator.helper.getMiniImgData('name', halter.variante.bild);
                $('.view-halterMitBohrung-Img').attr('href', srcImg).show();
                $('.view-halterMitBohrung-Img-preview').attr('src', srcPreview);
            } else {
                $('#view-halterOhneBohrung-auswahlHId').val(hId);
                $('#view-halterOhneBohrung-variantenId').val(vId);
                $('.view-halterOhneBohrung-HalterAuswahlPreview').html(halter.variante.name);
                $('.view-halterOhneBohrung-HalterAuswahlMaterial').html(halter.variante.material);
                $('.view-halterOhneBohrung-HalterAuswahlArtNr').html(halter.variante.artnr);
                $('.view-halterOhneBohrung-HalterAuswahlWand').html(API.dotToComma(halter.variante.wandabstand));
                $('.view-halterOhneBohrung-HalterAuswahlSize').html((halter.variante.halterkantenlaenge == 0 ? '&Oslash;' + API.dotToComma(halter.variante.durchmesser) : API.dotToComma(halter.variante.halterkantenlaenge) + ' x ' + API.dotToComma(halter.variante.halterkantenlaenge)));
                $('.view-halterOhneBohrung-HalterAuswahlKopf').html(halter.variante.kopfform);
                $('.view-halterOhneBohrung-HalterAuswahlPreis').html(API.priceView(halter.variante.preis));
                $('.halterOBohrungAuswahl').show();

                $('.view-halterOhneBohrung-selection').show();
                var srcImg = Konfigurator.config.halterImgPfad + halter.variante.bild;
                var srcPreview = Konfigurator.config.halterImgPfad + Konfigurator.helper.getMiniImgData('path') + Konfigurator.helper.getMiniImgData('name', halter.variante.bild);
                $('.view-halterOhneBohrung-Img').attr('href', srcImg).show();
                $('.view-halterOhneBohrung-Img-preview').attr('src', srcPreview);
            }
            HalterFilter.showFilterFunction(e, ctxMit);
        },
        showMitFilter: function () {
            $(this.config.mit.normalerBereich).hide();
            $(this.config.mit.filterBereich).show();
        },
        hideMitFilter: function () {
            $(this.config.mit.filterBereich).hide();
            $(this.config.mit.normalerBereich).show();
        },
        showOhneFilter: function () {
            $(this.config.ohne.normalerBereich).hide();
            $(this.config.ohne.filterBereich).show();
        },
        hideOhneFilter: function () {
            $(this.config.ohne.filterBereich).hide();
            $(this.config.ohne.normalerBereich).show();
        },
        createMitView: function () {
            var html = this.addContainerHeader();
            for (var i = 0; i < this.halter.length; i++) {
                if (this.halter[i].show && !this.halter[i].kante) {
                    html += this.halter[i].html;
                }
            }
            $(this.config.mit.container).html(html);
        },
        createOhneView: function () {
            var html = this.addContainerHeader();
            for (var i = 0; i < this.halter.length; i++) {
                if (this.halter[i].show && this.halter[i].kante) {
                    html += this.halter[i].html;
                }
            }
            $(this.config.ohne.container).html(html);
        },
        objToHtml: function (obj, uid) {
            var src = Konfigurator.config.halterImgPfad;
            var html = '<div class="row" style="margin:6px 0 0 0 !important; padding-top: 6px !important; border-top: 1px solid #B4A97F;">';
            html += '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="font-size: 11px !important;">';
            html += '<div class="row" style="margin:0px !important;">';
            html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
            html += '<input type="hidden" name="vId" value="' + obj.uid + '" />';
            html += '<input type="hidden" name="hId" value="' + uid + '" />';
            html += '<p style="text-align: left; font-size: 12px !important; margin-bottom: 0; font-weight: bold; display: inline-block;">' + obj.name + '</p><span class="sprite-Bestaetigen addFilterHalter' + (obj.position == 'kante' ? 'Ohne' : 'Mit') + 'ToAuswahlBtn" style="display: inline-block;"></span>';
            html += '<p style="text-align: left; font-size: 12px !important; margin-bottom: 0;">' + obj.material + '<br /> Preis: ' + API.priceView(obj.preis) + ' &euro;' + '</p>';
            html += '</div>';
            html += '</div>';
            html += '<div class="row" style="margin:0px !important;">';
            html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">';
            html += 'Art.Nr.:';
            html += '</div>';
            html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">';
            html += 'Wandabst.:';
            html += '</div>';
            html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">';
            html += 'Gr&ouml;&szlig;e:';
            html += '</div>';
            html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">';
            html += 'Kopfform:';
            html += '</div>';
            html += '</div>';
            html += '<div class="row" style="margin:0px !important;">';
            html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">';
            html += obj.artnr;
            html += '</div>';
            html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">';
            html += obj.wandabstand;
            html += '</div>';
            html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">';
            html += (obj.halterkantenlaenge != 0 ? obj.halterkantenlaenge + ' x ' + obj.halterkantenlaenge + ' mm' : '&oslash; ' + obj.durchmesser + 'mm');
            html += '</div>';
            html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">';
            html += obj.kopfform;
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
            var srcImg = src + obj.bild;
            var srcPreview = src + Konfigurator.helper.getMiniImgData('path') + Konfigurator.helper.getMiniImgData('name', obj.bild);
            html += '<a href="' + srcImg + '" data-lightbox="halterMBohrung" data-title="' + obj.name + ' - ' + obj.material + '">';
            html += '<img class="img-responsive" src="' + srcPreview + '" style="margin-top: 8px !important;">';
            html += '</a>';
            html += '</div>';
            html += '</div>';
            this.halter.push({
                show: true,
                artnr: obj.artnr,
                material: obj.material,
                wa: obj.wandabstand,
                verwendung: obj.beschreibung,
                html: html,
                kante: (obj.position == 'kante' ? true : false)
            });
        },
        addContainerHeader: function () {
            var html = '<div class="row" style="padding: 0 !important; margin: 6px 0 !important; color: #998B55; ">';
            html += '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="padding: 0 !important; text-align: left;">';
            html += 'Halter';
            html += '</div>';
            html += '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="padding: 0 !important; text-align: right;">';
            html += 'Bild';
            html += '</div>';
            html += '</div>';
            return html;
        }
    };
    var View = {
        initializeFrontEnd: function () {
            InputFieldTest.start();
            //ConfigurationView
            this.Configuration.createView.initialize();
            //Bearbeitungen
            this.Bearbeitungen.Kanten.createKantenAuswahl();
            this.Bearbeitungen.Ecken.createEckBearbeitungAuswahl();
            this.Bearbeitungen.Ecken.createEckSelectionView();
            this.Bearbeitungen.Ecken.createSelectionView();
            this.Bearbeitungen.Ecken.createEckSelectionView();
            this.Bearbeitungen.Ecken.createSelectionView();
            this.Bearbeitungen.Bohrungen.iniBohrungView();
            this.Bearbeitungen.Bohrungen.createEckSelectionView();
            this.Bearbeitungen.Bohrungen.createSelectionView();
            this.Bearbeitungen.Senkungen.iniSenkungView();
            this.Bearbeitungen.Senkungen.createEckSelectionView();
            this.Bearbeitungen.Senkungen.createSelectionView();
            this.Bearbeitungen.Senkungen.createSchraubenMView();
            //Halter
            this.Halter.mitBohrung.createEckSelectionView();
            this.Halter.mitBohrung.createSelectionView();
            this.Halter.ohneBohrung.createSelectionView();
        },
        actions: {
            initializeFirst: function () {
                this.Configuration.initialize();
                this.Material.initialize();
                this.Bearbeitungen.initialize();
                this.Halter.initialize();
            },
            Configuration: {
                initialize: function () {
                    $('body').on('click', '#addToCartBtn', View.actions.Configuration.addToCartFunction);
                    $('body').on('click', '#addToCartMobileBtn', View.actions.Configuration.addToCartFunction);
                    $('body').on('click', '#editCartBtn', View.actions.Configuration.editCartFunction);
                    $('body').on('click', '#editCartMobileBtn', View.actions.Configuration.editCartFunction);
                    $('body').on('click', '#minusQtyBtn', View.actions.Configuration.minusQtyFunction);
                    $('body').on('click', '#plusQtyBtn', View.actions.Configuration.plusQtyFunction);
                    $('body').on('keyup', '#view-configuration-qty', View.actions.Configuration.checkEnteredQtyFunction);
                    $('body').on('keyup', '#view-configuration-width', View.actions.Configuration.drawImgFunction);
                    $('body').on('keyup', '#view-configuration-height', View.actions.Configuration.drawImgFunction);
                    $('body').on('click', '#configuration-tempern', View.actions.Configuration.clickTempernFunction)

                    $('body').on('click', '.bearbeitungHeader', View.actions.Configuration.closeAccordionFunction);
                    $('body').on('click', '#back-to-Top-Lnk', View.actions.Configuration.backToTopFunction);
                    $('body').on('click', '#show-mobile-img-btn', View.actions.Configuration.showMobileCADFunction);
                },
                clickTempernFunction: function (e) {
                    if (!Bearbeitungen.Tempern.current.tempern) {
                        Bearbeitungen.Tempern.setTempern(true);
                    } else {
                        Bearbeitungen.Tempern.setTempern(false);
                    }
                    if (Validate.materialSet()) {
                        Price.createPriceView();
                    }
                },
                showMobileCADFunction: function (e) {
                    e.preventDefault();
                    $('#mobile-img-area').toggle("fast", function () {
                        var img = $('#show-mobile-img-btn').find('img');
                        if (img.attr('src') == 'typo3conf/ext/glshop/Resources/Public/Img/CAD.png') {
                            img.attr('src', 'typo3conf/ext/glshop/Resources/Public/Img/CAD_open.png');
                        } else {
                            img.attr('src', 'typo3conf/ext/glshop/Resources/Public/Img/CAD.png');
                        }
                    });
                },
                backToTopFunction: function (e) {
                    e.preventDefault();
                    var href = $(this).attr('href');
                    $('html, body').animate({
                        scrollTop: $(href).offset().top
                    }, 'slow');
                },
                closeAccordionFunction: function (e) {
                    e.preventDefault();
                    var accordion = $(this).next('div.panel-group');
                    accordion.find('div.panel-collapse.in').removeClass('in');
                    return false;
                },
                drawImgFunction: function (e) {
                    e.preventDefault();
                    var width = $('#view-configuration-width');
                    var height = $('#view-configuration-height');
                    var qty = $('#view-configuration-qty').val();
                    var errorField = width.parent('div').parent('div').parent('div').parent('div').find('div.error');
                    var valid = true;
                    valid = valid && Validate.checkRegexp(width, errorField);
                    valid = valid && Validate.checkRegexp(height, errorField);
                    valid = valid && Validate.material(width, height, errorField);
                    if (valid) {
                        Grundeinstellung.setHeight(height.val()).setWidth(width.val()).setQty(qty);
                        $('#view-konfigurator-img').show();
                        Konfigurator.helper.drawCADImg();
                        View.Configuration.createView.insertGrundEinstellungenView();
                    }

                    if (Validate.materialSet()) {
                        Price.createPriceView();
                    }
                },
                saveImgToServer: function (imgId) {
                    var imgName = '';
                    var img = $('#' + imgId).getCanvasImage("png");
                    return imgName;
                },
                editCartFunction: function (e) {
                    e.preventDefault();
                    var cartPosition = Konfigurator.getDataForCart(), saved = false;
                    //log(cartPosition);
                    //var img = View.actions.Configuration.saveImgToServer('view-konfigurator-img');
                    var img = $('#view-konfigurator-img').getCanvasImage("png");
                    var preis = Price.calculate();
                    var data = new Object();
                    data.eID = 'ajaxDispatcher';
                    data.request = {
                        pluginName: 'Glacrylshop',
                        controller: 'Aj',
                        action: 'addToCart',
                        arguments: {
                            'artikel': cartPosition,
                            'anzahl': cartPosition.materialConfig.qty,
                            'img': img,
                            'preis': preis,
                            'posNr': Konfigurator.data.edit.posNr,
                            'schild': true
                        }
                    };
                    var saved = API.ajax(false, data, 'POST', 'json');
                    if (saved) {
                        if (cartPosition.materialConfig.qty > Validate.config.maxQty) {
                            $('#konfigurator-qty-warning').html(cartPosition.materialConfig.qty);
                            $('#konfigurator-qty-Dialog').dialog('open');
                        } else {
                            $('#konfigurator-success-Dialog').dialog("open");
                        }
                        Konfigurator.data.edit = null;
                        Konfigurator.resetKonfiguratorView();
                        View.Configuration.createView.insertGrundEinstellungenView();
                    } else {
                        $('#konfigurator-error-Dialog').dialog("open");
                    }
                    if ($('#konfigurator-img-mobile').is(':visible')) {
                        $('#show-mobile-img-btn').trigger('click');
                    }
                },
                addToCartFunction: function (e) {
                    e.preventDefault();
                    var cartPosition = Konfigurator.getDataForCart(), saved = false;
                    //log(cartPosition);
                    //var img = View.actions.Configuration.saveImgToServer('view-konfigurator-img');
                    var img = $('#view-konfigurator-img').getCanvasImage("png");
                    var preis = Price.calculate();
                    var data = new Object();
                    data.eID = 'ajaxDispatcher';
                    data.request = {
                        pluginName: 'Glacrylshop',
                        controller: 'Aj',
                        action: 'addToCart',
                        arguments: {
                            'artikel': cartPosition,
                            'anzahl': cartPosition.materialConfig.qty,
                            'img': img,
                            'preis': preis,
                            'schild': true
                        }
                    };
                    var saved = API.ajax(false, data, 'POST', 'json');
                    if (saved) {
                        if (cartPosition.materialConfig.qty > Validate.config.maxQty) {
                            $('#konfigurator-qty-warning').html(cartPosition.materialConfig.qty);
                            $('#konfigurator-qty-Dialog').dialog('open');
                        } else {
                            $('#konfigurator-success-Dialog').dialog("open");
                        }
                        Konfigurator.resetKonfiguratorView();
                    } else {
                        $('#konfigurator-error-Dialog').dialog("open");
                    }
                    if ($('#konfigurator-img-mobile').is(':visible')) {
                        $('#show-mobile-img-btn').trigger('click');
                    }
                },
                checkEnteredQtyFunction: function (e) {
                    e.preventDefault();
                    var qty = parseInt($(this).val());
                    var valid = true;
                    var errorField = $(this).parent('div').parent('div').parent('div').parent('div').find('div.error');
                    valid = valid && Validate.emptyField({'St&uuml;ckzahl': $(this)}, errorField);
                    valid = valid && Validate.checkRegexp($(this), errorField);
                    valid = valid && Validate.checkNumber($(this), errorField);
                    if (valid) {
                        Grundeinstellung.setQty(qty);
                        Price.createPriceView();
                        var shop = Konfigurator.prepareDataForImg();
                        var material = shop.material;
                        var shildSize = shop.materialConfig;
                        var temperKilo = parseFloat(shildSize.height) * parseFloat(shildSize.width) / 1000000 * 1.2 * parseFloat(material.size) * qty;
                        var temperHtml = '<input type="checkbox" id="configuration-tempern">+' + API.priceView(Price.getTemperPrice(parseInt(qty), temperKilo)) + '€';
                        $('#view-configuration-tempern span label').html(temperHtml);
                        var tempernSet = Bearbeitungen.Tempern.getCurrentConfiguration();
                        if (tempernSet.tempern) {
                            $('#configuration-tempern').prop('checked', true);
                        }
                    }
                },
                minusQtyFunction: function (e) {
                    e.preventDefault();
                    var qtyField = $('#view-configuration-qty');
                    var qty = parseInt(qtyField.val());
                    var newQty = 1;
                    var valid = true;
                    var errorField = qtyField.parent('div').parent('div').parent('div').parent('div').find('div.error');
                    valid = valid && Validate.emptyField({'St&uuml;ckzahl': qtyField}, errorField);
                    valid = valid && Validate.checkRegexp(qtyField, errorField);
                    valid = valid && Validate.checkNumber(qtyField, errorField);
                    if (valid) {
                        if (qty > 1) {
                            newQty = --qty;
                        }
                        Grundeinstellung.setQty(newQty);
                        $('#view-configuration-qty').val(newQty);
                        Price.createPriceView();
                        var shop = Konfigurator.prepareDataForImg();
                        var material = shop.material;
                        var shildSize = shop.materialConfig;
                        var temperKilo = parseFloat(shildSize.height) * parseFloat(shildSize.width) / 1000000 * 1.2 * parseFloat(material.size) * newQty;
                        var temperHtml = '<input type="checkbox" id="configuration-tempern">+' + API.priceView(Price.getTemperPrice(parseInt(newQty), temperKilo)) + '€';
                        $('#view-configuration-tempern span label').html(temperHtml);
                        var tempernSet = Bearbeitungen.Tempern.getCurrentConfiguration();
                        if (tempernSet.tempern) {
                            $('#configuration-tempern').prop('checked', true);
                        }
                    }
                },
                plusQtyFunction: function (e) {
                    e.preventDefault();
                    var qtyField = $('#view-configuration-qty');
                    var qty = parseInt(qtyField.val());
                    var valid = true;
                    var errorField = qtyField.parent('div').parent('div').parent('div').parent('div').find('div.error');
                    valid = valid && Validate.emptyField({'St&uuml;ckzahl': qtyField}, errorField);
                    valid = valid && Validate.checkRegexp(qtyField, errorField);
                    valid = valid && Validate.checkNumber(qtyField, errorField, true);
                    if (valid) {
                        if (qty == 99999) {
                            qty = qty;
                        } else {
                            qty++;
                        }
                        Grundeinstellung.setQty(qty);
                        $('#view-configuration-qty').val(qty);
                        Price.createPriceView();
                        var shop = Konfigurator.prepareDataForImg();
                        var material = shop.material;
                        var shildSize = shop.materialConfig;
                        var temperKilo = parseFloat(shildSize.height) * parseFloat(shildSize.width) / 1000000 * 1.2 * parseFloat(material.size) * qty;
                        var temperHtml = '<input type="checkbox" id="configuration-tempern">+' + API.priceView(Price.getTemperPrice(parseInt(qty), temperKilo)) + '€';
                        $('#view-configuration-tempern span label').html(temperHtml);
                        var tempernSet = Bearbeitungen.Tempern.getCurrentConfiguration();
                        if (tempernSet.tempern) {
                            $('#configuration-tempern').prop('checked', true);
                        }
                    }
                }
            },
            Material: {
                initialize: function () {
                    $('body').on('change', '#view-material-auswahl div div div.panel-body select', View.actions.Material.changeMaterialFunction);
                    $('body').on('click', '.addMaterialBtn', View.actions.Material.addMaterialFunction);
                },
                changeMaterialFunction: function (e) {
                    e.preventDefault();
                    var mId = $(this).parent('div').find('input[name="materialUid"]').val();
                    var vId = $(this).val();
                    var panelId = $(this).parent('div').parent('div').attr('id').split('_');
                    Material.setVariante(vId);
                    View.Material.changeSizeView(panelId[2], mId, vId);
                    var material = Konfigurator.data.material;
                    var bildSrc = Konfigurator.config.materialImgPfad;
                    for (var i = 0; i < material.length; i++) {
                        if (parseInt(mId) == parseInt(material[i].uid)) {
                            for (var j = 0; j < material[i].varianten.length; j++) {
                                if (parseInt(vId) == parseInt(material[i].varianten[j].uid)) {
                                    bildSrc += material[i].varianten[j].bild;
                                }
                            }
                        }
                    }
                    $(this).parent('div').find('div.row').find('div.materialImg').find('img').attr('src', bildSrc);
                    $(this).parent('div').find('div.row').find('div.materialImg').find('a').attr('href', bildSrc);
                },
                addMaterialFunction: function (e) {
                    var material = $('#view-material-auswahl').find('div.in');
                    var mId = material.find('div').find('input[name="materialUid"]').val();
                    var vId = (API.isset(material.find('div').find('select').val()) ? material.find('div').find('select').val() : material.find('div').find('input[name="variantenUid"]').val());
                    var checkedVariante = material.find('div').find('div.row').find('div:first').find('input[name="dicke"]:checked');
                    var size = checkedVariante.val();
                    var width = $('#view-configuration-width');
                    var height = $('#view-configuration-height');
                    var errorField = material.find('div.error');
                    var valid = true;
                    valid = valid && Validate.emptyField({'Breite': width, 'H&ouml;he': height}, errorField);
                    if (valid) {
                        Material.setMaterial(mId).setVariante(vId).setSize(size);
                        Material.checkedVariante = checkedVariante;
                        View.Bearbeitungen.Kanten.createKantenAuswahl();
                        var kantenEdit = Bearbeitungen.Kanten.getCurrentConfiguration();
                        if (mId == 3) {
                            if ((kantenEdit.uid == 2) || (kantenEdit.uid == 4)) {
                                $('#view-kanten-auswahl select').val(1);
                            }
                        }

                        View.actions.Bearbeitungen.changeAndSaveKantenAuswahlFunction();
                        Halter.checkConfiguration();
                        View.Configuration.createView.insertMaterialView();
                        Price.createPriceView();
                        $('#view-configuration-priceview').show();
                        var shop = Konfigurator.prepareDataForImg();
                        var material = shop.material;
                        var shildSize = shop.materialConfig;
                        var qty = parseInt((Grundeinstellung.getCurrentConfiguration().qty));
                        var temperKilo = parseFloat(shildSize.height) * parseFloat(shildSize.width) / 1000000 * 1.2 * parseFloat(material.size) * qty;
                        var temperHtml = '<input type="checkbox" id="configuration-tempern">+' + API.priceView(Price.getTemperPrice(parseInt(qty), temperKilo)) + '€';
                        $('#view-configuration-tempern span label').html(temperHtml);
                        var tempernSet = Bearbeitungen.Tempern.getCurrentConfiguration();
                        if (tempernSet.tempern) {
                            $('#configuration-tempern').prop('checked', true);
                        }


                        Dispatcher.clearErrorFields(Dispatcher.Type.Halter).clearErrorFields(Dispatcher.Type.Bearbeitung);
                        //if (API.isMobileTest() || API.isTabletTest()) {
                        if (API.MobileCheck()) {
                            $('#mobile-footer-data').show();
                        } else {
                            $('#mobile-footer-data').hide();
                        }

                        if (!API.isset(Konfigurator.data.edit.article)) {
                            $('#editCartBtn').hide();
                            $('#editCartMobileBtn').hide();
                            $('#addToCartBtn').show();
                            $('#addToCartMobileBtn').show();
                        }
                        Tooltips.initialize();
                    } else {
                        e.preventDefault();
                    }
                }
            },
            Bearbeitungen: {
                initialize: function () {
                    // Kanten
                    $('body').on('change', '#view-kanten-auswahl select', View.actions.Bearbeitungen.changeAndSaveKantenAuswahlFunction);
                    $('body').on('keyup', '#view-kanten-facette', View.actions.Bearbeitungen.addFacetteKantenFunction);
                    $('body').on('change', '#view-kanten-angle', View.actions.Bearbeitungen.changeKantenAngleFunction);
                    // Ecken
                    $('body').on('click', '#eckenAuswahlBox button[name="eckenAuswahlBox"]', View.actions.Bearbeitungen.eckenAuswahlFunction);
                    $('body').on('tap', '#eckenCheckBox label', API.markEckenCheckbox);
                    $('body').on('click', '#view-addEckXY', View.actions.Bearbeitungen.addSchraegeEckeFunction);
                    $('body').on('click', '#view-addEckRadius', View.actions.Bearbeitungen.addRundeEckeFunction);
                    $('body').on('click', '.editEckenBtn', View.actions.Bearbeitungen.editEckenFunction);
                    $('body').on('click', '.deleteEckenBtn', View.actions.Bearbeitungen.deleteEditEckenFunction);
                    $('body').on('click', '.acceptEckenBtn', View.actions.Bearbeitungen.acceptEditEckenFunction);
                    // Bohrungen
                    $('body').on('tap', '#bohrungenCheckBox label', API.markEckenCheckbox);
                    $('body').on('click', '.editBohrungenBtn', View.actions.Bearbeitungen.editBohrungenFunction);
                    $('body').on('click', '.deleteBohrungenBtn', View.actions.Bearbeitungen.deleteEditBohrungenFunction);
                    $('body').on('click', '.acceptBohrungenBtn', View.actions.Bearbeitungen.acceptEditBohrungenFunction);
                    $('body').on('click', '#addBohrungenBtn', View.actions.Bearbeitungen.addBohrungFunction);
                    // Senkungen
                    $('body').on('tap', '#senkungenCheckBox label', API.markEckenCheckbox);
                    $('body').on('click', '.editSenkungenBtn', View.actions.Bearbeitungen.editSenkungenFunction);
                    $('body').on('click', '.deleteSenkungenBtn', View.actions.Bearbeitungen.deleteEditSenkungenFunction);
                    $('body').on('click', '.acceptSenkungenBtn', View.actions.Bearbeitungen.acceptEditSenkungenFunction);
                    $('body').on('click', '#addSenkungenBtn', View.actions.Bearbeitungen.addSenkungFunction);
                },
                deleteEditEckenFunction: function (e) {
                    e.preventDefault();
                    var selection = $(this).parent('td').parent('tr').find('td:first').text();
                    Bearbeitungen.Ecken.removeConfiguration(selection);
                    View.Bearbeitungen.Ecken.createEckSelectionView();
                    View.Bearbeitungen.Ecken.createSelectionView();
                    View.Configuration.createView.insertEckenView();
                    Price.createPriceView();
                    Konfigurator.helper.drawCADImg();
                },
                acceptEditEckenFunction: function (e) {
                    e.preventDefault();
                    var selection = $(this).parent('td').parent('tr').find('td');
                    var x = 0, y = 0, radius = 0, corner = '';
                    var edit = 0, oldCorner = '';
                    $.each(selection, function (i) {
                        if (i == 0) {
                            corner = $(this).find('select').val();
                            oldCorner = $(this).find('input[type=hidden]').val();
                        } else if (i == 1) {
                            x = $(this).find('input').val();
                            if ((x == '') || (x == ' - ') || (Number(x) == 0)) {
                                x = null;
                            }
                        } else if (i == 2) {
                            y = $(this).find('input').val();
                            if ((y == '') || (y == ' - ') || (Number(y) == 0)) {
                                y = null;
                            }
                        } else if (i == 3) {
                            radius = $(this).find('input').val();
                            if ((radius == '') || (radius == ' - ') || (Number(radius) == 0)) {
                                radius = null;
                            }
                        } else if (i == 4) {
                            $(this).find('.editEckenBtn').show();
                            $(this).find('.deleteEckenBtn').show();
                            $(this).find('.acceptEckenBtn').hide();
                        }
                    });
                    var kanten = Bearbeitungen.Kanten.getCurrentConfiguration();
                    var change = true;
                    if (radius != null) {
                        edit = 2;
                        x = null;
                        y = null;
                        if ((kanten.uid == 2) || (kanten.uid == 4)) {
                            change = true;
                        } else {
                            change = false;
                        }
                    } else {
                        edit = 1;
                    }

                    if (change) {
                        //log(edit, corner, radius, x, y, oldCorner);
                        Bearbeitungen.Ecken.editConfiguration(edit, corner, radius, x, y, oldCorner);
                        //log(Bearbeitungen.Ecken.getCurrentConfiguration());
                    }
                    View.Bearbeitungen.Ecken.createEckSelectionView();
                    View.Bearbeitungen.Ecken.createSelectionView();
                    View.Configuration.createView.insertEckenView();
                    Price.createPriceView();
                    Konfigurator.helper.drawCADImg();
                },
                editEckenFunction: function (e) {
                    e.preventDefault();
                    var eckenCorner = Bearbeitungen.Ecken.corner;
                    var corner = ['E1', 'E2', 'E3', 'E4'];
                    var selection = $(this).parent('td').parent('tr').find('td');
                    $.each(selection, function (i) {
                        if (i == 0) {
                            var text = $(this).text();
                            var tmpl = '<select>';
                            for (var i = 0; i < corner.length; i++) {
                                if ((corner[i] == text) || (!eckenCorner.isCornerSet(corner[i]))) {
                                    tmpl += '<option ' + (corner[i] == text ? 'selected' : '') + ' value="' + corner[i] + '">' + corner[i] + '</option>';
                                }
                            }
                            tmpl += '</select>';
                            tmpl += '<input type="hidden" maxlength="4" value="' + text + '" />';
                            $(this).html(tmpl);
                        } else if (i == 4) {
                            $(this).find('.acceptEckenBtn').show();
                            $(this).find('.editEckenBtn').hide();
                            $(this).find('.deleteEckenBtn').hide();
                        } else if (i != 4) {
                            var text = $(this).text();
                            var tmpl = '<input type="text" maxlength="4" value="' + text + '" />'
                            $(this).html(tmpl);
                        }
                    });
                    $('#view-eckbearbeitung-x').val('');
                    $('#view-eckbearbeitung-y').val('');
                    $('#view-eckbearbeitung-radius').val('');
                },
                deleteEditBohrungenFunction: function (e) {
                    e.preventDefault();
                    var index = $(this).parent('td').parent('tr').find('td:first').find('input[type=hidden]').val();
                    var halter = Halter.getHalterByBohrIndex(index);
                    if (API.isset(halter)) {
                        Halter.removeConfiguration(halter.index);
                        View.Halter.mitBohrung.createEckSelectionView();
                        View.Halter.mitBohrung.createSelectionView();
                        View.Configuration.createView.insertHalterView();
                    }

                    Bearbeitungen.Bohrungen.removeConfiguration(index);
                    View.Bearbeitungen.Bohrungen.createEckSelectionView();
                    View.Bearbeitungen.Bohrungen.createSelectionView();
                    View.Configuration.createView.insertBohrungView();
                    Price.createPriceView();
                    Konfigurator.helper.drawCADImg();
                },
                acceptEditBohrungenFunction: function (e) {
                    e.preventDefault();
                    var selection = $(this).parent('td').parent('tr').find('td');
                    var x = 0, y = 0, radius = 0, corner = '', index = '';
                    $.each(selection, function (i) {
                        if (i == 0) {
                            corner = $(this).find('select').val();
                            index = $(this).find('input[type=hidden]').val();
                        } else if (i == 1) {
                            x = $(this).find('input').val();
                        } else if (i == 2) {
                            y = $(this).find('input').val();
                        } else if (i == 3) {
                            radius = API.commaToDot($(this).find('input').val());
                        } else if (i == 4) {
                            $(this).find('.editBohrungenBtn').show();
                            $(this).find('.deleteBohrungenBtn').show();
                            $(this).find('.acceptBohrungenBtn').hide();
                        }
                    });
                    var halter = Halter.getHalterByBohrIndex(index);
                    if (API.isset(halter)) {
                        Halter.editConfiguration(halter.index, halter.hid, halter.vid, corner, x, y, null, index);
                        View.Halter.mitBohrung.createEckSelectionView();
                        View.Halter.mitBohrung.createSelectionView();
                        View.Configuration.createView.insertHalterView();
                    }

                    Bearbeitungen.Bohrungen.editConfiguration(index, 1, corner, radius, x, y);
                    View.Bearbeitungen.Bohrungen.createEckSelectionView();
                    View.Bearbeitungen.Bohrungen.createSelectionView();
                    View.Configuration.createView.insertBohrungView();
                    Price.createPriceView();
                    Konfigurator.helper.drawCADImg();
                },
                editBohrungenFunction: function (e) {
                    e.preventDefault();
                    var bohrungCorner = Bearbeitungen.Bohrungen.corner;
                    var corner = ['E1', 'E2', 'E3', 'E4', 'FREI'];
                    var selection = $(this).parent('td').parent('tr').find('td');
                    var index = null;
                    $.each(selection, function (i) {
                        if (i == 0) {
                            var text = $(this).find('span').text();
                            index = $(this).find('input[type=hidden]').val();
                            var tmpl = '<select>';
                            for (var i = 0; i < corner.length; i++) {
                                if ((corner[i] == text) || (!bohrungCorner.isCornerSet(corner[i]))) {
                                    tmpl += '<option ' + (corner[i] == text ? 'selected' : '') + ' value="' + corner[i] + '">' + corner[i] + '</option>';
                                }
                            }
                            tmpl += '</select>';
                            tmpl += '<input type="hidden" value="' + index + '" />';
                            $(this).html(tmpl);
                        } else if (i == 4) {
                            $(this).find('.acceptBohrungenBtn').show();
                            $(this).find('.editBohrungenBtn').hide();
                            $(this).find('.deleteBohrungenBtn').hide();
                        } else if (i != 4) {
                            var text = $(this).text();
                            var tmpl = '<input type="text" maxlength="4" value="' + text + '" />'
                            $(this).html(tmpl);
                        }
                    });
                    var halter = Halter.getHalterByBohrIndex(index);
                    if (API.isset(halter)) {
                        $.each(selection, function (i) {
                            if (i == 3) {
                                $(this).find('input').attr('disabled', 'disabled');
                            }
                        });
                    }

                    $('#view-bohrungen-d').val('');
                    $('#view-bohrungen-x').val('');
                    $('#view-bohrungen-y').val('');
                },
                deleteEditSenkungenFunction: function (e) {
                    e.preventDefault();
                    var index = $(this).parent('td').parent('tr').find('td:first').find('input[type=hidden]').val();
                    var halter = Halter.getHalterByBohrIndex(index);
                    if (API.isset(halter)) {
                        Halter.removeConfiguration(halter.index);
                        View.Halter.mitBohrung.createEckSelectionView();
                        View.Halter.mitBohrung.createSelectionView();
                        View.Configuration.createView.insertHalterView();
                    }

                    Bearbeitungen.Senkungen.removeConfiguration(index);
                    View.Bearbeitungen.Senkungen.createEckSelectionView();
                    View.Bearbeitungen.Senkungen.createSelectionView();
                    View.Configuration.createView.insertSenkungView();
                    Price.createPriceView();
                    Konfigurator.helper.drawCADImg();
                },
                acceptEditSenkungenFunction: function (e) {
                    e.preventDefault();
                    var selection = $(this).parent('td').parent('tr').find('td');
                    var x = 0, y = 0, m = 0, corner = '', index = '';
                    $.each(selection, function (i) {
                        if (i == 0) {
                            corner = $(this).find('select').val();
                            index = $(this).find('input[type=hidden]').val();
                        } else if (i == 1) {
                            x = $(this).find('input').val();
                        } else if (i == 2) {
                            y = $(this).find('input').val();
                        } else if (i == 3) {
                            m = $(this).find('select').val();
                        } else if (i == 4) {
                            $(this).find('.editSenkungenBtn').show();
                            $(this).find('.deleteSenkungenBtn').show();
                            $(this).find('.acceptSenkungenBtn').hide();
                        }
                    });
                    var halter = Halter.getHalterByBohrIndex(index);
                    if (API.isset(halter)) {
                        Halter.editConfiguration(halter.index, halter.hid, halter.vid, corner, x, y, null, index);
                        View.Halter.mitBohrung.createEckSelectionView();
                        View.Halter.mitBohrung.createSelectionView();
                        View.Configuration.createView.insertHalterView();
                    }

                    Bearbeitungen.Senkungen.editConfiguration(index, 2, corner, m, x, y);
                    View.Bearbeitungen.Senkungen.createEckSelectionView();
                    View.Bearbeitungen.Senkungen.createSelectionView();
                    View.Configuration.createView.insertSenkungView();
                    Price.createPriceView();
                    Konfigurator.helper.drawCADImg();
                },
                editSenkungenFunction: function (e) {
                    e.preventDefault();
                    var senkungCorner = Bearbeitungen.Senkungen.corner;
                    var corner = ['E1', 'E2', 'E3', 'E4', 'FREI'];
                    var senkungen = Konfigurator.data.senkungen;
                    var selection = $(this).parent('td').parent('tr').find('td');
                    var index = null;
                    $.each(selection, function (i) {
                        if (i == 0) {
                            var text = $(this).find('span').text();
                            index = $(this).find('input[type=hidden]').val();
                            var tmpl = '<select>';
                            for (var i = 0; i < corner.length; i++) {
                                if ((corner[i] == text) || (!senkungCorner.isCornerSet(corner[i]))) {
                                    tmpl += '<option ' + (corner[i] == text ? 'selected' : '') + ' value="' + corner[i] + '">' + corner[i] + '</option>';
                                }
                            }
                            tmpl += '</select>';
                            tmpl += '<input type="hidden" value="' + index + '" />';
                            $(this).html(tmpl);
                        } else if (i == 3) {
                            var text = $(this).text();
                            var tmpl = '<select>';
                            for (var i = 0; i < senkungen.length; i++) {
                                tmpl += '<option ' + (parseInt(text) == parseInt(senkungen[i].gewinde) ? 'selected' : '') + ' value="' + parseInt(senkungen[i].gewinde) + '">' + parseInt(senkungen[i].gewinde) + '</option>';
                            }
                            tmpl += '</select>';
                            $(this).html(tmpl);
                        } else if (i == 4) {
                            $(this).find('.acceptSenkungenBtn').show();
                            $(this).find('.editSenkungenBtn').hide();
                            $(this).find('.deleteSenkungenBtn').hide();
                        } else if (i != 4) {
                            var text = $(this).text();
                            var tmpl = '<input type="text" maxlength="4" value="' + text + '" />';
                            $(this).html(tmpl);
                        }
                    });
                    var halter = Halter.getHalterByBohrIndex(index);
                    if (API.isset(halter)) {
                        $.each(selection, function (i) {
                            if (i == 3) {
                                $(this).find('select').attr('disabled', 'disabled');
                            }
                        });
                    }

                    $('#view-senkungen-x').val('');
                    $('#view-senkungen-y').val('');
                },
                changeKantenAngleFunction: function (e) {
                    e.preventDefault();
                    $('#view-kanten-facette').val('');
                },
                changeAndSaveKantenAuswahlFunction: function (e) {
                    if (API.isset(e))
                        e.preventDefault();
                    var src = Konfigurator.config.bearbeitungImgPfad, kanten = Konfigurator.data.kanten, srcImg = '', srcPreview = '';
                    var kId = parseInt($('#view-kanten-auswahl select').val());
                    //console.log('Kanten Id: ' + kId);

                    var width = $('#view-configuration-width');
                    var height = $('#view-configuration-height');
                    var errorField = width.parent('div').parent('div').parent('div').parent('div').find('div.error');
                    var sizeEnabled = Validate.material(width, height, errorField, kId);
                    if (sizeEnabled) {

                        Grundeinstellung.setWidth(width.val()).setHeight(height.val());
                        View.Configuration.createView.insertGrundEinstellungenView();
                        var eckSelection = Bearbeitungen.Ecken.getCurrentConfiguration();
                        var changeKante = true;
                        var eckenToDelete = [];
                        for (var i = 0; i < eckSelection.length; i++) {
                            if (API.isset(eckSelection[i].uid)) {
                                if (!Konfigurator.helper.isEckeForKanteEnabled(eckSelection[i].uid, kId)) {
                                    changeKante = false;
                                    eckenToDelete.push(eckSelection[i]);
                                }
                            }
                        }

                        if (changeKante) {
                            if (kId == 6) {
                                $('#view-facetten-eigenschaften').show();
                                $('#view-kanten-eigenschaften').hide();
                                for (var i = 0; i < kanten.length; i++) {
                                    if (parseInt(kanten[i].uid) == kId) {
                                        srcImg = src + kanten[i].bild;
                                        srcPreview = src + Konfigurator.helper.getMiniImgData('path') + Konfigurator.helper.getMiniImgData('name', kanten[i].bild);
                                    }
                                }
                                $('#view-facceten-img-preview').attr('src', srcPreview);
                                $('#view-facceten-img').attr('href', srcImg);
                                var edit = Konfigurator.data.edit;
                                if (API.isset(edit)) {
                                    if (API.isset(edit.article)) {
                                        if (API.isset(edit.article.bearbeitungen.kanten.facette)) {
                                            Bearbeitungen.Kanten.setBearbeitung(edit.article.bearbeitungen.kanten.uid);
                                            Bearbeitungen.Kanten.setFacette(edit.article.bearbeitungen.kanten.facette);
                                            Bearbeitungen.Kanten.setAngle(edit.article.bearbeitungen.kanten.angle);
                                            $('#view-kanten-facette').val(edit.article.bearbeitungen.kanten.facette);
                                            $('#view-kanten-angle').val(edit.article.bearbeitungen.kanten.angle);
                                            View.Configuration.createView.insertKantenView();
                                            Price.createPriceView();
                                        }
                                    }
                                }
                            } else {
                                $('#view-facetten-eigenschaften').hide();
                                $('#view-kanten-eigenschaften').show();
                                for (var i = 0; i < kanten.length; i++) {
                                    if (parseInt(kanten[i].uid) == kId) {
                                        srcImg = src + kanten[i].bild;
                                        srcPreview = src + Konfigurator.helper.getMiniImgData('path') + Konfigurator.helper.getMiniImgData('name', kanten[i].bild);
                                    }
                                }
                                $('#view-kanten-img-preview').attr('src', srcPreview);
                                $('#view-kanten-img').attr('href', srcImg);
                                Bearbeitungen.Kanten.setBearbeitung(kId);
                                Bearbeitungen.Kanten.setFacette(null);
                                Bearbeitungen.Kanten.setAngle(null);
                                View.Configuration.createView.insertKantenView();
                                Price.createPriceView();
                                $('#view-kanten-facette').val('');
                                $('#view-kanten-angle').val('45');
                            }
                            View.Bearbeitungen.Ecken.createEckBearbeitungAuswahl();
                            $('.view-eckbearbeitung-rund').hide();
                            $('#view-ecken-img').hide();
                            Konfigurator.helper.drawCADImg();
                        } else {
                            Dispatcher.transition.ecken = eckenToDelete;
                            $('#konfigurator-changeKanten-Dialog').dialog('open');
                        }
                    } else {
                        var kanten = Bearbeitungen.Kanten.getCurrentConfiguration();
                        $(this).val(kanten.uid);
                        $('#konfigurator-changeKante-sizeInfo-Dialog').dialog('open');
                    }
                },
                addFacetteKantenFunction: function (e) {
                    e.preventDefault();
                    var kId = $('#view-kanten-auswahl select').val();
                    var facette = $('#view-kanten-facette');
                    var angle = $('#view-kanten-angle').val();
                    var errorField = facette.parent('div').parent('div').parent('div').find('div.error');
                    var valid = true;
                    valid = valid && Validate.materialSet(errorField);
                    if (!valid) {
                        Dispatcher.addErrorField(Dispatcher.Type.Bearbeitung, errorField);
                    }
                    valid = valid && Validate.checkRegexp(facette, errorField);
                    valid = valid && Validate.checkFacettenEingabe(facette, angle, false, errorField);
                    if (valid) {
                        Bearbeitungen.Kanten.setBearbeitung(kId);
                        if ((facette != null) && (angle != '')) {
                            Bearbeitungen.Kanten.setAngle(angle).setFacette(facette.val());
                        }
                        View.Configuration.createView.insertKantenView();
                        Price.createPriceView();
                        Konfigurator.helper.drawCADImg();
                    }
                },
                eckenAuswahlFunction: function (e) {
                    e.preventDefault();
                    $(this).addClass('active').siblings().removeClass('active');
                    var eId = $(this).val();
                    switch (eId) {
                        case "1":
                            $('.view-eckbearbeitung-schraeg').show();
                            $('.view-eckbearbeitung-rund').hide();
                            break;
                        case "2":
                            $('.view-eckbearbeitung-rund').show();
                            $('.view-eckbearbeitung-schraeg').hide();
                            break;
                    }
                    $('#selectedEckBearbeitung').val(eId);
                    var ecken = Konfigurator.data.ecken, src = Konfigurator.config.bearbeitungImgPfad, srcImg = '', srcPreview = '';
                    for (var i = 0; i < ecken.length; i++) {
                        if (parseInt(ecken[i].uid) == parseInt(eId)) {
                            srcImg = src + ecken[i].bild;
                            srcPreview = src + Konfigurator.helper.getMiniImgData('path') + Konfigurator.helper.getMiniImgData('name', ecken[i].bild);
                        }
                    }
                    $('#view-ecken-img').show().attr('href', srcImg);
                    $('#view-ecken-img-preview').show().attr('src', srcPreview);
                },
                addSchraegeEckeFunction: function (e) {
                    e.preventDefault();
                    var eId = $('#selectedEckBearbeitung').val();
                    var x = $('#view-eckbearbeitung-x');
                    var y = $('#view-eckbearbeitung-y');
                    var cornerField = $('#eckenCheckBox');
                    var corner = cornerField.find('label.active input');
                    var errorField = cornerField.parent('div').parent('div').parent('div').find('div.error');
                    var valid = true;
                    valid = valid && Validate.materialSet(errorField);
                    if (!valid) {
                        Dispatcher.addErrorField(Dispatcher.Type.Bearbeitung, errorField);
                    }
                    valid = valid && Validate.isCheckboxSelected(cornerField, errorField);
                    valid = valid && Validate.checkRegexp(x, errorField);
                    valid = valid && Validate.checkRegexp(y, errorField);
                    if (valid) {
                        $.each(corner, function (i, ecke) {
                            var eVal = $(ecke).val();
                            if (eVal != 'ALLE') {
                                var cornerState = $(ecke).parent('label').attr('disabled');
                                if (!API.isset(cornerState)) {
                                    Bearbeitungen.Ecken.addConfiguration(eId, eVal, null, x.val(), y.val());
                                }
                            }
                        });
                        View.Configuration.createView.insertEckenView();
                        View.Bearbeitungen.Ecken.createEckSelectionView();
                        View.Bearbeitungen.Ecken.createSelectionView();
                        Price.createPriceView();
                        Konfigurator.helper.drawCADImg();
                    }
                },
                addRundeEckeFunction: function (e) {
                    e.preventDefault();
                    var eId = $('#selectedEckBearbeitung').val();
                    var x = null;
                    var y = null;
                    var cornerField = $('#eckenCheckBox');
                    var corner = cornerField.find('label.active input');
                    var radius = $('#view-eckbearbeitung-radius');
                    var errorField = cornerField.parent('div').parent('div').parent('div').find('div.error');
                    var valid = true;
                    valid = valid && Validate.materialSet(errorField);
                    if (!valid) {
                        Dispatcher.addErrorField(Dispatcher.Type.Bearbeitung, errorField);
                    }
                    valid = valid && Validate.isCheckboxSelected(cornerField, errorField);
                    valid = valid && Validate.checkRegexp(radius, errorField);
                    valid = valid && Validate.checkEckRadius(radius, false, errorField);
                    if (valid) {
                        $.each(corner, function (i, ecke) {
                            var eVal = $(ecke).val();
                            if (eVal != 'ALLE') {
                                var cornerState = $(ecke).parent('label').attr('disabled');
                                if (!API.isset(cornerState)) {
                                    Bearbeitungen.Ecken.addConfiguration(eId, eVal, radius.val(), x, y);
                                }
                            }
                        });
                        View.Configuration.createView.insertEckenView();
                        View.Bearbeitungen.Ecken.createEckSelectionView();
                        View.Bearbeitungen.Ecken.createSelectionView();
                        Price.createPriceView();
                        Konfigurator.helper.drawCADImg();
                    }
                },
                addBohrungFunction: function (e) {
                    e.preventDefault();
                    var d = $('#view-bohrungen-d');
                    var x = $('#view-bohrungen-x');
                    var y = $('#view-bohrungen-y');
                    var cornerField = $('#bohrungenCheckBox');
                    var corner = cornerField.find('label.active input');
                    var errorField = cornerField.parent('div').parent('div').parent('div').find('div.error');
                    var valid = true;
                    valid = valid && Validate.materialSet(errorField);
                    if (!valid) {
                        Dispatcher.addErrorField(Dispatcher.Type.Bearbeitung, errorField);
                    }
                    valid = valid && Validate.isCheckboxSelected(cornerField, errorField);
                    valid = valid && Validate.checkRegexp(d, errorField, 'float');
                    valid = valid && Validate.checkRegexp(x, errorField);
                    valid = valid && Validate.checkRegexp(y, errorField);
                    if (valid) {
                        $.each(corner, function (i, ecke) {
                            var eVal = $(ecke).val();
                            if (eVal != 'ALLE') {
                                var cornerState = $(ecke).parent('label').attr('disabled');
                                if (!API.isset(cornerState)) {
                                    Bearbeitungen.Bohrungen.addConfiguration(1, eVal, API.commaToDot(d.val()), x.val(), y.val());
                                }
                            }
                        });
                        View.Configuration.createView.insertBohrungView();
                        View.Bearbeitungen.Bohrungen.createEckSelectionView();
                        View.Bearbeitungen.Bohrungen.createSelectionView();
                        Price.createPriceView();
                        Konfigurator.helper.drawCADImg();
                    }
                },
                addSenkungFunction: function (e) {
                    e.preventDefault();
                    var m = $('#view-senkungen-m').val();
                    var x = $('#view-senkungen-x');
                    var y = $('#view-senkungen-y');
                    var dB = 0, dS = 0;
                    var cornerField = $('#senkungenCheckBox');
                    var corner = cornerField.find('label.active input');
                    var senkungen = Konfigurator.data.senkungen;
                    var errorField = cornerField.parent('div').parent('div').parent('div').find('div.error');
                    for (var i = 0; i < senkungen.length; i++) {
                        if (parseFloat(senkungen[i].gewinde) == parseFloat(m)) {
                            dB = parseFloat(senkungen[i].bohrung);
                            dS = parseFloat(senkungen[i].senkung);
                        }
                    }
                    var valid = true;
                    valid = valid && Validate.materialSet(errorField);
                    if (!valid) {
                        Dispatcher.addErrorField(Dispatcher.Type.Bearbeitung, errorField);
                    }
                    valid = valid && Validate.isCheckboxSelected(cornerField, errorField);
                    valid = valid && Validate.checkRegexp(x, errorField);
                    valid = valid && Validate.checkRegexp(y, errorField);
                    if (valid) {
                        $.each(corner, function (i, ecke) {
                            var eVal = $(ecke).val();
                            if (eVal != 'ALLE') {
                                var cornerState = $(ecke).parent('label').attr('disabled');
                                if (!API.isset(cornerState)) {
                                    Bearbeitungen.Senkungen.addConfiguration(2, eVal, m, dB, dS, x.val(), y.val());
                                }
                            }
                        });
                        View.Configuration.createView.insertSenkungView();
                        View.Bearbeitungen.Senkungen.createEckSelectionView();
                        View.Bearbeitungen.Senkungen.createSelectionView();
                        Price.createPriceView();
                        Konfigurator.helper.drawCADImg();
                    }
                }
            },
            Halter: {
                initialize: function () {
                    // Halter mit Bohrung
                    $('body').on('click', '#addHalterMitBohrungBtn', View.actions.Halter.addHalterMitBohrungFunction);
                    $('body').on('tap', '#halterMitBohrungCheckBox label', API.markEckenCheckbox);
                    $('body').on('click', '#editHalterMitBohrungBtn', View.actions.Halter.acceptEditHalterFunction);

                    // Halter ohne Bohrung
                    $('body').on('click', '#addHalterOhneBohrungBtn', View.actions.Halter.addHalterOhneBohrungFunction);
                    $('body').on('click', '#editHalterOhneBohrungBtn', View.actions.Halter.acceptEditHalterFunction);

                    $('body').on('click', '.editHalterBtn', View.actions.Halter.editHalterFunction);
                    $('body').on('click', '.deleteHalterBtn', View.actions.Halter.deleteEditHalterFunction);
                    $('body').on('click', '.info-halterMit-icon', View.actions.Halter.showHalterMitInfoFunction);
                    $('body').on('click', '.info-halterOhne-icon', View.actions.Halter.showHalterOhneInfoFunction);

                    // Detail
                    $('body').on('click', '#close-detailMitHalter', View.actions.Halter.closeDetailMitHalterFunction);
                    $('body').on('click', '#close-detailOhneHalter', View.actions.Halter.closeDetailOhneHalterFunction);
                },
                closeDetailMitHalterFunction: function (e) {
                    $('.view-halterMitBohrung-HalterAuswahlPreview').html('&nbsp;');
                    $('.view-halterMitBohrung-HalterAuswahlMaterial').html('&nbsp;');
                    $('.view-halterMitBohrung-HalterAuswahlArtNr').html('&nbsp;');
                    $('.view-halterMitBohrung-HalterAuswahlWand').html('&nbsp;');
                    $('.view-halterMitBohrung-HalterAuswahlSize').html('&nbsp;');
                    $('.view-halterMitBohrung-HalterAuswahlKopf').html('&nbsp;');
                    $('.view-halterMitBohrung-HalterAuswahlPreis').html('&nbsp;');
                    $('.view-halterMitBohrung-selection').hide();
                    if (API.isset(Halter.currentEditing)) {
                        Halter.removeConfiguration(Halter.currentEditing.index);
                        Halter.addConfiguration(Halter.currentEditing.hid, Halter.currentEditing.vid, Halter.currentEditing.corner, Halter.currentEditing.x, Halter.currentEditing.y, Halter.currentEditing.index, Halter.currentEditing.qty, Halter.currentEditing.bohrIndex);
                        View.Halter.mitBohrung.createEckSelectionView();
                        Halter.currentEditing = null;
                    }
                },
                closeDetailOhneHalterFunction: function (e) {
                    $('.view-halterOhneBohrung-HalterAuswahlPreview').html('&nbsp;');
                    $('.view-halterOhneBohrung-HalterAuswahlMaterial').html('&nbsp;');
                    $('.view-halterOhneBohrung-HalterAuswahlArtNr').html('&nbsp;');
                    $('.view-halterOhneBohrung-HalterAuswahlWand').html('&nbsp;');
                    $('.view-halterOhneBohrung-HalterAuswahlSize').html('&nbsp;');
                    $('.view-halterOhneBohrung-HalterAuswahlKopf').html('&nbsp;');
                    $('.view-halterOhneBohrung-HalterAuswahlPreis').html('&nbsp;');
                    $('.view-halterOhneBohrung-selection').hide();
                    if (API.isset(Halter.currentEditing)) {
                        Halter.removeConfiguration(Halter.currentEditing.index);
                        Halter.addConfiguration(Halter.currentEditing.hid, Halter.currentEditing.vid, Halter.currentEditing.corner, Halter.currentEditing.x, Halter.currentEditing.y, Halter.currentEditing.index, Halter.currentEditing.qty, Halter.currentEditing.bohrIndex);
                        Halter.currentEditing = null;
                    }
                },
                showHalterMitInfoFunction: function (e) {
                    var halterId = $(this).parent('td').parent('tr').find('input[type=hidden]').val();
                    var config = Halter.getConfiguration(halterId);
                    var halterData = Konfigurator.helper.getHalter(config.hid, config.vid);
                    $('.view-halterMitBohrung-HalterAuswahlPreview').html(halterData.variante.name);
                    $('.view-halterMitBohrung-HalterAuswahlMaterial').html(halterData.variante.material);
                    $('.view-halterMitBohrung-HalterAuswahlArtNr').html(halterData.variante.artnr);
                    $('.view-halterMitBohrung-HalterAuswahlWand').html(API.dotToComma(halterData.variante.wandabstand));
                    $('.view-halterMitBohrung-HalterAuswahlSize').html((halterData.variante.halterkantenlaenge == 0 ? '&Oslash;' + API.dotToComma(halterData.variante.durchmesser) : API.dotToComma(halterData.variante.halterkantenlaenge) + ' x ' + API.dotToComma(halterData.variante.halterkantenlaenge)));
                    $('.view-halterMitBohrung-HalterAuswahlKopf').html(halterData.variante.kopfform);
                    $('.view-halterMitBohrung-HalterAuswahlPreis').html(API.priceView(halterData.variante.preis));
                    var srcImg = Konfigurator.config.halterImgPfad + halterData.variante.bild;
                    var srcPreview = Konfigurator.config.halterImgPfad + Konfigurator.helper.getMiniImgData('path') + Konfigurator.helper.getMiniImgData('name', halterData.variante.bild);
                    $('.view-halterMitBohrung-Img').attr('href', srcImg).show();
                    $('.view-halterMitBohrung-Img-preview').attr('src', srcPreview);
                    $('.view-halterMitBohrung-selection').show();
                    $('#halter-mitBohrung-AbstandEdit').hide();
                    if (API.isset(Halter.currentEditing)) {
                        Halter.removeConfiguration(Halter.currentEditing.index);
                        Halter.addConfiguration(Halter.currentEditing.hid, Halter.currentEditing.vid, Halter.currentEditing.corner, Halter.currentEditing.x, Halter.currentEditing.y, Halter.currentEditing.index, Halter.currentEditing.qty, Halter.currentEditing.bohrIndex);
                        View.Halter.mitBohrung.createEckSelectionView();
                        Halter.currentEditing = null;
                    }
                },
                showHalterOhneInfoFunction: function (e) {
                    var halterId = $(this).parent('td').parent('tr').find('input[type=hidden]').val();
                    var config = Halter.getConfiguration(halterId);
                    var halterData = Konfigurator.helper.getHalter(config.hid, config.vid);
                    $('.view-halterOhneBohrung-HalterAuswahlPreview').html(halterData.variante.name);
                    $('.view-halterOhneBohrung-HalterAuswahlMaterial').html(halterData.variante.material);
                    $('.view-halterOhneBohrung-HalterAuswahlArtNr').html(halterData.variante.artnr);
                    $('.view-halterOhneBohrung-HalterAuswahlWand').html(API.dotToComma(halterData.variante.wandabstand));
                    $('.view-halterOhneBohrung-HalterAuswahlSize').html((halterData.variante.halterkantenlaenge == 0 ? '&Oslash;' + API.dotToComma(halterData.variante.durchmesser) : API.dotToComma(halterData.variante.halterkantenlaenge) + ' x ' + API.dotToComma(halterData.variante.halterkantenlaenge)));
                    $('.view-halterOhneBohrung-HalterAuswahlKopf').html(halterData.variante.kopfform);
                    $('.view-halterOhneBohrung-HalterAuswahlPreis').html(API.priceView(halterData.variante.preis));
                    var srcImg = Konfigurator.config.halterImgPfad + halterData.variante.bild;
                    var srcPreview = Konfigurator.config.halterImgPfad + Konfigurator.helper.getMiniImgData('path') + Konfigurator.helper.getMiniImgData('name', halterData.variante.bild);
                    $('.view-halterOhneBohrung-Img').attr('href', srcImg).show();
                    $('.view-halterOhneBohrung-Img-preview').attr('src', srcPreview);
                    $('.view-halterOhneBohrung-selection').show();
                    $('#halter-ohneBohrung-qtyEdit').hide();
                    if (API.isset(Halter.currentEditing)) {
                        Halter.removeConfiguration(Halter.currentEditing.index);
                        Halter.addConfiguration(Halter.currentEditing.hid, Halter.currentEditing.vid, Halter.currentEditing.corner, Halter.currentEditing.x, Halter.currentEditing.y, Halter.currentEditing.index, Halter.currentEditing.qty, Halter.currentEditing.bohrIndex);
                        Halter.currentEditing = null;
                    }
                },
                deleteEditHalterFunction: function (e) {
                    e.preventDefault();
                    var index = $(this).parent('td').parent('tr').find('td:first').find('input[type=hidden]').val();
                    var ctxOhne = false;
                    var halter = Halter.getConfiguration(index);
                    if (parseInt(halter.hid) == 7) {
                        Bearbeitungen.Senkungen.removeConfiguration(halter.bohrIndex);
                    } else {
                        Bearbeitungen.Bohrungen.removeConfiguration(halter.bohrIndex);
                    }

                    Halter.removeConfiguration(index);
                    if ($(this).parent('td').parent('tr').parent('tbody').parent('table').find('thead>tr>th').length == 3) {
                        ctxOhne = true;
                    }

                    if (ctxOhne) {
                        View.Halter.ohneBohrung.createSelectionView();
                    } else {
                        View.Halter.mitBohrung.createEckSelectionView();
                        View.Halter.mitBohrung.createSelectionView();
                    }
                    View.Configuration.createView.insertHalterView();
                    View.Configuration.createView.insertSenkungView();
                    View.Configuration.createView.insertBohrungView();
                    View.Bearbeitungen.Senkungen.createEckSelectionView();
                    View.Bearbeitungen.Senkungen.createSelectionView();
                    View.Bearbeitungen.Bohrungen.createEckSelectionView();
                    View.Bearbeitungen.Bohrungen.createSelectionView();
                    Price.createPriceView();
                    Konfigurator.helper.drawCADImg();
                    $('#editHalterMitBohrungBtn').hide();
                    $('#addHalterMitBohrungBtn').show();
                    $('.view-halterMitBohrung-selection').hide();
                    if (API.isset(Halter.currentEditing)) {
                        Halter.currentEditing = null;
                    }
                },
                acceptEditHalterFunction: function (e) {
                    e.preventDefault();

                    var ctxOhne = true, index = null, halter = null, variante = null, x = null, y = null, qty = null;
                    if ($('#view-halterMitBohrung-x').is(':visible')) {
                        ctxOhne = false;
                    }

                    if (!ctxOhne) {
                        var cornerField = $('#halterMitBohrungCheckBox');
                        var corner = cornerField.find('label.active input').val();
                        index = $('#view-halterMitBohrung-configIndex').val();
                        halter = $('#view-halterMitBohrung-auswahlHId').val();
                        variante = $('#view-halterMitBohrung-variantenId').val();
                        x = $('#view-halterMitBohrung-x').val();
                        y = $('#view-halterMitBohrung-y').val();
                    } else {
                        qty = $('#view-halterOhneBohrung-qty').val();
                        index = $('#view-halterOhneBohrung-configIndex').val();
                        halter = $('#view-halterOhneBohrung-auswahlHId').val();
                        variante = $('#view-halterOhneBohrung-variantenId').val();
                    }

                    Halter.editConfiguration(index, halter, variante, corner, x, y, qty);

                    if (!ctxOhne) {
                        View.Halter.mitBohrung.createEckSelectionView();
                        View.Halter.mitBohrung.createSelectionView();
                    } else {
                        View.Halter.ohneBohrung.createSelectionView();
                    }

                    if (!ctxOhne) {
                        if (parseInt(halter) == parseInt(7)) {
                            var currSenkung = Bearbeitungen.Senkungen.getConfiguration(Halter.getConfiguration(index).bohrIndex);
                            Bearbeitungen.Senkungen.editConfiguration(currSenkung.index, currSenkung.uid, corner, currSenkung.m, x, y);
                            View.Bearbeitungen.Senkungen.createEckSelectionView();
                            View.Bearbeitungen.Senkungen.createSelectionView();
                        } else {
                            var currBohrung = Bearbeitungen.Bohrungen.getConfiguration(Halter.getConfiguration(index).bohrIndex);
                            var currHalter = Konfigurator.helper.getHalter(halter, variante);
                            Bearbeitungen.Bohrungen.editConfiguration(currBohrung.index, currBohrung.uid, corner, currHalter.variante.plattenbohrungUnterseite, x, y);
                            View.Bearbeitungen.Bohrungen.createEckSelectionView();
                            View.Bearbeitungen.Bohrungen.createSelectionView();
                        }
                    }

                    View.Configuration.createView.insertHalterView();
                    View.Configuration.createView.insertSenkungView();
                    View.Configuration.createView.insertBohrungView();
                    Price.createPriceView();
                    Konfigurator.helper.drawCADImg();
                    if (!ctxOhne) {
                        $('#editHalterMitBohrungBtn').hide();
                        $('#addHalterMitBohrungBtn').show();
                        $('.view-halterMitBohrung-selection').hide();
                    } else {
                        $('#editHalterOhneBohrungBtn').hide();
                        $('#addHalterOhneBohrungBtn').show();
                        $('.view-halterOhneBohrung-selection').hide();
                    }
                    if (API.isset(Halter.currentEditing)) {
                        Halter.currentEditing = null;
                    }
                },
                editHalterFunction: function (e) {
                    e.preventDefault();

                    var ctxOhne = false;
                    if ($(this).parent('td').parent('tr').parent('tbody').parent('table').find('thead>tr>th').length == 3) {
                        ctxOhne = true;
                    }

                    var selection = $(this).parent('td').parent('tr').find('input[type=hidden]').val();
                    var halterToEdit = Halter.getConfiguration(selection);
                    Halter.currentEditing = halterToEdit;
                    var halterData = Konfigurator.helper.getHalter(halterToEdit.hid, halterToEdit.vid);
                    //console.log(halterToEdit);
                    if (!ctxOhne) {
                        $('#halter-mitBohrung-AbstandEdit').show();
                        $('#view-halterMitBohrung-auswahlHId').val(halterToEdit.hid);
                        $('#view-halterMitBohrung-variantenId').val(halterToEdit.vid);
                        $('#view-halterMitBohrung-configIndex').val(halterToEdit.index);
                        $('#view-halterMitBohrung-x').val(halterToEdit.x);
                        $('#view-halterMitBohrung-y').val(halterToEdit.y);

                        $('.view-halterMitBohrung-HalterAuswahlPreview').html(halterData.variante.name);
                        $('.view-halterMitBohrung-HalterAuswahlMaterial').html(halterData.variante.material);
                        $('.view-halterMitBohrung-HalterAuswahlArtNr').html(halterData.variante.artnr);
                        $('.view-halterMitBohrung-HalterAuswahlWand').html(API.dotToComma(halterData.variante.wandabstand));
                        $('.view-halterMitBohrung-HalterAuswahlSize').html((halterData.variante.halterkantenlaenge == 0 ? '&Oslash;' + API.dotToComma(halterData.variante.durchmesser) : API.dotToComma(halterData.variante.halterkantenlaenge) + ' x ' + API.dotToComma(halterData.variante.halterkantenlaenge)));
                        $('.view-halterMitBohrung-HalterAuswahlKopf').html(halterData.variante.kopfform);
                        $('.view-halterMitBohrung-HalterAuswahlPreis').html(API.priceView(halterData.variante.preis));
                        var srcImg = Konfigurator.config.halterImgPfad + halterData.variante.bild;
                        var srcPreview = Konfigurator.config.halterImgPfad + Konfigurator.helper.getMiniImgData('path') + Konfigurator.helper.getMiniImgData('name', halterData.variante.bild);
                        $('.view-halterMitBohrung-Img').attr('href', srcImg).show();
                        $('.view-halterMitBohrung-Img-preview').attr('src', srcPreview);
                        $('.view-halterMitBohrung-selection').show();
                        $('#editHalterMitBohrungBtn').show();
                        $('#addHalterMitBohrungBtn').hide();
                        Halter.corner.unSetCorner(halterToEdit.corner);
                        setTimeout(function () {
                            API.markEckenCheckboxElementByLabel($('#halterMitBohrungCheckBox'), halterToEdit.corner);
                        }, 100);
                        View.Halter.mitBohrung.createEckSelectionView();
                    } else {
                        $('#halter-ohneBohrung-qtyEdit').show();
                        $('#view-halterOhneBohrung-auswahlHId').val(halterToEdit.hid);
                        $('#view-halterOhneBohrung-variantenId').val(halterToEdit.vid);
                        $('#view-halterOhneBohrung-configIndex').val(halterToEdit.index);
                        $('#view-halterOhneBohrung-qty').val(halterToEdit.qty);

                        $('.view-halterOhneBohrung-HalterAuswahlPreview').html(halterData.variante.name);
                        $('.view-halterOhneBohrung-HalterAuswahlMaterial').html(halterData.variante.material);
                        $('.view-halterOhneBohrung-HalterAuswahlArtNr').html(halterData.variante.artnr);
                        $('.view-halterOhneBohrung-HalterAuswahlWand').html(API.dotToComma(halterData.variante.wandabstand));
                        $('.view-halterOhneBohrung-HalterAuswahlSize').html((halterData.variante.halterkantenlaenge == 0 ? '&Oslash;' + API.dotToComma(halterData.variante.durchmesser) : API.dotToComma(halterData.variante.halterkantenlaenge) + ' x ' + API.dotToComma(halterData.variante.halterkantenlaenge)));
                        $('.view-halterOhneBohrung-HalterAuswahlKopf').html(halterData.variante.kopfform);
                        $('.view-halterOhneBohrung-HalterAuswahlPreis').html(API.priceView(halterData.variante.preis));
                        var srcImg = Konfigurator.config.halterImgPfad + halterData.variante.bild;
                        var srcPreview = Konfigurator.config.halterImgPfad + Konfigurator.helper.getMiniImgData('path') + Konfigurator.helper.getMiniImgData('name', halterData.variante.bild);
                        $('.view-halterOhneBohrung-Img').attr('href', srcImg).show();
                        $('.view-halterOhneBohrung-Img-preview').attr('src', srcPreview);
                        $('.view-halterOhneBohrung-selection').show();
                        $('#editHalterOhneBohrungBtn').show();
                        $('#addHalterOhneBohrungBtn').hide();
                    }
                },
                addHalterMitBohrungFunction: function (e) {
                    e.preventDefault();
                    var hId = $('#view-halterMitBohrung-auswahlHId').val();
                    var vId = $('#view-halterMitBohrung-variantenId').val();
                    var cornerField = $('#halterMitBohrungCheckBox');
                    var corner = cornerField.find('label.active input');
                    var x = $('#view-halterMitBohrung-x');
                    var y = $('#view-halterMitBohrung-y');
                    var errorField = cornerField.parent('div').parent('div').parent('div').find('div.error');
                    var valid = true;
                    valid = valid && Validate.materialSet(errorField);
                    if (!valid) {
                        Dispatcher.addErrorField(Dispatcher.Type.Halter, errorField);
                    }
                    valid = valid && Validate.isCheckboxSelected(cornerField, errorField);
                    valid = valid && Validate.checkRegexp(x, errorField);
                    valid = valid && Validate.checkRegexp(y, errorField);
                    if (valid) {
                        var halter = Konfigurator.helper.getHalter(hId, vId);
                        var bohrIndex = null;
                        $.each(corner, function (i, ecke) {
                            var eVal = $(ecke).val();
                            if (eVal != 'ALLE') {
                                var cornerState = $(ecke).parent('label').attr('disabled');
                                if (!API.isset(cornerState)) {
                                    if (hId == 7) {
                                        var dB = halter.variante.plattenbohrungUnterseite, dS = 0, m = 0;
                                        var senkungen = Konfigurator.data.senkungen;
                                        for (var i = 0; i < senkungen.length; i++) {
                                            if (parseFloat(senkungen[i].bohrung) == parseFloat(dB)) {
                                                m = parseFloat(senkungen[i].gewinde);
                                                dS = parseFloat(senkungen[i].senkung);
                                            }
                                        }
                                        bohrIndex = Bearbeitungen.Senkungen.addConfiguration(2, eVal, m, dB, dS, x.val(), y.val(), null, true);
                                    } else {
                                        var dB = halter.variante.plattenbohrungUnterseite;
                                        bohrIndex = Bearbeitungen.Bohrungen.addConfiguration(1, eVal, dB, x.val(), y.val(), null, true);
                                    }
                                    Halter.addConfiguration(hId, vId, eVal, x.val(), y.val(), null, null, bohrIndex);
                                }
                            }
                        });
                        View.Halter.mitBohrung.createEckSelectionView();
                        View.Halter.mitBohrung.createSelectionView();
                        View.Bearbeitungen.Senkungen.createEckSelectionView();
                        View.Bearbeitungen.Senkungen.createSelectionView();
                        View.Bearbeitungen.Bohrungen.createEckSelectionView();
                        View.Bearbeitungen.Bohrungen.createSelectionView();
                        View.Configuration.createView.insertHalterView();
                        View.Configuration.createView.insertSenkungView();
                        View.Configuration.createView.insertBohrungView();
                        Price.createPriceView();
                        Konfigurator.helper.drawCADImg();

                        $('.view-halterMitBohrung-HalterAuswahlPreview').html('&nbsp;');
                        $('.view-halterMitBohrung-HalterAuswahlMaterial').html('&nbsp;');
                        $('.view-halterMitBohrung-HalterAuswahlArtNr').html('&nbsp;');
                        $('.view-halterMitBohrung-HalterAuswahlWand').html('&nbsp;');
                        $('.view-halterMitBohrung-HalterAuswahlSize').html('&nbsp;');
                        $('.view-halterMitBohrung-HalterAuswahlKopf').html('&nbsp;');
                        $('.view-halterMitBohrung-HalterAuswahlPreis').html('&nbsp;');
                        $('.view-halterMitBohrung-selection').hide();

                    }
                },
                addHalterOhneBohrungFunction: function (e) {
                    e.preventDefault();
                    var hId = $('#view-halterOhneBohrung-auswahlHId').val();
                    var vId = $('#view-halterOhneBohrung-variantenId').val();
                    var qty = $('#view-halterOhneBohrung-qty');
                    var errorField = qty.parent('div').parent('div').parent('div').parent('div').parent('div').find('div.error');
                    var valid = true;
                    valid = valid && Validate.materialSet(errorField);
                    if (!valid) {
                        Dispatcher.addErrorField(Dispatcher.Type.Halter, errorField);
                    }
                    valid = valid && Validate.checkRegexp(qty, errorField);
                    if (valid) {
                        Halter.addConfiguration(hId, vId, null, null, null, null, qty.val());
                        View.Configuration.createView.insertHalterView();
                        $('#view-halterOhneBohrung-qty').val('');
                        Price.createPriceView();
                        View.Halter.ohneBohrung.createSelectionView();
                        Konfigurator.helper.drawCADImg();

                        $('.view-halterOhneBohrung-HalterAuswahlPreview').html('&nbsp;');
                        $('.view-halterOhneBohrung-HalterAuswahlMaterial').html('&nbsp;');
                        $('.view-halterOhneBohrung-HalterAuswahlArtNr').html('&nbsp;');
                        $('.view-halterOhneBohrung-HalterAuswahlWand').html('&nbsp;');
                        $('.view-halterOhneBohrung-HalterAuswahlSize').html('&nbsp;');
                        $('.view-halterOhneBohrung-HalterAuswahlKopf').html('&nbsp;');
                        $('.view-halterOhneBohrung-HalterAuswahlPreis').html('&nbsp;');
                        $('.view-halterOhneBohrung-selection').hide();
                    }
                }
            }
        },
        Material: {
            changeSizeView: function (panelId, mId, vId) {
                var material = Konfigurator.data.material;
                var tmpl = '';
                for (var i = 0; i < material.length; i++) {
                    if (material[i].uid == mId) {
                        for (var j = 0; j < material[i].varianten.length; j++) {
                            if (material[i].varianten[j].uid == vId) {
                                for (var k = 0; k < material[i].varianten[j].formen.length; k++) {
                                    tmpl += '<p><input  class="addMaterialBtn" id="size_' + material[i].uid + '_' + material[i].varianten[j].uid + '_' + material[i].varianten[j].formen[k].uid + '" type="radio" name="dicke" value="' + material[i].varianten[j].formen[k].dicke + '"><label for="size_' + material[i].uid + '_' + material[i].varianten[j].uid + '_' + material[i].varianten[j].formen[k].uid + '">' + material[i].varianten[j].formen[k].dicke + ' mm</label></p>';
                                }
                            }
                        }
                    }
                    $('#sizeAuswahl_' + panelId).html(tmpl);
                }
            },
            changeImagePreview: function () {

            }
        },
        Bearbeitungen: {
            Kanten: {
                createKantenAuswahl: function () {
                    var kanten = Konfigurator.data.kanten, src = Konfigurator.config.bearbeitungImgPfad, srcSet = false, srcImg = '', srcPreview = '';
                    var edit = Bearbeitungen.Kanten.getCurrentConfiguration();
                    var tmpl = '';
                    tmpl += '<select>';
                    for (var i = 0; i < kanten.length; i++) {
                        if (this.bearbeitungErlaubt(kanten[i].uid)) {
                            tmpl += '<option';
                            if (API.isset(edit.uid) && (parseInt(edit.uid) == parseInt(kanten[i].uid))) {
                                tmpl += ' selected="selected" ';
                                if (!srcSet) {
                                    srcSet = true;
                                    srcImg = src + kanten[i].bild;
                                    srcPreview = src + Konfigurator.helper.getMiniImgData('path') + Konfigurator.helper.getMiniImgData('name', kanten[i].bild);
                                }
                            }
                            tmpl += ' value="' + kanten[i].uid + '">' + kanten[i].name + '</option>';
                        }
                    }
                    tmpl += '</select>';
                    $('#view-kanten-auswahl').html(tmpl);
                    $('#view-kanten-img-preview').attr('src', srcPreview);
                    $('#view-kanten-img').attr('href', srcImg);
                    if (API.isset(edit.facette) && (edit.facette != '')) {
                        $('#view-kanten-facette').val(edit.facette);
                        $('#view-kanten-angle').val(edit.angle);
                        $('#view-facetten-eigenschaften').show();
                        $('#view-kanten-eigenschaften').hide();
                        for (var i = 0; i < kanten.length; i++) {
                            if (parseInt(kanten[i].uid) == parseInt(edit.uid)) {
                                srcImg = src + kanten[i].bild;
                                srcPreview = src + Konfigurator.helper.getMiniImgData('path') + Konfigurator.helper.getMiniImgData('name', kanten[i].bild);
                            }
                        }
                        $('#view-facceten-img-preview').attr('src', srcPreview);
                        $('#view-facceten-img').attr('href', srcImg);
                    } else {
                        $('#view-facetten-eigenschaften').hide();
                    }
                },
                bearbeitungErlaubt: function (kId) {
                    var dependencies = Konfigurator.dependencies.kanten;
                    var material = Material.getCurrentConfiguration();
                    if (API.isset(material.uid)) {
                        for (var i = 0; i < dependencies.length; i++) {
                            if (parseInt(dependencies[i].uid) == parseInt(kId)) {
                                if ($.inArray(parseInt(material.uid), dependencies[i].material) > -1) {
                                    return true;
                                } else {
                                    return false;
                                }
                            }
                        }
                    } else {
                        return true;
                    }
                }
            },
            Ecken: {
                createEckBearbeitungAuswahl: function () {
                    var ecken = Konfigurator.data.ecken;
                    var kanten = Bearbeitungen.Kanten.getCurrentConfiguration();
                    var tmpl = '';
                    var tooltip = false;
                    tmpl += '<div id="eckenAuswahlBox" class="btn-group">';
                    for (var i = 0; i < ecken.length; i++) {
                        tmpl += '<button class="btn btn-glacryl" type="button" value="' + ecken[i].uid + '" name="eckenAuswahlBox" id="eckenAuswahlBox' + i + '">' + ecken[i].name + '</button>';
                    }
                    tmpl += '<input type="hidden" id="selectedEckBearbeitung" value="" />';
                    tmpl += '</div>';
                    if ((kanten.uid == 2) || (kanten.uid == 4)) {
                    } else {
                        tmpl += '<span class="ui-icon ui-icon-info ecken-info-btn"></span>';
                        tooltip = true;
                    }
                    $('#view-ekcen-auswahl').html(tmpl);
                    if (tooltip) {
                        Tooltips.initialize();
                    }
                    this.switchSelection();
                },
                switchSelection: function () {
                    var kanten = Bearbeitungen.Kanten.getCurrentConfiguration();
                    var ecken = Konfigurator.data.ecken;
                    if (kanten.uid != null) {
                        for (var i = 0; i < ecken.length; i++) {
                            if (Konfigurator.helper.isEckeForKanteEnabled(ecken[i].uid, kanten.uid)) {
                                API.enableButton($('#eckenAuswahlBox').find('button[value=' + ecken[i].uid + ']'));
                            } else {
                                API.disableButton($('#eckenAuswahlBox').find('button[value=' + ecken[i].uid + ']'));
                            }
                        }
                    }
                },
                createEckSelectionView: function () {
                    var corner = Bearbeitungen.Ecken.corner;
                    var tmpl = '';
                    tmpl += '<div id="eckenCheckBox"  class="btn-group" data-toggle="buttons">';
                    tmpl += '<label class="btn btn-glacryl">';
                    tmpl += '<input type="checkbox" value="ALLE" />ALLE';
                    tmpl += '</label>';
                    for (var i = 0; i < corner.corner.length; i++) {
                        tmpl += '<label class="btn btn-glacryl">';
                        tmpl += '<input type="checkbox" value="' + corner.corner[i] + '" />' + corner.corner[i];
                        tmpl += '</label>';
                    }
                    tmpl += '</div>';
                    $('#view-ecken-eckAuswahl').html(tmpl);
                    var buttons = $('#eckenCheckBox label');
                    $.each(buttons, function (i, button) {
                        var corner = Bearbeitungen.Ecken.corner;
                        var cornerName = $(button).find('input').val();
                        if (corner.isCornerSet(cornerName)) {
                            API.disableCheckBox($(button));
                        }
                    });
                },
                createSelectionView: function () {
                    var selection = Bearbeitungen.Ecken.getCurrentConfiguration();
                    var tmpl = '';
                    for (var i = 0; i < selection.length; i++) {
                        tmpl += '<tr>';
                        tmpl += '<td>' + selection[i].corner + '</td>';
                        tmpl += '<td>' + (selection[i].x != null ? selection[i].x : ' - ') + '</td>';
                        tmpl += '<td>' + (selection[i].y != null ? selection[i].y : ' - ') + '</td>';
                        tmpl += '<td>' + (selection[i].radius != null ? selection[i].radius : ' - ') + '</td>';
                        tmpl += '<td><span class="sprite-Stift editEckenBtn"></span><span class="sprite-Loeschen deleteEckenBtn"></span><span class="sprite-Bestaetigen acceptEckenBtn"></span></td>';
                        tmpl += '</tr>';
                    }
                    $('#view-ecken-selection table').find('tbody').html(tmpl);
                    $('.acceptEckenBtn').hide();
                }
            },
            Bohrungen: {
                iniBohrungView: function () {
                    var bohrungen = Konfigurator.data.bohrungen, src = Konfigurator.config.bearbeitungImgPfad, srcImg = '', srcPreview = '';
                    for (var i = 0; i < bohrungen.length; i++) {
                        if (bohrungen[i].uid == 1) {
                            srcImg = src + bohrungen[i].bild;
                            srcPreview = src + Konfigurator.helper.getMiniImgData('path') + Konfigurator.helper.getMiniImgData('name', bohrungen[i].bild);
                        }
                    }
                    $('#view-bohrung-img').attr('href', srcImg);
                    $('#view-bohrung-img-preview').attr('src', srcPreview);
                },
                createEckSelectionView: function () {
                    var corner = Bearbeitungen.Bohrungen.corner;
                    var tmpl = '';
                    tmpl += '<div id="bohrungenCheckBox" class="btn-group" data-toggle="buttons">';
                    tmpl += '<label class="btn btn-glacryl">';
                    tmpl += '<input type="checkbox" value="ALLE" />ALLE';
                    tmpl += '</label>';
                    for (var i = 0; i < corner.corner.length; i++) {
                        tmpl += '<label class="btn btn-glacryl">';
                        tmpl += '<input type="checkbox" value="' + corner.corner[i] + '">' + corner.corner[i];
                        tmpl += '</label>';
                    }
                    tmpl += '<label class="btn btn-glacryl">';
                    tmpl += '<input type="checkbox" value="FREI" />FREI';
                    tmpl += '</label>';
                    tmpl += '</div>';
                    $('#view-bohrungen-eckAuswahl').html(tmpl);
                    var buttons = $('#bohrungenCheckBox label');
                    $.each(buttons, function (i, button) {
                        var corner = Bearbeitungen.Bohrungen.corner;
                        var cornerName = $(button).find('input').val();
                        if (corner.isCornerSet(cornerName)) {
                            API.disableCheckBox($(button));
                        }
                    });
                },
                createSelectionView: function () {
                    var selection = Bearbeitungen.Bohrungen.getCurrentConfiguration();
                    var tmpl = '';
                    for (var i = 0; i < selection.length; i++) {
                        tmpl += '<tr>';
                        tmpl += '<td><input type="hidden" value="' + selection[i].index + '" /><span>' + selection[i].corner + '</span></td>';
                        tmpl += '<td>' + (selection[i].x != null ? selection[i].x : ' - ') + '</td>';
                        tmpl += '<td>' + (selection[i].y != null ? selection[i].y : ' - ') + '</td>';
                        tmpl += '<td>' + (selection[i].dB != null ? selection[i].dB : ' - ') + '</td>';
                        tmpl += '<td><span class="sprite-Stift editBohrungenBtn"></span><span class="sprite-Loeschen deleteBohrungenBtn"></span><span class="sprite-Bestaetigen acceptBohrungenBtn"></span></td>';
                        tmpl += '</tr>';
                    }
                    $('#view-bohrungen-selection table').find('tbody').html(tmpl);
                    $('.acceptBohrungenBtn').hide();
                }
            },
            Senkungen: {
                iniSenkungView: function () {
                    var bohrungen = Konfigurator.data.bohrungen, src = Konfigurator.config.bearbeitungImgPfad, srcImg = '', srcPreview = '';
                    for (var i = 0; i < bohrungen.length; i++) {
                        if (bohrungen[i].uid == 2) {
                            srcImg = src + bohrungen[i].bild;
                            srcPreview = src + Konfigurator.helper.getMiniImgData('path') + Konfigurator.helper.getMiniImgData('name', bohrungen[i].bild);
                        }
                    }
                    $('#view-senkung-img-preview').attr('src', srcPreview);
                    $('#view-senkung-img').attr('href', srcImg);
                },
                createSchraubenMView: function () {
                    var senkungen = Konfigurator.data.senkungen;
                    var tmpl = '';
                    tmpl += '<label for="view-senkungen-m" style="font-size: 11pt ! important; margin: 5px 0px 5px;">F&uuml;r Gewindeschrauben</label>';
                    tmpl += '<label for="view-senkungen-m" style="display:inline-block !important;margin-right:12px;">M</label>';
                    tmpl += '<select style="display:inline-block; width:30%;" id="view-senkungen-m">';
                    for (var i = 0; i < senkungen.length; i++) {
                        tmpl += '<option valu="' + Number(senkungen[i].gewinde) + '">' + Number(senkungen[i].gewinde) + '</option>';
                    }
                    tmpl += '</select>';
                    $('#view-senkungen-schrauben').html(tmpl);
                },
                createEckSelectionView: function () {
                    var corner = Bearbeitungen.Senkungen.corner;
                    var tmpl = '';
                    tmpl += '<div id="senkungenCheckBox" class="btn-group" data-toggle="buttons">';
                    tmpl += '<label class="btn btn-glacryl">';
                    tmpl += '<input type="checkbox" value="ALLE" />ALLE';
                    tmpl += '</label>';
                    for (var i = 0; i < corner.corner.length; i++) {
                        tmpl += '<label class="btn btn-glacryl">';
                        tmpl += '<input type="checkbox" value="' + corner.corner[i] + '">' + corner.corner[i];
                        tmpl += '</label>';
                    }
                    tmpl += '<label class="btn btn-glacryl">';
                    tmpl += '<input type="checkbox" value="FREI">FREI';
                    tmpl += '</label>';
                    tmpl += '</div>';
                    $('#view-senkungen-eckAuswahl').html(tmpl);
                    var buttons = $('#senkungenCheckBox label');
                    $.each(buttons, function (i, button) {
                        var corner = Bearbeitungen.Senkungen.corner;
                        var cornerName = $(button).find('input').val();
                        if (corner.isCornerSet(cornerName)) {
                            API.disableCheckBox($(button));
                        }
                    });
                },
                createSelectionView: function () {
                    var selection = Bearbeitungen.Senkungen.getCurrentConfiguration();
                    var tmpl = '';
                    for (var i = 0; i < selection.length; i++) {
                        tmpl += '<tr>';
                        tmpl += '<td><input type="hidden" value="' + selection[i].index + '" /><span>' + selection[i].corner + '</span></td>';
                        tmpl += '<td>' + (selection[i].x != null ? selection[i].x : ' - ') + '</td>';
                        tmpl += '<td>' + (selection[i].y != null ? selection[i].y : ' - ') + '</td>';
                        tmpl += '<td>' + (selection[i].m != null ? selection[i].m : ' - ') + '</td>';
                        tmpl += '<td><span class="sprite-Stift editSenkungenBtn"></span><span class="sprite-Loeschen deleteSenkungenBtn"></span><span class="sprite-Bestaetigen acceptSenkungenBtn"></span></td>';
                        tmpl += '</tr>';
                    }
                    $('#view-senkungen-selection table').find('tbody').html(tmpl);
                    $('.acceptSenkungenBtn').hide();
                }
            }
        },
        Halter: {
            mitBohrung: {
                istHalterErlaubt: function (hId) {
                    var material = Material.getCurrentConfiguration();
                    var halter = Konfigurator.data.halter;
                    if (material.uid != null) {
                        for (var i = 0; i < halter.length; i++) {
                            if (halter[i].uid == hId) {
                                for (var j = 0; j < halter[i].varianten.length; j++) {
                                    if (halter[i].varianten[j].position != 'kante') {
                                        if (((parseFloat(material.size) >= parseFloat(halter[i].varianten[j].materialVon)) || (parseFloat(halter[i].varianten[j].materialVon) == -1)) && ((parseFloat(material.size) <= parseFloat(halter[i].varianten[j].materialBis)) || (parseFloat(halter[i].varianten[j].materialBis) == -1))) {
                                            return true;
                                        } else {
                                            return false;
                                        }
                                    } else {
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        for (var i = 0; i < halter.length; i++) {
                            if (halter[i].uid == hId) {
                                for (var j = 0; j < halter[i].varianten.length; j++) {
                                    if (halter[i].varianten[j].position != 'kante') {
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
                            }
                        }
                    }
                },
                createEckSelectionView: function () {
                    var corner = Halter.corner;
                    var tmpl = '';
                    tmpl += '<div id="halterMitBohrungCheckBox" class="btn-group" data-toggle="buttons">';
                    tmpl += '<label class="btn btn-glacryl">';
                    tmpl += '<input type="checkbox" value="ALLE" />ALLE';
                    tmpl += '</label>';
                    for (var i = 0; i < corner.corner.length; i++) {
                        tmpl += '<label class="btn btn-glacryl">';
                        tmpl += '<input type="checkbox" value="' + corner.corner[i] + '" />' + corner.corner[i];
                        tmpl += '</label>';
                    }
                    tmpl += '<label class="btn btn-glacryl">';
                    tmpl += '<input type="checkbox" value="FREI" />FREI';
                    tmpl += '</label>';
                    tmpl += '</div>';
                    $('#view-halterMitBohrung-eckAuswahl').html(tmpl);
                    var buttons = $('#halterMitBohrungCheckBox label');
                    $.each(buttons, function (i, button) {
                        var corner = Halter.corner;
                        var cornerName = $(button).find('input').val();
                        if (corner.isCornerSet(cornerName)) {
                            API.disableCheckBox($(button));
                        }
                    });
                },
                createSelectionView: function () {
                    var selection = Halter.getCurrentConfiguration();
                    var halter = Konfigurator.data.halter;
                    var tmpl = '';
                    for (var i = 0; i < selection.length; i++) {
                        if (API.isset(selection[i].corner)) {
                            tmpl += '<tr>';
                            tmpl += '<td><input type="hidden" value="' + selection[i].index + '" /><span>' + selection[i].corner + '</span></td>';
                            tmpl += '<td>' + selection[i].x + '</td>';
                            tmpl += '<td>' + selection[i].y + '</td>';
                            for (var j = 0; j < halter.length; j++) {
                                if (halter[j].uid == selection[i].hid) {
                                    for (var k = 0; k < halter[j].varianten.length; k++) {
                                        if (halter[j].varianten[k].uid == selection[i].vid) {
                                            tmpl += '<td><input type="hidden" class="hId" value="' + selection[i].hid + '" /><input type="hidden" class="vId" value="' + selection[i].vid + '" />Art.Nr.: ' + halter[j].varianten[k].artnr + '</td>';
                                        }
                                    }
                                }
                            }
                            tmpl += '<td>';
                            tmpl += '<span class="sprite-Stift editHalterBtn"></span>';
                            tmpl += '<span class="sprite-Loeschen deleteHalterBtn"></span>';
                            tmpl += '<span class="info-halterMit-icon">i</span></td>';
                            tmpl += '</tr>';
                        }
                    }
                    $('#view-halterMitBohrung-selection table').find('tbody').html(tmpl);
                }
            },
            ohneBohrung: {
                istHalterErlaubt: function (hId) {
                    var material = Material.getCurrentConfiguration();
                    var halter = Konfigurator.data.halter;
                    if (material.uid != null) {
                        for (var i = 0; i < halter.length; i++) {
                            if (halter[i].uid == hId) {
                                for (var j = 0; j < halter[i].varianten.length; j++) {
                                    if (halter[i].varianten[j].position == 'kante') {
                                        if (((parseFloat(material.size) >= parseFloat(halter[i].varianten[j].materialVon)) || (parseFloat(halter[i].varianten[j].materialVon) == -1)) && ((parseFloat(material.size) <= parseFloat(halter[i].varianten[j].materialBis)) || (parseFloat(halter[i].varianten[j].materialBis) == -1))) {
                                            return true;
                                        } else {
                                            return false;
                                        }
                                    } else {
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        for (var i = 0; i < halter.length; i++) {
                            if (halter[i].uid == hId) {
                                for (var j = 0; j < halter[i].varianten.length; j++) {
                                    if (halter[i].varianten[j].position == 'kante') {
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
                            }
                        }
                    }
                },
                createSelectionView: function () {
                    var selection = Halter.getCurrentConfiguration();
                    var halter = Konfigurator.data.halter;
                    //log(selection);
                    var tmpl = '';
                    for (var i = 0; i < selection.length; i++) {
                        if (!API.isset(selection[i].corner)) {
                            tmpl += '<tr>';
                            tmpl += '<td><input type="hidden" value="' + selection[i].index + '" /><span>' + selection[i].qty + '</span></td>';
                            for (var j = 0; j < halter.length; j++) {
                                if (halter[j].uid == selection[i].hid) {
                                    for (var k = 0; k < halter[j].varianten.length; k++) {
                                        if (halter[j].varianten[k].uid == selection[i].vid) {
                                            tmpl += '<td><input type="hidden" class="hId" value="' + selection[i].hid + '" /><input type="hidden" class="vId" value="' + selection[i].vid + '" />Art.Nr.: ' + halter[j].varianten[k].artnr + '</td>';
                                        }
                                    }
                                }
                            }
                            tmpl += '<td>';
                            tmpl += '<span class="sprite-Stift editHalterBtn"></span>';
                            tmpl += '<span class="sprite-Loeschen deleteHalterBtn"></span>';
                            tmpl += '<span class="info-halterOhne-icon">i</span></td>';
                            tmpl += '</tr>';
                        }
                    }
                    $('#view-halterOhneBohrung-selection table').find('tbody').html(tmpl);
                }
            }
        },
        Configuration: {
            createView: {
                initialize: function () {
                    this.insertMaterialView();
                    this.insertGrundEinstellungenView();
                    this.insertKantenView();
                    this.insertEckenView();
                    this.insertBohrungView();
                    this.insertSenkungView();
                    this.insertHalterView();
                    this.iniDialog();
                },
                iniDialog: function () {
                    $('#konfigurator-success-Dialog').dialog({
                        autoOpen: false,
                        resizable: false,
                        height: 'auto',
                        width: 'auto',
                        modal: true,
                        buttons: {
                            'Weiter einkaufen': function () {
                                Konfigurator.clearEditState();
                                $(this).dialog("close");
                            },
                            'Zum Warenkorb': function () {
                                $(this).dialog("close");
                                var baseUrl = $('base').attr('href');
                                var url = baseUrl + 'shop/?tx_glshop_glacrylshop%5Baction%5D=index&tx_glshop_glacrylshop%5Bcontroller%5D=Cart';
                                window.location = url;
                            }
                        }
                    });
                    $('#konfigurator-error-Dialog').dialog({
                        autoOpen: false,
                        resizable: false,
                        height: 'auto',
                        modal: true,
                        buttons: {
                            OK: function () {
                                $(this).dialog("close");
                            }
                        }
                    });
                    $('#konfigurator-qty-Dialog').dialog({
                        autoOpen: false,
                        resizable: false,
                        height: 'auto',
                        modal: true,
                        buttons: {
                            OK: function () {
                                $(this).dialog("close");
                                $('konfigurator-qty-warning').html('');
                            }
                        },
                        close: function () {
                            $('#konfigurator-success-Dialog').dialog("open");
                        }
                    });
                    $('#konfigurator-changeKante-sizeInfo-Dialog').dialog({
                        autoOpen: false,
                        resizable: false,
                        height: 'auto',
                        modal: true,
                        buttons: {
                            OK: function () {
                                $(this).dialog("close");
                            }
                        }
                    });
                    $('#konfigurator-changeKanten-Dialog').dialog({
                        autoOpen: false,
                        resizable: false,
                        height: 'auto',
                        modal: true,
                        buttons: {
                            'Ja': function () {
                                var eckenToDelete = Dispatcher.transition.ecken;
                                for (var i = 0; i < eckenToDelete.length; i++) {
                                    Bearbeitungen.Ecken.removeConfiguration(eckenToDelete[i].corner);
                                }
                                View.Configuration.createView.insertEckenView();
                                Price.createPriceView();
                                Dispatcher.clearTransition();
                                View.actions.Bearbeitungen.changeAndSaveKantenAuswahlFunction();
                                View.Bearbeitungen.Ecken.createEckBearbeitungAuswahl();
                                View.Bearbeitungen.Ecken.createEckSelectionView();
                                View.Bearbeitungen.Ecken.createSelectionView();
                                $('.view-eckbearbeitung-rund').hide();
                                $('#view-ecken-img').hide();
                                $(this).dialog("close");
                            },
                            'Nein': function () {
                                Dispatcher.clearTransition();
                                $(this).dialog("close");
                            }
                        }
                    });
                },
                insertMaterialView: function () {
                    var material = Konfigurator.data.material;
                    var config = Material.getCurrentConfiguration();
                    var tmpl = 'Bitte Material w&auml;hlen';
                    if (config.uid != null) {
                        for (var i = 0; i < material.length; i++) {
                            if (material[i].uid == config.uid) {
                                for (var j = 0; j < material[i].varianten.length; j++) {
                                    if (material[i].varianten[j].uid == config.vid) {
                                        tmpl = material[i].name + ' ' + config.size + ' mm ' + material[i].varianten[j].name;
                                    }
                                }
                            }
                        }
                    }
                    $('#view-configuration-material').html(tmpl);
                    this.insertGrundEinstellungenView();
                },
                insertGrundEinstellungenView: function () {
                    var grundEinstellung = Grundeinstellung.getCurrentConfiguration();
                    var tmpl = 'keine';
                    if ((grundEinstellung.height != null) && (grundEinstellung.width != null)) {
                        tmpl = grundEinstellung.width + ' x ' + grundEinstellung.height + ' mm';
                    }
                    $('#view-configuration-size span').html(tmpl);
                },
                insertKantenView: function () {
                    var config = Bearbeitungen.Kanten.getCurrentConfiguration();
                    var tmpl = 'keine';
                    if (config.uid != null) {
                        var kanten = Konfigurator.helper.getKanten(config.uid);
                        tmpl = kanten.name;
                    }
                    $('#view-configuration-kanten span').html(tmpl);
                },
                insertEckenView: function () {
                    var config = Bearbeitungen.Ecken.getCurrentConfiguration();
                    var ecken = Konfigurator.data.ecken;
                    var tmpl = 'keine';
                    var count = {
                        'schraeg': 0,
                        'rund': 0
                    };
                    if (config.length > 0) {
                        for (var i = 0; i < config.length; i++) {
                            for (var j = 0; j < ecken.length; j++) {
                                if (config[i].uid == ecken[j].uid) {
                                    if (parseInt(config[i].uid) == 1) {
                                        if (config[i].corner == 'ALLE') {
                                            count.schraeg += 4;
                                        } else {
                                            count.schraeg++;
                                        }
                                    } else {
                                        if (config[i].corner == 'ALLE') {
                                            count.rund += 4;
                                        } else {
                                            count.rund++;
                                        }
                                    }
                                }
                            }
                        }
                        if ((count.schraeg > 0) && (count.rund > 0)) {
                            tmpl = count.schraeg + 'x mit Schr&auml;gecke und ' + count.rund + 'x mit Rundecke';
                        } else if (count.schraeg > 0) {
                            tmpl = count.schraeg + 'x Schr&auml;gecke ';
                        } else if (count.rund > 0) {
                            tmpl = count.rund + 'x Rundecke ';
                        }
                    }
                    $('#view-configuration-ecken span').html(tmpl);
                },
                insertBohrungView: function () {
                    var config = Bearbeitungen.Bohrungen.getCurrentConfiguration();
                    var tmpl = 'keine';
                    var count = 0;
                    if (config.length > 0) {
                        for (var i = 0; i < config.length; i++) {
                            if (config[i].corner == 'ALLE') {
                                count += 4;
                            } else {
                                count++;
                            }
                        }
                        tmpl = count + 'x Bohrung(en)';
                    }
                    $('#view-configuration-bohrungen span').html(tmpl);
                },
                insertSenkungView: function () {
                    var config = Bearbeitungen.Senkungen.getCurrentConfiguration();
                    var tmpl = 'keine';
                    var count = 0;
                    if (config.length > 0) {
                        for (var i = 0; i < config.length; i++) {
                            if (config[i].corner == 'ALLE') {
                                count += 4;
                            } else {
                                count++;
                            }
                        }
                        tmpl = count + 'x Senkung(en)';
                    }
                    $('#view-configuration-senkungen span').html(tmpl);
                },
                insertHalterView: function () {
                    var config = Halter.getCurrentConfiguration();
                    var tmpl = 'keine';
                    var countMit = 0, countOhne = 0;
                    if (config.length > 0) {
                        for (var i = 0; i < config.length; i++) {
                            var halter = Konfigurator.helper.getHalter(config[i].hid, config[i].vid);
                            if (config[i].corner == null) {
                                countOhne += parseInt(config[i].qty);
                            } else {
                                if (config[i].corner == 'ALLE') {
                                    countMit += 4;
                                } else {
                                    countMit++;
                                }
                            }
                        }

                        if ((countMit > 0) && (countOhne > 0)) {
                            tmpl = countMit + 'x mit und ' + countOhne + 'x ohne Bohrungen';
                        } else if (countMit > 0) {
                            tmpl = countMit + 'x mit Bohrungen ';
                        } else if (countOhne > 0) {
                            tmpl = countOhne + 'x ohne Bohrungen ';
                        }
                    }

                    $('#view-configuration-halter span').html(tmpl);
                }
            }
        }
    };
    $(function () {
        Konfigurator.initialize();
        Konfigurator.mobileSchild = new Schild();
        Konfigurator.resetKonfiguratorView();
        View.actions.initializeFirst();
        HalterFilter.iniFirst();
        Tooltips.initialize(null);
        $('#view-configuration-width').focus();
    });
})(jQuery);