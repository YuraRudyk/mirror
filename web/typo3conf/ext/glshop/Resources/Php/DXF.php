<?php

if (!defined('_WRITER_PATH'))
	define('_WRITER_PATH', dirname(preg_replace('/\\\\/', '/', __FILE__)) . '/');

// DXF-writer
require_once(_WRITER_PATH . 'DxfWriter/DXFwriter.php');

class DXF {

	public $d = null;
	public $offset = 5;
	public $positionen = array();
	public $w = null;
	public $h = null;
	public $ecken = null;
	public $bohrungen = null;
	public $senkungen = null;
	public $generated = array();
	public $artikel = null;
	public $extPath = null;
	public $auNr = '';

	public function __construct($artikel, $extPath, $auNr) {
		$this->extPath = $extPath;
		$this->artikel = $artikel;
		$this->auNr = $auNr;
		$this->iniData();
		$this->schilderZeichnen();
		$this->getFileList(true);
	}

	public function schilderZeichnen() {
		$positionen = $this->positionen;

		foreach ($positionen as $nr => $pos) {
			$this->d = new DxfWriter();
			$this->d->appendStyle(new DxfStyle(array('widthFactor' => 0, 'obliqueAngle' => 0)));

			$this->w = $pos['w'];
			$this->h = $pos['h'];
			$this->ecken = (isset($pos['ecken']) ? $pos['ecken'] : null);
			$this->bohrungen = (isset($pos['bohrungen']) ? $pos['bohrungen'] : null);
			$this->senkungen = (isset($pos['senkungen']) ? $pos['senkungen'] : null);


			$ecken = $this->ecken;
			if (!isset($ecken)) {
				$this->addNormalSchild($pos);
			} else {
				if (isset($ecken['ALLE'])) {
					if (isset($ecken['ALLE']['r'])) {
						$this->addSchildAlleRund($ecken['ALLE']['r']);
					} else {
						$this->addSchildAlleSchraeg($ecken['ALLE']['x'], $ecken['ALLE']['y']);
					}
				} else {
					$this->addKantenForSchild();
					foreach ($ecken as $ecke => $value) {
						if (isset($value['r'])) {
							$this->addRundeEcke($ecke, $value['r']);
						} else {
							$this->addSchraegeEcke($ecke, $value['x'], $value['y']);
						}
					}
				}
			}

			$this->addBohrungen();
			$this->addSenkungen();

			//$this->beschrifteSchild();

			$this->saveDxf('BI_' . $this->auNr . '_Pos' . $pos['pos'] . '.dxf', $pos['pos']);
		}
	}

	public function addBohrungen() {
		$bohrungen = $this->bohrungen;
		$w = $this->w;
		$h = $this->h;

		if (isset($bohrungen)) {
			foreach ($bohrungen as $ecke => $value) {
				if ($ecke == 'ALLE') {
					$this->addBohrung($value['x'], $h - $value['y'], $value['dB']); // E1
					$this->addBohrung($w - $value['x'], $h - $value['y'], $value['dB']); //E2
					$this->addBohrung($w - $value['x'], $value['y'], $value['dB']); // E3
					$this->addBohrung($value['x'], $value['y'], $value['dB']); // E4		
				} else if ($ecke == 'E1') {
					$this->addBohrung($value['x'], $h - $value['y'], $value['dB']); // E1
				} else if ($ecke == 'E2') {
					$this->addBohrung($w - $value['x'], $h - $value['y'], $value['dB']); //E2
				} else if ($ecke == 'E3') {
					$this->addBohrung($w - $value['x'], $value['y'], $value['dB']); // E3
				} else if ($ecke == 'E4') {
					$this->addBohrung($value['x'], $value['y'], $value['dB']); // E4		
				} else if ($ecke == 'FREI') {
					$this->addBohrung($value['x'], $value['y'], $value['dB']); // E4		
				}
			}
		}
	}

