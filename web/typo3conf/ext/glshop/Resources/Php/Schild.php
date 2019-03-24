<?php

class Schild {

	public $log = false;
	public $data = array();
	public $corner = array();
	public $material = array(
		'width' => null,
		'height' => null
	);
	public $color = null;
	public $paths = array(
		'base' => null,
		'halter' => 'Resources/Public/Img/Products/',
		'fonts' => 'Resources/Public/Css/Fonts/',
		'save' => 'Resources/Private/Downloads/Zeichnungen/'
	);
	public $config = array(
		'offsetX' => 0,
		'offsetY' => 0,
		'tOffset' => 50, //80
		'scale' => 1,
		'bild' => null,
		'cWidth' => 600,
		'cHeight' => 600,
		'facette' => false
	);

	public function initialize($data, $path) {
		$this->config['offsetX'] = $this->config['cWidth'] / 2;
		$this->config['offsetY'] = $this->config['cHeight'] / 2;
		$this->data = $data;
		$this->material['width'] = $this->data['materialConfig']['width'];
		$this->material['height'] = $this->data['materialConfig']['height'];
		$this->paths['base'] = $path;
		$this->checkScale();
		$this->corner = $this->getCorner();
		if (isset($this->data['bearbeitungen']['kanten']['facette']) && ($this->data['bearbeitungen']['kanten']['facette'] != '')) {
			$this->config['facette'] = true;
		}
		return $this;
	}

	public function draw() {
		$this->clearCanvas()->drawSchild();
		$this->beschrifteEcken()->zeichneSkala();
		$this->zeichneBohrungen()->zeichneSenkungen();
		$this->zeichneHalter();
		return $this;
	}

	public function clearCanvas() {
		if (is_resource($this->config['bild'])) {
			imagedestroy($this->config['bild']);
		}
		$this->config['bild'] = imagecreate($this->config['cWidth'], $this->config['cHeight']);
		$this->iniColors();
		return $this;
	}

	public function iniColors() {
		$colors = array(
			'white' => ImageColorAllocate($this->config['bild'], 0xFF, 0xFF, 0xFF),
			'black' => ImageColorAllocate($this->config['bild'], 0x00, 0x00, 0x00)
		);
		$this->color = $colors;
		return $this;
	}

	public function getCorner() {
		$offsetX = $this->config['offsetX'];
		$offsetY = $this->config['offsetY'];
		$breite = $this->scaleValue($this->material['width']);
		$hoehe = $this->scaleValue($this->material['height']);
		$corner = array(
			//E1
			array(
				"x" => $offsetX - $breite / 2,
				"y" => $offsetY - $hoehe / 2
			// E2
			), array(
				"x" => $offsetX + $breite / 2,
				"y" => $offsetY - $hoehe / 2
			// E3
			), array(
				"x" => $offsetX + $breite / 2,
				"y" => $offsetY + $hoehe / 2
			// E4
			), array(
				"x" => $offsetX - $breite / 2,
				"y" => $offsetY + $hoehe / 2
		));
		return $corner;
	}

	/* public function checkScale() {
	  $sX = intval($this->material['width']);
	  $sY = intval($this->material['height']);
	  $cX = $this->config['cWidth'] - $this->config['tOffset'] * 2;
	  $cY = $this->config['cHeight'] - $this->config['tOffset'] * 2;
	  if ((($sX < $cX) && ($sY < $cY)) || (($sX > $cX) && ($sX > $cY))) {
	  if ($sX < $sY) {
	  $this->config['scale'] = $cY / $sY;
	  } else {
	  $this->config['scale'] = $cX / $sX;
	  }
	  } else if (($sX > $cX) && ($sY < $cY)) {
	  $this->config['scale'] = $cX / $sX;
	  } else if (($sX < $cX) && ($sY > $cY)) {
	  $this->config['scale'] = $cY / $sY;
	  }
	  if ($this->log)
	  log($this->config['scale']);
	  } */

	public function checkScale() {
		$sX = intval($this->material['width']);
		$sY = intval($this->material['height']);
		$cX = $this->config['cWidth'] - $this->config['tOffset'] * 2;
		$cY = $this->config['cHeight'] - $this->config['tOffset'] * 2;
		$this->debugTypo($sX, 'sX');
		$this->debugTypo($sY, 'sY');
		$this->debugTypo($cX, 'cX');
		$this->debugTypo($cY, 'cY');
		if (($sX > $cX) && ($sY > $cY)) {
			if ($sX > $sY) {
				$this->config['scale'] = $cX / $sX;
			} else if ($sX < $sY) {
				$this->config['scale'] = $cY / $sY;
			} else {
				$this->config['scale'] = $cX / $sX;
			}
		} else if (($sX < $cX) && ($sY < $cY)) {
			if ($sX > $sY) {
				$this->config['scale'] = $cX / $sX;
			} else if ($sX < $sY) {
				$this->config['scale'] = $cY / $sY;
			} else {
				$this->config['scale'] = $cX / $sX;
			}
		} else if (($sX > $cX) && ($sY <= $cY)) {
			$this->config['scale'] = $cX / $sX;
		} else if (($sX <= $cX) && ($sY > $cY)) {
			$this->config['scale'] = $cY / $sY;
		}
		$this->debugTypo($this->config['scale'], 'Scale');
	}

	public function saveImg($userId, $position) {
		$name = time() . $userId . $position . '.jpg';
		imagejpeg($this->config['bild'], $this->paths['base'] . $this->paths['save'] . $name, 100);
		$this->clearSpace();
		return $name;
	}

	public function clearSpace() {
		imagedestroy($this->config['bild']);
	}

	public function getEckRadius() {
		$r = 0;
		if (isset($this->data['bearbeitungen']['ecken'][0])) {
			if ($this->data['bearbeitungen']['ecken'][0]['corner'] == "ALLE") {
				if ($this->data['bearbeitungen']['ecken'][0]['radius'] != null) {
					$r = $this->data['bearbeitungen']['ecken'][0]['radius'];
				}
			}
		}
		return floatval($r);
	}

	public function drawSchild() {
		$corner = $this->data['bearbeitungen']['ecken'];
		if (count($corner) == 0) {
			$this->debugTypo('Normaler Schild', 'Schildtyp');
			$x = $this->config['offsetX'] - $this->scaleValue($this->material['width'] / 2);
			$y = $this->config['offsetY'] - $this->scaleValue($this->material['height'] / 2);
			$width = $this->scaleValue($this->material['width']);
			$height = $this->scaleValue($this->material['height']);
			$this->drawRect($x, $y, $width, $height);
			if ($this->config['facette']) {
				$facette = $this->scaleValue($this->data['bearbeitungen']['kanten']['facette']);
				$this->drawRect($x + $facette, $y + $facette, $width - $facette * 2, $height - $facette * 2);
			}
		} else if ($corner[0]['corner'] == "ALLE") {
			if ($corner[0]['radius']) {
				$this->debugTypo('Schild mit allen Runden Ecken', 'Schildtyp');

				$this->zeichneAlleEckenRund();
				if ($this->config['facette']) {
					$this->zeichneAlleEckenRund(floatval($this->data['bearbeitungen']['kanten']['facette']));
				}
			} else {
				$this->debugTypo('Schild mit allen Schrägen Ecken', 'Schildtyp');

				$this->zeichneAlleEckenSchraeg();
				if ($this->config['facette']) {
					$this->zeichneAlleEckenSchraeg(floatval($this->data['bearbeitungen']['kanten']['facette']));
				}
			}
		} else {
			$this->debugTypo('Schild mit unterschiedlichen Ecken', 'Schildtyp');

			$this->zeichneEcken();
			if ($this->config['facette']) {
				$this->zeichneEcken(floatval($this->data['bearbeitungen']['kanten']['facette']));
			}
		}
	}

