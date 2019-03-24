function log() {
	if (typeof console !== 'undefined') {
		console.log(arguments);
	}
}

(function ($) {

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
			'.right.info-icon.mat': '#material-info-tooltip'
		},
		initialize: function () {
			$('.info-icon, .info-icon-halter').each(function () {
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
							if (API.isMobile.matches) {
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
					var mId = icon.parent('a').next('div').find('input[name=materialUid]').val();
					var vId = icon.parent('a').next('div').find('input[name=variantenUid]').val();
					//log(mId, vId);
					var material = Konfigurator.helper.getMaterial(mId, vId);
					$('span.tooltip-material-name').html(material.material.name);
					$('p.tooltip-material-info').html(material.material.desc);
					break;
				case '.info-icon-halter.eHmB':
					var hId = $('#view-halterMitBohrung-auswahl select').val();
					var vId = $('#view-halterMitBohrung-variantenId').val();
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
		isMobile: window.matchMedia("only screen and (max-width: 40em)"),
		createRandomNumber: function () {
			var number = Math.floor(Math.random() * (10000 - 1 + 3) + 1);
			if ($.inArray(number, this.usedIds) == -1) {
				this.usedIds.push(number);
				return number;
			} else {
				return this.createRandomNumber();
			}
		},
		ajax: function (datei, async, data, type, dataType, sMsg, eMsg) {
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
			if ((dataType == 'json') && (res != '') && (res != null) && (res.length > 0)) {
				res = eval("(" + res + ")");
			}
			return res;
		},
		dotToComma: function (string) {
			string = string + "";
			string = string.replace(".", ",");
			return string;
		},
		commaToDot: function (string) {
			string = string + "";
			string = string.replace(".", "");
			string = string.replace(",", ".");
			return string;
		},
		round: function (x, n) {
			if ((n < 1) || (n > 14))
				return false;
			var e = Math.pow(10, n);
			var k = (Math.round(x * e) / e).toString();
			if (k.indexOf('.') == -1)
				k += '.';
			k += e.toString().substring(1);
			return k.substring(0, k.indexOf('.') + n + 1);
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

				// fehlende Nullen einfügen
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
				}
			},
			material: {
				max: 2030,
				min: 1520
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
			o.attr('style', 'border: 1px solid #A51107 !important; color: #A51107 !important; overflow:hidden; padding:0px !important;padding-left:4px !important;');
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
		checkRegexp: function (o, errorField) {
			var regexp = this.config.regexp.ganzeZahl.exp, n = this.config.regexp.ganzeZahl.text;
			if (o.is(':visible')) {
				if (!(regexp.test(o.val()))) {
					this.addErrorStyle(o);
					this.updateText(errorField, n);
					errorField.parent('div').attr('style', 'margin-top:-8px;').parent('div').attr('style', 'height: 258px;').prev('div').attr('style', 'width: 100%; background-color: rgba(255, 255, 255, 0.3); position: absolute; height: 245px;');
					return false;
				} else {
					this.removeErrorStyle(o);
					this.updateText(errorField, '');
					errorField.parent('div').attr('style', 'margin-top:-8px;').parent('div').attr('style', 'height: 258px;').prev('div').attr('style', 'width: 100%; background-color: rgba(255, 255, 255, 0.3); position: absolute; height: 245px;');
					return true;
				}
			} else {
				this.removeErrorStyle(0);
				this.updateText(errorField, '');
				errorField.parent('div').attr('style', 'margin-top:-8px;').parent('div').attr('style', 'height: 212px;').prev('div').attr('style', 'width: 100%; background-color: rgba(255, 255, 255, 0.3); position: absolute; height: 200px;');
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
						this.updateText(errorField, 'Die maximal mögliche Facettenbreite von ' + max + ' mm darf nicht überschritten werden!');
					}
					return false;
				} else if (Number(facette) < min) {
					if (!check) {
						this.addErrorStyle(F);
						this.updateText(errorField, 'Die minimal mögliche Facettenbreite von ' + min + ' mm darf nicht unterschritten werden!');
					}
					return false;
				}
				if ((res != null) && (Number(res) < 1)) {
					if (!check) {
						this.addErrorStyle(F);
						this.updateText(errorField, 'Die gewünschte Facettenbreite ist bei gewählter Materialstärke nicht möglich. Bitte reduzieren Sie die Facettenbreite oder erhöhen Sie die Materialstärke.');
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
						this.updateText(errorField, 'Die Größe vom Eckradius darf die kleinste Kante nicht übersteigen (' + minKante + ' mm)!');
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
					errorField.parent('div').attr('style', 'margin-top:-8px;').parent('div').attr('style', 'height: 258px;').prev('div').attr('style', 'width: 100%; background-color: rgba(255, 255, 255, 0.3); position: absolute; height: 245px;');
					this.updateText(errorField, 'Bitte w&auml;hlen Sie zuerst eine Materialvariante aus!');
					return false;
				}
				errorField.parent('div').attr('style', 'margin-top:-8px;').parent('div').attr('style', 'height: 212px;').prev('div').attr('style', 'width: 100%; background-color: rgba(255, 255, 255, 0.3); position: absolute; height: 200px;');
				this.updateText(errorField);
			} else {
				if (!API.isset(size)) {
					return false;
				}
			}
			return true;
		},
		material: function (width, height, errorField) {
			var w = Number(width.val()), h = Number(height.val()), max = this.config.material.max, min = this.config.material.min;
			if ((w != 0) && (h != 0)) {
				if (w > h) {
					if (w > max) {
						this.updateText(errorField, 'Das Feld "Breite" darf den Maximalwert von ' + max + ' mm nicht übersteigen!');
						this.addErrorStyle(width);
						this.removeErrorStyle(height);
						errorField.parent('div').attr('style', 'margin-top:-8px;').parent('div').attr('style', 'height: 258px;').prev('div').attr('style', 'width: 100%; background-color: rgba(255, 255, 255, 0.3); position: absolute; height: 245px;');
						return false;
					} else if (w < 20) {
						this.updateText(errorField, 'Das Feld "Breite" darf den Minimalwert von 20 mm nicht unterschreiten!');
						this.addErrorStyle(width);
						this.removeErrorStyle(height);
						errorField.parent('div').attr('style', 'margin-top:-8px;').parent('div').attr('style', 'height: 258px;').prev('div').attr('style', 'width: 100%; background-color: rgba(255, 255, 255, 0.3); position: absolute; height: 245px;');
						return false;
					}
					if (h > min) {
						this.updateText(errorField, 'Das Feld "Höhe" darf den Maximalwert von ' + min + ' mm nicht übersteigen!');
						this.addErrorStyle(height);
						this.removeErrorStyle(width);
						errorField.parent('div').attr('style', 'margin-top:-8px;').parent('div').attr('style', 'height: 258px;').prev('div').attr('style', 'width: 100%; background-color: rgba(255, 255, 255, 0.3); position: absolute; height: 245px;');
						return false;
					} else if (h < 20) {
						this.updateText(errorField, 'Das Feld "Höhe" darf den Minimalwert von 20 mm nicht unterschreiten!');
						this.addErrorStyle(height);
						this.removeErrorStyle(width);
						errorField.parent('div').attr('style', 'margin-top:-8px;').parent('div').attr('style', 'height: 258px;').prev('div').attr('style', 'width: 100%; background-color: rgba(255, 255, 255, 0.3); position: absolute; height: 245px;');
						return false;
					}
				} else {
					if (h > max) {
						this.updateText(errorField, 'Das Feld "Höhe" darf den Maximalwert von ' + max + ' mm nicht übersteigen!');
						this.addErrorStyle(height);
						this.removeErrorStyle(width);
						errorField.parent('div').attr('style', 'margin-top:-8px;').parent('div').attr('style', 'height: 258px;').prev('div').attr('style', 'width: 100%; background-color: rgba(255, 255, 255, 0.3); position: absolute; height: 245px;');
						return false;
					} else if (h < 20) {
						this.updateText(errorField, 'Das Feld "Höhe" darf den Minimalwert von 20 mm nicht unterschreiten!');
						this.addErrorStyle(height);
						this.removeErrorStyle(width);
						errorField.parent('div').attr('style', 'margin-top:-8px;').parent('div').attr('style', 'height: 258px;').prev('div').attr('style', 'width: 100%; background-color: rgba(255, 255, 255, 0.3); position: absolute; height: 245px;');
						return false;
					}
					if (w > min) {
						this.updateText(errorField, 'Das Feld "Breite" darf den Maximalwert von ' + min + ' mm nicht übersteigen!');
						this.addErrorStyle(width);
						this.removeErrorStyle(height);
						errorField.parent('div').attr('style', 'margin-top:-8px;').parent('div').attr('style', 'height: 258px;').prev('div').attr('style', 'width: 100%; background-color: rgba(255, 255, 255, 0.3); position: absolute; height: 245px;');
						return false;
					} else if (w < 20) {
						this.updateText(errorField, 'Das Feld "Breite" darf den Minimalwert von 20 mm nicht unterschreiten!');
						this.addErrorStyle(width);
						this.removeErrorStyle(height);
						errorField.parent('div').attr('style', 'margin-top:-8px;').parent('div').attr('style', 'height: 258px;').prev('div').attr('style', 'width: 100%; background-color: rgba(255, 255, 255, 0.3); position: absolute; height: 245px;');
						return false;
					}
				}
			} else {
				if (w == 0) {
					this.addErrorStyle(width);
					this.removeErrorStyle(height);
					this.updateText(errorField, 'Bitte geben Sie eine Zahl ein!');
					errorField.parent('div').attr('style', 'margin-top:-8px;').parent('div').attr('style', 'height: 258px;').prev('div').attr('style', 'width: 100%; background-color: rgba(255, 255, 255, 0.3); position: absolute; height: 245px;');
					return false;
				} else {
					if (h == 0) {
						this.addErrorStyle(height);
						this.removeErrorStyle(width);
						this.updateText(errorField, 'Bitte geben Sie eine Zahl ein!');
						errorField.parent('div').attr('style', 'margin-top:-8px;').parent('div').attr('style', 'height: 258px;').prev('div').attr('style', 'width: 100%; background-color: rgba(255, 255, 255, 0.3); position: absolute; height: 245px;');
						return false;
					}
				}
			}
			this.removeErrorStyle(height);
			this.removeErrorStyle(width);
			this.updateText(errorField, '');
			errorField.parent('div').attr('style', 'margin-top:-8px;').parent('div').attr('style', 'height: 258px;').prev('div').attr('style', 'width: 100%; background-color: rgba(255, 255, 255, 0.3); position: absolute; height: 246px;');
			return true;
		}
	};

	/* Price calculation */
	var Price = {
		rabatt: {
			schild: {
				0: {
					preisVon: 0,
					preisBis: 5,
					stkZahlen: {
						1: 1,
						3: 0.45,
						5: 0.3,
						10: 0.19,
						25: 0.12,
						50: 0.1
					}
				},
				1: {
					preisVon: 5,
					preisBis: 100,
					stkZahlen: {
						1: 1,
						3: 0.76,
						5: 0.63,
						10: 0.54,
						25: 0.45,
						50: 0.39
					}
				},
				2: {
					preisVon: 100,
					preisBis: 1000,
					stkZahlen: {
						1: 1,
						3: 0.86,
						5: 0.78,
						10: 0.72,
						25: 0.67,
						50: 0.64
					}
				}
			},
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
		createPriceView: function () {
			var qty = Grundeinstellung.getCurrentConfiguration().qty;
			var preis = this.calculatePrice();
			$('#cart-configuration-qty').html(qty + ' Stk.');
			$('#cart-configuration-onePrice').html('à ' + API.priceView(parseFloat(preis) / parseInt(qty)) + ' &euro; netto');
			$('#cart-configuration-sumPrice').html(API.priceView(preis) + ' &euro;');
		},
		calculatePrice: function () {
			var preis = parseFloat(0);
			var shop = Konfigurator.prepareDataForImg();
			var config = shop.configuration;
			var material = shop.material;
			var shildSize = shop.materialConfig;
			var kanten = shop.bearbeitungen.kanten;
			var ecken = shop.bearbeitungen.ecken;
			var bohrungen = shop.bearbeitungen.bohrungen;
			var senkungen = shop.bearbeitungen.senkungen;
			var halter = shop.halter;
			var qty = Number(Grundeinstellung.getCurrentConfiguration().qty);
			var grundpreisZuschnitt = 0;

			// Material Preis
			for (var i = 0; i < config.material.length; i++) {
				if (config.material[i].uid == material.uid) {
					for (var j = 0; j < config.material[i].varianten.length; j++) {
						if (config.material[i].varianten[j].uid == material.vid) {
							for (var k = 0; k < config.material[i].varianten[j].formen.length; k++) {
								if (parseFloat(config.material[i].varianten[j].formen[k].dicke) == parseFloat(material.size)) {
									preis += parseFloat(config.material[i].varianten[j].formen[k].preis) * (parseFloat(shildSize.width) / 1000 * parseFloat(shildSize.height) / 1000);
								}
							}
						}
					}
				}
			}

			//log('------------------------------');

			//log('Materialpreis', preis);

			//log('Kanten', kanten);

			// Kantenbearbeitungspreis
			if (typeof kanten != 'undefined') {
				var lfm = 2 * (parseInt(shildSize.width) + parseInt(shildSize.height));
				for (var j = 0; j < config.kanten.length; j++) {
					if (kanten.uid == parseInt(config.kanten[j].uid)) {
						grundpreisZuschnitt += parseFloat(config.kanten[j].preis);
						for (var k = 0; k < config.kanten[j].varianten.length; k++) {
							if ((parseFloat(material.size) >= parseFloat(config.kanten[j].varianten[k].ab)) && (parseFloat(material.size) <= parseFloat(config.kanten[j].varianten[k].bis))) {
								//log('Preis bei der Kantenberechnung', preis);
								preis += (lfm / 1000) * parseFloat(config.kanten[j].varianten[k].preis) + grundpreisZuschnitt;
								//preis += (lfm / 1000) * parseFloat(config.kanten[j].varianten[k].preis);
							}
						}
					}
				}
			}

			//log('Preis inkl. Kanten', preis);

			//log('------------------------------');

			// Eckbearbeitung
			if ((typeof ecken != 'undefined') && (ecken.length > 0)) {
				for (var i = 0; i < ecken.length; i++) {
					for (var j = 0; j < config.ecken.length; j++) {
						if (ecken[i].uid == config.ecken[j].uid) {
							if (config.ecken[j].varianten.length > 0) {
								for (var k = 0; k < config.ecken[j].varianten.length; k++) {
									if (ecken[i].radius == null) {
										var sLength = sqrt(parseFloat(pow(ecken[i].x, 2)) + parseFloat(pow(ecken[i].y, 2)));
										if ((sLength >= parseFloat(config.ecken[j].varianten[k].ab)) && ((sLength <= parseFloat(config.ecken[j].varianten[k].bis)) || (parseFloat(config.ecken[j].varianten[k].bis) == parseFloat(-1)))) {
											if (ecken[i].corner == 'ALLE') {
												preis += parseFloat(config.ecken[j].varianten[k].preis) * 4;
											} else {
												preis += parseFloat(config.ecken[j].varianten[k].preis);
											}
										}
									} else if ((parseFloat(ecken[i].radius) >= parseFloat(config.ecken[j].varianten[k].ab)) && ((parseFloat(ecken[i].radius) <= parseFloat(config.ecken[j].varianten[k].bis)) || (parseFloat(config.ecken[j].varianten[k].bis) == parseFloat(-1)))) {
										if (ecken[i].corner == 'ALLE') {
											preis += parseFloat(config.ecken[j].varianten[k].preis) * 4;
										} else {
											preis += parseFloat(config.ecken[j].varianten[k].preis);
										}
									}
								}
							} else {
								if (ecken[i].corner == 'ALLE') {
									preis += parseFloat(config.ecken[j].preis) * 4;
								} else {
									preis += parseFloat(config.ecken[j].preis);
								}
							}
						}
					}
				}
			}

			//log('Preis inkl. Ecken', preis);

			// Bohrungen
			if ((typeof bohrungen != 'undefined') && (bohrungen.length > 0)) {
				for (var i = 0; i < bohrungen.length; i++) {
					for (var j = 0; j < config.bohrungen.length; j++) {
						if (bohrungen[i].uid == config.bohrungen[j].uid) {
							if (config.bohrungen[j].varianten.length > 0) {
								for (var k = 0; k < config.bohrungen[j].varianten.length; k++) {
									if ((parseFloat(bohrungen[i].dB) >= parseFloat(config.bohrungen[j].varianten[k].ab)) && ((parseFloat(bohrungen[i].dB) <= parseFloat(config.bohrungen[j].varianten[k].bis)) || (parseFloat(config.bohrungen[j].varianten[k].bis) == parseFloat(-1)))) {
										if (bohrungen[i].corner == 'ALLE') {
											preis += parseFloat(config.bohrungen[j].varianten[k].preis) * 4;
										} else {
											preis += parseFloat(config.bohrungen[j].varianten[k].preis);
										}
									}
								}
							} else {
								if (bohrungen[i].corner == 'ALLE') {
									preis += parseFloat(config.bohrungen[j].preis) * 4;
								} else {
									preis += parseFloat(config.bohrungen[j].preis);
								}
							}
						}
					}
				}
			}

			//log('Preis inkl. Bohrungen', preis);

			// Senkungen
			if ((typeof senkungen != 'undefined') && (senkungen.length > 0)) {
				for (var i = 0; i < senkungen.length; i++) {
					for (var j = 0; j < config.bohrungen.length; j++) {
						if (senkungen[i].uid == config.bohrungen[j].uid) {
							if (config.bohrungen[j].varianten.length > 0) {
								for (var k = 0; k < config.bohrungen[j].varianten.length; k++) {
									if ((parseFloat(senkungen[i].dS) >= parseFloat(config.bohrungen[j].varianten[k].ab)) && ((parseFloat(senkungen[i].dS) <= parseFloat(config.bohrungen[j].varianten[k].bis)) || (parseFloat(config.bohrungen[j].varianten[k].bis) == parseFloat(-1)))) {
										if (senkungen[i].corner == 'ALLE') {
											preis += parseFloat(config.bohrungen[j].varianten[k].preis) * 4;
										} else {
											preis += parseFloat(config.bohrungen[j].varianten[k].preis);
										}
									}
								}
							} else {
								if (senkungen[i].corner == 'ALLE') {
									preis += parseFloat(config.bohrungen[j].preis) * 4;
								} else {
									preis += parseFloat(config.bohrungen[j].preis);
								}
							}
						}
					}
				}
			}

			//	log('Preis inkl. Senkungen', preis);


			var preisInklRabatt = Number(this.calculatePriceWithRabatt(preis, qty, 'schild'));

			//	log('Preis nach Rabatt', preisInklRabatt);

			//preis = (preisInklRabatt + (grundpreisZuschnitt / qty)) * qty;
			preis = preisInklRabatt * qty;

			//	log('Preis Rabatiert', preis);
			// Halter
			if ((typeof halter != 'undefined') && (halter.length > 0)) {
				var halterGesamtPreis = 0;
				for (var i = 0; i < halter.length; i++) {
					var realQty = halter[i].qty * qty;
					var halterEinzelPreis = this.getProductPrice(halter[i].hid, halter[i].vid, 'halter');
					var halterPreisInklRabatt = this.calculatePriceWithRabatt(halterEinzelPreis, realQty, 'product');
					halterGesamtPreis += (halterPreisInklRabatt * realQty);
				}
				preis = preis + halterGesamtPreis;
			}

			//	log('Preis inkl. Halter', preis);

			return API.round(preis, 2);
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
			return price;
		},
		calculatePriceWithRabatt: function (price, qty, type) {
			var sRabatt = this.rabatt.schild, pRabatt = this.rabatt.product, faktor = 1, aStk = 1, aFaktor = 1;
			if (type == 'schild') {
				for (var gr in sRabatt) {
					if ((parseFloat(price) >= parseFloat(sRabatt[gr].preisVon)) && (parseFloat(price) < parseFloat(sRabatt[gr].preisBis))) {
						for (var stk in sRabatt[gr].stkZahlen) {
							if ((parseInt(qty) >= parseInt(aStk)) && (parseInt(qty) < parseInt(stk))) {
								faktor = aFaktor;
							} else if ((parseInt(qty) >= 50) && (parseInt(stk) == 50)) {
								faktor = sRabatt[gr].stkZahlen[stk];
							}
							aFaktor = sRabatt[gr].stkZahlen[stk];
							aStk = stk;
						}
					}
				}
			} else if (type == 'product') {
				var priceToCompare = parseFloat(price) * parseFloat(qty);
				for (var gr in pRabatt) {
					if ((parseFloat(priceToCompare) >= parseFloat(pRabatt[gr].preisVon)) && (parseFloat(priceToCompare) < parseFloat(pRabatt[gr].preisBis))) {
						faktor = pRabatt[gr].rabatt;
					} else if ((parseFloat(priceToCompare) >= parseFloat(pRabatt[gr].preisVon)) && (parseInt(pRabatt[gr].preisBis) == -1)) {
						faktor = pRabatt[gr].rabatt;
					}
				}
			}
			return API.round((price * faktor), 2);
		}
	};

	var Cart = {
		adressen: [],
		userData: null,
		originalAdress: {
			person: '',
			firma: '',
			strasse: '',
			plz: '',
			ort: ''
		},
		data: {
			adresse: {
				rechnung: null,
				lieferung: null,
			},
			bemerkung: {
				kommission: null,
				bemerkung: null
			},
			versand: {
				art: null,
				preis: null
			},
			zahlung: {
				art: null
			}
		},
		getData: function () {
			return this.data;
		},
		setVersand: function (a, p) {
			this.data.versand.art = a;
			this.data.versand.preis = p;
		},
		setZahlung: function (z) {
			this.data.zahlung.art = z;
		},
		setKommission: function (k) {
			this.data.bemerkung.kommission = k;
		},
		setBemerkung: function (b) {
			this.data.bemerkung.bemerkung = b;
		},
		setLieferAdresse: function (id) {
			this.data.adresse.lieferung = id;
		},
		resetLieferAdresse: function () {
			this.data.adresse.lieferung = null;
		},
		initialize: function () {
			this.setUserData();
			this.setAdressen();
			this.setOriginalAdress();
		},
		setOriginalAdress: function () {
			this.originalAdress.person = $('#kasse-shipping-adress').find('input[name=person]').val();
			this.originalAdress.firma = $('#kasse-shipping-adress').find('input[name=firma]').val();
			this.originalAdress.strasse = $('#kasse-shipping-adress').find('input[name=adress]').val();
			this.originalAdress.plz = $('#kasse-shipping-adress').find('input[name=zip]').val();
			this.originalAdress.ort = $('#kasse-shipping-adress').find('input[name=city]').val();
		},
		getOriginalAdress: function () {
			return this.originalAdress;
		},
		setUserData: function () {
			var data = new Object();
			data.eID = 'ajaxDispatcher';
			data.request = {
				pluginName: 'Glacrylshop',
				controller: 'Aj',
				action: 'userAdress',
				arguments: {
					'uid': ''
				}
			};
			var adress = API.ajax('Manager', false, data, 'GET', 'json');
			this.userData = adress;
		},
		getUserData: function () {
			return this.userData;
		},
		setAdressen: function () {
			var data = new Object();
			data.eID = 'ajaxDispatcher';
			data.request = {
				pluginName: 'Glacrylshop',
				controller: 'Aj',
				action: 'userAdress',
				arguments: {
					'uid': ''
				}
			};

			var adressen = API.ajax('Manager', false, data, 'GET', 'json');

			for (var i = 0; i < adressen.length; i++) {
				var adr = new Adresse(adressen[i].uid, adressen[i].firma, adressen[i].person, adressen[i].strasse, adressen[i].plz, adressen[i].ort);
				this.adressen.push(adr);
			}
		},
		getAdress: function (uid) {
			for (var i = 0; i < this.adressen.length; i++) {
				if (this.adressen[i].uid == uid) {
					return this.adressen[i];
				}
			}
		},
		getAdressen: function () {
			return this.adressen;
		}
	};

	function Adresse(uid, firma, person, strasse, plz, ort) {
		this.uid = uid;
		this.firma = firma;
		this.person = person;
		this.strasse = strasse;
		this.plz = plz;
		this.ort = ort;
		this.getAdress = function () {
			return this;
		};
	}

	function Corner() {
		this.corner = ['ALLE', 'E1', 'E2', 'E3', 'E4'];
		var ALL = false;
		var E1 = false;
		var E2 = false;
		var E3 = false;
		var E4 = false;
		this.setCorner = function (corner) {
			switch (corner) {
				case 'ALLE':
					ALL = true;
					E1 = true;
					E2 = true;
					E3 = true;
					E4 = true;
					break;
				case 'E1':
					E1 = true;
					ALL = true;
					break;
				case 'E2':
					E2 = true;
					ALL = true;
					break;
				case 'E3':
					E3 = true;
					ALL = true;
					break;
				case 'E4':
					E4 = true;
					ALL = true;
					break;
			}
		};

		this.isCornerSet = function (corner) {
			switch (corner) {
				case 'ALLE':
					return ALL;
					break;
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
				case 'ALLE':
					ALL = false;
					E1 = false;
					E2 = false;
					E3 = false;
					E4 = false;
					break;
				case 'E1':
					E1 = false;
					if (!areSomeCornerSet()) {
						ALL = false;
					}
					break;
				case 'E2':
					E2 = false;
					if (!areSomeCornerSet()) {
						ALL = false;
					}
					break;
				case 'E3':
					E3 = false;
					if (!areSomeCornerSet()) {
						ALL = false;
					}
					break;
				case 'E4':
					E4 = false;
					if (!areSomeCornerSet()) {
						ALL = false;
					}
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
			return this;
		}
	};
	var Bearbeitungen = {
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
				this.setBearbeitung(1).setFacette(null).setAngle(null);
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
		editConfiguration: function (index, halter, variante, corner, x, y, qty) {
			var oldConfig = Halter.getConfiguration(index);
			var newConfig = Konfigurator.helper.getHalter(halter, variante);
			var bohrIndex = null;
			var dB = newConfig.variante.plattenbohrungUnterseite, m = 0, dS = 0;
			var senkungen = Konfigurator.data.senkungen;
			for (var i = 0; i < senkungen.length; i++) {
				if (parseFloat(senkungen[i].bohrung) == parseFloat(dB)) {
					m = parseFloat(senkungen[i].gewinde);
					dS = parseFloat(senkungen[i].senkung);
				}
			}
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
		dependencies: {
			kanten: [{
					uid: 1,
					material: [8, 11, 12]
				}, {
					uid: 2,
					material: [8, 11]
				}, {
					uid: 3,
					material: [8, 11, 12]
				}, {
					uid: 4,
					material: [8, 11]
				}, {
					uid: 5,
					material: [8, 11, 12]
				}, {
					uid: 6,
					material: [8, 11, 12]
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
			var data = new Object();
			data.eID = 'ajaxDispatcher';
			data.request = {
				pluginName: 'Glacrylshop',
				controller: 'Aj',
				action: 'ajax',
				arguments: {
					'uid': ''
				}
			};
			this.data = API.ajax('Manager', false, data, 'GET', 'json');
			while (!API.isset(this.data.senkungen[0])) {
				this.data = API.ajax('Manager', false, data, 'GET', 'json');
			}
			//log(this.data);
			return this;
		},
		createView: function () {
			View.initializeFrontEnd();
			return this;
		},
		resetKonfiguratorView: function () {
			Material.clearCurrentConfiguration();
			Bearbeitungen.Kanten.clearCurrentConfiguration();
			Bearbeitungen.Ecken.clearCurrentConfiguration(true);
			Bearbeitungen.Bohrungen.clearCurrentConfiguration(true);
			Bearbeitungen.Senkungen.clearCurrentConfiguration(true);
			Halter.clearCurrentConfiguration(true);
			this.resetKonfiguratorInputs();
			this.createView();
			$('#view-konfigurator-img').hide();
			$('#view-configuration-priceview').hide();
			return this;
		},
		resetKonfiguratorInputs: function () {
			$('#view-configuration-qty').val('1');
			$('#view-configuration-width').val('');
			$('#view-configuration-height').val('');
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
		prepareDataForImg: function () {
			var data = {
				configuration: Konfigurator.data,
				material: Material.getCurrentConfiguration(),
				materialConfig: Grundeinstellung.getCurrentConfiguration(),
				bearbeitungen: {
					kanten: Bearbeitungen.Kanten.getCurrentConfiguration(),
					ecken: Bearbeitungen.Ecken.getCurrentConfiguration(),
					bohrungen: Bearbeitungen.Bohrungen.getCurrentConfiguration(),
					senkungen: Bearbeitungen.Senkungen.getCurrentConfiguration()
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
					senkungen: Bearbeitungen.Senkungen.getCurrentConfiguration()
				},
				halter: Halter.getCurrentConfiguration()
			};
			return data;
		},
		helper: {
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
	var View = {
		initializeFrontEnd: function () {
			//ConfigurationView
			this.Configuration.createView.initialize();
			//Material
			this.Material.createMaterialAuswahl();
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
			this.Halter.mitBohrung.createHalterAuswahl();
			this.Halter.mitBohrung.createEckSelectionView();
			this.Halter.mitBohrung.createSelectionView();
			this.Halter.ohneBohrung.createHalterAuswahl();
			this.Halter.ohneBohrung.createSelectionView();
		},
		actions: {
			initializeFirst: function () {
				this.Configuration.initialize();
				this.Material.initialize();
				this.Bearbeitungen.initialize();
				this.Halter.initialize();
				this.Cart.initialize();
			},
			Cart: {
				initialize: function () {
					// Warenkorb
					$('body').on('click', '.cartItem-DetailBtn', View.actions.Cart.showDetailFunction);
					$('body').on('click', '.cart-change-qty', View.actions.Cart.updateCartPositionFunction);
					$('body').on('click', '.delete-position-Btn', View.actions.Cart.deletePositionFromCartFunction);
					// Kasse
					$('body').on('click', 'input[name="kasse-versand"]', View.actions.Cart.calculateDeliveryFunction);
					$('body').on('click', '#kasse-bestellenBtn', View.actions.Cart.orderFunction);
					$('body').on('click', '.selectDifferentShippingBtn', View.actions.Cart.selectDifferentAdressFuntion);
					$('body').on('click', '#different-adress-select', View.actions.Cart.selectShippingAdressFuntion);
					$('body').on('click', '#save-differentAdressBtn', View.actions.Cart.saveDifferentAdressFunction);
					$('body').on('click', '#abbr-differentAdressBtn', View.actions.Cart.cancelDifferentAdressFunction);
					$('body').on('click', '#choose-differentAdressBtn', View.actions.Cart.chooseDifferentAdressFunction);
				},
				cancelDifferentAdressFunction: function (e) {
					e.preventDefault();

					$('#kasse-shipping-adress').show();
					$('#kasse-different-adress').hide();
				},
				deletePositionFromCartFunction: function (e) {
					e.preventDefault();
					var posAction = $(this).attr('value');
					$(this).parent('form').find('input.positionAction').val(posAction);
					$(this).parent('form').submit();
				},
				updateCartPositionFunction: function (e) {
					e.preventDefault();
					var posAction = $(this).attr('value');
					$(this).parent('form').find('input.positionAction').val(posAction);
					$(this).parent('form').submit();
				},
				orderFunction: function (e) {
					e.preventDefault();
					var kommission = $('#kasse-kommission').val();
					var zahlung = 'rechnung';

					Cart.setZahlung(zahlung);
					Cart.setKommission(kommission);

					var data = new Object();
					data.eID = 'ajaxDispatcher';
					data.request = {
						pluginName: 'Glacrylshop',
						controller: 'Aj',
						action: 'placeOrder',
						arguments: {
							'data': Cart.getData(),
						}
					};

					log(data);

					var res = API.ajax('Manager', false, data, 'POST', 'json');

					if (res.error == true) {
						$('.kasse-success').show();
						$('.kasse-maske').hide();
					} else {
						$('.kasse-success').hide();
						$('.kasse-maske').show();
					}
				},
				chooseDifferentAdressFunction: function (e) {
					e.preventDefault;
					var selectedAdress = $('#different-adress-select').val(), adresse = null;

					if (selectedAdress == 'eigene') {
						Cart.resetLieferAdresse();
						adresse = Cart.getOriginalAdress();
					} else {
						Cart.setLieferAdresse(selectedAdress);
						adresse = Cart.getAdress(selectedAdress);
					}


					$('#kasse-shipping-company b').html(adresse.firma);
					$('#kasse-shipping-person').html(adresse.person);
					$('#kasse-shipping-street').html(adresse.strasse);
					$('#kasse-shipping-zip').html(adresse.plz);
					$('#kasse-shipping-city').html(adresse.ort);

					$('#kasse-shipping-adress').show();
					$('#kasse-different-adress').hide();
				},
				saveDifferentAdressFunction: function (e) {
					var firma = $('#different-firma').val();
					var person = $('#different-person').val();
					var strasse = $('#different-str').val();
					var plz = $('#different-plz').val();
					var ort = $('#different-ort').val();

					var data = new Object();
					data.eID = 'ajaxDispatcher';
					data.request = {
						pluginName: 'Glacrylshop',
						controller: 'Aj',
						action: 'saveLieferAdresse',
						arguments: {
							'abwFirma': firma,
							'abwPerson': person,
							'abwStrasse': strasse,
							'abwPlz': plz,
							'abwOrt': ort,
						}
					};

					var newAdr = API.ajax('Manager', false, data, 'POST', 'json');
					var adresse = new Adresse(newAdr.uid, newAdr.firma, newAdr.person, newAdr.strasse, newAdr.plz, newAdr.ort);
					Cart.adressen.push(adresse);
					$('#different-adress-select').append('<option value="' + newAdr.uid + '" title="' + newAdr.person + '">' + (newAdr.firma == '' ? newAdr.person : newAdr.firma) + '</option>');
					Cart.setLieferAdresse(newAdr.uid);

					$('#kasse-shipping-company b').html(adresse.firma);
					$('#kasse-shipping-person').html(adresse.person);
					$('#kasse-shipping-street').html(adresse.strasse);
					$('#kasse-shipping-zip').html(adresse.plz);
					$('#kasse-shipping-city').html(adresse.ort);

					$('#kasse-shipping-adress').show();
					$('#kasse-different-adress').hide();
				},
				selectShippingAdressFuntion: function (e) {
					e.preventDefault;
					var selectedAdress = $(this).val();
					if (selectedAdress == 'none') {
						$('#choose-differentAdressBtn').attr('style', 'display:none;');
						$('#save-differentAdressBtn').attr('style', 'display:inline-block;');

						$('#different-firma').val('').removeAttr('readonly');
						$('#different-person').val('').removeAttr('readonly');
						$('#different-str').val('').removeAttr('readonly');
						$('#different-plz').val('').removeAttr('readonly');
						$('#different-ort').val('').removeAttr('readonly');
					} else if (selectedAdress == 'eigene') {
						$('#choose-differentAdressBtn').attr('style', 'display:inline-block;');
						$('#save-differentAdressBtn').attr('style', 'display:none;');

						var adress = Cart.getOriginalAdress();

						$('#different-firma').val(adress.firma).attr('readonly', 'readonly');
						$('#different-person').val(adress.person).attr('readonly', 'readonly');
						$('#different-str').val(adress.strasse).attr('readonly', 'readonly');
						$('#different-plz').val(adress.plz).attr('readonly', 'readonly');
						$('#different-ort').val(adress.ort).attr('readonly', 'readonly');
					} else {
						$('#choose-differentAdressBtn').attr('style', 'display:inline-block;');
						$('#save-differentAdressBtn').attr('style', 'display:none;');

						var adressen = Cart.getAdressen();
						for (var i = 0; i < adressen.length; i++) {
							if (Number(adressen[i].uid) == Number(selectedAdress)) {
								$('#different-firma').val(adressen[i].firma).removeAttr('readonly');
								$('#different-person').val(adressen[i].person).removeAttr('readonly');
								$('#different-str').val(adressen[i].strasse).removeAttr('readonly');
								$('#different-plz').val(adressen[i].plz).removeAttr('readonly');
								$('#different-ort').val(adressen[i].ort).removeAttr('readonly');
							}
						}
					}
				},
				selectDifferentAdressFuntion: function (e) {
					e.preventDefault;
					$('#kasse-shipping-adress').hide();
					$('#kasse-different-adress').show();
				},
				calculateDeliveryFunction: function (e) {
					var versandArt = $(this).attr('id'), versand = 0, mwst = 0, brutto = 0, netto = parseFloat(API.commaToDot($('#kasse-netto span').html()));
					switch (versandArt) {
						case 'kasse-versand-abholung':
							mwst = (netto + versand) * 0.19;
							brutto = netto + versand + mwst;
							$('#kasse-versand span').html(API.priceView(versand));
							$('#kasse-mwst span').html(API.priceView(mwst));
							$('#kasse-brutto b span').html(API.priceView(brutto));
							Cart.setVersand('abholung', 0);
							break;
						case 'kasse-versand-standard':
							versand = parseFloat($('#kasse-standardversand-preis').val());
							mwst = (netto + versand) * 0.19;
							brutto = netto + versand + mwst;
							$('#kasse-versand span').html(API.priceView(versand));
							$('#kasse-mwst span').html(API.priceView(mwst));
							$('#kasse-brutto b span').html(API.priceView(brutto));
							Cart.setVersand('sandard', API.round(versand, 2));
							break;
						case 'kasse-versand-express':
							versand = parseFloat($('#kasse-expressversand-preis').val());
							mwst = (netto + versand) * 0.19;
							brutto = netto + versand + mwst;
							$('#kasse-versand span').html(API.priceView(versand));
							$('#kasse-mwst span').html(API.priceView(mwst));
							$('#kasse-brutto b span').html(API.priceView(brutto));
							Cart.setVersand('express', API.round(versand, 2));
							break;
					}
				},
				showDetailFunction: function (e) {
					e.preventDefault();
					var details = $(this).parent('td').parent('tr').next('tr');

					if (details.is(":visible")) {
						$(this).parent('td').parent('tr').find('td').each(function () {
							$(this).addClass('cell-bottom-border');
							details.find('td').each(function () {
								$(this).removeClass('cell-bottom-border');
							});
						});
					} else {
						$(this).parent('td').parent('tr').find('td').each(function () {
							$(this).removeClass('cell-bottom-border');
							details.find('td').each(function () {
								$(this).addClass('cell-bottom-border');
							});
						});
					}

					details.toggle();
				}
			},
			Configuration: {
				initialize: function () {
					$('body').on('click', '#addToCartBtn', View.actions.Configuration.addToCartFunction);
					$('body').on('click', '#minusQtyBtn', View.actions.Configuration.minusQtyFunction);
					$('body').on('click', '#plusQtyBtn', View.actions.Configuration.plusQtyFunction);
					$('body').on('keyup', '#view-configuration-qty', View.actions.Configuration.checkEnteredQtyFunction);
					$('body').on('keyup', '#view-configuration-width', View.actions.Configuration.drawImgFunction);
					$('body').on('keyup', '#view-configuration-height', View.actions.Configuration.drawImgFunction);
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
						Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
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
				addToCartFunction: function (e) {
					e.preventDefault();
					var cartPosition = Konfigurator.getDataForCart(), saved = false;

					//log(cartPosition);
					//var img = View.actions.Configuration.saveImgToServer('view-konfigurator-img');
					var img = $('#view-konfigurator-img').getCanvasImage("png");

					var preis = Price.calculatePrice();

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
					var saved = API.ajax('Manager', false, data, 'POST', 'json');

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
				},
				checkEnteredQtyFunction: function (e) {
					e.preventDefault();
					var qty = parseInt($(this).val());
					if (isNaN(qty)) {
						$(this).val(1);
						Grundeinstellung.setQty(1);
					} else if (qty == 0) {
						$(this).val(1);
						Grundeinstellung.setQty(1);
					} else {
						Grundeinstellung.setQty(qty);
						$(this).val(qty);
					}
					Price.createPriceView();
				},
				minusQtyFunction: function (e) {
					e.preventDefault();
					var qty = parseInt($('#view-configuration-qty').val()), newQty = 0;
					if (qty == 1) {
						newQty = qty;
					} else {
						newQty = --qty;
					}
					Grundeinstellung.setQty(newQty);
					$('#view-configuration-qty').val(newQty);
					Price.createPriceView();
				},
				plusQtyFunction: function (e) {
					e.preventDefault();
					e.preventDefault();
					var qty = parseInt($('#view-configuration-qty').val());
					if (qty == 99999) {
						qty = qty;
					} else {
						qty++;
					}
					Grundeinstellung.setQty(qty);
					$('#view-configuration-qty').val(qty);
					Price.createPriceView();
				}
			},
			Material: {
				initialize: function () {
					$('body').on('change', '#view-material-auswahl dd div select', View.actions.Material.changeMaterialFunction);
					$('body').on('click', '.addMaterialBtn', View.actions.Material.addMaterialFunction);
				},
				changeMaterialFunction: function (e) {
					e.preventDefault();
					var mId = $(this).parent('div').find('input[name="materialUid"]').val();
					var vId = $(this).val();
					var panelId = $(this).parent('div').attr('id').split('_');
					Material.setVariante(vId);
					View.Material.changeSizeView(panelId[1], mId, vId);
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
					var material = $('#view-material-auswahl').find('dd.active');
					var mId = material.find('div').find('input[name="materialUid"]').val();
					var vId = (API.isset(material.find('div').find('select').val()) ? material.find('div').find('select').val() : material.find('div').find('input[name="variantenUid"]').val());
					var size = material.find('div').find('div.row').find('div:first').find('input[name="dicke"]:checked').val();
					var width = $('#view-configuration-width');
					var height = $('#view-configuration-height');
					var errorField = $(this).parent('p').parent('div').parent('div').parent('div').find('div.error');
					var valid = true;

					valid = valid && Validate.emptyField({'Breite': width, 'H&ouml;he': height}, errorField);

					if (valid) {
						Material.setMaterial(mId).setVariante(vId).setSize(size);
						View.Bearbeitungen.Kanten.createKantenAuswahl();
						View.Halter.mitBohrung.createHalterAuswahl();
						View.Halter.ohneBohrung.createHalterAuswahl();
						View.Configuration.createView.insertMaterialView();
						Price.createPriceView();
						$('#view-configuration-priceview').show();
						Dispatcher.clearErrorFields(Dispatcher.Type.Halter).clearErrorFields(Dispatcher.Type.Bearbeitung);
					} else {
						e.preventDefault();
					}
				}
			},
			Bearbeitungen: {
				initialize: function () {
					$('body').on('change', '#view-kanten-auswahl select', View.actions.Bearbeitungen.changeAndSaveKantenAuswahlFunction);
					$('body').on('keyup', '#view-kanten-facette', View.actions.Bearbeitungen.addFacetteKantenFunction);
					$('body').on('change', '#view-kanten-angle', View.actions.Bearbeitungen.changeKantenAngleFunction);
					$('body').on('click', '#eckenAuswahlBox input[name="eckenAuswahlBox"]', View.actions.Bearbeitungen.eckenAuswahlFunction);
					$('body').on('click', '#view-addEckXY', View.actions.Bearbeitungen.addSchraegeEckeFunction);
					$('body').on('click', '#view-addEckRadius', View.actions.Bearbeitungen.addRundeEckeFunction);
					$('body').on('click', '.editEckenBtn', View.actions.Bearbeitungen.editEckenFunction);
					$('body').on('click', '.deleteEckenBtn', View.actions.Bearbeitungen.deleteEditEckenFunction);
					$('body').on('click', '.acceptEckenBtn', View.actions.Bearbeitungen.acceptEditEckenFunction);
					$('body').on('click', '.editBohrungenBtn', View.actions.Bearbeitungen.editBohrungenFunction);
					$('body').on('click', '.deleteBohrungenBtn', View.actions.Bearbeitungen.deleteEditBohrungenFunction);
					$('body').on('click', '.acceptBohrungenBtn', View.actions.Bearbeitungen.acceptEditBohrungenFunction);
					$('body').on('click', '.editSenkungenBtn', View.actions.Bearbeitungen.editSenkungenFunction);
					$('body').on('click', '.deleteSenkungenBtn', View.actions.Bearbeitungen.deleteEditSenkungenFunction);
					$('body').on('click', '.acceptSenkungenBtn', View.actions.Bearbeitungen.acceptEditSenkungenFunction);
					$('body').on('click', '#addBohrungenBtn', View.actions.Bearbeitungen.addBohrungFunction);
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
					Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
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
					if (radius != null) {
						edit = 2;
					} else {
						edit = 1;
					}
					//log(edit, corner, radius, x, y, oldCorner);
					Bearbeitungen.Ecken.editConfiguration(edit, corner, radius, x, y, oldCorner);
					//log(Bearbeitungen.Ecken.getCurrentConfiguration());
					View.Bearbeitungen.Ecken.createEckSelectionView();
					View.Bearbeitungen.Ecken.createSelectionView();
					View.Configuration.createView.insertEckenView();
					Price.createPriceView();
					Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
				},
				editEckenFunction: function (e) {
					e.preventDefault();
					var corner = ['ALLE', 'E1', 'E2', 'E3', 'E4'];
					var selection = $(this).parent('td').parent('tr').find('td');
					$.each(selection, function (i) {
						if (i == 0) {
							var text = $(this).text();
							var tmpl = '<select>';
							for (var i = 0; i < corner.length; i++) {
								tmpl += '<option ' + (corner[i] == text ? 'selected' : '') + ' value="' + corner[i] + '">' + corner[i] + '</option>';
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
				},
				deleteEditBohrungenFunction: function (e) {
					e.preventDefault();
					var index = $(this).parent('td').parent('tr').find('td:first').find('input[type=hidden]').val();
					Bearbeitungen.Bohrungen.removeConfiguration(index);
					View.Bearbeitungen.Bohrungen.createEckSelectionView();
					View.Bearbeitungen.Bohrungen.createSelectionView();
					View.Configuration.createView.insertBohrungView();
					Price.createPriceView();
					Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
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
							radius = $(this).find('input').val();
						} else if (i == 4) {
							$(this).find('.editBohrungenBtn').show();
							$(this).find('.deleteBohrungenBtn').show();
							$(this).find('.acceptBohrungenBtn').hide();
						}
					});
					Bearbeitungen.Bohrungen.editConfiguration(index, 1, corner, radius, x, y);
					View.Bearbeitungen.Bohrungen.createEckSelectionView();
					View.Bearbeitungen.Bohrungen.createSelectionView();
					View.Configuration.createView.insertBohrungView();
					Price.createPriceView();
					Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
				},
				editBohrungenFunction: function (e) {
					e.preventDefault();
					var corner = ['ALLE', 'E1', 'E2', 'E3', 'E4', 'FREI'];
					var selection = $(this).parent('td').parent('tr').find('td');
					$.each(selection, function (i) {
						if (i == 0) {
							var text = $(this).find('span').text();
							var index = $(this).find('input[type=hidden]').val();
							var tmpl = '<select>';
							for (var i = 0; i < corner.length; i++) {
								tmpl += '<option ' + (corner[i] == text ? 'selected' : '') + ' value="' + corner[i] + '">' + corner[i] + '</option>';
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
				},
				deleteEditSenkungenFunction: function (e) {
					e.preventDefault();
					var index = $(this).parent('td').parent('tr').find('td:first').find('input[type=hidden]').val();
					Bearbeitungen.Senkungen.removeConfiguration(index);
					View.Bearbeitungen.Senkungen.createEckSelectionView();
					View.Bearbeitungen.Senkungen.createSelectionView();
					View.Configuration.createView.insertSenkungView();
					Price.createPriceView();
					Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
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
					Bearbeitungen.Senkungen.editConfiguration(index, 2, corner, m, x, y);
					View.Bearbeitungen.Senkungen.createEckSelectionView();
					View.Bearbeitungen.Senkungen.createSelectionView();
					View.Configuration.createView.insertSenkungView();
					Price.createPriceView();
					Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
				},
				editSenkungenFunction: function (e) {
					e.preventDefault();
					var corner = ['ALLE', 'E1', 'E2', 'E3', 'E4', 'FREI'];
					var senkungen = Konfigurator.data.senkungen;
					var selection = $(this).parent('td').parent('tr').find('td');
					$.each(selection, function (i) {
						if (i == 0) {
							var text = $(this).find('span').text();
							var index = $(this).find('input[type=hidden]').val();
							var tmpl = '<select>';
							for (var i = 0; i < corner.length; i++) {
								tmpl += '<option ' + (corner[i] == text ? 'selected' : '') + ' value="' + corner[i] + '">' + corner[i] + '</option>';
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
							var tmpl = '<input type="text" maxlength="4" value="' + text + '" />'
							$(this).html(tmpl);
						}
					});
				},
				changeKantenAngleFunction: function (e) {
					e.preventDefault();
					$('#view-kanten-facette').val('');
				},
				changeAndSaveKantenAuswahlFunction: function (e) {
					if (typeof e != 'undefined')
						e.preventDefault();
					var src = Konfigurator.config.bearbeitungImgPfad, kanten = Konfigurator.data.kanten;
					var kId = parseInt($('#view-kanten-auswahl select').val());

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
									src += kanten[i].bild;
								}
							}
							$('#view-facceten-img-preview').attr('src', src);
							$('#view-facceten-img').attr('href', src);
						} else {
							$('#view-facetten-eigenschaften').hide();
							$('#view-kanten-eigenschaften').show();
							for (var i = 0; i < kanten.length; i++) {
								if (parseInt(kanten[i].uid) == kId) {
									src += kanten[i].bild;
								}
							}
							$('#view-kanten-img-preview').attr('src', src);
							$('#view-kanten-img').attr('href', src);
							Bearbeitungen.Kanten.setBearbeitung(kId);
							View.Configuration.createView.insertKantenView();
							Price.createPriceView();
							Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
						}
						View.Bearbeitungen.Ecken.createEckBearbeitungAuswahl();
						$('.view-eckbearbeitung-rund').hide();
						$('#view-ecken-img').hide();
					} else {
						Dispatcher.transition.ecken = eckenToDelete;
						$('#konfigurator-changeKanten-Dialog').dialog('open');
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
						Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
					}
				},
				eckenAuswahlFunction: function (e) {
					e.preventDefault();
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
					var ecken = Konfigurator.data.ecken, src = Konfigurator.config.bearbeitungImgPfad;
					for (var i = 0; i < ecken.length; i++) {
						if (parseInt(ecken[i].uid) == parseInt(eId)) {
							src += ecken[i].bild;
						}
					}
					$('#view-ecken-img').show().attr('href', src);
					$('#view-ecken-img-preview').show().attr('src', src);
				},
				addSchraegeEckeFunction: function (e) {
					e.preventDefault();
					var eId = $('#selectedEckBearbeitung').val();
					var x = $('#view-eckbearbeitung-x');
					var y = $('#view-eckbearbeitung-y');
					var cornerField = $('#eckenCheckBox');
					var errorField = cornerField.parent('div').parent('div').parent('div').find('div.error');
					var corner = cornerField.find('input[name="eckenCheckBox"]:checked').val();
					var valid = true;

					valid = valid && Validate.materialSet(errorField);
					if (!valid) {
						Dispatcher.addErrorField(Dispatcher.Type.Bearbeitung, errorField);
					}
					valid = valid && Validate.isRadioSelected(cornerField, errorField);
					valid = valid && Validate.checkRegexp(x, errorField);
					valid = valid && Validate.checkRegexp(y, errorField);

					if (valid) {
						Bearbeitungen.Ecken.addConfiguration(eId, corner, null, x.val(), y.val());
						View.Configuration.createView.insertEckenView();
						View.Bearbeitungen.Ecken.createEckSelectionView();
						View.Bearbeitungen.Ecken.createSelectionView();
						Price.createPriceView();
						Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
					}
				},
				addRundeEckeFunction: function (e) {
					e.preventDefault();
					var eId = $('#selectedEckBearbeitung').val();
					var x = null;
					var y = null;
					var cornerField = $('#eckenCheckBox');
					var corner = cornerField.find('input[name="eckenCheckBox"]:checked').val();
					var radius = $('#view-eckbearbeitung-radius');
					var errorField = cornerField.parent('div').parent('div').parent('div').find('div.error');
					var valid = true;

					valid = valid && Validate.materialSet(errorField);
					if (!valid) {
						Dispatcher.addErrorField(Dispatcher.Type.Bearbeitung, errorField);
					}
					valid = valid && Validate.isRadioSelected(cornerField, errorField);
					valid = valid && Validate.checkRegexp(radius, errorField);
					valid = valid && Validate.checkEckRadius(radius, false, errorField);

					if (valid) {
						Bearbeitungen.Ecken.addConfiguration(eId, corner, radius.val(), x, y);
						View.Configuration.createView.insertEckenView();
						View.Bearbeitungen.Ecken.createEckSelectionView();
						View.Bearbeitungen.Ecken.createSelectionView();
						Price.createPriceView();
						Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
					}
				},
				addBohrungFunction: function (e) {
					e.preventDefault();
					var d = $('#view-bohrungen-d');
					var x = $('#view-bohrungen-x');
					var y = $('#view-bohrungen-y');
					var cornerField = $('#bohrungenCheckBox');
					var corner = cornerField.find('input[name="bohrungenCheckBox"]:checked').val();
					var errorField = cornerField.parent('div').parent('div').parent('div').find('div.error');
					var valid = true;
					valid = valid && Validate.materialSet(errorField);
					if (!valid) {
						Dispatcher.addErrorField(Dispatcher.Type.Bearbeitung, errorField);
					}
					valid = valid && Validate.isRadioSelected(cornerField, errorField);
					valid = valid && Validate.checkRegexp(d, errorField);
					valid = valid && Validate.checkRegexp(x, errorField);
					valid = valid && Validate.checkRegexp(y, errorField);

					if (valid) {
						Bearbeitungen.Bohrungen.addConfiguration(1, corner, d.val(), x.val(), y.val());
						View.Configuration.createView.insertBohrungView();
						View.Bearbeitungen.Bohrungen.createEckSelectionView();
						View.Bearbeitungen.Bohrungen.createSelectionView();
						Price.createPriceView();
						Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
					}
				},
				addSenkungFunction: function (e) {
					e.preventDefault();
					var m = $('#view-senkungen-m').val();
					var x = $('#view-senkungen-x');
					var y = $('#view-senkungen-y');
					var dB = 0, dS = 0;
					var cornerField = $('#senkungenCheckBox');
					var corner = cornerField.find('input[name="senkungenCheckBox"]:checked').val();
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
					valid = valid && Validate.isRadioSelected(cornerField, errorField);
					valid = valid && Validate.checkRegexp(x, errorField);
					valid = valid && Validate.checkRegexp(y, errorField);

					if (valid) {
						Bearbeitungen.Senkungen.addConfiguration(2, corner, m, dB, dS, x.val(), y.val());
						View.Configuration.createView.insertSenkungView();
						View.Bearbeitungen.Senkungen.createEckSelectionView();
						View.Bearbeitungen.Senkungen.createSelectionView();
						Price.createPriceView();
						Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
					}
				}
			},
			Halter: {
				initialize: function () {
					$('body').on('change', '#view-halterMitBohrung-auswahl select', View.actions.Halter.changeHalterMitBohrungAuswahlFunction);
					$('body').on('click', '#addHalterMitBohrungBtn', View.actions.Halter.addHalterMitBohrungFunction);
					$('body').on('click', '.editHalterBtn', View.actions.Halter.editHalterFunction);
					$('body').on('click', '.deleteHalterBtn', View.actions.Halter.deleteEditHalterFunction);
					$('body').on('click', '.acceptHalterBtn', View.actions.Halter.acceptEditHalterFunction);
					$('body').on('change', '#view-halterMitBohrung-selection table tbody tr td select.hSelect', View.actions.Halter.changeEditHalterSelectFunction);
					$('body').on('change', '#view-halterOhneBohrung-selection table tbody tr td select.hSelect', View.actions.Halter.changeEditHalterSelectFunction);
					$('body').on('change', '#view-halterOhneBohrung-auswahl select', View.actions.Halter.changeHalterOhneBohrungAuswahlFunction);
					$('body').on('click', '#addHalterOhneBohrungBtn', View.actions.Halter.addHalterOhneBohrungFunction);
				},
				changeEditHalterSelectFunction: function (e) {
					e.preventDefault();
					var halter = Konfigurator.data.halter;
					var hId = $(this).val();
					var tmpl = '';
					for (var i = 0; i < halter.length; i++) {
						if (halter[i].uid == hId) {
							if (halter[i].varianten.length > 1) {
								for (var j = 0; j < halter[i].varianten.length; j++) {
									tmpl += '<option value="' + halter[i].varianten[j].uid + '">' + halter[i].varianten[j].name + '</option>';
								}
								$(this).parent('td').find('select.vSelect').html(tmpl);
							} else {
								$(this).parent('td').find('input.vSelect').val(halter[i].varianten[0].uid);
								$(this).parent('td').find('span').html(halter[i].varianten[0].name);
							}
						}
					}
				},
				deleteEditHalterFunction: function (e) {
					e.preventDefault();
					var index = $(this).parent('td').parent('tr').find('td:first').find('input[type=hidden]').val();

					var ctxOhne = false;

					var halter = Halter.getConfiguration(index);

					if (halter.hid == 7) {
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
					Price.createPriceView();
					Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
				},
				acceptEditHalterFunction: function (e) {
					e.preventDefault();
					var selection = $(this).parent('td').parent('tr').find('td');
					var x = null, y = null, halter = null, variante = null, corner = null, index = null, qty = null;
					var ctxOhne = false;

					if (selection.parent('tr').parent('tbody').parent('table').find('thead>tr>th').length == 3) {
						ctxOhne = true;
					}

					$.each(selection, function (i) {
						if (i == 0) {
							if (!ctxOhne) {
								corner = $(this).find('select').val();
							} else {
								qty = $(this).find('input[type=text]').val();
							}
							index = parseInt($(this).find('input[type=hidden]').val());
						} else if ((i == 1) && (!ctxOhne)) {
							x = $(this).find('input').val();
						} else if ((i == 2) && (!ctxOhne)) {
							y = $(this).find('input').val();
						} else if ((i == 3) || ((i == 1) && (ctxOhne))) {
							halter = $(this).find('.hSelect').val();
							variante = $(this).find('.vSelect').val();
						} else if ((i == 4) || ((i == 2) && (ctxOhne))) {
							$(this).find('.editHalterBtn').show();
							$(this).find('.deleteHalterBtn').show();
							$(this).find('.acceptHalterBtn').hide();
						}
					});

					Halter.editConfiguration(index, halter, variante, corner, x, y, qty);

					if (!ctxOhne) {
						View.Halter.mitBohrung.createEckSelectionView();
						View.Halter.mitBohrung.createSelectionView();
					} else {
						View.Halter.ohneBohrung.createSelectionView();
					}
					View.Configuration.createView.insertHalterView();
					View.Configuration.createView.insertSenkungView();
					View.Configuration.createView.insertBohrungView();
					Price.createPriceView();
					Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
				},
				editHalterFunction: function (e) {
					e.preventDefault();
					var ctxOhne = false;
					if ($(this).parent('td').parent('tr').parent('tbody').parent('table').find('thead>tr>th').length == 3) {
						ctxOhne = true;
					}
					var corner = ['ALLE', 'E1', 'E2', 'E3', 'E4', 'FREI'];
					var selection = $(this).parent('td').parent('tr').find('td');
					var halter = Konfigurator.data.halter;
					$.each(selection, function (i) {
						if (i == 0) {
							var tmpl = '';
							var text = $(this).find('span').text();
							var index = $(this).find('input[type=hidden]').val();
							if (!ctxOhne) {
								tmpl += '<select>';
								for (var i = 0; i < corner.length; i++) {
									tmpl += '<option ' + (corner[i] == text ? 'selected' : '') + ' value="' + corner[i] + '">' + corner[i] + '</option>';
								}
								tmpl += '</select>';
							} else {
								tmpl += '<input type="text" maxlength="4" value="' + text + '" />';
							}
							tmpl += '<input type="hidden" value="' + index + '" />';
							$(this).html(tmpl);
						} else if ((i == 3) || ((i == 1) && (ctxOhne))) {
							var hId = $(this).find('input.hId').val();
							var vId = $(this).find('input.vId').val();
							var tmpl = '<select class="hSelect">';
							for (var j = 0; j < halter.length; j++) {
								var show = true;
								for (var k = 0; k < halter[j].varianten.length; k++) {
									if ((halter[j].varianten[k].position == 'kante') && (!ctxOhne)) {
										show = false;
									} else if ((halter[j].varianten[k].position != 'kante') && (ctxOhne)) {
										show = false;
									} else if ((halter[j].varianten[k].position == 'kante') && (ctxOhne)) {
										show = true;
									}
								}
								if (show) {
									tmpl += '<option ' + (halter[j].uid == hId ? 'selected' : '') + ' value="' + halter[j].uid + '">' + halter[j].name + '</option>';
								}
							}
							tmpl += '</select>';
							for (var j = 0; j < halter.length; j++) {
								if (halter[j].uid == hId) {
									if (halter[j].varianten.length > 1) {
										tmpl += '<select class="vSelect">';
										for (var k = 0; k < halter[j].varianten.length; k++) {
											tmpl += '<option ' + (halter[j].varianten[k].uid == vId ? 'selected' : '') + ' value="' + halter[j].varianten[k].uid + '">' + halter[j].varianten[k].name + '</option>'
										}
										tmpl += '</select>';
									} else {
										tmpl += '<input type="hidden" value="' + halter[j].varianten[0].uid + '" class="vSelect" />';
										tmpl += '<span>' + halter[j].varianten[0].name + '</span>';
									}
								}
							}
							$(this).html(tmpl);
						} else if ((i == 4) || ((i == 2) && (ctxOhne))) {
							$(this).find('.acceptHalterBtn').show();
							$(this).find('.editHalterBtn').hide();
							$(this).find('.deleteHalterBtn').hide();
						} else if ((i != 4) && (!ctxOhne)) {
							var text = $(this).text();
							var tmpl = '<input type="text" maxlength="4" value="' + text + '" />'
							$(this).html(tmpl);
						}
					});
				},
				changeHalterMitBohrungAuswahlFunction: function (e) {
					e.preventDefault();
					var hId = $(this).val();
					View.Halter.createHalterVariantenAuswahl(hId, 'view-halterMitBohrung-varianten');
					var halter = Konfigurator.data.halter, src = Konfigurator.config.halterImgPfad;
					for (var i = 0; i < halter.length; i++) {
						if (parseInt(halter[i].uid) == parseInt(hId)) {
							src += halter[i].varianten[0].bild;
						}
					}
					$('#view-halterMitBohrung-Img').attr('href', src);
					$('#view-halterMitBohrung-Img-preview').attr('src', src);
				},
				addHalterMitBohrungFunction: function (e) {
					e.preventDefault();
					var hId = $('#view-halterMitBohrung-auswahl select').val();
					var vId = $('#view-halterMitBohrung-variantenId').val();
					var cornerField = $('#halterMitBohrungCheckBox');
					var corner = cornerField.find('input[name="halterMitBohrungCheckBox"]:checked').val();
					var x = $('#view-halterMitBohrung-x');
					var y = $('#view-halterMitBohrung-y');
					var errorField = cornerField.parent('div').parent('div').parent('div').find('div.error');
					var valid = true;

					valid = valid && Validate.materialSet(errorField);
					if (!valid) {
						Dispatcher.addErrorField(Dispatcher.Type.Halter, errorField);
					}
					valid = valid && Validate.isRadioSelected(cornerField, errorField);
					valid = valid && Validate.checkRegexp(x, errorField);
					valid = valid && Validate.checkRegexp(y, errorField);

					if (valid) {
						var halter = Konfigurator.helper.getHalter(hId, vId);
						var bohrIndex = null;
						if (hId == 7) {
							var dB = halter.variante.plattenbohrungUnterseite, dS = 0, m = 0;
							var senkungen = Konfigurator.data.senkungen;
							for (var i = 0; i < senkungen.length; i++) {
								if (parseFloat(senkungen[i].bohrung) == parseFloat(dB)) {
									m = parseFloat(senkungen[i].gewinde);
									dS = parseFloat(senkungen[i].senkung);
								}
							}
							bohrIndex = Bearbeitungen.Senkungen.addConfiguration(2, corner, m, dB, dS, x.val(), y.val(), null, true);
						} else {
							var dB = halter.variante.plattenbohrungUnterseite;
							bohrIndex = Bearbeitungen.Bohrungen.addConfiguration(1, corner, dB, x.val(), y.val(), null, true);
						}

						Halter.addConfiguration(hId, vId, corner, x.val(), y.val(), null, null, bohrIndex);

						View.Configuration.createView.insertHalterView();
						View.Configuration.createView.insertSenkungView();
						View.Configuration.createView.insertBohrungView();
						View.Halter.mitBohrung.createEckSelectionView();
						View.Halter.mitBohrung.createSelectionView();
						Price.createPriceView();
						Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
					}
				},
				changeHalterOhneBohrungAuswahlFunction: function (e) {
					e.preventDefault();
					var hId = $(this).val();
					View.Halter.createHalterVariantenAuswahl(hId, 'view-halterOhneBohrung-varianten');
				}, addHalterOhneBohrungFunction: function (e) {
					e.preventDefault();
					var hId = $('#view-halterOhneBohrung-auswahl select').val();
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
						Konfigurator.schild.initialize('view-konfigurator-img', Konfigurator.prepareDataForImg()).draw();
					}
				}
			}
		},
		Material: {
			createMaterialAuswahl: function () {
				var material = Konfigurator.data.material;
				var tmpl = '';
				for (var i = 0; i < material.length; i++) {
					var panelId = API.createRandomNumber();
					tmpl += '<dd class="' + (i == (material.length - 1) ? 'last' : '') + '">';
					tmpl += '<a href="#panel_' + panelId + '">' + material[i].name + ' <span class="right info-icon mat">i</span></a>';
					tmpl += '<div id="panel_' + panelId + '" class="content">';
					tmpl += '<div class="error"></div>';
					tmpl += '<input type="hidden" name="materialUid" value="' + material[i].uid + '" />';
					if (material[i].varianten.length == 1) {
						tmpl += '<input type="hidden" value="' + material[i].varianten[0].uid + '" name="variantenUid" />';
						tmpl += '<p style="padding: 0 0 0 16px; margin-bottom: 0px;">' + material[i].varianten[0].name + '</p>';
					} else {
						tmpl += '<select>';
						for (var j = 0; j < material[i].varianten.length; j++) {
							tmpl += '<option value="' + material[i].varianten[j].uid + '" ' + (material[i].varianten.length == 1 ? 'selected' : '') + '>' + material[i].varianten[j].name + '</option>';
						}
						tmpl += '</select>';
					}
					tmpl += '<div class="row">';
					tmpl += '<div id="sizeAuswahl_' + panelId + '" class="large-6 columns view-material-size">';
					for (var k = 0; k < material[i].varianten[0].formen.length; k++) {
						var randomId = API.createRandomNumber();
						tmpl += '<p><input class="addMaterialBtn" id="size_' + randomId + '" type="radio" name="dicke" value="' + material[i].varianten[0].formen[k].dicke + '"><label for="size_' + randomId + '">' + material[i].varianten[0].formen[k].dicke + ' mm</label></p>';
					}
					tmpl += '</div>';
					tmpl += '<div class="large-6 columns materialImg">';
					tmpl += '<a href="' + Konfigurator.config.materialImgPfad + material[i].varianten[0].bild + '" data-lightbox="material' + panelId + '" data-title="' + material[i].name + '" >';
					tmpl += '<img src="' + Konfigurator.config.materialImgPfad + material[i].varianten[0].bild + '" />';
					tmpl += '</a>';
					tmpl += '</div>';
					tmpl += '</div>';
					tmpl += '</div>';
					tmpl += '</dd>';
				}
				$('#view-material-auswahl').html(tmpl);
			},
			changeSizeView: function (panelId, mId, vId) {
				var material = Konfigurator.data.material;
				var tmpl = '';
				for (var i = 0; i < material.length; i++) {
					if (material[i].uid == mId) {
						for (var j = 0; j < material[i].varianten.length; j++) {
							if (material[i].varianten[j].uid == vId) {
								for (var k = 0; k < material[i].varianten[j].formen.length; k++) {
									var randomId = API.createRandomNumber();
									tmpl += '<p><input  class="addMaterialBtn" id="size_' + randomId + '" type="radio" name="dicke" value="' + material[i].varianten[j].formen[k].dicke + '"><label for="size_' + randomId + '">' + material[i].varianten[j].formen[k].dicke + ' mm</label></p>';
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
					var kanten = Konfigurator.data.kanten, src = Konfigurator.config.bearbeitungImgPfad, srcSet = false;
					var tmpl = '';
					tmpl += '<select>';
					for (var i = 0; i < kanten.length; i++) {
						if (this.bearbeitungErlaubt(kanten[i].uid)) {
							tmpl += '<option value="' + kanten[i].uid + '">' + kanten[i].name + '</option>';
							if (!srcSet) {
								src += kanten[i].bild;
								srcSet = true;
							}
						}
					}
					tmpl += '</select>';
					$('#view-kanten-auswahl').html(tmpl);
					$('#view-kanten-img-preview').attr('src', src);
					$('#view-kanten-img').attr('href', src);

					$('#view-facetten-eigenschaften').hide();
				},
				bearbeitungErlaubt: function (kId) {
					var dependencies = Konfigurator.dependencies.kanten;
					var material = Material.getCurrentConfiguration();
					if (material.uid != null) {
						for (var i = 0; i < dependencies.length; i++) {
							if (dependencies[i].uid == kId) {
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
					var tmpl = '';
					tmpl += '<div id="eckenAuswahlBox">';
					for (var i = 0; i < ecken.length; i++) {
						tmpl += '<input type="radio" value="' + ecken[i].uid + '" name="eckenAuswahlBox" id="eckenAuswahlBox' + i + '"><label for="eckenAuswahlBox' + i + '">' + ecken[i].name + '</label>';
					}
					tmpl += '<input type="hidden" id="selectedEckBearbeitung" value="" />';
					tmpl += '</div>';
					$('#view-ekcen-auswahl').html(tmpl);
					$('#eckenAuswahlBox').buttonset();
					this.switchSelection();
				},
				switchSelection: function () {
					var kanten = Bearbeitungen.Kanten.getCurrentConfiguration();
					var ecken = Konfigurator.data.ecken;
					//$('#eckenAuswahlBox').buttonset();
					if (kanten.uid != null) {
						for (var i = 0; i < ecken.length; i++) {
							if (Konfigurator.helper.isEckeForKanteEnabled(ecken[i].uid, kanten.uid)) {
								$('#eckenAuswahlBox').find('input[value=' + ecken[i].uid + ']').button("enable");
							} else {
								//log($('#eckenAuswahlBox').find('input[value=' + ecken[i].uid + ']'));
								//$('#eckenAuswahlBox').find('input[value=' + ecken[i].uid + ']').button("disable");
								$('#eckenAuswahlBox').find('input[value=' + ecken[i].uid + ']').button("option", "disabled", true);
							}
						}
						$('#eckenAuswahlBox').buttonset();

					}
				},
				createEckSelectionView: function () {
					var corner = Bearbeitungen.Ecken.corner;
					var tmpl = '';
					tmpl += '<div id="eckenCheckBox">';
					for (var i = 0; i < corner.corner.length; i++) {
						tmpl += '<input value="' + corner.corner[i] + '" type="radio" name="eckenCheckBox" id="eckenCheckBox' + i + '"><label for="eckenCheckBox' + i + '">' + corner.corner[i] + '</label>';
					}
					tmpl += '</div>';
					$('#view-ecken-eckAuswahl').html(tmpl);
					$('#eckenCheckBox').buttonset();
					var buttons = $('#eckenCheckBox input');
					$.each(buttons, function () {
						var cornerName = $(this).button("option", "label");
						if (corner.isCornerSet(cornerName)) {
							$(this).button("disable");
						}
					});
				},
				createSelectionView: function () {
					var selection = Bearbeitungen.Ecken.getCurrentConfiguration();
					var tmpl = '';
					tmpl += '<table>';
					tmpl += '<colgroup>';
					tmpl += '<col width="1*">';
					tmpl += '<col width="30">';
					tmpl += '<col width="30">';
					tmpl += '<col width="1*">';
					tmpl += '<col width="65">';
					tmpl += '</colgroup>';
					tmpl += '<thead>';
					tmpl += '<tr>';
					tmpl += '<th width="20">Ecke(n)</th>';
					tmpl += '<th width="10">X</th>';
					tmpl += '<th width="10">Y</th>';
					tmpl += '<th width="10">Radius</th>';
					tmpl += '<th>Aktion</th>';
					tmpl += '</tr>';
					tmpl += '</thead>';
					tmpl += '<tbody>';
					for (var i = 0; i < selection.length; i++) {
						tmpl += '<tr>';
						tmpl += '<td>' + selection[i].corner + '</td>';
						tmpl += '<td>' + (selection[i].x != null ? selection[i].x : ' - ') + '</td>';
						tmpl += '<td>' + (selection[i].y != null ? selection[i].y : ' - ') + '</td>';
						tmpl += '<td>' + (selection[i].radius != null ? selection[i].radius : ' - ') + '</td>';
						tmpl += '<td><span class="sprite-Stift editEckenBtn"></span><span class="sprite-Loeschen deleteEckenBtn"></span><span class="sprite-Bestaetigen acceptEckenBtn"></span></td>';
						tmpl += '</tr>';
					}
					tmpl += '</tbody>';
					tmpl += '</table>';
					tmpl += '</div>';
					$('#view-ecken-selection').html(tmpl);
					$('.acceptEckenBtn').hide();
				}
			},
			Bohrungen: {
				iniBohrungView: function () {
					var bohrungen = Konfigurator.data.bohrungen, src = Konfigurator.config.bearbeitungImgPfad;
					for (var i = 0; i < bohrungen.length; i++) {
						if (bohrungen[i].uid == 1) {
							src += bohrungen[i].bild;
						}
					}
					$('#view-bohrung-img').attr('href', src);
					$('#view-bohrung-img-preview').attr('src', src);
				},
				createEckSelectionView: function () {
					var corner = Bearbeitungen.Bohrungen.corner;
					var tmpl = '';
					tmpl += '<div id="bohrungenCheckBox">';
					for (var i = 0; i < corner.corner.length; i++) {
						tmpl += '<input type="radio" name ="bohrungenCheckBox" id="bohrungenCheckBox' + i + '" value="' + corner.corner[i] + '"><label for="bohrungenCheckBox' + i + '">' + corner.corner[i] + '</label>';
					}
					tmpl += '<input type="radio" name="bohrungenCheckBox" id="bohrungenCheckBox' + (corner.corner.length + parseInt(1)) + '" value="FREI"><label for="bohrungenCheckBox' + (corner.corner.length + parseInt(1)) + '">FREI</label>';
					tmpl += '</div>';
					$('#view-bohrungen-eckAuswahl').html(tmpl);
					$('#bohrungenCheckBox').buttonset();
					var buttons = $('#bohrungenCheckBox input');
					$.each(buttons, function () {
						var cornerName = $(this).button("option", "label");
						if (corner.isCornerSet(cornerName)) {
							$(this).button("disable");
						}
					});
				},
				createSelectionView: function () {
					var selection = Bearbeitungen.Bohrungen.getCurrentConfiguration();
					var tmpl = '';
					tmpl += '<table>';
					tmpl += '<colgroup>';
					tmpl += '<col width="1*">';
					tmpl += '<col width="30">';
					tmpl += '<col width="30">';
					tmpl += '<col width="1*">';
					tmpl += '<col width="65">';
					tmpl += '</colgroup>';
					tmpl += '<thead>';
					tmpl += '<tr>';
					tmpl += '<th width="20">Ecke(n)</th>';
					tmpl += '<th width="10">X</th>';
					tmpl += '<th width="10">Y</th>';
					tmpl += '<th width="10">Radius</th>';
					tmpl += '<th>Aktion</th>';
					tmpl += '</tr>';
					tmpl += '</thead>';
					tmpl += '<tbody>';
					for (var i = 0; i < selection.length; i++) {
						tmpl += '<tr>';
						tmpl += '<td><input type="hidden" value="' + selection[i].index + '" /><span>' + selection[i].corner + '</span></td>';
						tmpl += '<td>' + (selection[i].x != null ? selection[i].x : ' - ') + '</td>';
						tmpl += '<td>' + (selection[i].y != null ? selection[i].y : ' - ') + '</td>';
						tmpl += '<td>' + (selection[i].dB != null ? selection[i].dB : ' - ') + '</td>';
						tmpl += '<td><span class="sprite-Stift editBohrungenBtn"></span><span class="sprite-Loeschen deleteBohrungenBtn"></span><span class="sprite-Bestaetigen acceptBohrungenBtn"></span></td>';
						tmpl += '</tr>';
					}
					tmpl += '</tbody>';
					tmpl += '</table>';
					tmpl += '</div>';
					$('#view-bohrungen-selection').html(tmpl);
					$('.acceptBohrungenBtn').hide();
				}
			},
			Senkungen: {
				iniSenkungView: function () {
					var bohrungen = Konfigurator.data.bohrungen, src = Konfigurator.config.bearbeitungImgPfad;
					for (var i = 0; i < bohrungen.length; i++) {
						if (bohrungen[i].uid == 2) {
							src += bohrungen[i].bild;
						}
					}
					$('#view-senkung-img-preview').attr('src', src);
					$('#view-senkung-img').attr('href', src);
				},
				createSchraubenMView: function () {
					var senkungen = Konfigurator.data.senkungen;
					var tmpl = '';
					tmpl += '<label for="view-senkungen-m"  style="font-size: 11pt ! important; margin: -6px 0px 5px;">Für Gewindeschrauben</label>';
					tmpl += '<label style="display:inline-block;">M</label> <select style="display:inline-block; width:88%;" id="view-senkungen-m">';
					for (var i = 0; i < senkungen.length; i++) {
						tmpl += '<option valu="' + Number(senkungen[i].gewinde) + '">' + Number(senkungen[i].gewinde) + '</option>';
					}
					tmpl += '</select>';

					$('#view-senkungen-schrauben').html(tmpl);
				},
				createEckSelectionView: function () {
					var corner = Bearbeitungen.Senkungen.corner;
					var tmpl = '';
					tmpl += '<div id="senkungenCheckBox">';
					for (var i = 0; i < corner.corner.length; i++) {
						tmpl += '<input type="radio" name ="senkungenCheckBox" id="senkungenCheckBox' + i + '" value="' + corner.corner[i] + '"><label for="senkungenCheckBox' + i + '">' + corner.corner[i] + '</label>';
					}
					tmpl += '<input type="radio" name="senkungenCheckBox" id="senkungenCheckBox' + (corner.corner.length + parseInt(1)) + '" value="FREI"><label for="senkungenCheckBox' + (corner.corner.length + parseInt(1)) + '">FREI</label>';
					tmpl += '</div>';
					$('#view-senkungen-eckAuswahl').html(tmpl);
					$('#senkungenCheckBox').buttonset();
					var buttons = $('#senkungenCheckBox input');
					$.each(buttons, function () {
						var cornerName = $(this).button("option", "label");
						if (corner.isCornerSet(cornerName)) {
							$(this).button("disable");
						}
					});
				},
				createSelectionView: function () {
					var selection = Bearbeitungen.Senkungen.getCurrentConfiguration();
					var tmpl = '';
					tmpl += '<table>';
					tmpl += '<colgroup>';
					tmpl += '<col width="1*">';
					tmpl += '<col width="30">';
					tmpl += '<col width="30">';
					tmpl += '<col width="30">';
					tmpl += '<col width="65">';
					tmpl += '</colgroup>';
					tmpl += '<thead>';
					tmpl += '<tr>';
					tmpl += '<th width="20">Ecke(n)</th>';
					tmpl += '<th width="10">X</th>';
					tmpl += '<th width="10">Y</th>';
					tmpl += '<th width="10">M</th>';
					tmpl += '<th>Aktion</th>';
					tmpl += '</tr>';
					tmpl += '</thead>';
					tmpl += '<tbody>';
					for (var i = 0; i < selection.length; i++) {
						tmpl += '<tr>';
						tmpl += '<td><input type="hidden" value="' + selection[i].index + '" /><span>' + selection[i].corner + '</span></td>';
						tmpl += '<td>' + (selection[i].x != null ? selection[i].x : ' - ') + '</td>';
						tmpl += '<td>' + (selection[i].y != null ? selection[i].y : ' - ') + '</td>';
						tmpl += '<td>' + (selection[i].m != null ? selection[i].m : ' - ') + '</td>';
						tmpl += '<td><span class="sprite-Stift editSenkungenBtn"></span><span class="sprite-Loeschen deleteSenkungenBtn"></span><span class="sprite-Bestaetigen acceptSenkungenBtn"></span></td>';
						tmpl += '</tr>';
					}
					tmpl += '</tbody>';
					tmpl += '</table>';
					tmpl += '</div>';
					$('#view-senkungen-selection').html(tmpl);
					$('.acceptSenkungenBtn').hide();
				}
			}
		},
		Halter: {
			createHalterVariantenAuswahl: function (hId, divId) {
				var tmpl = '';
				var halter = Konfigurator.data.halter;
				for (var i = 0; i < halter.length; i++) {
					if (halter[i].uid == hId) {
						if (halter[i].varianten.length > 1) {
							tmpl += '<select id="' + divId + 'Id">';
							for (var j = 0; j < halter[i].varianten.length; j++) {
								tmpl += '<option value="' + halter[i].varianten[j].uid + '">' + halter[i].varianten[j].name + '</option>';
							}
							tmpl += '</select>';
						} else {
							tmpl += '<input id="' + divId + 'Id" type="hidden" value="' + halter[i].varianten[0].uid + '" />';
							tmpl += '<p style="font-family: Arial; font-size: 10pt; color: #444444;margin:-12px 0;">' + halter[i].varianten[0].name + '</p>';
						}
					}
				}
				$('#' + divId).html(tmpl);
			},
			mitBohrung: {
				createHalterAuswahl: function () {
					var halter = Konfigurator.data.halter, halterImgSrc = Konfigurator.config.halterImgPfad, imgSet = false;
					var tmpl = '';
					tmpl += '<select>';
					for (var i = 0; i < halter.length; i++) {
						if (this.istHalterErlaubt(halter[i].uid)) {
							tmpl += '<option value="' + halter[i].uid + '">' + halter[i].name + '</option>';
						}
					}
					tmpl += '</select><span class="info-icon-halter eHmB" style="vertical-align: middle;">i</span>';
					tmpl += '<div id="view-halterMitBohrung-varianten"></div>';
					if ($(tmpl).find('option').length == 0) {
						tmpl = '<p>Keine passenden Halter verf&uuml;gbar!</p>';
					}
					$('#view-halterMitBohrung-auswahl').html(tmpl);
					View.Halter.createHalterVariantenAuswahl($('#view-halterMitBohrung-auswahl select').val(), 'view-halterMitBohrung-varianten');
					var selectedHId = $('#view-halterMitBohrung-auswahl').find('select').val();
					for (var i = 0; i < halter.length; i++) {
						if (selectedHId == halter[i].uid) {
							halterImgSrc += halter[i].varianten[0].bild;
							imgSet = true;
						}
					}
					if (imgSet) {
						$('#view-halterMitBohrung-Img').attr('href', halterImgSrc);
						$('#view-halterMitBohrung-Img-preview').attr('src', halterImgSrc);
					}
				},
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
					tmpl += '<div id="halterMitBohrungCheckBox">';
					for (var i = 0; i < corner.corner.length; i++) {
						tmpl += '<input type="radio" name ="halterMitBohrungCheckBox" id="halterMitBohrungCheckBox' + i + '" value="' + corner.corner[i] + '"><label for="halterMitBohrungCheckBox' + i + '">' + corner.corner[i] + '</label>';
					}
					tmpl += '<input type="radio" name="halterMitBohrungCheckBox" id="halterMitBohrungCheckBox' + (corner.corner.length + parseInt(1)) + '" value="FREI"><label for="halterMitBohrungCheckBox' + (corner.corner.length + parseInt(1)) + '">FREI</label>';
					tmpl += '</div>';
					$('#view-halterMitBohrung-eckAuswahl').html(tmpl);
					$('#halterMitBohrungCheckBox').buttonset();
					var buttons = $('#halterMitBohrungCheckBox input');
					$.each(buttons, function () {
						var cornerName = $(this).button("option", "label");
						if (corner.isCornerSet(cornerName)) {
							$(this).button("disable");
						}
					});
				},
				createSelectionView: function () {
					var selection = Halter.getCurrentConfiguration();
					var halter = Konfigurator.data.halter;
					var tmpl = '';
					tmpl += '<table>';
					tmpl += '<colgroup>';
					tmpl += '<col width="1*">';
					tmpl += '<col width="30">';
					tmpl += '<col width="30">';
					tmpl += '<col width="1*">';
					tmpl += '<col width="65">';
					tmpl += '</colgroup>';
					tmpl += '<thead>';
					tmpl += '<tr>';
					tmpl += '<th width="20">Ecke(n)</th>';
					tmpl += '<th width="10">X</th>';
					tmpl += '<th width="10">Y</th>';
					tmpl += '<th width="10">Halter </th>';
					tmpl += '<th>Aktion</th>';
					tmpl += '</tr>';
					tmpl += '</thead>';
					tmpl += '<tbody>';
					for (var i = 0; i < selection.length; i++) {
						if (selection[i].corner != null) {
							tmpl += '<tr>';
							tmpl += '<td><input type="hidden" value="' + selection[i].index + '" /><span>' + selection[i].corner + '</span></td>';
							tmpl += '<td>' + selection[i].x + '</td>';
							tmpl += '<td>' + selection[i].y + '</td>';
							for (var j = 0; j < halter.length; j++) {
								if (halter[j].uid == selection[i].hid) {
									tmpl += '<td><input type="hidden" class="hId" value="' + selection[i].hid + '" /><input type="hidden" class="vId" value="' + selection[i].vid + '" />' + halter[j].name + '</td>';
								}
							}
							tmpl += '<td><span class="sprite-Stift editHalterBtn"></span><span class="sprite-Loeschen deleteHalterBtn"></span><span class="sprite-Bestaetigen acceptHalterBtn"></span></td>';
							tmpl += '</tr>';
						}
					}
					tmpl += '</tbody>';
					tmpl += '</table>';
					tmpl += '</div>';
					$('#view-halterMitBohrung-selection').html(tmpl);
					$('.acceptHalterBtn').hide();
				}
			},
			ohneBohrung: {
				createHalterAuswahl: function () {
					var halter = Konfigurator.data.halter, halterImgSrc = Konfigurator.config.halterImgPfad, imgSet = false;
					var tmpl = '';
					tmpl += '<select>';
					for (var i = 0; i < halter.length; i++) {
						if (this.istHalterErlaubt(halter[i].uid)) {
							tmpl += '<option value="' + halter[i].uid + '">' + halter[i].name + '</option>';
						}
					}
					tmpl += '</select><span class="info-icon-halter eHoB" style="vertical-align:middle;">i</span>';
					tmpl += '<div id="view-halterOhneBohrung-varianten"></div>';
					if ($(tmpl).find('option').length == 0) {
						tmpl = '<p>Keine passenden Halter verf&uuml;gbar!</p>';
						$('#view-halterOhneBohrung-Img').hide();
						$('#view-halterOhneBohrung-qty').parent('div').parent('div').hide();
					} else {
						$('#view-halterOhneBohrung-Img').show();
						$('#view-halterOhneBohrung-qty').parent('div').parent('div').show();
					}
					$('#view-halterOhneBohrung-auswahl').html(tmpl);
					View.Halter.createHalterVariantenAuswahl($('#view-halterOhneBohrung-auswahl select').val(), 'view-halterOhneBohrung-varianten');
					var selectedHId = $('#view-halterOhneBohrung-auswahl').find('select').val();
					for (var i = 0; i < halter.length; i++) {
						if (selectedHId == halter[i].uid) {
							halterImgSrc += halter[i].varianten[0].bild;
							imgSet = true;
						}
					}

					if (imgSet) {
						$('#view-halterOhneBohrung-Img').attr('href', halterImgSrc);
						$('#view-halterOhneBohrung-Img-preview').attr('src', halterImgSrc);
					}
				},
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
					tmpl += '<table>';
					tmpl += '<colgroup>';
					tmpl += '<col width="30">';
					tmpl += '<col width="1*">';
					tmpl += '<col width="65">';
					tmpl += '</colgroup>';
					tmpl += '<thead>';
					tmpl += '<tr>';
					tmpl += '<th width="10">Stk.</th>';
					tmpl += '<th width="10">Halter </th>';
					tmpl += '<th>Aktion</th>';
					tmpl += '</tr>';
					tmpl += '</thead>';
					tmpl += '<tbody>';
					for (var i = 0; i < selection.length; i++) {
						if (!API.isset(selection[i].corner)) {
							tmpl += '<tr>';
							tmpl += '<td><input type="hidden" value="' + selection[i].index + '" /><span>' + selection[i].qty + '</span></td>';
							for (var j = 0; j < halter.length; j++) {
								if (halter[j].uid == selection[i].hid) {
									tmpl += '<td><input type="hidden" class="hId" value="' + selection[i].hid + '" /><input type="hidden" class="vId" value="' + selection[i].vid + '" />' + halter[j].name + '</td>';
								}
							}
							tmpl += '<td><span class="sprite-Stift editHalterBtn"></span><span class="sprite-Loeschen deleteHalterBtn"></span><span class="sprite-Bestaetigen acceptHalterBtn"></span></td>';
							tmpl += '</tr>';
						}
					}
					tmpl += '</tbody>';
					tmpl += '</table>';
					tmpl += '</div>';
					$('#view-halterOhneBohrung-selection').html(tmpl);
					$('.acceptHalterBtn').hide();
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
						modal: true,
						buttons: {
							'Weiter einkaufen': function () {
								$(this).dialog("close");
							},
							'Zum Warenkorb': function () {
								$(this).dialog("close");
								var baseUrl = $('base').attr('href');
								var url = baseUrl + 'glacryl-shop/?tx_pdschildkonfigurator_flgkonfigurator%5Baction%5D=index&tx_pdschildkonfigurator_flgkonfigurator%5Bcontroller%5D=Warenkorb&cHash=62f03094ac894eaddd7104a1f6f02361';
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
										tmpl = material[i].name + ' ' + material[i].varianten[j].name;
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
					var size = Material.getCurrentConfiguration().size;
					var tmpl = 'keine';
					if ((grundEinstellung.height != null) && (grundEinstellung.width != null) && (size != null)) {
						tmpl = grundEinstellung.width + ' x ' + grundEinstellung.height + ' x ' + size + ' mm';
					} else if ((grundEinstellung.height != null) && (grundEinstellung.width != null) && (size == null)) {
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

	var Product = {
		View: {
			initializeFirst: function () {
				this.iniDialog();
			},
			iniDialog: function () {
				$('#products-success-Dialog').dialog({
					autoOpen: false,
					resizable: false,
					height: 'auto',
					modal: true,
					buttons: {
						'Weiter einkaufen': function () {
							$(this).dialog("close");
						},
						'Zum Warenkorb': function () {
							$(this).dialog("close");
							var baseUrl = $('base').attr('href');
							var url = baseUrl + 'glacryl-shop/?tx_pdschildkonfigurator_flgkonfigurator%5Baction%5D=index&tx_pdschildkonfigurator_flgkonfigurator%5Bcontroller%5D=Warenkorb&cHash=62f03094ac894eaddd7104a1f6f02361';
							window.location = url;
						}
					}
				});

				$('#products-error-Dialog').dialog({
					autoOpen: false,
					resizable: false,
					height: 'auto',
					modal: true, buttons: {
						OK: function () {
							$(this).dialog("close");
						}
					}
				});

				$('#products-qty-Dialog').dialog({
					autoOpen: false,
					resizable: false,
					height: 'auto',
					modal: true,
					buttons: {
						OK: function () {
							$(this).dialog("close");
							$('products-qty-warning').html('');
						}
					},
					close: function () {
						$('#products-success-Dialog').dialog('open');
					}
				});
			},
			actions: {
				initialize: function () {
					$('body').on('click', '.info-icon-products', Product.View.actions.showProductInfoFunction);

					$('body').on('click', '.add-product-to-cart-Tail-Btn', Product.View.actions.addProductTailToCartFunction);
				},
				showProductInfoFunction: function (e) {
					e.preventDefault();
					$(this).parent('div').parent('li').find('div div.product-main').toggle();
					$(this).parent('div').parent('li').find('div div.product-info').toggle();
				},
				addProductTailToCartFunction: function (e) {
					e.preventDefault();
					var uid = $(this).parent('div').parent('div').prev('div').find('div div input[name=produkt-uid]').val();
					var vid = $(this).parent('div').parent('div').prev('div').find('div div input[name=produkt-vid]').val();
					var qty = $(this).parent('div').parent('div').prev('div').find('div div p input').val();
					var cartPosition = {
						halter: {
							uid: uid,
							vid: vid
						}
					};

					var price = Price.getProductPrice(uid, vid, 'halter');
					var rbPrice = Price.calculatePriceWithRabatt(price, qty, 'product');
					var data = new Object();
					data.eID = 'ajaxDispatcher';
					data.request = {
						pluginName: 'Glacrylshop',
						controller: 'Aj',
						action: 'addToCart',
						arguments: {
							'artikel': cartPosition,
							'anzahl': qty,
							'preis': (rbPrice * Number(qty)),
							'schild': false
						}
					};
					var res = API.ajax('Manager', false, data, 'POST', 'json');
					if (res) {
						if (qty > Validate.config.maxQty) {
							$('#products-qty-warning').html(qty);
							$('#products-qty-Dialog').dialog('open');
						} else {
							$('#products-success-Dialog').dialog('open');
						}
					} else {
						$('#products-error-Dialog').dialog('open');
					}
				}
			}
		}
	};

	var Konto = {
		View: {
			initializeFirst: function () {
				$('.bestellungen-table').dataTable({
					"bProcessing": true,
					"bDeferRender": true,
					"bAutoWidth": false,
					"bJQueryUI": true
				});
				$('.adressen-table').dataTable({
					"bProcessing": true,
					"bDeferRender": true,
					"bAutoWidth": false,
					"bJQueryUI": true
				});
				this.Actions.initialize();
			},
			Actions: {
				initialize: function () {
					$('body').on('click', '.edit-firmenDaten', Konto.View.Actions.editFirmaBTNAction);
					$('body').on('click', '.accept-firmenDaten', Konto.View.Actions.acceptFirmaBTNAction);
					$('body').on('click', '.edit-firmenAdresse', Konto.View.Actions.editAdressBTNAction);
					$('body').on('click', '.accept-firmenAdresse', Konto.View.Actions.acceptAdressBTNAction);
					$('body').on('click', '.edit-ansprechpartner', Konto.View.Actions.editPartnerBTNAction);
					$('body').on('click', '.accept-ansprechpartner', Konto.View.Actions.acceptPartnerBTNAction);
					$('body').on('click', '.edit-kontakt', Konto.View.Actions.editKontaktBTNAction);
					$('body').on('click', '.accept-kontakt', Konto.View.Actions.acceptKontaktBTNAction);
				},
				acceptFirmaBTNAction: function (e) {
					e.preventDefault();
					var firma = $('span.data-kdFirma input').val();
					var ustId = $('span.data-kdUstId input').val();

					var data = new Object();
					data.eID = 'ajaxDispatcher';
					data.request = {
						pluginName: 'Glacrylshop',
						controller: 'Aj',
						action: 'editUser',
						arguments: {
							'firma': firma,
							'ustId': ustId
						}
					};
					var res = API.ajax('Manager', false, data, 'GET', 'json');

					if (res.error == 'false') {
						$(this).removeClass('sprite-Bestaetigen accept-firmenDaten').addClass('sprite-Stift edit-firmenDaten');
						$('span.data-kdFirma').html(res.user.firma);
						$('span.data-kdUstId').html(res.user.ustId);

					}
				},
				editFirmaBTNAction: function (e) {
					e.preventDefault();
					$(this).removeClass('sprite-Stift edit-firmenDaten').addClass('sprite-Bestaetigen accept-firmenDaten');

					var data = $(this).parent('legend').parent('fieldset').find('div span');
					data.each(function (i, el) {
						var text = $(el).text();
						if (i != 0) {
							$(el).html('<input type="text" value="' + text + '" />');
						}
					});
				},
				acceptAdressBTNAction: function (e) {
					e.preventDefault();
					var str = $('span.data-kdStr input').val();
					var plz = $('span.data-kdPlz input').val();
					var ort = $('span.data-kdOrt input').val();

					var data = new Object();
					data.eID = 'ajaxDispatcher';
					data.request = {
						pluginName: 'Glacrylshop',
						controller: 'Aj',
						action: 'editUser',
						arguments: {
							'str': str,
							'plz': plz,
							'ort': ort
						}};
					var res = API.ajax('Manager', false, data, 'GET', 'json');

					if (res.error == 'false') {
						$(this).removeClass('sprite-Bestaetigen accept-firmenAdresse').addClass('sprite-Stift edit-firmenAdresse');

						$('span.data-kdStr').html(res.user.str);
						$('span.data-kdPlz').html(res.user.plz);
						$('span.data-kdOrt').html(res.user.ort);
					}
				},
				editAdressBTNAction: function (e) {
					e.preventDefault();

					$(this).removeClass('sprite-Stift edit-firmenAdresse').addClass('sprite-Bestaetigen accept-firmenAdresse');

					var data = $(this).parent('legend').parent('fieldset').find('div span');
					data.each(function (i, el) {
						var text = $(el).text();
						$(el).html('<input type="text" value="' + text + '" />');
					});
				},
				acceptPartnerBTNAction: function (e) {
					e.preventDefault();
					var sex = $('span.data-kdSex select').val();
					var name = $('span.data-kdName input').val();
					var vorname = $('span.data-kdVorname input').val();

					var data = new Object();
					data.eID = 'ajaxDispatcher';
					data.request = {
						pluginName: 'Glacrylshop',
						controller: 'Aj',
						action: 'editUser',
						arguments: {
							'sex': sex,
							'name': name,
							'vorname': vorname
						}
					};
					var res = API.ajax('Manager', false, data, 'GET', 'json');

					if (res.error == 'false') {
						$(this).removeClass('sprite-Bestaetigen accept-ansprechpartner').addClass('sprite-Stift edit-ansprechpartner');

						$('span.data-kdSex').html((res.user.sex == 0 ? 'Herr' : 'Frau'));
						$('span.data-kdName').html(res.user.name);
						$('span.data-kdVorname').html(res.user.vorname);
					}
				},
				editPartnerBTNAction: function (e) {
					e.preventDefault();

					$(this).removeClass('sprite-Stift edit-ansprechpartner').addClass('sprite-Bestaetigen accept-ansprechpartner');
					var data = $(this).parent('legend').parent('fieldset').find('div span');
					data.each(function (i, el) {
						var text = $(el).text(), tmpl = '';
						if (i == 0) {
							tmpl = '<select>';
							tmpl += '<option value="null">&nbsp;</option>';
							tmpl += '<option value="1"' + (text == 'Frau' ? ' selected ' : 0) + '>Frau</option>';
							tmpl += '<option value="0"' + (text == 'Herr' ? ' selected ' : 0) + '>Herr</option>';
							tmpl += '</select>';
						} else {
							tmpl += '<input type="text" value="' + text + '" />';
						}
						$(el).html(tmpl);
					});
				},
				acceptKontaktBTNAction: function (e) {
					e.preventDefault();
					var mail = $('span.data-kdMail input').val();
					var tel = $('span.data-kdTel input').val();
					var fax = $('span.data-kdFax input').val();

					var data = new Object();
					data.eID = 'ajaxDispatcher';
					data.request = {
						pluginName: 'Glacrylshop',
						controller: 'Aj',
						action: 'editUser',
						arguments: {
							'mail': mail,
							'tel': tel,
							'fax': fax
						}
					};
					var res = API.ajax('Manager', false, data, 'GET', 'json');

					if (res.error == 'false') {
						$(this).removeClass('sprite-Bestaetigen accept-kontakt').addClass('sprite-Stift edit-kontakt');

						$('span.data-kdMail').html(res.user.mail);
						$('span.data-kdTel').html(res.user.tel);
						$('span.data-kdFax').html(res.user.fax);
					}
				},
				editKontaktBTNAction: function (e) {
					e.preventDefault();

					$(this).removeClass('sprite-Stift edit-kontakt').addClass('sprite-Bestaetigen accept-kontakt');

					var data = $(this).parent('legend').parent('fieldset').find('div span');
					data.each(function (i, el) {
						var text = $(el).text();
						$(el).html('<input type="text" value="' + text + '" />');
					});
				}
			}
		}
	};

	var Direktanfrage = {
		View: {
			initialize: function () {
				this.clearForm();
			},
			clearForm: function () {
				$('#anfrage-betreff').val('');
				$('#anfrage-text').val('');
			} 
		},
		Actions: {
			initializeFirst: function () {
				$('body').on('click', '#anfrage-send', Direktanfrage.Actions.sendAnfrageFunction);

				this.iniFileUploader();
			},
			sendAnfrageFunction: function (e) {
				e.preventDefault();
			},
			iniFileUploader: function () {
				
				var uploadUrl = 'index.php?eID=ajaxDispatcher&request[pluginName]=Glacrylshop&request[controller]=Aj&request[action]=uploadFile&request[arguments][uid]=';

				$("#anfrage-upload").uploadFile({
					url: uploadUrl,
					multiple: true,
					dragDrop: true,
					fileName: "files",
					uploadButtonClass: "button expand",
					abortStr: "Abbrechen",
					cancelStr: "Beenden",
					doneStr: "Fertig",
					dragDropStr: "<span><b>Sie können mehrere Dateien zum hochladen hierher ziehen!</b></span>",
					showStatusAfterSuccess: false,
				});
			}
		}
	}

	$(function () {
		Konfigurator.initialize().createView();
		Konfigurator.schild = new Schild();
		Konfigurator.resetKonfiguratorView();
		View.actions.initializeFirst();

		Tooltips.initialize();

		Cart.initialize();

		$('#view-configuration-width').focus();

		Product.View.initializeFirst();
		Product.View.actions.initialize();

		Konto.View.initializeFirst();

		Direktanfrage.View.initialize();
		Direktanfrage.Actions.initializeFirst();

	});
})(jQuery);