	public function addSenkungen() {
		$senkungen = $this->senkungen;
		$w = $this->w;
		$h = $this->h;

		if (isset($senkungen)) {
			foreach ($senkungen as $ecke => $value) {
				if ($ecke == 'ALLE') {
					$this->addBohrung($value['x'], $h - $value['y'], $value['dB']); // E1
					$this->addBohrung($value['x'], $h - $value['y'], $value['dS']); // E1
					$this->addBohrung($w - $value['x'], $h - $value['y'], $value['dB']); //E2
					$this->addBohrung($w - $value['x'], $h - $value['y'], $value['dS']); //E2
					$this->addBohrung($w - $value['x'], $value['y'], $value['dB']); // E3
					$this->addBohrung($w - $value['x'], $value['y'], $value['dS']); // E3
					$this->addBohrung($value['x'], $value['y'], $value['dB']); // E4		
					$this->addBohrung($value['x'], $value['y'], $value['dS']); // E4		
				} else if ($ecke == 'E1') {
					$this->addBohrung($value['x'], $h - $value['y'], $value['dB']); // E1
					$this->addBohrung($value['x'], $h - $value['y'], $value['dS']); // E1
				} else if ($ecke == 'E2') {
					$this->addBohrung($w - $value['x'], $h - $value['y'], $value['dB']); //E2
					$this->addBohrung($w - $value['x'], $h - $value['y'], $value['dS']); //E2
				} else if ($ecke == 'E3') {
					$this->addBohrung($w - $value['x'], $value['y'], $value['dB']); // E3
					$this->addBohrung($w - $value['x'], $value['y'], $value['dS']); // E3
				} else if ($ecke == 'E4') {
					$this->addBohrung($value['x'], $value['y'], $value['dB']); // E4		
					$this->addBohrung($value['x'], $value['y'], $value['dS']); // E4		
				} else if ($ecke == 'FREI') {
					$this->addBohrung($value['x'], $value['y'], $value['dB']); // E4		
					$this->addBohrung($value['x'], $value['y'], $value['dS']); // E4		
				}
			}
		}
	}

	public function addBohrung($x, $y, $d) {
		$this->d->append(new DxfCircle(array('center' => array($x, $y), 'radius' => $d / 2, 'color' => 3)));
	}

	public function addNormalSchild() {
		$w = $this->w;
		$h = $this->h;

		$this->d->append(new DxfSolid(array('points' => array(
				array(0, 0),
				array($w, 0),
				array(0, $h),
				array($w, $h)),
			'color' => 250)
		));
	}

	public function addKantenForSchild() {
		$w = $this->w;
		$h = $this->h;
		$ecke = $this->ecken;

// $ecken = array('r'=>10, 'x'=>null, 'y' =>null);
// $ecken = array('r'=>null, 'x'=>10, 'y' =>10);

		$this->d->append(new DxfLine(array('points' => array(
				array($w - (isset($ecke['E2']['r']) ? $ecke['E2']['r'] : (isset($ecke['E2']['x']) ? $ecke['E2']['x'] : 0) ), $h),
				array((isset($ecke['E1']['r']) ? $ecke['E1']['r'] : (isset($ecke['E1']['x']) ? $ecke['E1']['x'] : 0) ), $h),
			), 'color' => 3))); // K1
		$this->d->append(new DxfLine(array('points' => array(
				array($w, (isset($ecke['E3']['r']) ? $ecke['E3']['r'] : (isset($ecke['E3']['y']) ? $ecke['E3']['y'] : 0) )),
				array($w, $h - (isset($ecke['E2']['r']) ? $ecke['E2']['r'] : (isset($ecke['E2']['y']) ? $ecke['E2']['y'] : 0) )),
			), 'color' => 3))); // K2
		$this->d->append(new DxfLine(array('points' => array(
				array((isset($ecke['E4']['r']) ? $ecke['E4']['r'] : (isset($ecke['E4']['x']) ? $ecke['E4']['x'] : 0) ), 0),
				array($w - (isset($ecke['E3']['r']) ? $ecke['E3']['r'] : (isset($ecke['E3']['x']) ? $ecke['E3']['x'] : 0) ), 0),
			), 'color' => 3))); // K3
		$this->d->append(new DxfLine(array('points' => array(
				array(0, $h - (isset($ecke['E1']['r']) ? $ecke['E1']['r'] : (isset($ecke['E1']['y']) ? $ecke['E1']['y'] : 0) )),
				array(0, (isset($ecke['E4']['r']) ? $ecke['E4']['r'] : (isset($ecke['E4']['y']) ? $ecke['E4']['y'] : 0) )),
			), 'color' => 3))); // K4
	}