	public function beschrifteEcken() {
		$breite = $this->scaleValue($this->material['width']);
		$hoehe = $this->scaleValue($this->material['height']);
		$xE1 = $this->config['offsetX'] - $breite / 2 - 20;
		$yE1 = $this->config['offsetY'] - $hoehe / 2 - 5;
		$xE2 = $this->config['offsetX'] + $breite / 2 + 5;
		$yE2 = $this->config['offsetY'] - $hoehe / 2 - 5;
		$xE3 = $this->config['offsetX'] + $breite / 2 + 5;
		$yE3 = $this->config['offsetY'] + $hoehe / 2 + 15;
		$xE4 = $this->config['offsetX'] - $breite / 2 - 20;
		$yE4 = $this->config['offsetY'] + $hoehe / 2 + 15;

		$this->beschriftung(9, 0, $xE1, $yE1, 'E1');
		$this->beschriftung(9, 0, $xE2, $yE2, 'E2');
		$this->beschriftung(9, 0, $xE3, $yE3, 'E3');
		$this->beschriftung(9, 0, $xE4, $yE4, 'E4');
		return $this;
	}

	/* public function beschrifteKanten() {
	  $schrift = "8pt Verdana, sans-serif";
	  $breite = $this->material['width'];
	  $hoehe = $this->material['height'];
	  $xE1 = $this->config['offsetX'];
	  $yE1 = $this->config['offsetY'] - $this->scaleValue($hoehe) / 2 - 10 - 13; // -13 Zeilenkorrektur
	  $xE2 = $this->config['offsetX'] + $this->scaleValue($breite) / 2 + 10 + 13; // +13 Zeilenkorrektur
	  $yE2 = $this->config['offsetY'];
	  $xE3 = $this->config['offsetX'];
	  $yE3 = $this->config['offsetY'] + $this->scaleValue($hoehe) / 2 + 10 + 13; // +13 Zeilenkorrektur
	  $xE4 = $this->config['offsetX'] - $this->scaleValue($breite) / 2 - 10 - 13; // -13 Zeilenkorrektur
	  $yE4 = $this->config['offsetY'];

	  $this->beschriftung(true, 'K1', 'kantenBeschriftung', '#E6E6E6', '#515151', 1, $xE1, $yE1, $schrift, 'K1: ' + $breite + ' mm', 0);
	  $this->beschriftung(true, 'K2', 'kantenBeschriftung', '#E6E6E6', '#515151', 1, $xE2, $yE2, $schrift, 'K2: ' + $hoehe + ' mm', 90);
	  $this->beschriftung(true, 'K3', 'kantenBeschriftung', '#E6E6E6', '#515151', 1, $xE3, $yE3, $schrift, 'K3: ' + $breite + ' mm', 0);
	  $this->beschriftung(true, 'K4', 'kantenBeschriftung', '#E6E6E6', '#515151', 1, $xE4, $yE4, $schrift, 'K4: ' + $hoehe + ' mm', 270);
	  return $this;
	  } */

	public function zeichneSkala() {
		//$this->beschriftung(10, 0, ($this->config['cWidth'] / 2 - $this->config['cWidth'] / 4), ($this->config['cHeight'] / 2 - $this->config['cHeight'] / 4), 'Scale: ' . $this->config['scale']);

		$scaleOld = $this->config['scale'];
		$this->config['scale'] = 1;

		$this->beschriftung(9, 0, 55, $this->config['cHeight'] - 5, 'X');
		$this->beschriftung(9, 0, 7, $this->config['cHeight'] - 55, 'Y');
		// Horizontaler Pfeil
		$this->drawLine(array(
			'x1' => 10,
			'y1' => $this->config['cHeight'] - 10,
			'x2' => 50,
			'y2' => $this->config['cHeight'] - 10
		))->drawLine(array(
			'x1' => 50,
			'y1' => $this->config['cHeight'] - 10,
			'x2' => 45,
			'y2' => $this->config['cHeight'] - 5
		))->drawLine(array(
			'x1' => 50,
			'y1' => $this->config['cHeight'] - 10,
			'x2' => 45,
			'y2' => $this->config['cHeight'] - 15
				// Vertikaler Pfeil
		))->drawLine(array(
			'x1' => 10,
			'y1' => $this->config['cHeight'] - 10,
			'x2' => 10,
			'y2' => $this->config['cHeight'] - 50
		))->drawLine(array(
			'x1' => 10,
			'y1' => $this->config['cHeight'] - 50,
			'x2' => 5,
			'y2' => $this->config['cHeight'] - 45
		))->drawLine(array(
			'x1' => 10,
			'y1' => $this->config['cHeight'] - 50,
			'x2' => 15,
			'y2' => $this->config['cHeight'] - 45
		));

		$this->config['scale'] = $scaleOld;
		return $this;
	}

	public function zeichneBohrungen() {
		$bohrungen = $this->data['bearbeitungen']['bohrungen'];
		
		$this->debugTypo($bohrungen, 'Bohrungen:');
				
		if (isset($bohrungen)) {
			for ($i = 0; $i < count($bohrungen); $i++) {
				$this->setBohrung($bohrungen[$i], $bohrungen[$i]['corner']);
			}
		}
		return $this;
	}

	public function zeichneSenkungen() {
		$senkungen = $this->data['bearbeitungen']['senkungen'];
		if (isset($senkungen)) {
			for ($i = 0; $i < count($senkungen); $i++) {
				$this->setSenkung($senkungen[$i], $senkungen[$i]['corner']);
			}
		}
		return $this;
	}

	public function setSenkung($bohrung, $corner) {
		switch ($corner) {
			case 'ALLE':
				$this->setSenkung($bohrung, 'E1');
				$this->setSenkung($bohrung, 'E2');
				$this->setSenkung($bohrung, 'E3');
				$this->setSenkung($bohrung, 'E4');
				break;
			case 'E1':
				$this->zeichneKreis($this->corner[0]['x'] + $this->scaleValue($bohrung['x']), $this->corner[0]['y'] + $this->scaleValue($bohrung['y']), $this->scaleValue($bohrung['dS'] / 2));
				$this->setBohrung($bohrung, $corner);
				break;
			case 'E2':
				$this->zeichneKreis($this->corner[1]['x'] - $this->scaleValue($bohrung['x']), $this->corner[1]['y'] + $this->scaleValue($bohrung['y']), $this->scaleValue($bohrung['dS'] / 2));
				$this->setBohrung($bohrung, $corner);
				break;
			case 'E3':
				$this->zeichneKreis($this->corner[2]['x'] - $this->scaleValue($bohrung['x']), $this->corner[2]['y'] - $this->scaleValue($bohrung['y']), $this->scaleValue($bohrung['dS'] / 2));
				$this->setBohrung($bohrung, $corner);
				break;
			case 'E4':
				$this->zeichneKreis($this->corner[3]['x'] + $this->scaleValue($bohrung['x']), $this->corner[3]['y'] - $this->scaleValue($bohrung['y']), $this->scaleValue($bohrung['dS'] / 2));
				$this->setBohrung($bohrung, $corner);
				break;
			case 'FREI':
				$this->zeichneKreis($this->corner[3]['x'] + $this->scaleValue($bohrung['x']), $this->corner[3]['y'] - $this->scaleValue($bohrung['y']), $this->scaleValue($bohrung['dS'] / 2));
				$this->setBohrung($bohrung, $corner);
				break;
		}
	}

