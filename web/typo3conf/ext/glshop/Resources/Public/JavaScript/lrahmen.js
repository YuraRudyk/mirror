function Rahmen() {
	this.log = false;
	this.data = {};
	this.corner = {};
	this.material = {
		width: null,
		height: null
	};
	this.config = {
		imgPaths: {
			'halter': 'typo3conf/ext/glshop/Resources/Public/Img/Products/'
		},
		offsetX: 105,
		offsetY: 105,
		tOffset: 80,
		scale: 1,
		bild: null,
		cWidth: null,
		cHeight: null,
		facette: false
	};

	this.initialize = function (canvasId, data) {
		this.config.bild = $('#' + canvasId);
		this.config.cWidth = this.config.bild.width();
		this.config.cHeight = this.config.bild.height();
		this.config.offsetX = this.config.cWidth / 2;
		this.config.offsetY = this.config.cHeight / 2;
		this.data = data;
		this.material.width = this.data.materialConfig.width;
		this.material.height = this.data.materialConfig.height;
		this.checkScale();
		this.corner = this.getCorner();
		if ((typeof this.data.bearbeitungen.kanten.facette != 'undefined') && (this.data.bearbeitungen.kanten.facette != null) && (this.data.bearbeitungen.kanten.facette != '')) {
			this.config.facette = true;
		}
		return this;
	};
	this.clearCanvas = function () {
		this.config.bild.clearCanvas();
		return this;
	};
	this.getCorner = function () {
		var offsetX = this.config.offsetX,
				offsetY = this.config.offsetY,
				scale = this.config.scale,
				breite = this.material.width,
				hoehe = this.material.height;
		var corner = [{
				"x": offsetX - (breite * scale) / 2,
				"y": offsetY - (hoehe * scale) / 2
			}, {
				"x": offsetX + (breite * scale) / 2,
				"y": offsetY - (hoehe * scale) / 2
			}, {
				"x": offsetX + (breite * scale) / 2,
				"y": offsetY + (hoehe * scale) / 2
			}, {
				"x": offsetX - (breite * scale) / 2,
				"y": offsetY + (hoehe * scale) / 2
			}];
		return corner;
	};
	this.checkScale = function () {
		var sX = Number(this.material.width),
				sY = Number(this.material.height),
				cX = this.config.cWidth - this.config.tOffset,
				cY = this.config.cHeight - this.config.tOffset;
		if (((sX < cX) && (sY < cY)) || ((sX > cX) && (sX > cY))) {
			if (sX < sY) {
				this.config.scale = cY / sY;
			} else {
				this.config.scale = cX / sX;
			}
		} else if ((sX > cX) && (sY < cY)) {
			this.config.scale = cX / sX;
		} else if ((sX < cX) && (sY > cY)) {
			this.config.scale = cY / sY;
		}
		if (this.log)
			log(this.config.scale);
	};
	this.draw = function () {
		this.clearCanvas().drawSchild();
		this.beschrifteEcken().zeichneSkala();
		this.zeichneBohrungen().zeichneSenkungen();
		this.zeichneHalter();
		return this;
	};
	this.getEckRadius = function () {
		var r = 0;
		if (typeof this.data.bearbeitungen.ecken[0] != "undefined") {
			if (this.data.bearbeitungen.ecken[0].corner == "ALLE") {
				if (this.data.bearbeitungen.ecken[0].radius != null) {
					r = this.data.bearbeitungen.ecken[0].radius;
				}
			}
		}
		return Number(r);
	};
	this.drawSchild = function () {
		/*this.config.bild.drawRect({
		 fillStyle: '#FFF',
		 x: 0, y: 0,
		 width: this.config.cWidth,
		 height: this.config.cHeight,
		 fromCenter: false
		 });*/
		var corner = this.data.bearbeitungen.ecken;
		if (corner.length == 0) {
			if (this.log)
				log('Normaler Schild');

			this.drawRect(true, 'schild', 'material', '#000', 1, (this.scaleValue(this.getEckRadius(corner))), this.config.offsetX, this.config.offsetY, Number(this.material.width), Number(this.material.height));
			if (this.config.facette) {
				this.drawRect(true, 'schild', 'material', '#000', 1, (this.scaleValue(this.getEckRadius(corner))), this.config.offsetX, this.config.offsetY, (Number(this.material.width) - Number(this.data.bearbeitungen.kanten.facette) * 2), (Number(this.material.height) - Number(this.data.bearbeitungen.kanten.facette) * 2));
			}
		} else if (corner[0].corner == "ALLE") {
			if (corner[0].radius) {
				if (this.log)
					log('Schild mit allen Runden Ecken');

				this.zeichneAlleEckenRund();
				if (this.config.facette) {
					this.zeichneAlleEckenRund(Number(this.data.bearbeitungen.kanten.facette));
				}
			} else {
				if (this.log)
					log('Schild mit allen Schrägen Ecken');

				this.zeichneAlleEckenSchraeg();
				if (this.config.facette) {
					this.zeichneAlleEckenSchraeg(Number(this.data.bearbeitungen.kanten.facette));
				}
			}
		} else {
			if (this.log)
				log('Schild mit unterschiedlichen Ecken');

			this.zeichneEcken();
			if (this.config.facette) {
				this.zeichneEcken(Number(this.data.bearbeitungen.kanten.facette));
			}
		}
	};
	this.drawRect = function (layer, name, group, strokeStyle, strokeWidth, cornerRadius, x, y, width, height) {
		this.config.bild.drawRect({
			layer: layer,
			name: name,
			group: group,
			strokeStyle: strokeStyle,
			strokeWidth: strokeWidth,
			cornerRadius: cornerRadius,
			x: x,
			y: y,
			width: this.scaleValue(width),
			height: this.scaleValue(height)
		});
	};
	this.beschriftung = function (layer, name, group, fillStyle, strokeStyle, strokeWidth, x, y, font, text, rotate) {
		this.config.bild.drawText({
			layer: layer,
			name: name,
			group: group,
			fillStyle: fillStyle,
			strokeStyle: strokeStyle,
			strokeWidth: strokeWidth,
			x: x,
			y: y,
			font: font,
			text: text,
			rotate: rotate
		});
	};
	this.beschrifteEcken = function () {
		var schrift = "9pt Verdana, sans-serif", breite = this.material.width, hoehe = this.material.height,
				xE1 = this.config.offsetX - this.scaleValue(breite) / 2 - 10,
				yE1 = this.config.offsetY - this.scaleValue(hoehe) / 2 - 10,
				xE2 = this.config.offsetX + this.scaleValue(breite) / 2 + 10,
				yE2 = this.config.offsetY - this.scaleValue(hoehe) / 2 - 10,
				xE3 = this.config.offsetX + this.scaleValue(breite) / 2 + 10,
				yE3 = this.config.offsetY + this.scaleValue(hoehe) / 2 + 10,
				xE4 = this.config.offsetX - this.scaleValue(breite) / 2 - 10,
				yE4 = this.config.offsetY + this.scaleValue(hoehe) / 2 + 10;

		this.beschriftung(true, 'E1', 'eckBeschriftung', '#E6E6E6', '#515151', 1, xE1, yE1, schrift, 'E1', 0);
		this.beschriftung(true, 'E2', 'eckBeschriftung', '#E6E6E6', '#515151', 1, xE2, yE2, schrift, 'E2', 0);
		this.beschriftung(true, 'E3', 'eckBeschriftung', '#E6E6E6', '#515151', 1, xE3, yE3, schrift, 'E3', 0);
		this.beschriftung(true, 'E4', 'eckBeschriftung', '#E6E6E6', '#515151', 1, xE4, yE4, schrift, 'E4', 0);
		return this;
	};

	this.beschrifteKanten = function () {
		var schrift = "8pt Verdana, sans-serif", breite = this.material.width, hoehe = this.material.height,
				xE1 = this.config.offsetX,
				yE1 = this.config.offsetY - this.scaleValue(hoehe) / 2 - 10 - 13, // -13 Zeilenkorrektur
				xE2 = this.config.offsetX + this.scaleValue(breite) / 2 + 10 + 13, // +13 Zeilenkorrektur
				yE2 = this.config.offsetY,
				xE3 = this.config.offsetX,
				yE3 = this.config.offsetY + this.scaleValue(hoehe) / 2 + 10 + 13, // +13 Zeilenkorrektur
				xE4 = this.config.offsetX - this.scaleValue(breite) / 2 - 10 - 13, // -13 Zeilenkorrektur
				yE4 = this.config.offsetY;

		this.beschriftung(true, 'K1', 'kantenBeschriftung', '#E6E6E6', '#515151', 1, xE1, yE1, schrift, 'K1: ' + breite + ' mm', 0);
		this.beschriftung(true, 'K2', 'kantenBeschriftung', '#E6E6E6', '#515151', 1, xE2, yE2, schrift, 'K2: ' + hoehe + ' mm', 90);
		this.beschriftung(true, 'K3', 'kantenBeschriftung', '#E6E6E6', '#515151', 1, xE3, yE3, schrift, 'K3: ' + breite + ' mm', 0);
		this.beschriftung(true, 'K4', 'kantenBeschriftung', '#E6E6E6', '#515151', 1, xE4, yE4, schrift, 'K4: ' + hoehe + ' mm', 270);
		return this;
	};
	this.zeichneSkala = function () {
		var schrift = "8pt Verdana, sans-serif";
		this.beschriftung(true, 'X', 'skalenBeschriftung', '#E6E6E6', '#515151', 1, 60, this.config.cHeight - 10, schrift, 'X', 0);
		this.beschriftung(true, 'Y', 'skalenBeschriftung', '#E6E6E6', '#515151', 1, 10, this.config.cHeight - 60, schrift, 'Y', 0);
		// Horizontaler Pfeil
		this.config.bild.drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: 10,
			y1: this.config.cHeight - 10,
			x2: 50,
			y2: this.config.cHeight - 10
		}).drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: 50,
			y1: this.config.cHeight - 10,
			x2: 45,
			y2: this.config.cHeight - 5
		}).drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: 50,
			y1: this.config.cHeight - 10,
			x2: 45,
			y2: this.config.cHeight - 15
					// Vertikaler Pfeil
		}).drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: 10,
			y1: this.config.cHeight - 10,
			x2: 10,
			y2: this.config.cHeight - 50
		}).drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: 10,
			y1: this.config.cHeight - 50,
			x2: 5,
			y2: this.config.cHeight - 45
		}).drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: 10,
			y1: this.config.cHeight - 50,
			x2: 15,
			y2: this.config.cHeight - 45
		});
		return this;
	};
	this.zeichneBohrungen = function () {
		var bohrungen = this.data.bearbeitungen.bohrungen;
		if (typeof bohrungen != 'undefined') {
			for (var i = 0; i < bohrungen.length; i++) {
				this.setBohrung(bohrungen[i], bohrungen[i].corner);
			}
		}
		return this;
	};
	this.zeichneSenkungen = function () {
		var senkungen = this.data.bearbeitungen.senkungen;
		if (typeof senkungen != 'undefined') {
			for (var i = 0; i < senkungen.length; i++) {
				this.setSenkung(senkungen[i], senkungen[i].corner);
			}
		}
		return this;
	};
	this.setSenkung = function (bohrung, corner) {
		switch (corner) {
			case 'ALLE':
				this.setSenkung(bohrung, 'E1');
				this.setSenkung(bohrung, 'E2');
				this.setSenkung(bohrung, 'E3');
				this.setSenkung(bohrung, 'E4');
				break;
			case 'E1':
				this.zeichneKreis(true, 'senkBohrungen', '#555555', 1, this.corner[0].x + this.scaleValue(bohrung.x), this.corner[0].y + this.scaleValue(bohrung.y), this.scaleValue((bohrung.dS / 2)));
				this.setBohrung(bohrung, corner);
				break;
			case 'E2':
				this.zeichneKreis(true, 'senkBohrungen', '#555555', 1, this.corner[1].x - this.scaleValue(bohrung.x), this.corner[1].y + this.scaleValue(bohrung.y), this.scaleValue((bohrung.dS / 2)));
				this.setBohrung(bohrung, corner);
				break;
			case 'E3':
				this.zeichneKreis(true, 'senkBohrungen', '#555555', 1, this.corner[2].x - this.scaleValue(bohrung.x), this.corner[2].y - this.scaleValue(bohrung.y), this.scaleValue((bohrung.dS / 2)));
				this.setBohrung(bohrung, corner);
				break;
			case 'E4':
				this.zeichneKreis(true, 'senkBohrungen', '#555555', 1, this.corner[3].x + this.scaleValue(bohrung.x), this.corner[3].y - this.scaleValue(bohrung.y), this.scaleValue((bohrung.dS / 2)));
				this.setBohrung(bohrung, corner);
				break;
			case 'FREI':
				this.zeichneKreis(true, 'senkBohrungen', '#555555', 1, this.corner[3].x + this.scaleValue(bohrung.x), this.corner[3].y - this.scaleValue(bohrung.y), this.scaleValue((bohrung.dS / 2)));
				this.setBohrung(bohrung, corner);
				break;
		}
	};

	this.setBohrung = function (bohrung, corner) {
		switch (corner) {
			case 'ALLE':
				this.setBohrung(bohrung, 'E1');
				this.setBohrung(bohrung, 'E2');
				this.setBohrung(bohrung, 'E3');
				this.setBohrung(bohrung, 'E4');
				break;
			case 'E1':
				this.zeichneKreis(true, 'bohrungen', '#555555', 1, this.corner[0].x + this.scaleValue(bohrung.x), this.corner[0].y + this.scaleValue(bohrung.y), this.scaleValue((bohrung.dB / 2)));
				break;
			case 'E2':
				this.zeichneKreis(true, 'bohrungen', '#555555', 1, this.corner[1].x - this.scaleValue(bohrung.x), this.corner[1].y + this.scaleValue(bohrung.y), this.scaleValue((bohrung.dB / 2)));
				break;
			case 'E3':
				this.zeichneKreis(true, 'bohrungen', '#555555', 1, this.corner[2].x - this.scaleValue(bohrung.x), this.corner[2].y - this.scaleValue(bohrung.y), this.scaleValue((bohrung.dB / 2)));
				break;
			case 'E4':
				this.zeichneKreis(true, 'bohrungen', '#555555', 1, this.corner[3].x + this.scaleValue(bohrung.x), this.corner[3].y - this.scaleValue(bohrung.y), this.scaleValue((bohrung.dB / 2)));
				break;
			case 'FREI':
				this.zeichneKreis(true, 'bohrungen', '#555555', 1, this.corner[3].x + this.scaleValue(bohrung.x), this.corner[3].y - this.scaleValue(bohrung.y), this.scaleValue((bohrung.dB / 2)));
				break;
		}

	};
	this.zeichneKreis = function (layer, group, strokeStyle, strokeWidth, x, y, radius, fillStyle) {
		if ((typeof fillStyle != 'undefined') && (fillStyle != null)) {
			this.config.bild.drawArc({
				layer: layer,
				group: group,
				strokeStyle: strokeStyle,
				strokeWidth: strokeWidth,
				fillStyle: fillStyle,
				x: x,
				y: y,
				radius: radius
			});
		} else {
			this.config.bild.drawArc({
				layer: layer,
				group: group,
				strokeStyle: strokeStyle,
				strokeWidth: strokeWidth,
				x: x,
				y: y,
				radius: radius
			});
		}
	};

	this.rundeEcke = function (x, y, radius, start, end) {
		// start: 0 grad ist oben
		this.config.bild.drawArc({
			strokeStyle: "#000",
			strokeWidth: 1,
			x: x,
			y: y,
			radius: radius,
			start: start,
			end: end
		});
	};

	this.zeichneHalterBild = function (layer, name, group, source, x, y, width, height) {
		this.config.bild.drawImage({
			layer: layer,
			name: name,
			group: group,
			source: source,
			x: x,
			y: y,
			width: width,
			height: height,
			fromCenter: true
		});
	};

	this.zeichneAlleEckenSchraeg = function (facette) {
		var eingabe = this.data.bearbeitungen.ecken, ecken = [], p1 = 0, p2 = 0, p3 = 0, p4 = 0, p5 = 0, p6 = 0, p7 = 0, p8 = 0;
		for (var i = 0; i < eingabe.length; i++) {
			ecken[eingabe[i].corner] = eingabe[i];
		}

		if (this.log)
			log('Facette:', facette);

		if (facette) {
			facette = this.scaleValue(facette);
			// Ecke 0
			var p8x1 = this.corner[0].x;
			var p8y1 = this.corner[0].y + this.scaleValue(ecken['ALLE'].y);
			var p1x2 = this.corner[0].x + this.scaleValue(ecken['ALLE'].x);
			var p1y2 = this.corner[0].y;
			// Ecke 1
			var p2x1 = this.corner[1].x - this.scaleValue(ecken['ALLE'].x);
			var p2y1 = this.corner[1].y;
			var p3x2 = this.corner[1].x;
			var p3y2 = this.corner[1].y + this.scaleValue(ecken['ALLE'].y);
			// Ecke 2
			var p4x1 = this.corner[2].x;
			var p4y1 = this.corner[2].y - this.scaleValue(ecken['ALLE'].y);
			var p5x2 = this.corner[2].x - this.scaleValue(ecken['ALLE'].x);
			var p5y2 = this.corner[2].y;
			// Ecke 3
			var p6x1 = this.corner[3].x + this.scaleValue(ecken['ALLE'].x);
			var p6y1 = this.corner[3].y;
			var p7x2 = this.corner[3].x;
			var p7y2 = this.corner[3].y - this.scaleValue(ecken['ALLE'].y);
			//Verschiebungen
			p1 = Number(this.getFacettenVerschiebung('P1', facette, p8x1, p8y1, p1x2, p1y2));
			p2 = Number(this.getFacettenVerschiebung('P2', facette, p2x1, p2y1, p3x2, p3y2));
			p3 = Number(this.getFacettenVerschiebung('P3', facette, p2x1, p2y1, p3x2, p3y2));
			p4 = Number(this.getFacettenVerschiebung('P4', facette, p4x1, p4y1, p5x2, p5y2));
			p5 = Number(this.getFacettenVerschiebung('P5', facette, p4x1, p4y1, p5x2, p5y2));
			p6 = Number(this.getFacettenVerschiebung('P6', facette, p6x1, p6y1, p7x2, p7y2));
			p7 = Number(this.getFacettenVerschiebung('P7', facette, p6x1, p6y1, p7x2, p7y2));
			p8 = Number(this.getFacettenVerschiebung('P8', facette, p8x1, p8y1, p1x2, p1y2));
		}

		if (this.log)
			log('Skalierung:', this.config.scale);
		if (this.log)
			log('Facette skaliert:', facette);

		this.config.bild.drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: this.corner[0].x + (facette ? (this.scaleValue(ecken['ALLE'].x) + p1) : this.scaleValue(ecken['ALLE'].x)),
			y1: this.corner[0].y + (facette ? facette : 0),
			x2: this.corner[1].x - (facette ? (this.scaleValue(ecken['ALLE'].x) + p2) : this.scaleValue(ecken['ALLE'].x)),
			y2: this.corner[1].y + (facette ? facette : 0)
		}).drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: this.corner[1].x - (facette ? facette : 0),
			y1: this.corner[1].y + (facette ? (this.scaleValue(ecken['ALLE'].y) + p3) : this.scaleValue(ecken['ALLE'].y)),
			x2: this.corner[2].x - (facette ? facette : 0),
			y2: this.corner[2].y - (facette ? (this.scaleValue(ecken['ALLE'].y) + p4) : this.scaleValue(ecken['ALLE'].y))
		}).drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: this.corner[2].x - (facette ? (this.scaleValue(ecken['ALLE'].x) + p5) : this.scaleValue(ecken['ALLE'].x)),
			y1: this.corner[2].y - (facette ? facette : 0),
			x2: this.corner[3].x + (facette ? (this.scaleValue(ecken['ALLE'].x) + p6) : this.scaleValue(ecken['ALLE'].x)),
			y2: this.corner[3].y - (facette ? facette : 0)
		}).drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: this.corner[3].x + (facette ? facette : 0),
			y1: this.corner[3].y - (facette ? (this.scaleValue(ecken['ALLE'].y) + p7) : this.scaleValue(ecken['ALLE'].y)),
			x2: this.corner[0].x + (facette ? facette : 0),
			y2: this.corner[0].y + (facette ? (this.scaleValue(ecken['ALLE'].y) + p8) : this.scaleValue(ecken['ALLE'].y))
		});
		this.config.bild.drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: this.corner[1].x - (facette ? (this.scaleValue(ecken['ALLE'].x) + p2) : this.scaleValue(ecken['ALLE'].x)),
			y1: this.corner[1].y + (facette ? facette : 0),
			x2: this.corner[1].x - (facette ? facette : 0),
			y2: this.corner[1].y + (facette ? (this.scaleValue(ecken['ALLE'].y) + p3) : this.scaleValue(ecken['ALLE'].y))
		}).drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: this.corner[2].x - (facette ? facette : 0),
			y1: this.corner[2].y - (facette ? (this.scaleValue(ecken['ALLE'].y) + p4) : this.scaleValue(ecken['ALLE'].y)),
			x2: this.corner[2].x - (facette ? (this.scaleValue(ecken['ALLE'].x) + p5) : this.scaleValue(ecken['ALLE'].x)),
			y2: this.corner[2].y - (facette ? facette : 0)
		}).drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: this.corner[3].x + (facette ? (this.scaleValue(ecken['ALLE'].x) + p6) : this.scaleValue(ecken['ALLE'].x)),
			y1: this.corner[3].y - (facette ? facette : 0),
			x2: this.corner[3].x + (facette ? facette : 0),
			y2: this.corner[3].y - (facette ? (this.scaleValue(ecken['ALLE'].y) + p7) : this.scaleValue(ecken['ALLE'].y))
		}).drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: this.corner[0].x + (facette ? facette : 0),
			y1: this.corner[0].y + (facette ? (this.scaleValue(ecken['ALLE'].y) + p8) : this.scaleValue(ecken['ALLE'].y)),
			x2: this.corner[0].x + (facette ? (this.scaleValue(ecken['ALLE'].x) + p1) : this.scaleValue(ecken['ALLE'].x)),
			y2: this.corner[0].y + (facette ? facette : 0)
		});
	};

	this.zeichneAlleEckenRund = function (facette) {
		var eingabe = this.data.bearbeitungen.ecken, ecken = [], p1 = 0, p2 = 0, p3 = 0, p4 = 0, p5 = 0, p6 = 0, p7 = 0, p8 = 0;
		for (var i = 0; i < eingabe.length; i++) {
			ecken[eingabe[i].corner] = eingabe[i];
		}

		if (facette) {
			facette = this.scaleValue(facette);
			// Ecke 0
			var p8x1 = this.corner[0].x;
			var p8y1 = this.corner[0].y + this.scaleValue(ecken['ALLE'].radius);
			var p1x2 = this.corner[0].x + this.scaleValue(ecken['ALLE'].radius);
			var p1y2 = this.corner[0].y;
			// Ecke 1
			var p2x1 = this.corner[1].x - this.scaleValue(ecken['ALLE'].radius);
			var p2y1 = this.corner[1].y;
			var p3x2 = this.corner[1].x;
			var p3y2 = this.corner[1].y + this.scaleValue(ecken['ALLE'].radius);
			// Ecke 2
			var p4x1 = this.corner[2].x;
			var p4y1 = this.corner[2].y - this.scaleValue(ecken['ALLE'].radius);
			var p5x2 = this.corner[2].x - this.scaleValue(ecken['ALLE'].radius);
			var p5y2 = this.corner[2].y;
			// Ecke 3
			var p6x1 = this.corner[3].x + this.scaleValue(ecken['ALLE'].radius);
			var p6y1 = this.corner[3].y;
			var p7x2 = this.corner[3].x;
			var p7y2 = this.corner[3].y - this.scaleValue(ecken['ALLE'].radius);
			//Verschiebungen
			p1 = Number(this.getFacettenVerschiebung('P1', facette, p8x1, p8y1, p1x2, p1y2));
			p2 = Number(this.getFacettenVerschiebung('P2', facette, p2x1, p2y1, p3x2, p3y2));
			p3 = Number(this.getFacettenVerschiebung('P3', facette, p2x1, p2y1, p3x2, p3y2));
			p4 = Number(this.getFacettenVerschiebung('P4', facette, p4x1, p4y1, p5x2, p5y2));
			p5 = Number(this.getFacettenVerschiebung('P5', facette, p4x1, p4y1, p5x2, p5y2));
			p6 = Number(this.getFacettenVerschiebung('P6', facette, p6x1, p6y1, p7x2, p7y2));
			p7 = Number(this.getFacettenVerschiebung('P7', facette, p6x1, p6y1, p7x2, p7y2));
			p8 = Number(this.getFacettenVerschiebung('P8', facette, p8x1, p8y1, p1x2, p1y2));
		}

		this.config.bild.drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: this.corner[0].x + (facette ? this.scaleValue(ecken['ALLE'].radius) + p1 : this.scaleValue(ecken['ALLE'].radius)),
			y1: this.corner[0].y + (facette ? facette : 0),
			x2: this.corner[1].x - (facette ? this.scaleValue(ecken['ALLE'].radius) + p2 : this.scaleValue(ecken['ALLE'].radius)),
			y2: this.corner[1].y + (facette ? facette : 0)
		});

		this.config.bild.drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: this.corner[1].x - (facette ? facette : 0),
			y1: this.corner[1].y + (facette ? this.scaleValue(ecken['ALLE'].radius) + p3 : this.scaleValue(ecken['ALLE'].radius)),
			x2: this.corner[2].x - (facette ? facette : 0),
			y2: this.corner[2].y - (facette ? this.scaleValue(ecken['ALLE'].radius) + p4 : this.scaleValue(ecken['ALLE'].radius))
		});
		this.config.bild.drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: this.corner[2].x - (facette ? this.scaleValue(ecken['ALLE'].radius) + p5 : this.scaleValue(ecken['ALLE'].radius)),
			y1: this.corner[2].y - (facette ? facette : 0),
			x2: this.corner[3].x + (facette ? this.scaleValue(ecken['ALLE'].radius) + p6 : this.scaleValue(ecken['ALLE'].radius)),
			y2: this.corner[3].y - (facette ? facette : 0)
		});
		this.config.bild.drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: this.corner[3].x + (facette ? facette : 0),
			y1: this.corner[3].y - (facette ? this.scaleValue(ecken['ALLE'].radius) + p7 : this.scaleValue(ecken['ALLE'].radius)),
			x2: this.corner[0].x + (facette ? facette : 0),
			y2: this.corner[0].y + (facette ? this.scaleValue(ecken['ALLE'].radius) + p8 : this.scaleValue(ecken['ALLE'].radius))
		});

		this.rundeEcke(
				this.corner[0].x + (facette ? this.scaleValue(ecken['ALLE'].radius) + p1 : this.scaleValue(ecken['ALLE'].radius)),
				this.corner[0].y + (facette ? this.scaleValue(ecken['ALLE'].radius) + p8 : this.scaleValue(ecken['ALLE'].radius)),
				(facette ? (this.corner[0].x + this.scaleValue(ecken['ALLE'].radius) + p1) - (this.corner[0].x + facette) : this.scaleValue(ecken['ALLE'].radius)), 270, 0);
		this.rundeEcke(
				this.corner[1].x - (facette ? this.scaleValue(ecken['ALLE'].radius) + p2 : this.scaleValue(ecken['ALLE'].radius)),
				this.corner[1].y + (facette ? this.scaleValue(ecken['ALLE'].radius) + p3 : this.scaleValue(ecken['ALLE'].radius)),
				(facette ? (this.corner[1].x - facette) - (this.corner[1].x - (this.scaleValue(ecken['ALLE'].radius) + p2)) : this.scaleValue(ecken['ALLE'].radius)), 0, 90);
		this.rundeEcke(
				this.corner[2].x - (facette ? this.scaleValue(ecken['ALLE'].radius) + p5 : this.scaleValue(ecken['ALLE'].radius)),
				this.corner[2].y - (facette ? this.scaleValue(ecken['ALLE'].radius) + p4 : this.scaleValue(ecken['ALLE'].radius)),
				(facette ? (this.corner[2].x - facette) - (this.corner[2].x - (this.scaleValue(ecken['ALLE'].radius) + p5)) : this.scaleValue(ecken['ALLE'].radius)), 90, 180);
		this.rundeEcke(
				this.corner[3].x + (facette ? this.scaleValue(ecken['ALLE'].radius) + p6 : this.scaleValue(ecken['ALLE'].radius)),
				this.corner[3].y - (facette ? this.scaleValue(ecken['ALLE'].radius) + p7 : this.scaleValue(ecken['ALLE'].radius)),
				(facette ? (this.corner[3].x + this.scaleValue(ecken['ALLE'].radius) + p6) - (this.corner[3].x + facette) : this.scaleValue(ecken['ALLE'].radius)), 180, 270);
	};

	this.zeichneEcken = function (facette) {
		var eingabe = this.data.bearbeitungen.ecken, ecken = [], p1 = 0, p2 = 0, p3 = 0, p4 = 0, p5 = 0, p6 = 0, p7 = 0, p8 = 0;
		for (var i = 0; i < eingabe.length; i++) {
			ecken[eingabe[i].corner] = eingabe[i];
		}

		if (facette) {
			facette = this.scaleValue(facette);
			// Ecke 0
			var p8x1 = this.corner[0].x;
			var p8y1 = this.corner[0].y + (ecken['E1'] ? (ecken['E1'].radius ? this.scaleValue(ecken['E1'].radius) : this.scaleValue(ecken['E1'].y)) : 0);
			var p1x2 = this.corner[0].x + (ecken['E1'] ? (ecken['E1'].radius ? this.scaleValue(ecken['E1'].radius) : this.scaleValue(ecken['E1'].x)) : 0);
			var p1y2 = this.corner[0].y;
			// Ecke 1
			var p2x1 = this.corner[1].x - (ecken['E2'] ? (ecken['E2'].radius ? this.scaleValue(ecken['E2'].radius) : this.scaleValue(ecken['E2'].x)) : 0);
			var p2y1 = this.corner[1].y;
			var p3x2 = this.corner[1].x;
			var p3y2 = this.corner[1].y + (ecken['E2'] ? (ecken['E2'].radius ? this.scaleValue(ecken['E2'].radius) : this.scaleValue(ecken['E2'].y)) : 0);
			// Ecke 2
			var p4x1 = this.corner[2].x;
			var p4y1 = this.corner[2].y - (ecken['E3'] ? (ecken['E3'].radius ? this.scaleValue(ecken['E3'].radius) : this.scaleValue(ecken['E3'].y)) : 0);
			var p5x2 = this.corner[2].x - (ecken['E3'] ? (ecken['E3'].radius ? this.scaleValue(ecken['E3'].radius) : this.scaleValue(ecken['E3'].x)) : 0);
			var p5y2 = this.corner[2].y;
			// Ecke 3
			var p6x1 = this.corner[3].x + (ecken['E4'] ? (ecken['E4'].radius ? this.scaleValue(ecken['E4'].radius) : this.scaleValue(ecken['E4'].x)) : 0);
			var p6y1 = this.corner[3].y;
			var p7x2 = this.corner[3].x;
			var p7y2 = this.corner[3].y - (ecken['E4'] ? (ecken['E4'].radius ? this.scaleValue(ecken['E4'].radius) : this.scaleValue(ecken['E4'].y)) : 0);
			//Verschiebungen
			p1 = ((p1x2 - p8x1) != 0 ? Number(this.getFacettenVerschiebung('P1', facette, p8x1, p8y1, p1x2, p1y2)) : 0);
			p2 = ((p3x2 - p2x1) != 0 ? Number(this.getFacettenVerschiebung('P2', facette, p2x1, p2y1, p3x2, p3y2)) : 0);
			p3 = ((p3y2 - p2y1) != 0 ? Number(this.getFacettenVerschiebung('P3', facette, p2x1, p2y1, p3x2, p3y2)) : 0);
			p4 = ((p5y2 - p4y1) != 0 ? Number(this.getFacettenVerschiebung('P4', facette, p4x1, p4y1, p5x2, p5y2)) : 0);
			p5 = ((p4x1 - p5x2) != 0 ? Number(this.getFacettenVerschiebung('P5', facette, p4x1, p4y1, p5x2, p5y2)) : 0);
			p6 = ((p6x1 - p7x2) != 0 ? Number(this.getFacettenVerschiebung('P6', facette, p6x1, p6y1, p7x2, p7y2)) : 0);
			p7 = ((p6y1 - p7y2) != 0 ? Number(this.getFacettenVerschiebung('P7', facette, p6x1, p6y1, p7x2, p7y2)) : 0);
			p8 = ((p8y1 - p1y2) != 0 ? Number(this.getFacettenVerschiebung('P8', facette, p8x1, p8y1, p1x2, p1y2)) : 0);
		}

		this.config.bild.drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: this.corner[0].x + (ecken['E1'] ? (facette ? (ecken['E1'].radius ? this.scaleValue(ecken['E1'].radius) + p1 : this.scaleValue(ecken['E1'].x) + p1) : (ecken['E1'].radius ? this.scaleValue(ecken['E1'].radius) : this.scaleValue(ecken['E1'].x))) : (facette ? facette : 0)),
			y1: this.corner[0].y + (facette ? facette : 0),
			x2: this.corner[1].x - (ecken['E2'] ? (facette ? (ecken['E2'].radius ? this.scaleValue(ecken['E2'].radius) + p2 : this.scaleValue(ecken['E2'].x) + p2) : (ecken['E2'].radius ? this.scaleValue(ecken['E2'].radius) : this.scaleValue(ecken['E2'].x))) : (facette ? facette : 0)),
			y2: this.corner[1].y + (facette ? facette : 0)
		});

		this.config.bild.drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: this.corner[1].x - (facette ? facette : 0),
			y1: this.corner[1].y + (ecken['E2'] ? (facette ? (ecken['E2'].radius ? this.scaleValue(ecken['E2'].radius) + p3 : this.scaleValue(ecken['E2'].y) + p3) : (ecken['E2'].radius ? this.scaleValue(ecken['E2'].radius) : this.scaleValue(ecken['E2'].y))) : (facette ? facette : 0)),
			x2: this.corner[2].x - (facette ? facette : 0),
			y2: this.corner[2].y - (ecken['E3'] ? (facette ? (ecken['E3'].radius ? this.scaleValue(ecken['E3'].radius) + p4 : this.scaleValue(ecken['E3'].y) + p4) : (ecken['E3'].radius ? this.scaleValue(ecken['E3'].radius) : this.scaleValue(ecken['E3'].y))) : (facette ? facette : 0))
		});
		this.config.bild.drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: this.corner[2].x - (ecken['E3'] ? (facette ? (ecken['E3'].radius ? this.scaleValue(ecken['E3'].radius) + p5 : this.scaleValue(ecken['E3'].x) + p5) : (ecken['E3'].radius ? this.scaleValue(ecken['E3'].radius) : this.scaleValue(ecken['E3'].x))) : (facette ? facette : 0)),
			y1: this.corner[2].y - (facette ? facette : 0),
			x2: this.corner[3].x + (ecken['E4'] ? (facette ? (ecken['E4'].radius ? this.scaleValue(ecken['E4'].radius) + p6 : this.scaleValue(ecken['E4'].x) + p6) : (ecken['E4'].radius ? this.scaleValue(ecken['E4'].radius) : this.scaleValue(ecken['E4'].x))) : (facette ? facette : 0)),
			y2: this.corner[3].y - (facette ? facette : 0)
		});
		this.config.bild.drawLine({
			strokeStyle: "#000",
			strokeWidth: 1,
			x1: this.corner[3].x + (facette ? facette : 0),
			y1: this.corner[3].y - (ecken['E4'] ? (facette ? (ecken['E4'].radius ? this.scaleValue(ecken['E4'].radius) + p7 : this.scaleValue(ecken['E4'].y) + p7) : (ecken['E4'].radius ? this.scaleValue(ecken['E4'].radius) : this.scaleValue(ecken['E4'].y))) : (facette ? facette : 0)),
			x2: this.corner[0].x + (facette ? facette : 0),
			y2: this.corner[0].y + (ecken['E1'] ? (facette ? (ecken['E1'].radius ? this.scaleValue(ecken['E1'].radius) + p8 : this.scaleValue(ecken['E1'].y) + p8) : (ecken['E1'].radius ? this.scaleValue(ecken['E1'].radius) : this.scaleValue(ecken['E1'].y))) : (facette ? facette : 0))
		});

		for (var ecke in ecken) {
			if (ecke == 'E1') {
				if (ecken[ecke].radius) {
					this.rundeEcke(
							this.corner[0].x + (facette ? this.scaleValue(ecken[ecke].radius) + p1 : this.scaleValue(ecken[ecke].radius)),
							this.corner[0].y + (facette ? this.scaleValue(ecken[ecke].radius) + p8 : this.scaleValue(ecken[ecke].radius)),
							(facette ? (this.corner[0].x + this.scaleValue(ecken[ecke].radius) + p1) - (this.corner[0].x + facette) : this.scaleValue(ecken[ecke].radius)), 270, 0);
				} else {
					this.config.bild.drawLine({
						strokeStyle: "#000",
						strokeWidth: 1,
						x1: this.corner[0].x + (facette ? facette : 0),
						y1: this.corner[0].y + (facette ? this.scaleValue(ecken[ecke].y) + p8 : this.scaleValue(ecken[ecke].y)),
						x2: this.corner[0].x + (facette ? this.scaleValue(ecken[ecke].x) + p1 : this.scaleValue(ecken[ecke].x)),
						y2: this.corner[0].y + (facette ? facette : 0)
					});
				}
			} else if (ecke == 'E2') {
				if (ecken[ecke].radius) {
					this.rundeEcke(
							this.corner[1].x - (facette ? this.scaleValue(ecken[ecke].radius) + p2 : this.scaleValue(ecken[ecke].radius)),
							this.corner[1].y + (facette ? this.scaleValue(ecken[ecke].radius) + p3 : this.scaleValue(ecken[ecke].radius)),
							(facette ? (this.corner[1].x - facette) - (this.corner[1].x - (this.scaleValue(ecken[ecke].radius) + p2)) : this.scaleValue(ecken[ecke].radius)), 0, 90);
				} else {
					this.config.bild.drawLine({
						strokeStyle: "#000",
						strokeWidth: 1,
						x1: this.corner[1].x - (facette ? this.scaleValue(ecken[ecke].x) + p2 : this.scaleValue(ecken[ecke].x)),
						y1: this.corner[1].y + (facette ? facette : 0),
						x2: this.corner[1].x - (facette ? facette : 0),
						y2: this.corner[1].y + (facette ? this.scaleValue(ecken[ecke].y) + p3 : this.scaleValue(ecken[ecke].y))
					});
				}
			} else if (ecke == 'E3') {
				if (ecken[ecke].radius) {
					this.rundeEcke(
							this.corner[2].x - (facette ? this.scaleValue(ecken[ecke].radius) + p5 : this.scaleValue(ecken[ecke].radius)),
							this.corner[2].y - (facette ? this.scaleValue(ecken[ecke].radius) + p4 : this.scaleValue(ecken[ecke].radius)),
							(facette ? (this.corner[2].x - facette) - (this.corner[2].x - (this.scaleValue(ecken[ecke].radius) + p5)) : this.scaleValue(ecken[ecke].radius)), 90, 180);
				} else {
					this.config.bild.drawLine({
						strokeStyle: "#000",
						strokeWidth: 1,
						x1: this.corner[2].x - (facette ? facette : 0),
						y1: this.corner[2].y - (facette ? this.scaleValue(ecken[ecke].y) + p4 : this.scaleValue(ecken[ecke].y)),
						x2: this.corner[2].x - (facette ? this.scaleValue(ecken[ecke].x) + p5 : this.scaleValue(ecken[ecke].x)),
						y2: this.corner[2].y - (facette ? facette : 0)
					});
				}
			} else if (ecke == 'E4') {
				if (ecken[ecke].radius) {
					this.rundeEcke(
							this.corner[3].x + (facette ? this.scaleValue(ecken[ecke].radius) + p6 : this.scaleValue(ecken[ecke].radius)),
							this.corner[3].y - (facette ? this.scaleValue(ecken[ecke].radius) + p7 : this.scaleValue(ecken[ecke].radius)),
							(facette ? (this.corner[3].x + this.scaleValue(ecken[ecke].radius) + p6) - (this.corner[3].x + facette) : this.scaleValue(ecken[ecke].radius)), 180, 270);
				} else {
					this.config.bild.drawLine({
						strokeStyle: "#000",
						strokeWidth: 1,
						x1: this.corner[3].x + (facette ? this.scaleValue(ecken[ecke].x) + p6 : this.scaleValue(ecken[ecke].x)),
						y1: this.corner[3].y - (facette ? facette : 0),
						x2: this.corner[3].x + (facette ? facette : 0),
						y2: this.corner[3].y - (facette ? this.scaleValue(ecken[ecke].y) + p7 : this.scaleValue(ecken[ecke].y))
					});
				}

			}
		}
	};

	this.erstelleRundeHalter = function (halter, halterInfo) {
		if (halter.corner == "ALLE") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[0].x + this.scaleValue(halter.x), this.corner[0].y + this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[1].x - this.scaleValue(halter.x), this.corner[1].y + this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[2].x - this.scaleValue(halter.x), this.corner[2].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[3].x + this.scaleValue(halter.x), this.corner[3].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
			} else {
				this.zeichneKreis(true, 'halter', '#555555', 1, this.corner[0].x + this.scaleValue(halter.x), this.corner[0].y + this.scaleValue(halter.y), this.scaleValue((parseFloat(halterInfo.durchmesser) / 2)), '#FFFFFF');
				this.zeichneKreis(true, 'halter', '#555555', 1, this.corner[1].x - this.scaleValue(halter.x), this.corner[1].y + this.scaleValue(halter.y), this.scaleValue((parseFloat(halterInfo.durchmesser) / 2)), '#FFFFFF');
				this.zeichneKreis(true, 'halter', '#555555', 1, this.corner[2].x - this.scaleValue(halter.x), this.corner[2].y - this.scaleValue(halter.y), this.scaleValue((parseFloat(halterInfo.durchmesser) / 2)), '#FFFFFF');
				this.zeichneKreis(true, 'halter', '#555555', 1, this.corner[3].x + this.scaleValue(halter.x), this.corner[3].y - this.scaleValue(halter.y), this.scaleValue((parseFloat(halterInfo.durchmesser) / 2)), '#FFFFFF');
			}
		} else if (halter.corner == "E1") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[0].x + this.scaleValue(halter.x), this.corner[0].y + this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
			} else {
				this.zeichneKreis(true, 'halter', '#555555', 1, this.corner[0].x + this.scaleValue(halter.x), this.corner[0].y + this.scaleValue(halter.y), (this.scaleValue(parseFloat(halterInfo.durchmesser) / 2)), '#FFFFFF');
			}
		} else if (halter.corner == "E2") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[1].x - this.scaleValue(halter.x), this.corner[1].y + this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
			} else {
				this.zeichneKreis(true, 'halter', '#555555', 1, this.corner[1].x - this.scaleValue(halter.x), this.corner[1].y + this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser) / 2), '#FFFFFF');
			}
		} else if (halter.corner == "E3") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[2].x - this.scaleValue(halter.x), this.corner[2].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
			} else {
				this.zeichneKreis(true, 'halter', '#555555', 1, this.corner[2].x - this.scaleValue(halter.x), this.corner[2].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser) / 2), '#FFFFFF');
			}
		} else if (halter.corner == "E4") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[3].x + this.scaleValue(halter.x), this.corner[3].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
			} else {
				this.zeichneKreis(true, 'halter', '#555555', 1, this.corner[3].x + this.scaleValue(halter.x), this.corner[3].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser) / 2), '#FFFFFF');
			}
		} else if (halter.corner == "FREI") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[3].x + this.scaleValue(halter.x), this.corner[3].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
			} else {
				this.zeichneKreis(true, 'halter', '#555555', 1, this.corner[3].x + this.scaleValue(halter.x), this.corner[3].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser) / 2), '#FFFFFF');
			}
		}
	};
	this.erstelleSenkungHalter = function (halter, halterInfo) {
		// Bohrungdaten für Senkbohrungen
		var b = {
			dB: Number(halterInfo.plattenbohrungUnterseite),
			sB: Number(halterInfo.durchmesser),
			x: halter.x,
			y: halter.y
		};
		if (halter.corner == "ALLE") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[0].x + this.scaleValue(halter.x), this.corner[0].y + this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[1].x - this.scaleValue(halter.x), this.corner[1].y + this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[2].x - this.scaleValue(halter.x), this.corner[2].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[3].x + this.scaleValue(halter.x), this.corner[3].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
			} else {
				this.setSenkung(b, 'ALLE');
			}
		} else if (halter.corner == "E1") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[0].x + this.scaleValue(halter.x), this.corner[0].y + this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
			} else {
				this.setSenkung(b, 'E1');
			}
		} else if (halter.corner == "E2") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[1].x - this.scaleValue(halter.x), this.corner[1].y + this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
			} else {
				this.setSenkung(b, 'E2');
			}
		} else if (halter.corner == "E3") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[2].x - this.scaleValue(halter.x), this.corner[2].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
			} else {
				this.setSenkung(b, 'E3');
			}
		} else if (halter.corner == "E4") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[3].x + this.scaleValue(halter.x), this.corner[3].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
			} else {
				this.setSenkung(b, 'E4');
			}
		} else if (halter.corner == "FREI") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[3].x + this.scaleValue(halter.x), this.corner[3].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.durchmesser)), this.scaleValue(parseFloat(halterInfo.durchmesser)));
			} else {
				this.setSenkung(b, 'E4');
			}
		}
	};

	/*function erstelleKantenHalter(anzahl, halterInfo) {
	 if ((typeof anzahl != 'undefined') && (anzahl != '')) {
	 anzahl = Number(anzahl);
	 if (anzahl == 2) {
	 if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
	 zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[0].x, this.corner[0].y - (data.material.hoehe / 2) * this.config.scale, halterInfo.durchmesser * this.config.scale, halterInfo.durchmesser * this.config.scale);
	 zeichneHalterBild(true, 'halter', 'halter', this.config.halter + 'top' + halterInfo.bild, this.corner[1].x, this.corner[1].y - (data.material.hoehe / 2) * this.config.scale, halterInfo.durchmesser * this.config.scale, halterInfo.durchmesser * this.config.scale);
	 } else {
	 zeichneKreis(true, 'halter', '#555555', 1, this.corner[0].x, this.corner[0].y + (data.material.hoehe / 2) * this.config.scale, (halterInfo.durchmesser / 2) * this.config.scale, '#FFFFFF');
	 zeichneKreis(true, 'halter', '#555555', 1, this.corner[1].x, this.corner[1].y + (data.material.hoehe / 2) * this.config.scale, (halterInfo.durchmesser / 2) * this.config.scale, '#FFFFFF');
	 }
	 } else if (anzahl == 4) {
	 if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
	 zeichneHalterBild(true, 'halter', 'halter', this.config.halter + 'top' + halterInfo.bild, this.corner[0].x + (halterInfo.durchmesser) * this.config.scale, this.corner[0].y, halterInfo.durchmesser * this.config.scale, halterInfo.durchmesser * this.config.scale);
	 zeichneHalterBild(true, 'halter', 'halter', this.config.halter + 'top' + halterInfo.bild, this.corner[1].x - (halterInfo.durchmesser) * this.config.scale, this.corner[1].y, halterInfo.durchmesser * this.config.scale, halterInfo.durchmesser * this.config.scale);
	 zeichneHalterBild(true, 'halter', 'halter', this.config.halter + 'top' + halterInfo.bild, this.corner[2].x - (halterInfo.durchmesser) * this.config.scale, this.corner[2].y, halterInfo.durchmesser * this.config.scale, halterInfo.durchmesser * this.config.scale);
	 zeichneHalterBild(true, 'halter', 'halter', this.config.halter + 'top' + halterInfo.bild, this.corner[3].x + (halterInfo.durchmesser) * this.config.scale, this.corner[3].y, halterInfo.durchmesser * this.config.scale, halterInfo.durchmesser * this.config.scale);
	 } else {
	 zeichneKreis(true, 'halter', '#555555', 1, this.corner[0].x + (halterInfo.durchmesser) * this.config.scale, this.corner[0].y, (halterInfo.durchmesser / 2) * this.config.scale, '#FFFFFF');
	 zeichneKreis(true, 'halter', '#555555', 1, this.corner[1].x - (halterInfo.durchmesser) * this.config.scale, this.corner[1].y, (halterInfo.durchmesser / 2) * this.config.scale, '#FFFFFF');
	 zeichneKreis(true, 'halter', '#555555', 1, this.corner[2].x - (halterInfo.durchmesser) * this.config.scale, this.corner[2].y, (halterInfo.durchmesser / 2) * this.config.scale, '#FFFFFF');
	 zeichneKreis(true, 'halter', '#555555', 1, this.corner[3].x + (halterInfo.durchmesser) * this.config.scale, this.corner[3].y, (halterInfo.durchmesser / 2) * this.config.scale, '#FFFFFF');
	 }
	 }
	 }
	 }*/

	this.erstelleEckigeHalter = function (halter, halterInfo) {
		//log(halter, halterInfo);
		if (halter.corner == "ALLE") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[0].x + this.scaleValue(halter.x), this.corner[0].y + this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)));
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[1].x - this.scaleValue(halter.x), this.corner[1].y + this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)));
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[2].x - this.scaleValue(halter.x), this.corner[2].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)));
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[3].x + this.scaleValue(halter.x), this.corner[3].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)));
			} else {
				this.drawRect(true, 'halter', 'halter', '#555555', 1, 1, this.corner[0].x + this.scaleValue(halter.x), this.corner[0].y + this.scaleValue(halter.y), parseFloat(halterInfo.halterkantenlaenge), parseFloat(halterInfo.halterkantenlaenge));
				this.drawRect(true, 'halter', 'halter', '#555555', 1, 1, this.corner[1].x - this.scaleValue(halter.x), this.corner[1].y + this.scaleValue(halter.y), parseFloat(halterInfo.halterkantenlaenge), parseFloat(halterInfo.halterkantenlaenge));
				this.drawRect(true, 'halter', 'halter', '#555555', 1, 1, this.corner[2].x - this.scaleValue(halter.x), this.corner[2].y - this.scaleValue(halter.y), parseFloat(halterInfo.halterkantenlaenge), parseFloat(halterInfo.halterkantenlaenge));
				this.drawRect(true, 'halter', 'halter', '#555555', 1, 1, this.corner[3].x + this.scaleValue(halter.x), this.corner[3].y - this.scaleValue(halter.y), parseFloat(halterInfo.halterkantenlaenge), parseFloat(halterInfo.halterkantenlaenge));
			}
		} else if (halter.corner == "E1") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[0].x + this.scaleValue(halter.x), this.corner[0].y + this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)));
			} else {
				this.drawRect(true, 'halter', 'halter', '#555555', 1, 1, this.corner[0].x + this.scaleValue(halter.x), this.corner[0].y + this.scaleValue(halter.y), parseFloat(halterInfo.halterkantenlaenge), parseFloat(halterInfo.halterkantenlaenge));
			}
		} else if (halter.corner == "E2") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + '/top' + halterInfo.bild, this.corner[1].x - this.scaleValue(halter.x), this.corner[1].y + this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)));
			} else {
				this.drawRect(true, 'halter', 'halter', '#555555', 1, 1, this.corner[1].x - this.scaleValue(halter.x), this.corner[1].y + this.scaleValue(halter.y), parseFloat(halterInfo.halterkantenlaenge), parseFloat(halterInfo.halterkantenlaenge));
			}
		} else if (halter.corner == "E3") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[2].x - this.scaleValue(halter.x), this.corner[2].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)));
			} else {
				this.drawRect(true, 'halter', 'halter', '#555555', 1, 1, this.corner[2].x - this.scaleValue(halter.x), this.corner[2].y - this.scaleValue(halter.y), parseFloat(halterInfo.halterkantenlaenge), parseFloat(halterInfo.halterkantenlaenge));
			}
		} else if (halter.corner == "E4") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[3].x + this.scaleValue(halter.x), this.corner[3].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)));
			} else {
				this.drawRect(true, 'halter', 'halter', '#555555', 1, 1, this.corner[3].x + this.scaleValue(halter.x), this.corner[3].y - this.scaleValue(halter.y), parseFloat(halterInfo.halterkantenlaenge), parseFloat(halterInfo.halterkantenlaenge));
			}
		} else if (halter.corner == "FREI") {
			if ((typeof halterInfo.bild != 'undefined') && (halterInfo.bild != '')) {
				this.zeichneHalterBild(true, 'halter', 'halter', this.config.imgPaths.halter + 'top' + halterInfo.bild, this.corner[3].x + this.scaleValue(halter.x), this.corner[3].y - this.scaleValue(halter.y), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)), this.scaleValue(parseFloat(halterInfo.halterkantenlaenge)));
			} else {
				this.drawRect(true, 'halter', 'halter', '#555555', 1, 1, this.corner[3].x + this.scaleValue(halter.x), this.corner[3].y - this.scaleValue(halter.y), parseFloat(halterInfo.halterkantenlaenge), parseFloat(halterInfo.halterkantenlaenge));
			}
		}
	};

	this.zeichneHalter = function () {
		var halter = this.data.halter;
		for (var i = 0; i < halter.length; i++) {
			var selected = this.getHalterInfo(halter[i].hid, halter[i].vid);
			switch (selected.position) {
				case 'senkung':
					//log('Senkhalter')
					this.erstelleSenkungHalter(halter[i], selected);
					break;
				case 'inner':
					if (parseInt(selected.halterkantenlaenge) == '0') {
						//	log('runde Halter');
						this.erstelleRundeHalter(halter[i], selected);
					} else {
						//	log('eck Halter');
						this.erstelleEckigeHalter(halter[i], selected);
					}
					break;
				case 'kante':
					//this.erstelleKantenHalter(halter[i].anzahl, halter[i].info);
					break;
			}
		}
		return this;
	};

	this.scaleValue = function (val) {
		return Number(val * this.config.scale);
	};

	this.getFacettenVerschiebung = function (punkt, facette, x1, y1, x2, y2) {
		var res = 0;
		switch (punkt) {
			case 'P1':
				res = facette / Math.tan(((180 - ((Math.atan((y1 - y2) / (x2 - x1)) * 180) / Math.PI)) / 2) * Math.PI / 180);
				break;
			case 'P2':
				res = facette / Math.tan(((180 - ((Math.atan((y2 - y1) / (x2 - x1)) * 180) / Math.PI)) / 2) * Math.PI / 180);
				break;
			case 'P3':
				res = facette / Math.tan(((180 - ((Math.atan((x2 - x1) / (y2 - y1)) * 180) / Math.PI)) / 2) * Math.PI / 180);
				break;
			case 'P4':
				res = facette / Math.tan(((180 - ((Math.atan((x1 - x2) / (y2 - y1)) * 180) / Math.PI)) / 2) * Math.PI / 180);
				break;
			case 'P5':
				res = facette / Math.tan(((180 - ((Math.atan((y2 - y1) / (x1 - x2)) * 180) / Math.PI)) / 2) * Math.PI / 180);
				break;
			case 'P6':
				res = facette / Math.tan(((180 - ((Math.atan((y1 - y2) / (x1 - x2)) * 180) / Math.PI)) / 2) * Math.PI / 180);
				break;
			case 'P7':
				res = facette / Math.tan(((180 - ((Math.atan((x1 - x2) / (y1 - y2)) * 180) / Math.PI)) / 2) * Math.PI / 180);
				break;
			case 'P8':
				res = facette / Math.tan(((180 - ((Math.atan((x2 - x1) / (y1 - y2)) * 180) / Math.PI)) / 2) * Math.PI / 180);
				break;
		}
		return Math.abs(res);
	};
	this.getHalterInfo = function (hId, vId) {
		var config = this.data.configuration.halter;
		for (var i = 0; i < config.length; i++) {
			if (config[i].uid == hId) {
				for (var j = 0; j < config[i].varianten.length; j++) {
					if (config[i].varianten[j].uid == vId) {
						return config[i].varianten[j];
					}
				}
			}
		}
		return null;
	};
}