	public function addSchildAlleRund($r) {
		$this->addKantenForSchild();
		$this->addRundeEcke('ALLE', $r);
	}

	public function addSchildAlleSchraeg($x, $y) {
		$this->addKantenForSchild();
		$this->addSchraegeEcke('ALLE', $x, $y);
	}

	public function addSchraegeEcke($ecke, $x, $y) {
		$w = $this->w;
		$h = $this->h;
		switch ($ecke) {
			case 'ALLE':
				$this->addSchraegeEcke('E1', $x, $y);
				$this->addSchraegeEcke('E2', $x, $y);
				$this->addSchraegeEcke('E3', $x, $y);
				$this->addSchraegeEcke('E4', $x, $y);
				break;
			case 'E1':
				$this->d->append(new DxfLine(array('points' => array(
						array(0, $h - $y),
						array($x, $h),
					), 'color' => 3))); // E1 
				break;
			case 'E2':
				$this->d->append(new DxfLine(array('points' => array(
						array($w - $x, $h),
						array($w, $h - $y),
					), 'color' => 3))); // E2
				break;
			case 'E3':
				$this->d->append(new DxfLine(array('points' => array(
						array($w, $y),
						array($w - $x, 0),
					), 'color' => 3))); // E3
				break;
			case 'E4':
				$this->d->append(new DxfLine(array('points' => array(
						array($x, 0),
						array(0, $y),
					), 'color' => 3))); // E4
				break;
		}
	}

	public function addRundeEcke($ecke, $r) {
		$w = $this->w;
		$h = $this->h;

		switch ($ecke) {
			case 'ALLE':
				$this->addRundeEcke('E1', $r);
				$this->addRundeEcke('E2', $r);
				$this->addRundeEcke('E3', $r);
				$this->addRundeEcke('E4', $r);
				break;
			case 'E1':
				$this->d->append(new DxfArc(array('center' => array($r, $h - $r, 0), 'radius' => $r, 'startAngle' => 90, 'endAngle' => 180, 'color' => 250, 'layer' => 'radius'))); // E1
				break;
			case 'E2':
				$this->d->append(new DxfArc(array('center' => array($w - $r, $h - $r, 0), 'radius' => $r, 'startAngle' => 0, 'endAngle' => 90, 'color' => 250, 'layer' => 'radius'))); // E2
				break;
			case 'E3':
				$this->d->append(new DxfArc(array('center' => array($w - $r, $r, 0), 'radius' => $r, 'startAngle' => 270, 'endAngle' => 360, 'color' => 250, 'layer' => 'radius'))); // E3
				break;
			case 'E4':
				$this->d->append(new DxfArc(array('center' => array($r, $r, 0), 'radius' => $r, 'startAngle' => 180, 'endAngle' => 270, 'color' => 250, 'layer' => 'radius'))); // E4
				break;
		}
	}

	public function beschrifteSchild() {
		$w = $this->w;
		$h = $this->h;

//Beschriftung
		$this->d->append(new DxfText(array('text' => 'E1', 'point' => array(0 - 4 * $this->offset, $h + 2 * $this->offset), 'height' => 15)));
		$this->d->append(new DxfText(array('text' => 'E2', 'point' => array($w + $this->offset, $h + 2 * $this->offset), 'height' => 15)));
		$this->d->append(new DxfText(array('text' => 'E3', 'point' => array($w + $this->offset, 0 - 4 * $this->offset), 'height' => 15)));
		$this->d->append(new DxfText(array('text' => 'E4', 'point' => array(0 - 4 * $this->offset, 0 - 4 * $this->offset), 'height' => 15)));
	}

	public function saveDxf($name, $pos) {

		$path = $this->extPath . 'Resources/Private/Downloads/Dxf/' . $name;

		$this->d->saveAs($path);
		if (file_exists($path)) {
			array_push($this->generated, array('file' => $name, 'res' => true, 'pos' => $pos));
			return true;
		}
		array_push($this->generated, array('file' => $name, 'res' => false, 'pos' => $pos));
		return false;
	}