	public function setBohrung($bohrung, $corner) {
		switch ($corner) {
			case 'ALLE':
				$this->setBohrung($bohrung, 'E1');
				$this->setBohrung($bohrung, 'E2');
				$this->setBohrung($bohrung, 'E3');
				$this->setBohrung($bohrung, 'E4');
				break;
			case 'E1':
				$this->zeichneKreis($this->corner[0]['x'] + $this->scaleValue($bohrung['x']), $this->corner[0]['y'] + $this->scaleValue($bohrung['y']), $this->scaleValue($bohrung['dB'] / 2));
				break;
			case 'E2':
				$this->zeichneKreis($this->corner[1]['x'] - $this->scaleValue($bohrung['x']), $this->corner[1]['y'] + $this->scaleValue($bohrung['y']), $this->scaleValue($bohrung['dB'] / 2));
				break;
			case 'E3':
				$this->zeichneKreis($this->corner[2]['x'] - $this->scaleValue($bohrung['x']), $this->corner[2]['y'] - $this->scaleValue($bohrung['y']), $this->scaleValue($bohrung['dB'] / 2));
				break;
			case 'E4':
				$this->zeichneKreis($this->corner[3]['x'] + $this->scaleValue($bohrung['x']), $this->corner[3]['y'] - $this->scaleValue($bohrung['y']), $this->scaleValue($bohrung['dB'] / 2));
				break;
			case 'FREI':
				$this->zeichneKreis($this->corner[3]['x'] + $this->scaleValue($bohrung['x']), $this->corner[3]['y'] - $this->scaleValue($bohrung['y']), $this->scaleValue($bohrung['dB'] / 2));
				break;
		}
	}

	public function zeichneHalterBild($source, $x, $y, $width, $height) {
		$halterImg = imagecreatefromstring(file_get_contents($source));
		imagecopymerge($this->config['bild'], $halterImg, $x, $y, 0, 0, $width, $height, 100);
		return $this;
	}

	public function zeichneAlleEckenSchraeg($facette = null) {
		$eingabe = $this->data['bearbeitungen']['ecken'];
		$ecken = array();
		$p1 = 0;
		$p2 = 0;
		$p3 = 0;
		$p4 = 0;
		$p5 = 0;
		$p6 = 0;
		$p7 = 0;
		$p8 = 0;
		for ($i = 0; $i < count($eingabe); $i++) {
			$ecken[$eingabe[$i]['corner']] = $eingabe[$i];
		}

		$this->debugTypo($facette, 'Facette:');

		if ($facette) {
			$facette = $this->scaleValue($facette);
			// Ecke 0
			$p8x1 = $this->corner[0]['x'];
			$p8y1 = $this->corner[0]['y'] + $this->scaleValue($ecken['ALLE']['y']);
			$p1x2 = $this->corner[0]['x'] + $this->scaleValue($ecken['ALLE']['x']);
			$p1y2 = $this->corner[0]['y'];
			// Ecke 1
			$p2x1 = $this->corner[1]['x'] - $this->scaleValue($ecken['ALLE']['x']);
			$p2y1 = $this->corner[1]['y'];
			$p3x2 = $this->corner[1]['x'];
			$p3y2 = $this->corner[1]['y'] + $this->scaleValue($ecken['ALLE']['y']);
			// Ecke 2
			$p4x1 = $this->corner[2]['x'];
			$p4y1 = $this->corner[2]['y'] - $this->scaleValue($ecken['ALLE']['y']);
			$p5x2 = $this->corner[2]['x'] - $this->scaleValue($ecken['ALLE']['x']);
			$p5y2 = $this->corner[2]['y'];
			// Ecke 3
			$p6x1 = $this->corner[3]['x'] + $this->scaleValue($ecken['ALLE']['x']);
			$p6y1 = $this->corner[3]['y'];
			$p7x2 = $this->corner[3]['x'];
			$p7y2 = $this->corner[3]['y'] - $this->scaleValue($ecken['ALLE']['y']);
			//Verschiebungen
			$p1 = floatval($this->getFacettenVerschiebung('P1', $facette, $p8x1, $p8y1, $p1x2, $p1y2));
			$p2 = floatval($this->getFacettenVerschiebung('P2', $facette, $p2x1, $p2y1, $p3x2, $p3y2));
			$p3 = floatval($this->getFacettenVerschiebung('P3', $facette, $p2x1, $p2y1, $p3x2, $p3y2));
			$p4 = floatval($this->getFacettenVerschiebung('P4', $facette, $p4x1, $p4y1, $p5x2, $p5y2));
			$p5 = floatval($this->getFacettenVerschiebung('P5', $facette, $p4x1, $p4y1, $p5x2, $p5y2));
			$p6 = floatval($this->getFacettenVerschiebung('P6', $facette, $p6x1, $p6y1, $p7x2, $p7y2));
			$p7 = floatval($this->getFacettenVerschiebung('P7', $facette, $p6x1, $p6y1, $p7x2, $p7y2));
			$p8 = floatval($this->getFacettenVerschiebung('P8', $facette, $p8x1, $p8y1, $p1x2, $p1y2));
		}

		$this->debugTypo($this->config['scale'], 'Skalierung:');
		$this->debugTypo($facette, 'Facette skaliert:');

		$x = $this->scaleValue($ecken['ALLE']['x']);
		$y = $this->scaleValue($ecken['ALLE']['y']);

		$this->drawLine(array(
			'x1' => $this->corner[0]['x'] + ($facette ? ($x + $p1) : $x),
			'y1' => $this->corner[0]['y'] + ($facette ? $facette : 0),
			'x2' => $this->corner[1]['x'] - ($facette ? ($x + $p2) : $x),
			'y2' => $this->corner[1]['y'] + ($facette ? $facette : 0)
		))->drawLine(array(
			'x1' => $this->corner[1]['x'] - ($facette ? $facette : 0),
			'y1' => $this->corner[1]['y'] + ($facette ? ($y + $p3) : $y),
			'x2' => $this->corner[2]['x'] - ($facette ? $facette : 0),
			'y2' => $this->corner[2]['y'] - ($facette ? ($y + $p4) : $y)
		))->drawLine(array(
			'x1' => $this->corner[2]['x'] - ($facette ? ($x + $p5) : $x),
			'y1' => $this->corner[2]['y'] - ($facette ? $facette : 0),
			'x2' => $this->corner[3]['x'] + ($facette ? ($x + $p6) : $x),
			'y2' => $this->corner[3]['y'] - ($facette ? $facette : 0)
		))->drawLine(array(
			'x1' => $this->corner[3]['x'] + ($facette ? $facette : 0),
			'y1' => $this->corner[3]['y'] - ($facette ? ($y + $p7) : $y),
			'x2' => $this->corner[0]['x'] + ($facette ? $facette : 0),
			'y2' => $this->corner[0]['y'] + ($facette ? ($y + $p8) : $y)
		));
		$this->drawLine(array(
			'x1' => $this->corner[1]['x'] - ($facette ? ($x + $p2) : $x),
			'y1' => $this->corner[1]['y'] + ($facette ? $facette : 0),
			'x2' => $this->corner[1]['x'] - ($facette ? $facette : 0),
			'y2' => $this->corner[1]['y'] + ($facette ? ($y + $p3) : $y)
		))->drawLine(array(
			'x1' => $this->corner[2]['x'] - ($facette ? $facette : 0),
			'y1' => $this->corner[2]['y'] - ($facette ? ($y + $p4) : $y),
			'x2' => $this->corner[2]['x'] - ($facette ? ($x + $p5) : $x),
			'y2' => $this->corner[2]['y'] - ($facette ? $facette : 0)
		))->drawLine(array(
			'x1' => $this->corner[3]['x'] + ($facette ? ($x + $p6) : $x),
			'y1' => $this->corner[3]['y'] - ($facette ? $facette : 0),
			'x2' => $this->corner[3]['x'] + ($facette ? $facette : 0),
			'y2' => $this->corner[3]['y'] - ($facette ? ($y + $p7) : $y)
		))->drawLine(array(
			'x1' => $this->corner[0]['x'] + ($facette ? $facette : 0),
			'y1' => $this->corner[0]['y'] + ($facette ? ($y + $p8) : $y),
			'x2' => $this->corner[0]['x'] + ($facette ? ($x + $p1) : $x),
			'y2' => $this->corner[0]['y'] + ($facette ? $facette : 0)
		));
	}

	public function zeichneAlleEckenRund($facette = null) {
		$eingabe = $this->data['bearbeitungen']['ecken'];
		$ecken = array();
		$p1 = 0;
		$p2 = 0;
		$p3 = 0;
		$p4 = 0;
		$p5 = 0;
		$p6 = 0;
		$p7 = 0;
		$p8 = 0;
		for ($i = 0; $i < count($eingabe); $i++) {
			$ecken[$eingabe[$i]['corner']] = $eingabe[$i];
		}

		if ($facette) {
			$facette = $this->scaleValue($facette);
			// Ecke 0
			$p8x1 = $this->corner[0]['x'];
			$p8y1 = $this->corner[0]['y'] + $this->scaleValue($ecken['ALLE']['radius']);
			$p1x2 = $this->corner[0]['x'] + $this->scaleValue($ecken['ALLE']['radius']);
			$p1y2 = $this->corner[0]['y'];
			// Ecke 1
			$p2x1 = $this->corner[1]['x'] - $this->scaleValue($ecken['ALLE']['radius']);
			$p2y1 = $this->corner[1]['y'];
			$p3x2 = $this->corner[1]['x'];
			$p3y2 = $this->corner[1]['y'] + $this->scaleValue($ecken['ALLE']['radius']);
			// Ecke 2
			$p4x1 = $this->corner[2]['x'];
			$p4y1 = $this->corner[2]['y'] - $this->scaleValue($ecken['ALLE']['radius']);
			$p5x2 = $this->corner[2]['x'] - $this->scaleValue($ecken['ALLE']['radius']);
			$p5y2 = $this->corner[2]['y'];
			// Ecke 3
			$p6x1 = $this->corner[3]['x'] + $this->scaleValue($ecken['ALLE']['radius']);
			$p6y1 = $this->corner[3]['y'];
			$p7x2 = $this->corner[3]['x'];
			$p7y2 = $this->corner[3]['y'] - $this->scaleValue($ecken['ALLE']['radius']);
			//Verschiebungen
			$p1 = floatval($this->getFacettenVerschiebung('P1', $facette, $p8x1, $p8y1, $p1x2, $p1y2));
			$p2 = floatval($this->getFacettenVerschiebung('P2', $facette, $p2x1, $p2y1, $p3x2, $p3y2));
			$p3 = floatval($this->getFacettenVerschiebung('P3', $facette, $p2x1, $p2y1, $p3x2, $p3y2));
			$p4 = floatval($this->getFacettenVerschiebung('P4', $facette, $p4x1, $p4y1, $p5x2, $p5y2));
			$p5 = floatval($this->getFacettenVerschiebung('P5', $facette, $p4x1, $p4y1, $p5x2, $p5y2));
			$p6 = floatval($this->getFacettenVerschiebung('P6', $facette, $p6x1, $p6y1, $p7x2, $p7y2));
			$p7 = floatval($this->getFacettenVerschiebung('P7', $facette, $p6x1, $p6y1, $p7x2, $p7y2));
			$p8 = floatval($this->getFacettenVerschiebung('P8', $facette, $p8x1, $p8y1, $p1x2, $p1y2));
		}

		$r = $this->scaleValue($ecken['ALLE']['radius']);

		$this->drawLine(array(
			'x1' => $this->corner[0]['x'] + ($facette ? $r + $p1 : $r),
			'y1' => $this->corner[0]['y'] + ($facette ? $facette : 0),
			'x2' => $this->corner[1]['x'] - ($facette ? $r + $p2 : $r),
			'y2' => $this->corner[1]['y'] + ($facette ? $facette : 0)
		));

		$this->drawLine(array(
			'x1' => $this->corner[1]['x'] - ($facette ? $facette : 0),
			'y1' => $this->corner[1]['y'] + ($facette ? $r + $p3 : $r),
			'x2' => $this->corner[2]['x'] - ($facette ? $facette : 0),
			'y2' => $this->corner[2]['y'] - ($facette ? $r + $p4 : $r)
		));
		$this->drawLine(array(
			'x1' => $this->corner[2]['x'] - ($facette ? $r + $p5 : $r),
			'y1' => $this->corner[2]['y'] - ($facette ? $facette : 0),
			'x2' => $this->corner[3]['x'] + ($facette ? $r + $p6 : $r),
			'y2' => $this->corner[3]['y'] - ($facette ? $facette : 0)
		));
		$this->drawLine(array(
			'x1' => $this->corner[3]['x'] + ($facette ? $facette : 0),
			'y1' => $this->corner[3]['y'] - ($facette ? $r + $p7 : $r),
			'x2' => $this->corner[0]['x'] + ($facette ? $facette : 0),
			'y2' => $this->corner[0]['y'] + ($facette ? $r + $p8 : $r)
		));

		$this->rundeEcke(
				$this->corner[0]['x'] + ($facette ? $r + $p1 : $r), $this->corner[0]['y'] + ($facette ? $r + $p8 : $r), ($facette ? ($this->corner[0]['x'] + $r + $p1) - ($this->corner[0]['x'] + $facette) : $r), 180, 270);
		$this->rundeEcke(
				$this->corner[1]['x'] - ($facette ? $r + $p2 : $r), $this->corner[1]['y'] + ($facette ? $r + $p3 : $r), ($facette ? ($this->corner[1]['x'] - $facette) - ($this->corner[1]['x'] - ($r + $p2)) : $r), 270, 360);
		$this->rundeEcke(
				$this->corner[2]['x'] - ($facette ? $r + $p5 : $r), $this->corner[2]['y'] - ($facette ? $r + $p4 : $r), ($facette ? ($this->corner[2]['x'] - $facette) - ($this->corner[2]['x'] - ($r + $p5)) : $r), 0, 90);
		$this->rundeEcke(
				$this->corner[3]['x'] + ($facette ? $r + $p6 : $r), $this->corner[3]['y'] - ($facette ? $r + $p7 : $r), ($facette ? ($this->corner[3]['x'] + $r + $p6) - ($this->corner[3]['x'] + $facette) : $r), 90, 180);
	}