	public function getFileList($return) {
		$html = 'Generierte Dateien: <br/>';
		$bad = 'Fehlgeschlagen: <br/>';
		$files = $this->generated;
		for ($i = 0; $i < count($files); $i++) {
			if ($files[$i]['res']) {
				$html .= '<a href="' . $files[$i]['file'] . '">' . $files[$i]['file'] . '</a><br/>';
			} else {
				$bad .= $files[$i]['file'] . '<br />';
			}
		}
		if ($return) {
			return $this->generated;
		} else {
			echo $html . '<br><br>' . $bad;
		}
	}

	public function iniData() {
		$orders = unserialize($this->artikel);

		foreach ($orders as $pos => $order) {
			$artikel = $order['artikel'];
			//$this->debugTypo($artikel);
			if (isset($artikel['material'])) {
				$position = array(
					'pos' => $pos,
					'w' => $artikel['materialConfig']['width'],
					'h' => $artikel['materialConfig']['height'],
					'ecken' => array(),
					'bohrungen' => array(),
					'senkungen' => array()
				);
				$edit = $artikel['bearbeitungen'];

				if (isset($edit['ecken'])) {
					$ecken = array();
					for ($i = 0; $i < count($edit['ecken']); $i++) {
						$position['ecken'][$edit['ecken'][$i]['corner']] = array(
							'r' => (isset($edit['ecken'][$i]['radius']) && ($edit['ecken'][$i]['radius'] != '') ? $edit['ecken'][$i]['radius'] : null),
							'x' => (isset($edit['ecken'][$i]['x']) && ($edit['ecken'][$i]['x'] != '') ? $edit['ecken'][$i]['x'] : null),
							'y' => (isset($edit['ecken'][$i]['y']) && ($edit['ecken'][$i]['y'] != '') ? $edit['ecken'][$i]['y'] : null)
						);
					}
				}

				if (isset($edit['bohrungen'])) {
					$bohrungen = array();
					for ($i = 0; $i < count($edit['bohrungen']); $i++) {
						$position['bohrungen'][$edit['bohrungen'][$i]['corner']] = array(
							'dB' => (isset($edit['bohrungen'][$i]['dB']) && ($edit['bohrungen'][$i]['dB'] != '') ? $edit['bohrungen'][$i]['dB'] : null),
							'dS' => (isset($edit['bohrungen'][$i]['dS']) && ($edit['bohrungen'][$i]['dS'] != '') ? $edit['bohrungen'][$i]['dS'] : null),
							'x' => (isset($edit['bohrungen'][$i]['x']) && ($edit['bohrungen'][$i]['x'] != '') ? $edit['bohrungen'][$i]['x'] : null),
							'y' => (isset($edit['bohrungen'][$i]['y']) && ($edit['bohrungen'][$i]['y'] != '') ? $edit['bohrungen'][$i]['y'] : null)
						);
					}
				}

				if (isset($edit['senkungen'])) {
					$senkungen = array();
					for ($i = 0; $i < count($edit['senkungen']); $i++) {
						$position['senkungen'][$edit['senkungen'][$i]['corner']] = array(
							'dB' => (isset($edit['senkungen'][$i]['dB']) && ($edit['senkungen'][$i]['dB'] != '') ? $edit['senkungen'][$i]['dB'] : null),
							'dS' => (isset($edit['senkungen'][$i]['dS']) && ($edit['senkungen'][$i]['dS'] != '') ? $edit['senkungen'][$i]['dS'] : null),
							'x' => (isset($edit['senkungen'][$i]['x']) && ($edit['senkungen'][$i]['x'] != '') ? $edit['senkungen'][$i]['x'] : null),
							'y' => (isset($edit['senkungen'][$i]['y']) && ($edit['senkungen'][$i]['y'] != '') ? $edit['senkungen'][$i]['y'] : null)
						);
					}
				}
				array_push($this->positionen, $position);
			}
		}
	}

	public function debugTypo($data) {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
	}

	public function debug($data, $functions = false, $vars = false, $fluid = false) {
		if ($fluid) {
			$this->view->assign('debug', $data);
		} else {
			echo "<pre>";
			if ($functions) {
				$class_methods = get_class_methods($data);
				foreach ($class_methods as $method_name) {
					echo "$method_name\n";
				}
			} else if ($vars) {
				var_dump(get_object_vars($data));
			} else {
				var_dump($data);
			}
			echo "</pre>";
		}
	}

}

?>