	public function zeichneEcken($facette = null) {
		$eingabe = $this->data['bearbeitungen']['ecken'];
		$ecken = array();
		$p1 = 0;
		$p2 = 0;
		$p3 = 0;
		$p4 = 0;
		$p5 = 0;
		$p6 = 0;
		$p7 = 0;
		$p8 = 0;
		for ($i = 0; $i < count($eingabe); $i++) {
			$ecken[$eingabe[$i]['corner']] = $eingabe[$i];
		}

		$e1x = $ecken['E1']['x'];
		$e1y = $ecken['E1']['y'];
		$e1r = $ecken['E1']['radius'];
		$e2x = $ecken['E2']['x'];
		$e2y = $ecken['E2']['y'];
		$e2r = $ecken['E2']['radius'];
		$e3x = $ecken['E3']['x'];
		$e3y = $ecken['E3']['y'];
		$e3r = $ecken['E3']['radius'];
		$e4x = $ecken['E4']['x'];
		$e4y = $ecken['E4']['y'];
		$e4r = $ecken['E4']['radius'];

		if ($facette) {
			$facette = $this->scaleValue($facette);
			// Ecke 0
			$p8x1 = floatval($this->corner[0]['x']);
			$p8y1 = floatval($this->corner[0]['y'] + ($ecken['E1'] ? ($e1r ? $this->scaleValue($e1r) : $this->scaleValue($e1y)) : 0));
			$p1x2 = floatval($this->corner[0]['x'] + ($ecken['E1'] ? ($e1r ? $this->scaleValue($e1r) : $this->scaleValue($e1x)) : 0));
			$p1y2 = floatval($this->corner[0]['y']);
			// Ecke 1
			$p2x1 = floatval($this->corner[1]['x'] - ($ecken['E2'] ? ($e2r ? $this->scaleValue($e2r) : $this->scaleValue($e2x)) : 0));
			$p2y1 = floatval($this->corner[1]['y']);
			$p3x2 = floatval($this->corner[1]['x']);
			$p3y2 = floatval($this->corner[1]['y'] + ($ecken['E2'] ? ($e2r ? $this->scaleValue($e2r) : $this->scaleValue($e2y)) : 0));
			// Ecke 2
			$p4x1 = floatval($this->corner[2]['x']);
			$p4y1 = floatval($this->corner[2]['y'] - ($ecken['E3'] ? ($e3r ? $this->scaleValue($e3r) : $this->scaleValue($e3y)) : 0));
			$p5x2 = floatval($this->corner[2]['x'] - ($ecken['E3'] ? ($e3r ? $this->scaleValue($e3r) : $this->scaleValue($e3x)) : 0));
			$p5y2 = floatval($this->corner[2]['y']);
			// Ecke 3
			$p6x1 = floatval($this->corner[3]['x'] + ($ecken['E4'] ? ($e4r ? $this->scaleValue($e4r) : $this->scaleValue($e4x)) : 0));
			$p6y1 = floatval($this->corner[3]['y']);
			$p7x2 = floatval($this->corner[3]['x']);
			$p7y2 = floatval($this->corner[3]['y'] - ($ecken['E4'] ? ($e4r ? $this->scaleValue($e4r) : $this->scaleValue($e4y)) : 0));
			//Verschiebungen
			$p1 = (($p1x2 - $p8x1) != 0 ? floatval($this->getFacettenVerschiebung('P1', $facette, $p8x1, $p8y1, $p1x2, $p1y2)) : 0);
			$p2 = (($p3x2 - $p2x1) != 0 ? floatval($this->getFacettenVerschiebung('P2', $facette, $p2x1, $p2y1, $p3x2, $p3y2)) : 0);
			$p3 = (($p3y2 - $p2y1) != 0 ? floatval($this->getFacettenVerschiebung('P3', $facette, $p2x1, $p2y1, $p3x2, $p3y2)) : 0);
			$p4 = (($p5y2 - $p4y1) != 0 ? floatval($this->getFacettenVerschiebung('P4', $facette, $p4x1, $p4y1, $p5x2, $p5y2)) : 0);
			$p5 = (($p4x1 - $p5x2) != 0 ? floatval($this->getFacettenVerschiebung('P5', $facette, $p4x1, $p4y1, $p5x2, $p5y2)) : 0);
			$p6 = (($p6x1 - $p7x2) != 0 ? floatval($this->getFacettenVerschiebung('P6', $facette, $p6x1, $p6y1, $p7x2, $p7y2)) : 0);
			$p7 = (($p6y1 - $p7y2) != 0 ? floatval($this->getFacettenVerschiebung('P7', $facette, $p6x1, $p6y1, $p7x2, $p7y2)) : 0);
			$p8 = (($p8y1 - $p1y2) != 0 ? floatval($this->getFacettenVerschiebung('P8', $facette, $p8x1, $p8y1, $p1x2, $p1y2)) : 0);
		}

		$this->drawLine(array(
			'x1' => $this->corner[0]['x'] + ($ecken['E1'] ? ($facette ? ($e1r ? $this->scaleValue($e1r) + $p1 : $this->scaleValue($e1x) + $p1) : ($e1r ? $this->scaleValue($e1r) : $this->scaleValue($e1x))) : ($facette ? $facette : 0)),
			'y1' => $this->corner[0]['y'] + ($facette ? $facette : 0),
			'x2' => $this->corner[1]['x'] - ($ecken['E2'] ? ($facette ? ($e2r ? $this->scaleValue($e2r) + $p2 : $this->scaleValue($e2x) + $p2) : ($e2r ? $this->scaleValue($e2r) : $this->scaleValue($e2x))) : ($facette ? $facette : 0)),
			'y2' => $this->corner[1]['y'] + ($facette ? $facette : 0)
		))->drawLine(array(
			'x1' => $this->corner[1]['x'] - ($facette ? $facette : 0),
			'y1' => $this->corner[1]['y'] + ($ecken['E2'] ? ($facette ? ($e2r ? $this->scaleValue($e2r) + $p3 : $this->scaleValue($e2y) + $p3) : ($e2r ? $this->scaleValue($e2r) : $this->scaleValue($e2y))) : ($facette ? $facette : 0)),
			'x2' => $this->corner[2]['x'] - ($facette ? $facette : 0),
			'y2' => $this->corner[2]['y'] - ($ecken['E3'] ? ($facette ? ($e3r ? $this->scaleValue($e3r) + $p4 : $this->scaleValue($e3y) + $p4) : ($e3r ? $this->scaleValue($e3r) : $this->scaleValue($e3y))) : ($facette ? $facette : 0))
		))->drawLine(array(
			'x1' => $this->corner[2]['x'] - ($ecken['E3'] ? ($facette ? ($e3r ? $this->scaleValue($e3r) + $p5 : $this->scaleValue($e3x) + $p5) : ($e3r ? $this->scaleValue($e3r) : $this->scaleValue($e3x))) : ($facette ? $facette : 0)),
			'y1' => $this->corner[2]['y'] - ($facette ? $facette : 0),
			'x2' => $this->corner[3]['x'] + ($ecken['E4'] ? ($facette ? ($e4r ? $this->scaleValue($e4r) + $p6 : $this->scaleValue($e4x) + $p6) : ($e4r ? $this->scaleValue($e4r) : $this->scaleValue($e4x))) : ($facette ? $facette : 0)),
			'y2' => $this->corner[3]['y'] - ($facette ? $facette : 0)
		))->drawLine(array(
			'x1' => $this->corner[3]['x'] + ($facette ? $facette : 0),
			'y1' => $this->corner[3]['y'] - ($ecken['E4'] ? ($facette ? ($e4r ? $this->scaleValue($e4r) + $p7 : $this->scaleValue($e4y) + $p7) : ($e4r ? $this->scaleValue($e4r) : $this->scaleValue($e4y))) : ($facette ? $facette : 0)),
			'x2' => $this->corner[0]['x'] + ($facette ? $facette : 0),
			'y2' => $this->corner[0]['y'] + ($ecken['E1'] ? ($facette ? ($e1r ? $this->scaleValue($e1r) + $p8 : $this->scaleValue($e1y) + $p8) : ($e1r ? $this->scaleValue($e1r) : $this->scaleValue($e1y))) : ($facette ? $facette : 0))
		));

		foreach ($ecken as $ecke => $value) {
			if ($ecke == 'E1') {
				if ($value['radius']) {
					$this->rundeEcke(
							$this->corner[0]['x'] + ($facette ? $this->scaleValue($value['radius']) + $p1 : $this->scaleValue($value['radius'])), $this->corner[0]['y'] + ($facette ? $this->scaleValue($value['radius']) + $p8 : $this->scaleValue($value['radius'])), ($facette ? ($this->corner[0]['x'] + $this->scaleValue($value['radius']) + $p1) - ($this->corner[0]['x'] + $facette) : $this->scaleValue($value['radius'])), 180, 270);
				} else {
					$this->drawLine(array(
						'x1' => $this->corner[0]['x'] + ($facette ? $facette : 0),
						'y1' => $this->corner[0]['y'] + ($facette ? $this->scaleValue($value['y']) + $p8 : $this->scaleValue($value['y'])),
						'x2' => $this->corner[0]['x'] + ($facette ? $this->scaleValue($value['x']) + $p1 : $this->scaleValue($value['x'])),
						'y2' => $this->corner[0]['y'] + ($facette ? $facette : 0)
					));
				}
			} else if ($ecke == 'E2') {
				if ($value['radius']) {
					$this->rundeEcke(
							$this->corner[1]['x'] - ($facette ? $this->scaleValue($value['radius']) + $p2 : $this->scaleValue($value['radius'])), $this->corner[1]['y'] + ($facette ? $this->scaleValue($value['radius']) + $p3 : $this->scaleValue($value['radius'])), ($facette ? ($this->corner[1]['x'] - $facette) - ($this->corner[1]['x'] - ($this->scaleValue($value['radius']) + $p2)) : $this->scaleValue($value['radius'])), 270, 360);
				} else {
					$this->drawLine(array(
						'x1' => $this->corner[1]['x'] - ($facette ? $this->scaleValue($value['x']) + $p2 : $this->scaleValue($value['x'])),
						'y1' => $this->corner[1]['y'] + ($facette ? $facette : 0),
						'x2' => $this->corner[1]['x'] - ($facette ? $facette : 0),
						'y2' => $this->corner[1]['y'] + ($facette ? $this->scaleValue($value['y']) + $p3 : $this->scaleValue($value['y']))
					));
				}
			} else if ($ecke == 'E3') {
				if ($value['radius']) {
					$this->rundeEcke(
							$this->corner[2]['x'] - ($facette ? $this->scaleValue($value['radius']) + $p5 : $this->scaleValue($value['radius'])), $this->corner[2]['y'] - ($facette ? $this->scaleValue($value['radius']) + $p4 : $this->scaleValue($value['radius'])), ($facette ? ($this->corner[2]['x'] - $facette) - ($this->corner[2]['x'] - ($this->scaleValue($value['radius']) + $p5)) : $this->scaleValue($value['radius'])), 0, 90);
				} else {
					$this->drawLine(array(
						'x1' => $this->corner[2]['x'] - ($facette ? $facette : 0),
						'y1' => $this->corner[2]['y'] - ($facette ? $this->scaleValue($value['y']) + $p4 : $this->scaleValue($value['y'])),
						'x2' => $this->corner[2]['x'] - ($facette ? $this->scaleValue($value['x']) + $p5 : $this->scaleValue($value['x'])),
						'y2' => $this->corner[2]['y'] - ($facette ? $facette : 0)
					));
				}
			} else if ($ecke == 'E4') {
				if ($value['radius']) {
					$this->rundeEcke(
							$this->corner[3]['x'] + ($facette ? $this->scaleValue($value['radius']) + $p6 : $this->scaleValue($value['radius'])), $this->corner[3]['y'] - ($facette ? $this->scaleValue($value['radius']) + $p7 : $this->scaleValue($value['radius'])), ($facette ? ($this->corner[3]['x'] + $this->scaleValue($value['radius']) + $p6) - ($this->corner[3]['x'] + $facette) : $this->scaleValue($value['radius'])), 90, 180);
				} else {
					$this->drawLine(array(
						'x1' => $this->corner[3]['x'] + ($facette ? $this->scaleValue($value['x']) + $p6 : $this->scaleValue($value['x'])),
						'y1' => $this->corner[3]['y'] - ($facette ? $facette : 0),
						'x2' => $this->corner[3]['x'] + ($facette ? $facette : 0),
						'y2' => $this->corner[3]['y'] - ($facette ? $this->scaleValue($value['y']) + $p7 : $this->scaleValue($value['y']))
					));
				}
			}
		}
	}

	public function erstelleRundeHalter($halter, $halterInfo) {
		if ($halter['corner'] == "ALLE") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[0]['x'] + $halter['x'], $this->corner[0]['y'] + $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[1]['x'] - $halter['x'], $this->corner[1]['y'] + $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[2]['x'] - $halter['x'], $this->corner[2]['y'] - $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[3]['x'] + $halter['x'], $this->corner[3]['y'] - $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
			} else {
				$this->zeichneKreis($this->corner[0]['x'] + $halter['x'], $this->corner[0]['y'] + $halter['y'], floatval($halterInfo['durchmesser']) / 2);
				$this->zeichneKreis($this->corner[1]['x'] - $halter['x'], $this->corner[1]['y'] + $halter['y'], floatval($halterInfo['durchmesser']) / 2);
				$this->zeichneKreis($this->corner[2]['x'] - $halter['x'], $this->corner[2]['y'] - $halter['y'], floatval($halterInfo['durchmesser']) / 2);
				$this->zeichneKreis($this->corner[3]['x'] + $halter['x'], $this->corner[3]['y'] - $halter['y'], floatval($halterInfo['durchmesser']) / 2);
			}
		} else if ($halter['corner'] == "E1") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[0]['x'] + $halter['x'], $this->corner[0]['y'] + $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
			} else {
				$this->zeichneKreis($this->corner[0]['x'] + $halter['x'], $this->corner[0]['y'] + $halter['y'], floatval($halterInfo['durchmesser']) / 2);
			}
		} else if ($halter['corner'] == "E2") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[1]['x'] - $halter['x'], $this->corner[1]['y'] + $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
			} else {
				$this->zeichneKreis(true, 'halter', '#555555', 1, $this->corner[1]['x'] - $halter['x'], $this->corner[1]['y'] + $halter['y'], floatval($halterInfo['durchmesser']) / 2);
			}
		} else if ($halter['corner'] == "E3") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[2]['x'] - $halter['x'], $this->corner[2]['y'] - $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
			} else {
				$this->zeichneKreis(true, 'halter', '#555555', 1, $this->corner[2]['x'] - $halter['x'], $this->corner[2]['y'] - $halter['y'], floatval($halterInfo['durchmesser']) / 2);
			}
		} else if ($halter['corner'] == "E4") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[3]['x'] + $halter['x'], $this->corner[3]['y'] - $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
			} else {
				$this->zeichneKreis(true, 'halter', '#555555', 1, $this->corner[3]['x'] + $halter['x'], $this->corner[3]['y'] - $halter['y'], floatval($halterInfo['durchmesser']) / 2);
			}
		} else if ($halter['corner'] == "FREI") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[3]['x'] + $halter['x'], $this->corner[3]['y'] - $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
			} else {
				$this->zeichneKreis($this->corner[3]['x'] + $halter['x'], $this->corner[3]['y'] - $halter['y'], floatval($halterInfo['durchmesser']) / 2);
			}
		}
	}

	public function erstelleSenkungHalter($halter, $halterInfo) {
		// Bohrungdaten für Senkbohrungen
		$b = array(
			'dB' => floatval($halterInfo['plattenbohrungUnterseite']),
			'sB' => floatval($halterInfo['durchmesser']),
			'x' => $halter['x'],
			'y' => $halter['y']
		);
		if ($halter['corner'] == "ALLE") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[0]['x'] + $halter['x'], $this->corner[0]['y'] + $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[1]['x'] - $halter['x'], $this->corner[1]['y'] + $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[2]['x'] - $halter['x'], $this->corner[2]['y'] - $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[3]['x'] + $halter['x'], $this->corner[3]['y'] - $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
			} else {
				$this->setSenkung($b, 'ALLE');
			}
		} else if ($halter['corner'] == "E1") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[0]['x'] + $halter['x'], $this->corner[0]['y'] + $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
			} else {
				$this->setSenkung($b, 'E1');
			}
		} else if ($halter['corner'] == "E2") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[1]['x'] - $halter['x'], $this->corner[1]['y'] + $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
			} else {
				$this->setSenkung($b, 'E2');
			}
		} else if ($halter['corner'] == "E3") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[2]['x'] - $halter['x'], $this->corner[2]['y'] - $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
			} else {
				$this->setSenkung($b, 'E3');
			}
		} else if ($halter['corner'] == "E4") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[3]['x'] + $halter['x'], $this->corner[3]['y'] - $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
			} else {
				$this->setSenkung($b, 'E4');
			}
		} else if ($halter['corner'] == "FREI") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[3]['x'] + $halter['x'], $this->corner[3]['y'] - $halter['y'], floatval($halterInfo['durchmesser']), floatval($halterInfo['durchmesser']));
			} else {
				$this->setSenkung($b, 'E4');
			}
		}
	}

	/* function erstelleKantenHalter(anzahl, halterInfo) {
	  if ((typeof anzahl != 'undefined') && (anzahl != '')) {
	  anzahl = floatval(anzahl);
	  if (anzahl == 2) {
	  if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
	  zeichneHalterBild(true, 'halter', 'halter', $this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[0]['x'], $this->corner[0]['y'] - (data.material.hoehe / 2) * $this->config['scale'], $halterInfo['durchmesser'] * $this->config['scale'], $halterInfo['durchmesser'] * $this->config['scale']);
	  zeichneHalterBild(true, 'halter', 'halter', $this->config.halter + 'top' + $halterInfo['bild'], $this->corner[1]['x'], $this->corner[1]['y'] - (data.material.hoehe / 2) * $this->config['scale'], $halterInfo['durchmesser'] * $this->config['scale'], $halterInfo['durchmesser'] * $this->config['scale']);
	  } else {
	  zeichneKreis(true, 'halter', '#555555', 1, $this->corner[0]['x'], $this->corner[0]['y'] + (data.material.hoehe / 2) * $this->config['scale'], ($halterInfo['durchmesser'] / 2) * $this->config['scale'], '#FFFFFF');
	  zeichneKreis(true, 'halter', '#555555', 1, $this->corner[1]['x'], $this->corner[1]['y'] + (data.material.hoehe / 2) * $this->config['scale'], ($halterInfo['durchmesser'] / 2) * $this->config['scale'], '#FFFFFF');
	  }
	  } else if (anzahl == 4) {
	  if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
	  zeichneHalterBild(true, 'halter', 'halter', $this->config.halter + 'top' + $halterInfo['bild'], $this->corner[0]['x'] + ($halterInfo['durchmesser']) * $this->config['scale'], $this->corner[0]['y'], $halterInfo['durchmesser'] * $this->config['scale'], $halterInfo['durchmesser'] * $this->config['scale']);
	  zeichneHalterBild(true, 'halter', 'halter', $this->config.halter + 'top' + $halterInfo['bild'], $this->corner[1]['x'] - ($halterInfo['durchmesser']) * $this->config['scale'], $this->corner[1]['y'], $halterInfo['durchmesser'] * $this->config['scale'], $halterInfo['durchmesser'] * $this->config['scale']);
	  zeichneHalterBild(true, 'halter', 'halter', $this->config.halter + 'top' + $halterInfo['bild'], $this->corner[2]['x'] - ($halterInfo['durchmesser']) * $this->config['scale'], $this->corner[2]['y'], $halterInfo['durchmesser'] * $this->config['scale'], $halterInfo['durchmesser'] * $this->config['scale']);
	  zeichneHalterBild(true, 'halter', 'halter', $this->config.halter + 'top' + $halterInfo['bild'], $this->corner[3]['x'] + ($halterInfo['durchmesser']) * $this->config['scale'], $this->corner[3]['y'], $halterInfo['durchmesser'] * $this->config['scale'], $halterInfo['durchmesser'] * $this->config['scale']);
	  } else {
	  zeichneKreis(true, 'halter', '#555555', 1, $this->corner[0]['x'] + ($halterInfo['durchmesser']) * $this->config['scale'], $this->corner[0]['y'], ($halterInfo['durchmesser'] / 2) * $this->config['scale'], '#FFFFFF');
	  zeichneKreis(true, 'halter', '#555555', 1, $this->corner[1]['x'] - ($halterInfo['durchmesser']) * $this->config['scale'], $this->corner[1]['y'], ($halterInfo['durchmesser'] / 2) * $this->config['scale'], '#FFFFFF');
	  zeichneKreis(true, 'halter', '#555555', 1, $this->corner[2]['x'] - ($halterInfo['durchmesser']) * $this->config['scale'], $this->corner[2]['y'], ($halterInfo['durchmesser'] / 2) * $this->config['scale'], '#FFFFFF');
	  zeichneKreis(true, 'halter', '#555555', 1, $this->corner[3]['x'] + ($halterInfo['durchmesser']) * $this->config['scale'], $this->corner[3]['y'], ($halterInfo['durchmesser'] / 2) * $this->config['scale'], '#FFFFFF');
	  }
	  }
	  }
	  } */

	public function erstelleEckigeHalter($halter, $halterInfo) {
		$this->debugTypo($halter, 'Halter:');
		$this->debugTypo($halterInfo, 'HalterInfo:');
		if ($halter['corner'] == "ALLE") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[0]['x'] + $halter['x'], $this->corner[0]['y'] + $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[1]['x'] - $halter['x'], $this->corner[1]['y'] + $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[2]['x'] - $halter['x'], $this->corner[2]['y'] - $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[3]['x'] + $halter['x'], $this->corner[3]['y'] - $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
			} else {
				$this->drawRect($this->corner[0]['x'] + $halter['x'], $this->corner[0]['y'] + $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
				$this->drawRect($this->corner[1]['x'] - $halter['x'], $this->corner[1]['y'] + $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
				$this->drawRect($this->corner[2]['x'] - $halter['x'], $this->corner[2]['y'] - $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
				$this->drawRect($this->corner[3]['x'] + $halter['x'], $this->corner[3]['y'] - $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
			}
		} else if ($halter['corner'] == "E1") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[0]['x'] + $halter['x'], $this->corner[0]['y'] + $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
			} else {
				$this->drawRect($this->corner[0]['x'] + $halter['x'], $this->corner[0]['y'] + $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
			}
		} else if ($halter['corner'] == "E2") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + '/top' + $halterInfo['bild'], $this->corner[1]['x'] - $halter['x'], $this->corner[1]['y'] + $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
			} else {
				$this->drawRect($this->corner[1]['x'] - $halter['x'], $this->corner[1]['y'] + $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
			}
		} else if ($halter['corner'] == "E3") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[2]['x'] - $halter['x'], $this->corner[2]['y'] - $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
			} else {
				$this->drawRect($this->corner[2]['x'] - $halter['x'], $this->corner[2]['y'] - $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
			}
		} else if ($halter['corner'] == "E4") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[3]['x'] + $halter['x'], $this->corner[3]['y'] - $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
			} else {
				$this->drawRect($this->corner[3]['x'] + $halter['x'], $this->corner[3]['y'] - $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
			}
		} else if ($halter['corner'] == "FREI") {
			if (isset($halterInfo['bild']) && ($halterInfo['bild'] != '')) {
				$this->zeichneHalterBild($this->paths['base'] . $this->paths['halter'] + 'top' + $halterInfo['bild'], $this->corner[3]['x'] + $halter['x'], $this->corner[3]['y'] - $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
			} else {
				$this->drawRect($this->corner[3]['x'] + $halter['x'], $this->corner[3]['y'] - $halter['y'], floatval($halterInfo['halterkantenlaenge']), floatval($halterInfo['halterkantenlaenge']));
			}
		}
	}

	public function zeichneHalter() {
		$halter = $this->data['halter'];
		for ($i = 0; $i < count($halter); $i++) {
			$selected = $this->getHalterInfo($halter[$i]['hid'], $halter[$i]['vid']);
			switch ($selected['position']) {
				case 'senkung':
					//log('Senkhalter')
					$this->erstelleSenkungHalter($halter[$i], $selected);
					break;
				case 'inner':
					if (intval($selected['halterkantenlaenge']) == '0') {
						//	log('runde Halter');
						$this->erstelleRundeHalter($halter[$i], $selected);
					} else {
						//	log('eck Halter');
						$this->erstelleEckigeHalter($halter[$i], $selected);
					}
					break;
				case 'kante':
					//$this->erstelleKantenHalter(halter[i].anzahl, halter[i].info);
					break;
			}
		}
		return this;
	}

	public function zeichneKreis($x, $y, $radius) {
		imagearc(
				$this->config['bild'], $x, $y, $radius * 2, $radius * 2, 0, 360, $this->color['black']
		);
		return $this;
	}

	public function rundeEcke($x, $y, $radius, $start, $end) {

		imagearc(
				$this->config['bild'], $x, $y, $radius * 2, $radius * 2, $start, $end, $this->color['black']
		);
		return $this;
	}

	public function drawRect($x, $y, $width, $height) {
		ImageRectangle(
				$this->config['bild'], $x, $y, $x + $width, $y + $height, $this->color['black']
		);
		return $this;
	}

	public function beschriftung($size, $angle, $x, $y, $text) {

		$path = $this->paths['base'] . $this->paths['fonts'];
		$font = 'verdana.ttf';

		ImageTTFText(
				$this->config['bild'], $size, $angle, $x, $y, $this->color['black'], $path . $font, $text
		);
		return $this;
	}

	public function drawLine($points) {
		imageline(
				$this->config['bild'], $points['x1'], $points['y1'], $points['x2'], $points['y2'], $this->color['black']
		);
		return $this;
	}

	public function scaleValue($val) {
		return floatval($val * $this->config['scale']);
	}

	public function getFacettenVerschiebung($punkt, $facette, $x1, $y1, $x2, $y2) {
		$res = 0;
		switch ($punkt) {
			case 'P1':
				$res = $facette / tan(((180 - ((atan(($y1 - $y2) / ($x2 - $x1)) * 180) / pi())) / 2) * pi() / 180);
				break;
			case 'P2':
				$res = $facette / tan(((180 - ((atan(($y2 - $y1) / ($x2 - $x1)) * 180) / pi())) / 2) * pi() / 180);
				break;
			case 'P3':
				$res = $facette / tan(((180 - ((atan(($x2 - $x1) / ($y2 - $y1)) * 180) / pi())) / 2) * pi() / 180);
				break;
			case 'P4':
				$res = $facette / tan(((180 - ((atan(($x1 - $x2) / ($y2 - $y1)) * 180) / pi())) / 2) * pi() / 180);
				break;
			case 'P5':
				$res = $facette / tan(((180 - ((atan(($y2 - $y1) / ($x1 - $x2)) * 180) / pi())) / 2) * pi() / 180);
				break;
			case 'P6':
				$res = $facette / tan(((180 - ((atan(($y1 - $y2) / ($x1 - $x2)) * 180) / pi())) / 2) * pi() / 180);
				break;
			case 'P7':
				$res = $facette / tan(((180 - ((atan(($x1 - $x2) / ($y1 - $y2)) * 180) / pi())) / 2) * pi() / 180);
				break;
			case 'P8':
				$res = $facette / tan(((180 - ((atan(($x2 - $x1) / ($y1 - $y2)) * 180) / pi())) / 2) * pi() / 180);
				break;
		}
		return abs($res);
	}

	public function getHalterInfo($hId, $vId) {
		$config = $this->data['configuration']['halter'];
		for ($i = 0; $i < count($config); $i++) {
			if ($config[$i]['uid'] == $hId) {
				for ($j = 0; $j < count($config[$i]['varianten']); $j++) {
					if ($config[$i]['varianten'][$j]['uid'] == $vId) {
						return $config[$i]['varianten'][$j];
					}
				}
			}
		}
		return null;
	}

	public function debugTypo($data, $name = '') {
		if ($this->log) {
			\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data, $name);
		}
	}

}

?>