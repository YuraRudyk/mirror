<?php

class Vorlagen {

	public $AB = 'ab';
	public $FE = 'fe';
	public $LS = 'ls';
	public $LSK = 'lsK';
	public $RE = 're';
	public $REK = 'reK';
	public $ABMAIL = 'abMail';
	protected $ab;
	protected $fe;
	protected $ls;
	protected $lsK;
	protected $re;
	protected $reK;
	protected $abMail;
	protected $htmlKopf = '	<!DOCTYPE html>
							<html>
								<head>
									<title></title>
									<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
									<link rel="stylesheet" type="text/css" href="style.css" media="all">
								</head>
								<body>';
	protected $htmlFooter = '	</body>
							</html>';
	protected $extPath;
	protected $order;
	protected $user;
	protected $konfigData;
	protected $nextNumber;
	protected $opt;
	protected $kdAdressen;
	protected $zBed;
	protected $countries = array(
		'DEU' => 'Deutschland',
		'AUT' => '&Ouml;sterreich',
		'CHE' => 'Schweiz'
	);
	protected $ausfuhr = array(
		'CHE'
	);

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

	public function initialize($data, $mail = false) {
		if (!$mail) {

			//$this->debugTypo($data);
			$this->extPath = $data['extPath'];
			$this->order = $data['order'];
			$this->user = $data['user'];
			$this->abUid = $data['abUid'];
			$this->konfigData = $data['konfigData'];
			$this->nextNumber = $data['nextNumber'];
			$this->opt = $data['opt'];
			$this->zBed = $data['zBed'];
			$this->kdAdressen = $data['kdAdressen'];
		} else {
			$this->createAbMail($data);
		}
	}

	public function getVorlage($opt) {
		switch ($opt) {
			case 'ab':
				return $this->createAb();
				break;
			case 'fe':
				return $this->createFe();
				break;
			case 'ls':
				return $this->createLs();
				break;
			case 'lsK':
				return $this->createLsK();
				break;
			case 're':
				return $this->createRe();
				break;
			case 'reK':
				return $this->createReK();
				break;
			case 'abMail':
				return $this->abMail;
				break;
			default:
				return false;
				break;
		}
	}

	public function debugTypo($data, $name = 'Debug') {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data, $name);
	}

	public function createAb() {

		//$this->debugTypo('Start');
		$order = $this->order;
		$user = $this->user;

		$formular = unserialize($order->getFormular());

		//$this->debugTypo($order);

		$html = $this->htmlKopf;

		$html .= '<!--mpdf';
		$html .= '<htmlpageheader name="myheader">';
		$html .= '<div class="logo">';
		//$html .= '<img src="' . $this->extPath . 'Resources/Php/Mpdf/imgs/logo.jpg" />';
		$html .= '<img src="https://www.glacryl.de/typo3conf/ext/glshop/Resources/Php/Mpdf/imgs/logo.jpg" />';
		$html .= '</div>';
		$html .= '<div class="clearer"></div>';
		$html .= '<div class="header">';
		$html .= '<div class="adresse">';

		$html .= $this->getAdressBlock($user);

		$html .= '</div>';
		$html .= '<div class="infoDaten">';
		$html .= '<p>AUFTRAGSBEST&Auml;TIGUNG</p>';
		$html .= '<table>';
		$html .= '<tr>';
		$html .= '<td>Auftrag Nummer</td>';

		$html .= '<td>I' . $this->nextNumber['ab'] . '</td>';

		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Kunden-Nummer</td>';
		$html .= '<td>' . $user->getUid() . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Bestelldatum</td>';
		$orderDate = $order->getDate();

		if (is_int($orderDate)) {
			$html .= '<td>' . date('d.m.Y', $orderDate) . '</td>';
		} else {
			$html .= '<td>' . $orderDate->format('d.m.Y') . '</td>';
		}
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>LT abgehend</td>';
		$html .= '<td>' . $formular['lieferzeit'] . '</td>';
		$html .= '</tr>';
		$html .= '</table>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</htmlpageheader> ';

		$html .= $this->getPaperFooter('ab');

		$html .= '<sethtmlpageheader name="myheader" value="on" show-this-page="1" />';
		$html .= '<sethtmlpagefooter name="myfooter" value="on" />';
		$html .= 'mpdf-->';
		$html .= '<div class="clearer"></div>';
		$html .= '<div class="content">';
		$html .= '<div>';
		$html .= '<p style="font-weight: bold; margin-bottom: 10px;">Sehr geehrte Damen und Herren,</p>';
		$html .= '<p>Wir danken f&uuml;r Ihren Auftrag und fertigen bzw. liefern nach unseren Allgemeinen Gesch&auml;ftsbedingungen folgende Positionen:</p>';
		$html .= '</div>';
		$bemerkung = unserialize($order->getComment());
		$html .= '<div>';
		if (isset($bemerkung['bemerkung']['bemerkung']) && $bemerkung['bemerkung']['bemerkung'] != '') {
			$html .= '<p style="margin-bottom: 10px;"><b>Ihre Nachricht: </b>' . $bemerkung['bemerkung']['bemerkung'] . '</p>';
		}
		if (isset($bemerkung['bemerkung']['kommission']) && $bemerkung['bemerkung']['kommission'] != '') {
			$html .= '<p style="margin-bottom: 10px;"><b>Ihre Kommission: </b>' . $bemerkung['bemerkung']['kommission'] . '</p>';
		}
		$html .= '</div>';
		$html .= '<div class="positionenTabelle">';
		$html .= '<table repeat_header="1" style="border-bottom:1px solid;">';
		//$this->debugTypo('1');
		$html .= $this->getPositionTableHeader('ab');
		//$this->debugTypo('2');
		$bodyData = $this->getPositionTableBody('ab');
		$html .= $bodyData['html'];
		$html .= '</table>';

		//$this->debugTypo('3');
		$preisData = $this->getZusammenFassungPreise($bodyData);
		$html .= $preisData['html'];
		//$this->debugTypo('4');
		$html .= '</div>';
		$html .= '<div>';
		$html .= '<table border="0" style="border-collapse: collapse;margin-left: -1px;">';
		$html .= '<tr style="height: 45px">';
		$html .= '<td valign="top">Zahlungsbed.:</td>';



		$html .= '<td valign="top">' . $this->getZahlungsBedingung($formular['zahlung']) . '</td>';


		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Lieferadresse:</td>';

		//$this->debugTypo($formular);

		if ($formular['lieferart'] != 'abholung') {
			if (isset($formular['lieferadresse'][0])) {
				$html .= '<td>' . $this->getLieferadresse() . '</td>';
			}
		} else {
			$html .= '<td>Selbstabholung</td>';
		}

		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td colspan="2">Bitte &uuml;berpr&uuml;fen Sie oben stehende Ma&szlig;- und Mengenangaben.</td>';
		$html .= '</tr>';
		$html .= '</table>';
		$html .= '</div>';
		$html .= '<div style="margin-top: 10px;">';
		$html .= '<p>Um eine fach- und termingerechte Ausf&uuml;hrung bem&uuml;ht zeichnen wir <br />mit freundlichen Gr&uuml;&szlig;en</p>';
		$html .= '<p style="margin-top: 30px;">GLACRYL Hedel GmbH</p>';
		$html .= '</div>';
		$html .= '</div>';

		$html .= $this->getBearbeitungsAnlage();

		$html .= $this->htmlFooter;

		return $html;
	}

	public function createFe() {

		date_default_timezone_set('Europe/Berlin');

		$order = $this->order;
		$user = $this->user;
		$bemerkungen = unserialize($order->getComment());

		$html = $this->htmlKopf;

		$html .= '<!--mpdf';
		$html .= '<htmlpageheader name="myheader">';
		$html .= '<div class="header">';
		$html .= '<div class="adresse">';
		$html .= $this->getAdressBlock($user);
		$html .= '</div>';
		$html .= '<div class="logo">';
		$html .= '<img src="https://www.glacryl.de/typo3conf/ext/glshop/Resources/Php/Mpdf/imgs/logo.jpg" />';
		//$html .= '<img src="' . $this->extPath . 'Resources/Php/Mpdf/imgs/logo.jpg" />';
		$html .= '</div>';
		$html .= '<div class="clearer"></div>';
		$html .= '<div class="barcode">';
		$html .= '<span>2</span>';
		$html .= '<barcode code="P.I' . $this->abUid . '.1" type="C39" class="barcode" />';
		$html .= '</div>';
		$html .= '<div class="clearer"></div>';
		$html .= '<div class="infoDaten">';
		$html .= '<table>';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th style="font-size: 1.3em;">Fertigungsschein-Nr.</th>';

		$html .= '<th style="font-size: 1.3em;">I' . $this->nextNumber['fe'] . '</th>';

		$html .= '<td class="tRight" style="text-align: right;">Datum:</td>';
		$html .= '<td>' . date('d.m.Y', time()) . '</td>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$html .= '<tr>';
		$html .= '<td>zu Auftrag</td>';
		//$html .= '<td>BI' . $order->getAb()->current()->getUid() . '</td>';
		$html .= '<td>I' . $this->abUid . '</td>';
		$html .= '<td class="tRight">Termin:</td>';
		$html .= '<td>' . date('d.m.Y', strtotime("+1 days")) . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Kunden-Nummer</td>';
		$html .= '<td>' . $user->getUid() . '</td>';
		$html .= '<td class="tRight">Bearbeiter:</td>';
		$html .= '<td>Glacryl Homepage</td>';
		$html .= '</tr>';
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</htmlpageheader> ';

		$html .= '<sethtmlpageheader name="myheader" value="on" show-this-page="1" />';
		$html .= '<sethtmlpagefooter name="myfooter" value="on" />';
		$html .= 'mpdf-->';
		$html .= '<div class="clearer"></div>';
		$html .= '<div class="content">';
		$html .= '<div>';
		$html .= '<div style="width: 470px; float:left;">';
		$html .= '<table style="width: 100%; border-collapse: collapse;">';
		$html .= '<tr>';
		$html .= '<td>Ansprechpartner:</td>';
		$html .= '<td>' . ($user->getGender() == 0 ? 'Hr.' : 'Fr.' ) . ' ' . $user->getFirstName() . ' ' . $user->getLastName() . ' ' . $user->getTelephone() . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>zuges. Liefertermin:</td>';
		$html .= '<td>' . date('d.m.Y', strtotime("+1 days")) . '</td>';
		$html .= '</tr>';
		$html .= '<tr>         ';
		$html .= '<td>Lieferbedingung:</td>';

		if ($bemerkungen['versand']['art'] == '') {
			$html .= '<td>Selbstabholung</td>';
		} else {
			$html .= '<td>Versand</td>';
		}
		$html .= '</tr>';
		$lieferadresse = $order->getShippingaddress();
		if ($lieferadresse != null) {
			$html .= '<tr>';
			$html .= '<td>Abweichende Adresse</td>';
			$html .= '<td>' . $lieferadresse->getCompany() . ', ' . $lieferadresse->getPerson() . ', ' . $lieferadresse->getStreet() . ', ' . $lieferadresse->getZip() . ' ' . $lieferadresse->getCity() . '</td>';
			$html .= '</tr>';
		}
		$html .= '</table>';
		$html .= '</div>';
		$html .= '<div style="width: 185px; float:right;">';
		$html .= '<table style="border-collapse: collapse; width: 100%;" border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="3" style="text-align: center;">Glas befindet sich in</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="text-align: center;">Schieber Nr.:</td>';
		$html .= '<td style="text-align: center;">oben</td>';
		$html .= '<td style="text-align: center;">unten</td>';
		$html .= '</tr>';
		$html .= '<tr>         ';
		$html .= '<td style="font-size: 1.2em;">&nbsp;</td>';
		$html .= '<td>&nbsp;</td>';
		$html .= '<td>&nbsp;</td>';
		$html .= '</tr>';
		$html .= '</table>';
		$html .= '</div>';
		$bemerkung = unserialize($order->getComment());
		$html .= '<div>';
		if (isset($bemerkung['bemerkung']['bemerkung']) && $bemerkung['bemerkung']['bemerkung'] != '') {
			$html .= '<p style="margin-bottom: 10px;"><b>Nachricht vom Kunden: </b>' . $bemerkung['bemerkung']['bemerkung'] . '</p>';
		}
		if (isset($bemerkung['bemerkung']['kommission']) && $bemerkung['bemerkung']['kommission'] != '') {
			$html .= '<p style="margin-bottom: 10px;"><b>Kommission: </b>' . $bemerkung['bemerkung']['kommission'] . '</p>';
		}
		$html .= '</div>';
		$html .= '</div>';
		$html .= '<div class="positionenTabelle">';
		$html .= '<table style="border-bottom:1px solid;">';
		$html .= $this->getPositionTableHeader('fe');

		$bodyData = $this->getPositionTableBody('fe');

		$html .= $bodyData['html'];

		$html .= $this->getPositionTableFooter('fe');
		$html .= '</table>';
		$html .= '</div>';
		$html .= $this->getFePageFooterDaten();
		$html .= '</div>';
		$html .= $this->getBearbeitungsAnlage();
		$html .= $this->htmlFooter;

		return $html;
	}

	public function createLs() {

		date_default_timezone_set('Europe/Berlin');

		$order = $this->order;
		$user = $this->user;

		$html = $this->htmlKopf;

		$html .= '<!--mpdf';
		$html .= '<htmlpageheader name="myheader">';
		$html .= '<div class="topContainer"></div>';
		$html .= '<div class="clearer"></div>';
		$html .= '<div class="header">';
		$html .= '<div class="adresse">';
		$html .= $this->getAdressBlock($user);
		$html .= '</div>';
		$html .= '<div class="infoDaten">';

		$html .= '<p>Lieferschein-Nr. I' . $this->nextNumber['ls'] . '</p>';

		$html .= '<table>';
		$html .= '<tr>';
		$html .= '<td>zu Auftrag-Nr.</td>';
		$html .= '<td>I' . $this->abUid . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Kunden-Nummer</td>';
		$html .= '<td>' . $user->getUid() . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td colspan="2">&nbsp;</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Druckdatum</td>';
		$html .= '<td>' . date('d.m.Y', time()) . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Bearbeiter</td>';
		$html .= '<td>Glacryl Homepage</td>';
		$html .= '</tr>';
		$html .= '</table>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</htmlpageheader> ';

		$html .= '<sethtmlpageheader name="myheader" value="on" show-this-page="1" />';
		$html .= '<sethtmlpagefooter name="myfooter" value="on" />';
		$html .= 'mpdf-->';
		$html .= '<div class="clearer"></div>';
		$html .= '<div class="content">';
		$html .= '<div>';
		$html .= '<p style="font-weight: bold; margin-bottom: 10px;">Sehr geehrte Damen und Herren,</p>';
		$html .= '<p>Bitte &uuml;berpr&uuml;fen Sie die gelieferten Positionen bei Erhalt.</p>';
		$html .= '</div>';
		$html .= '<div class="positionenTabelle">';
		$html .= '<table>';
		$html .= $this->getPositionTableHeader('ls');

		$bodyData = $this->getPositionTableBody('ls');

		$html .= $bodyData['html'];

		$html .= $this->getPositionTableFooter('ls');

		$html .= '</table>';
		$html .= '</div>';
		$html .= '<div>';
		$html .= '<table border="0" style="border-collapse: collapse;margin-left: -1px;">';

		$html .= '</table>';
		$html .= '</div>';
		$html .= '<div style="margin-top: 10px;">';
		$html .= '<p>Bei Nachfragen bitten wir um die Angabe der zugeordneten Auftragsnummer.</p>';
		$html .= '</div>';
		$html .= '</div>';

		//$html .= $this->getBearbeitungsAnlage();

		$html .= $this->htmlFooter;

		return $html;
	}

	public function createLsK() {

		date_default_timezone_set('Europe/Berlin');

		$order = $this->order;
		$user = $this->user;

		$html = $this->htmlKopf;

		$html .= '<!--mpdf';
		$html .= '<htmlpageheader name="myheader">';
		$html .= '<div class="logo">';
		$html .= '<img src="https://www.glacryl.de/typo3conf/ext/glshop/Resources/Php/Mpdf/imgs/logo.jpg" />';
		$html .= '</div>';
		$html .= '<div class="clearer"></div>';
		$html .= '<div class="header">';
		$html .= '<div class="adresse">';
		$html .= $this->getAdressBlock($user);
		$html .= '</div>';
		$html .= '<div class="infoDaten">';

		$html .= '<p>Empfangschein I' . $this->nextNumber['lsK'] . '</p>';

		$html .= '<table>';
		$html .= '<tr>';
		$html .= '<td>zu Auftrag-Nr.</td>';
		$html .= '<td>I' . $this->abUid . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Kunden-Nummer</td>';
		$html .= '<td>' . $user->getUid() . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td colspan="2">&nbsp;</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Druckdatum</td>';
		$html .= '<td>' . date('d.m.Y', time()) . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Bearbeiter</td>';
		$html .= '<td>Glacryl Homepage</td>';
		$html .= '</tr>';
		$html .= '</table>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</htmlpageheader> ';

		$html .= '<sethtmlpageheader name="myheader" value="on" show-this-page="1" />';
		$html .= '<sethtmlpagefooter name="myfooter" value="on" />';
		$html .= 'mpdf-->';

		$html .= '<div class="clearer"></div>';
		$html .= '<div class="content">';
		$html .= '<div>';
		$html .= '<p style="font-weight: bold; margin-bottom: 10px;">Sehr geehrte Damen und Herren,</p>';
		$html .= '<p>Bitte &uuml;berpr&uuml;fen Sie die gelieferten Positionen bei Erhalt.</p>';
		$html .= '</div>';
		$html .= '<div class="positionenTabelle">';
		$html .= '<table>';
		$html .= $this->getPositionTableHeader('lsK');

		$bodyData = $this->getPositionTableBody('lsK');

		$html .= $bodyData['html'];

		$html .= $this->getPositionTableFooter('lsK');

		$html .= '</table>';
		$html .= '</div>';
		$html .= '<div>';
		$html .= '<table border="0" style="margin-top:40px; width: 97%;border-collapse: collapse;margin-left: -1px;">';
		$html .= '<tr>';
		$html .= '<td colspan="3" style="width:75%;">&nbsp;</td>';
		$html .= '<td style="border-bottom: 1px solid; width:25%;">&nbsp;</td>';
		$html .= '</tr>  ';
		$html .= '<tr>';
		$html .= '<td colspan="3">&nbsp;</td>';
		$html .= '<td>Datum, Name</td>';
		$html .= '</tr>  ';
		$html .= '</table>';
		$html .= '</div>';
		$html .= '<div style="margin-top: 10px;">';
		$html .= '<p>Bei Nachfragen bitten wir um die Angabe der zugeordneten Auftragsnummer.</p>';
		$html .= '</div>';
		$html .= '</div>';

		//$html .= $this->getBearbeitungsAnlage();

		$html .= $this->htmlFooter;

		return $html;
	}

	public function createRe() {

		date_default_timezone_set('Europe/Berlin');

		$order = $this->order;
		$user = $this->user;

		$html = $this->htmlKopf;

		$html .= '<!--mpdf';
		$html .= '<htmlpageheader name="myheader">';
		$html .= '<div class="topContainer"></div>';
		$html .= '<div class="clearer"></div>';
		$html .= '<div class="header">';
		$html .= '<div class="adresse">';
		$html .= $this->getAdressBlock($user);
		$html .= '</div>';
		$html .= '<div class="infoDaten">';

		$html .= '<p>RECHNUNG-Nr. I' . $this->nextNumber['re'] . '</p>';

		$html .= '<table>';
		$html .= '<tr>';
		$html .= '<td>zu Auftrag-Nr.</td>';
		$html .= '<td>I' . $this->abUid . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Kunden-Nummer</td>';
		$html .= '<td>' . $user->getUid() . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Ust-IdNr.</td>';
		$html .= '<td>' . $user->getUstId() . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Datum</td>';
		$html .= '<td>' . date('d.m.Y', time()) . '</td>';
		$html .= '</tr>';
		$html .= '</table>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</htmlpageheader> ';

		$html .= $this->getPaperFooter('re');

		$html .= '<sethtmlpageheader name="myheader" value="on" show-this-page="1" />';
		$html .= '<sethtmlpagefooter name="myfooter" value="on" />';
		$html .= 'mpdf-->';
		$html .= '<div class="clearer"></div>';
		$html .= '<div class="content">';
		$html .= '<div>';
		$html .= '<p style="font-weight: bold; margin-bottom: 10px;">Sehr geehrte Damen und Herren,</p>';

		$formular = unserialize($this->order->getFormular());
		$lieferart = ($formular['lieferart'] == 'abholung' ? 'Abholung' : ($formular['lieferart'] == 'gls' ? 'Paketdienst GLS' : ($formular['lieferart'] == 'spedition' ? 'Spedition' : 'Lieferung')));
		$nach = (($formular['versandNach'] != null) && ($formular['versandNach']) != '' ? ' ' . $formular['versandNach'] : '');
		$ausland = (isset($formular['ausland']) && ($formular['ausland'] == 'true') ? true : false);

		if ($ausland) {
			if (in_array($user->getCountry(), $this->ausfuhr)) {
				$html .= '<p>" Es handelt sich um eine steuerfreie Ausfuhrlieferung "</p>';
			} else {
				$html .= '<p>" Es handelt sich um eine steuerfreie innergemeinschaftliche Lieferung "</p>';
			}
		}
		$html .= '<p>Sie erhielten per ' . $lieferart . ' am ' . $formular['lieferdatum'] . ' abgehend' . $nach . ' mit LS Nr.: I' . $this->order->getDelivery()->current()->getUid() . '<br/>';
		$html .= '- Lieferscheindatum entspricht Leistungsdatum - </p>';
		$html .= '<p>Wir danken Ihnen f&uuml;r Ihren Auftrag und erlauben uns zu berechnen:</p>';
		$html .= '</div>';
		$bemerkung = unserialize($order->getComment());
		$html .= '<div>';
		if (isset($bemerkung['bemerkung']['kommission']) && $bemerkung['bemerkung']['kommission'] != '') {
			$html .= '<p style="margin-bottom: 10px;"><b>Ihre Kommission: </b>' . $bemerkung['bemerkung']['kommission'] . '</p>';
		}
		$html .= '</div>';
		$html .= '<div class="positionenTabelle">';
		$html .= '<table style="border-bottom:1px solid;">';
		$html .= $this->getPositionTableHeader('re');

		$bodyData = $this->getPositionTableBody('re');

		$html .= $bodyData['html'];
		$html .= '</table>';

		$preisData = $this->getZusammenFassungPreise($bodyData);
		$html .= $preisData['html'];

		$html .= '</div>';
		$html .= $this->getZahlungsBedingungen($preisData['gesamtPreis']);
		$html .= '</div>';

		//$html .= $this->getBearbeitungsAnlage();

		$html .= $this->htmlFooter;

		return $html;
	}

	public function createReK() {

		date_default_timezone_set('Europe/Berlin');

		$order = $this->order;
		$user = $this->user;

		$html = $this->htmlKopf;

		$html .= '<!--mpdf';
		$html .= '<htmlpageheader name="myheader">';
		$html .= '<div class="logo">';
		$html .= '<img src="https://www.glacryl.de/typo3conf/ext/glshop/Resources/Php/Mpdf/imgs/logo.jpg" />';
		//$html .= '<img src="' . $this->extPath . 'Resources/Php/Mpdf/imgs/logo.jpg" />';
		$html .= '</div>';
		$html .= '<div class="clearer"></div>';
		$html .= '<div class="header">';
		$html .= '<div class="adresse">';
		$html .= $this->getAdressBlock($user);
		$html .= '</div>';
		$html .= '<div class="infoDaten">';

		$html .= '<p>RECHNUNG-Nr. I' . $this->nextNumber['reK'] . '</p>';

		$html .= '<table>';
		$html .= '<tr>';
		$html .= '<td>zu Auftrag-Nr.</td>';
		$html .= '<td>I' . $this->abUid . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Kunden-Nummer</td>';
		$html .= '<td>' . $user->getUid() . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Ust-IdNr.</td>';
		$html .= '<td>' . $user->getUstId() . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>Datum</td>';
		$html .= '<td>' . date('d.m.Y', time()) . '</td>';
		$html .= '</tr>';
		$html .= '</table>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</htmlpageheader> ';

		$html .= $this->getPaperFooter('reK');

		$html .= '<sethtmlpageheader name="myheader" value="on" show-this-page="1" />';
		$html .= '<sethtmlpagefooter name="myfooter" value="on" />';
		$html .= 'mpdf-->';
		$html .= '<div class="clearer"></div>';
		$html .= '<div class="content">';
		$html .= '<div>';
		$html .= '<p style="font-weight: bold; margin-bottom: 10px;">Sehr geehrte Damen und Herren,</p>';

		$formular = unserialize($this->order->getFormular());
		$lieferart = ($formular['lieferart'] == 'abholung' ? 'Abholung' : ($formular['lieferart'] == 'gls' ? 'Paketdienst GLS' : 'Spedition'));
		$nach = (($formular['versandNach'] != null) && ($formular['versandNach']) != '' ? ' ' . $formular['versandNach'] : '');
		$ausland = (isset($formular['ausland']) && ($formular['ausland'] == 'true') ? true : false);

		if ($ausland) {
			if (in_array($user->getCountry(), $this->ausfuhr)) {
				$html .= '<p>" Es handelt sich um eine steuerfreie Ausfuhrlieferung "</p>';
			} else {
				$html .= '<p>" Es handelt sich um eine steuerfreie innergemeinschaftliche Lieferung "</p>';
			}
		}

		$html .= '<p>Sie erhielten per ' . $lieferart . ' am ' . $formular['lieferdatum'] . ' abgehend' . $nach . ' mit LS Nr.: I' . $this->order->getDelivery()->current()->getUid() . '<br/>';
		$html .= '- Lieferscheindatum entspricht Leistungsdatum - </p>';

		$html .= '<p>Wir danken Ihnen f&uuml;r Ihren Auftrag und erlauben uns zu berechnen:</p>';
		$html .= '</div>';
		$bemerkung = unserialize($order->getComment());
		$html .= '<div>';
		if (isset($bemerkung['bemerkung']['kommission']) && $bemerkung['bemerkung']['kommission'] != '') {
			$html .= '<p style="margin-bottom: 10px;"><b>Ihre Kommission: </b>' . $bemerkung['bemerkung']['kommission'] . '</p>';
		}
		$html .= '</div>';
		$html .= '<div class="positionenTabelle">';
		$html .= '<table style="border-bottom:1px solid;">';
		$html .= $this->getPositionTableHeader('reK');

		$bodyData = $this->getPositionTableBody('re');

		$html .= $bodyData['html'];
		$html .= '</table>';


		$preisData = $this->getZusammenFassungPreise($bodyData);
		$html .= $preisData['html'];

		$html .= '</div>';
		$html .= $this->getZahlungsBedingungen($preisData['gesamtPreis']);
		$html .= '</div>';

		//$html .= $this->getBearbeitungsAnlage();

		$html .= $this->htmlFooter;

		return $html;
	}

	public function createAbMail($data) {
		$user = $data['user'];

		$mes = '<html>';
		$mes .= '<head>';
		$mes .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		$mes .= '<title></title>';
		$mes .= '<style type="text/css">';
		$mes .= 'body {';
		$mes .= 'font-family: Tahoma, Arial;';
		$mes .= 'font-size: 12pt;';
		$mes .= '}';
		$mes .= '</style>';
		$mes .= '</head>';
		$mes .= '<body>';
		$mes .= '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">';
		$mes .= '<tr>';
		$mes .= '<td align="center" valign="top">';
		$mes .= '<table border="0" cellpadding="0" cellspacing="0" width="800" id="emailContainer">';
		$mes .= '<tr>';
		$mes .= '<td align="center" valign="top">';
		$mes .= '<table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailHeader">';
		$mes .= '<tr>';
		$mes .= '<td align="left" style="font-size:8pt; color: #666666; padding-bottom:10px;">Ansbach, 09.09.2014</td>';
		$mes .= '</tr>';
		$mes .= '</table>';
		$mes .= '</td>';
		$mes .= '</tr>';
		$mes .= '<tr>';
		$mes .= '<td align="center" valign="top">';
		$mes .= '<table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailBody">';
		$mes .= '<tr>';
		$mes .= '<td align="left" valign="top" style="padding-bottom: 10px;">';
		$mes .= '<p style="line-height:1; margin:10px 0px 5px 0px;">Sehr geehrte' . ($user->getGender() == 0 ? 'r Herr ' : ' Frau ') . $user->getLastName() . ',</p>';
		$mes .= '<p style="line-height:1; margin:10px 0px;">wir haben Ihre Bestellung aufgenommen und werden diese schnellstm&ouml;glich bearbeiten.</p>';
		$mes .= '<p style="line-height:1; margin:5px 0px;">Mit freundlichen Gr&uuml;&szlig;en</p>';
		$mes .= '<p style="line-height:1; margin:5px 0px 10px 0px;">Ihr Glacryl Team</p>';
		$mes .= '<p><img src="' . md5(basename($data['GlacrylLogo'])) . '"  style="margin-right:10px;"/></p>';
		$mes .= '</td>';
		$mes .= '</tr>';
		$mes .= '</table>';
		$mes .= '</td>';
		$mes .= '</tr>';
		$mes .= '<tr>';
		$mes .= '<td align="center" valign="top">';
		$mes .= '<table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailFooter">';
		$mes .= '<colgroup>';
		$mes .= '<col width="12%">';
		$mes .= '<col width="*">';
		$mes .= '</colgroup>';
		$mes .= '<tr>';
		$mes .= '<td align="left" colspan="2" style="font-size:10pt;">Glacryl Hedel GmbH</td>';
		$mes .= '<tr>';
		$mes .= '<td align="left" colspan="2" style="font-size:10pt;">Naumannstra&szlig;e 13</td>';
		$mes .= '</tr>';
		$mes .= '<tr>';
		$mes .= '<td align="left" colspan="2" style="padding-bottom: 8px; font-size:10pt;">D-91522 Ansbach</td>';
		$mes .= '</tr>';
		$mes .= '<tr>';
		$mes .= '<td align="left" style="font-size:10pt;">Tel.:</td><td align="left" style="font-size:10pt;">0981 / 487 9999 0</td>';
		$mes .= '</tr>';
		$mes .= '<tr>';
		$mes .= '<td align="left" style="font-size:10pt;">Fax.:</td><td align="left" style="font-size:10pt;">0981 / 179 51</td>';
		$mes .= '</tr>';
		$mes .= '<tr>';
		$mes .= '<td align="left" style="padding-bottom: 8px; font-size:10pt;">Internet / Mail:</td><td align="left" style="padding-bottom: 8px; font-size:10pt;">www.glacryl.de / info@glacryl.de</td>';
		$mes .= '</tr>';
		$mes .= '<tr>';
		$mes .= '<td align="left" colspan="2" style="font-size:8pt;">Reg.-Gericht Ansbach - HRB 1495</td>';
		$mes .= '</tr>';
		$mes .= '<tr>';
		$mes .= '<td align="left" style="font-size:8pt;">Gesch&auml;ftsf&uuml;hrer:</td><td align="left" style="font-size:8pt;">Wolfgang Hedel</td>';
		$mes .= '</tr>';
		$mes .= '<tr>';
		$mes .= '<td align="left" style="font-size:8pt;">Sitz des Gerichts:</td><td align="left" style="font-size:8pt;">Ansbach</td>';
		$mes .= '</tr>';
		$mes .= '<tr>';
		$mes .= '<td align="left" style="font-size:8pt;">USt-IdNr.:</td><td align="left" style="font-size:8pt;">DE 131938998</td>';
		$mes .= '</tr>';
		$mes .= '</table>';
		$mes .= '</td>';
		$mes .= '</tr>';
		$mes .= '</table>';
		$mes .= '</td>';
		$mes .= '</tr>';
		$mes .= '</table>';
		$mes .= '</body>';
		$mes .= '</html>';
		$this->abMail = $mes;
	}

	public function getLieferadresse() {
		$formular = unserialize($this->order->getFormular());
		$adresse = null;

		if (isset($formular['lieferadresse'][0])) {
			$kdAdr = $this->kdAdressen;

			for ($i = 0; $i < count($kdAdr); $i++) {
				if ($kdAdr[$i]->getUid() == intval($formular['lieferadresse'][0])) {
					$adresse = $kdAdr[$i];
				}
			}
			if (!isset($adresse)) {
				$user = $this->user;
				$text = $user->getCompany() . ', ' . $user->getFirstName() . ' ' . $user->getLastName() . ', ' . $user->getAdress() . ', ' . $user->getZip() . ' ' . $user->getCity();
			} else {
				$text = $adresse->getCompany() . ', ' . $adresse->getPerson() . ', ' . $adresse->getStreet() . ', ' . $adresse->getZip() . ' ' . $adresse->getCity();
			}
		} else {
			$user = $this->user;
			$text = $user->getCompany() . ', ' . $user->getFirstName() . ' ' . $user->getLastName() . ', ' . $user->getAdress() . ', ' . $user->getZip() . ' ' . $user->getCity();
		}

		return $text;
	}

	public function getAdressBlock($user) {

		$order = $this->order;
		$opt = $this->opt;
		$lieferadresse = $order->getShippingaddress();
		$formular = unserialize($order->getFormular());
		$ausland = (isset($formular['ausland']) && ($formular['ausland'] == 'true') ? true : false);

		if ((($opt == 'ls') || ($opt == 'lsK')) && ($lieferadresse != null)) {
			$html = '<p>' . $lieferadresse->getCompany() . '</p>';
			$html .= '<p>' . $lieferadresse->getPerson() . '</p>';
			$html .= '<p>' . $lieferadresse->getStreet() . '</p>';
			$html .= '<p></p>';
			$html .= '<p>' . $lieferadresse->getZip() . ' ' . $lieferadresse->getCity() . '</p>';
		} else {
			$html = '<p>' . $user->getCompany() . '</p>';
			$html .= '<p>' . ($user->getGender() == 0 ? 'Herr' : 'Frau' ) . ' ' . $user->getFirstName() . ' ' . $user->getLastName() . '</p>';
			$html .= '<p>' . $user->getAdress() . '</p>';
			$html .= '<p></p>';
			$html .= '<p>' . $user->getZip() . ' ' . $user->getCity() . '</p>';
			if ($ausland) {
				$html .= '<p>' . $this->countries[$user->getCountry()] . '</p>';
			}
		}
		return $html;
	}

	public function getImgUrlTag($file) {
		$html = '';

		if (file_exists($this->extPath . 'Resources/Private/Downloads/Zeichnungen/' . $file)) {
			$html .= '<img src="' . $this->extPath . 'Resources/Private/Downloads/Zeichnungen/' . $file . '" />';
		} elseif (file_exists($this->extPath . 'Resources/Public/Img/Products/' . $file)) {
			$html .= '<img src="' . $this->extPath . 'Resources/Public/Img/Products/' . $file . '" />';
		} else {
			$html .= 'Leider kein Bild vorhanden';
		}
		return $html;
	}

	public function getBearbeitungsAnlage() {

		$order = $this->order;

		$artikel = unserialize($order->getArticle());

		$ecken = $this->konfigData['ecken'];
		$kanten = $this->konfigData['kanten'];
		$bohrungen = $this->konfigData['bohrungen'];
		$halter = $this->konfigData['halter'];

		$profile = $this->konfigData['produktart']['profile'];
		$frontscheiben = $this->konfigData['produktart']['frontscheiben'];
		$leds = $this->konfigData['produktart']['leds'];
		$streuplatten = $this->konfigData['produktart']['streuplatten'];
		$anschluss = $this->konfigData['produktart']['anschluss'];
		$befestigung = $this->konfigData['produktart']['montage'];

		$html = '';

		if (count($artikel) > 0) {

			$anlagenSet = false;

			foreach ($artikel as $posNr => $a) {
				if (($a['artikel']['material'] != null) || ($a['artikel']['profil'] != null)) {
					$anlagenSet = true;
				}
			}

			if ($anlagenSet) {
				$numItems = count($artikel);
				$counter = 0;

				foreach ($artikel as $posNr => $a) {
					if ($a['artikel']['material'] != null) {
						if ($counter == 0) {
							$html .= '<!--mpdf';
							$html .= '<pagebreak />';
							$html .= 'mpdf-->';

							$html .= '<div class="anlagen">';
							$html .= '<h3>Anlage Bearbeitungen</h3>';
						}

						$html .= '<div style="border: 1px solid; padding: 5px 10px 3px 10px;">';
						$html .= '<h4>Bearbeitungen Position ' . $posNr . ':</h4>';

						$html .= '<div class="row">';
						$html .= '<div class="imgCol">';
						if (($a['bild'] != null) && ($a['bild'] != '')) {
							$html .= '<p class="cart-detailImg">';
							$html .= $this->getImgUrlTag($a['bild']);
							$html .= '</p>';
						}
						$html .= '</div>';
						$html .= '<div class="textCol">';

						//if ($a['artikel']['material'] != null) {

						$html .= '<dl class="cart-detail-dl">';
						$html .= '<dt class="cart-detail-dt">Format</dt>';
						$html .= '<dd class="cart-detail-dd">';
						$html .= '<span><b>' . $a['anzahl'] . ' St&uuml;ck: ' . $a['artikel']['materialConfig']['width'] . ' x ' . $a['artikel']['materialConfig']['height'] . ' x ' . $a['artikel']['material']['size'] . ' mm</b></span>';
						$html .= '</dd>';
						$html .= '</dl>';

						$html .= '<dl class="cart-detail-dl">';
						$html .= '<dt class="cart-detail-dt">Kantenbearbeitung</dt>';
						$html .= '<dd class="cart-detail-dd">';
						$html .= '<span>';
						for ($i = 0; $i < count($kanten); $i++) {
							if ($kanten[$i]['uid'] == $a['artikel']['bearbeitungen']['kanten']['uid']) {
								$html .= '<span><b>' . $kanten[$i]['name'] . '</b></span>';
								if (trim($a['artikel']['bearbeitungen']['kanten']['facette']) != '') {
									$html .= '<span> - <b>Facette:</b> ' . $a['artikel']['bearbeitungen']['kanten']['facette'] . ' mm, <b>Facettenwinkel:</b> ' . $a['artikel']['bearbeitungen']['kanten']['angle'] . '&deg;</span>';
								}
							}
						}
						$html .= '</span>';
						$html .= '</dd>';
						$html .= '</dl>';

						if ($a['artikel']['bearbeitungen']['tempern'] != null) {
							$html .= '<dl class="cart-detail-dl">';
							$html .= '<dt class="cart-detail-dt">Tempern</dt>';
							$html .= '<dd class="cart-detail-dd">';
							$html .= '<span><b>';
							if ($a['artikel']['bearbeitungen']['tempern']['tempern'] === 'true') {
								$html .= 'Ja';
							} else {
								$html .= 'Nein';
							}
							$html .= '</b></span>';
							$html .= '</dd>';
							$html .= '</dl>';
						}
						if ($a['artikel']['bearbeitungen']['ecken'] != null) {
							$html .= '<dl class="cart-detail-dl">';
							$html .= '<dt class="cart-detail-dt">Eckbearbeitungen</dt>';
							for ($i = 0; $i < count($ecken); $i++) {
								for ($j = 0; $j < count($a['artikel']['bearbeitungen']['ecken']); $j++) {
									if ($ecken[$i]['uid'] == $a['artikel']['bearbeitungen']['ecken'][$j]['uid']) {
										$html .= '<dd class="cart-detail-dd">';
										$html .= '<span><b>Ecke:</b> ' . $a['artikel']['bearbeitungen']['ecken'][$j]['corner'] . ' - <b>' . $ecken[$i]['name'] . '</b>,</span> ';
										if (trim($a['artikel']['bearbeitungen']['ecken'][$j]['radius']) != '') {
											$html .= '<span><b>Radius:</b> ' . $a['artikel']['bearbeitungen']['ecken'][$j]['radius'] . ' mm</span>';
										} else {
											$html .= '<span><b>X:</b> ' . $a['artikel']['bearbeitungen']['ecken'][$j]['x'] . ' mm <b>Y:</b> ' . $a['artikel']['bearbeitungen']['ecken'][$j]['y'] . ' mm</span>';
										}
										$html .= '</dd>';
									}
								}
							}
							$html .= '</dl>';
						}
						if ($a['artikel']['bearbeitungen']['bohrungen'] != null) {
							$html .= '<dl class="cart-detail-dl">';
							$html .= '<dt class="cart-detail-dt">Bohrungen</dt>';
							for ($i = 0; $i < count($bohrungen); $i++) {
								for ($j = 0; $j < count($a['artikel']['bearbeitungen']['bohrungen']); $j++) {
									if ($bohrungen[$i]['uid'] == $a['artikel']['bearbeitungen']['bohrungen'][$j]['uid']) {
										$html .= '<dd class="cart-detail-dd">';
										$html .= '<span><b>Ecke:</b> ' . ($a['artikel']['bearbeitungen']['bohrungen'][$j]['corner'] == 'FREI' ? 'E4' : $a['artikel']['bearbeitungen']['bohrungen'][$j]['corner']) . '</span>';
										$html .= ' <span><b>X:</b> ' . $a['artikel']['bearbeitungen']['bohrungen'][$j]['x'] . ' mm</span>';
										$html .= ' <span><b>Y:</b> ' . $a['artikel']['bearbeitungen']['bohrungen'][$j]['y'] . ' mm</span>';
										$html .= ' <span><b>&Oslash;-Bohrung:</b> ' . $a['artikel']['bearbeitungen']['bohrungen'][$j]['dB'] . ' mm</span>';
										$html .= '</dd>';
									}
								}
							}
							$html .= '</dl>';
						}
						if ($a['artikel']['bearbeitungen']['senkungen'] != null) {
							$html .= '<dl class="cart-detail-dl">';
							$html .= '<dt class="cart-detail-dt">Senkbohrungen</dt>';
							for ($i = 0; $i < count($bohrungen); $i++) {
								for ($j = 0; $j < count($a['artikel']['bearbeitungen']['senkungen']); $j++) {
									if ($bohrungen[$i]['uid'] == $a['artikel']['bearbeitungen']['senkungen'][$j]['uid']) {
										$html .= '<dd class="cart-detail-dd">';
										$html .= '<span><b>Ecke:</b> ' . ($a['artikel']['bearbeitungen']['senkungen'][$j]['corner'] == 'FREI' ? 'E4' : $a['artikel']['bearbeitungen']['senkungen'][$j]['corner']) . '</span>';
										$html .= ' <span><b>X:</b> ' . $a['artikel']['bearbeitungen']['senkungen'][$j]['x'] . ' mm</span>';
										$html .= ' <span><b>Y:</b> ' . $a['artikel']['bearbeitungen']['senkungen'][$j]['y'] . ' mm</span>';
										$html .= ' <span><b>&Oslash;-Bohrung:</b> ' . $a['artikel']['bearbeitungen']['senkungen'][$j]['dB'] . ' mm</span>';
										$html .= ' <span><b>&Oslash;-Senkung:</b> ' . $a['artikel']['bearbeitungen']['senkungen'][$j]['dS'] . ' mm</span>';
										$html .= '</dd>';
									}
								}
							}
							$html .= '</dl>';
						}
						if ($a['artikel']['halter'] != null) {
							$html .= '<dl class="cart-detail-dl">';
							$html .= '<dt class="cart-detail-dt">Befestigung</dt>';

							$mHalter = array();
							for ($j = 0; $j < count($a['artikel']['halter']); $j++) {
								for ($i = 0; $i < count($halter); $i++) {
									if ($halter[$i]['uid'] == $a['artikel']['halter'][$j]['hid']) {
										for ($k = 0; $k < count($halter[$i]['varianten']); $k++) {
											if ($halter[$i]['varianten'][$k]['uid'] == $a['artikel']['halter'][$j]['vid']) {
												if (!array_key_exists($halter[$i]['varianten'][$k]['artnr'], $mHalter)) {
													$mHalter[$halter[$i]['varianten'][$k]['artnr']] = array(
														'qty' => 1,
														'halter' => $halter[$i]['varianten'][$k]
													);
												} else {
													$mHalter[$halter[$i]['varianten'][$k]['artnr']]['qty'] = $mHalter[$halter[$i]['varianten'][$k]['artnr']]['qty'] + 1;
												}
											}
										}
									}
								}
							}

							$countMHalter = count($mHalter);
							$counterMHalter = 0;
							foreach ($mHalter as $art => $data) {
								$html .= '<dd class="cart-detail-dd">';
								$html .= '<span><b>' . $data['qty'] . ' Stück ' . $data['halter']['name'] . ':</b></span><br />';
								$html .= '<span style="width:24px;"></span><span><b>Art.Nr.:</b> ' . $data['halter']['artnr'] . '</span><br />';
								if (++$counterMHalter !== $countMHalter) {
									$html .= '<hr />';
								}
								$html .= '</dd>';
							}
							$html .= '</dl>';
						}
					} else if ($a['artikel']['profil'] != null) {
						if ($counter == 0) {
							$html .= '<!--mpdf';
							$html .= '<pagebreak />';
							$html .= 'mpdf-->';

							$html .= '<div class="anlagen">';
							$html .= '<h3>Anlage Bearbeitungen</h3>';
						}

						$html .= '<div style="border: 1px solid; padding: 5px 10px 3px 10px;">';
						$html .= '<h4>Bearbeitungen Position ' . $posNr . ':</h4>';

						$html .= '<div class="row">';
						$html .= '<div class="imgCol">';
						if (($a['bild'] != null) && ($a['bild'] != '')) {
							$html .= '<p class="cart-detailImg">';
							$html .= $this->getImgUrlTag($a['bild']);
							$html .= '</p>';
						}
						$html .= '</div>';
						$html .= '<div class="textCol">';

						$html .= '<dl class="cart-detail-dl">';
						$html .= '<dt class="cart-detail-dt">Rahmenau&szlig;enma&szlig;</dt>';
						$html .= '<dd class="cart-detail-dd">';
						$html .= '<span><b>' . $a['anzahl'] . ' St&uuml;ck: ' . $a['artikel']['rahmenConfig']['width'] . ' x ' . $a['artikel']['rahmenConfig']['height'] . ' mm</b></span><br/>';
						$html .= '<span><b>Sichtbereich: </b>' . (intval($a['artikel']['rahmenConfig']['width']) - 2 * 13) . ' x ' . (intval($a['artikel']['rahmenConfig']['height']) - 2 * 13) . ' mm</span>';
						$html .= '</dd>';
						$html .= '</dl>';

						if ($a['artikel']['frontscheibe']['uid'] != null) {
							$html .= '<dl class="cart-detail-dl">';
							$html .= '<dt class="cart-detail-dt">Frontscheibe</dt>';
							$html .= '<dd class="cart-detail-dd">';
							$html .= '<span>';
							for ($i = 0; $i < count($frontscheiben); $i++) {
								if ($frontscheiben[$i]['uid'] == intval($a['artikel']['frontscheibe']['uid'])) {
									$html .= '<span>' . $frontscheiben[$i]['name'] . '</span><br/>';
									for ($j = 0; $j < count($frontscheiben[$i]['variante']); $j++) {
										if ($frontscheiben[$i]['variante'][$j]['uid'] == intval($a['artikel']['frontscheibe']['vid'])) {

											$html .= '<span>' . $frontscheiben[$i]['variante'][$j]['name'] . '</span><br/>';
										}
									}
									$html .= $this->getFrontscheibeMass($a['artikel']['rahmenConfig']['width'], $a['artikel']['rahmenConfig']['height'], $frontscheiben[$i]['artNr']);
								}
							}
							$html .= '</span>';
							$html .= '</dd>';
							$html .= '</dl>';
						}
						$html .= '<dl class="cart-detail-dl">';
						$html .= '<dt class="cart-detail-dt">Beleuchtung</dt>';
						$html .= '<dd class="cart-detail-dd">';
						$html .= '<span>';
						for ($i = 0; $i < count($leds); $i++) {
							if ($leds[$i]['uid'] == intval($a['artikel']['led']['uid'])) {
								for ($j = 0; $j < count($leds[$i]['variante']); $j++) {
									if ($leds[$i]['variante'][$j]['uid'] == intval($a['artikel']['led']['vid'])) {
										$html .= '<span><b>Lichtfarbe: </b>' . $leds[$i]['name'] . '</span><br/>';
										if ($leds[$i]['name'] == 'weiß') {
											$html .= '<span><b>Steuerung: </b>Farbe fest eingestellt - ' . $leds[$i]['variante'][$j]['name'] . '</span><br/>';
										} else {
											$html .= '<span><b>Steuerung: </b>' . $leds[$i]['variante'][$j]['name'] . '</span><br/>';
										}
										$html .= '<span><b>Verbaut in Rahmen: </b>';
										if ($a['artikel']['kanten']['Links'] == 'true') {
											$html .= ' Links ';
										}
										if ($a['artikel']['kanten']['Oben'] == 'true') {
											$html .= ' Oben ';
										}
										if ($a['artikel']['kanten']['Rechts'] == 'true') {
											$html .= ' Rechts ';
										}
										if ($a['artikel']['kanten']['Unten'] == 'true') {
											$html .= ' Unten ';
										}
										$html .= '</span><br/>';
									}
								}
							}
						}
						$html .= '</span>';
						$html .= '</dd>';
						$html .= '</dl>';

						$html .= '<dl class="cart-detail-dl">';
						$html .= '<dt class="cart-detail-dt">Lichtstreuplatte</dt>';
						$html .= '<dd class="cart-detail-dd">';
						$html .= '<span>';
						for ($i = 0; $i < count($streuplatten); $i++) {
							if ($streuplatten[$i]['uid'] == intval($a['artikel']['streuplatte']['uid'])) {
								for ($j = 0; $j < count($streuplatten[$i]['variante']); $j++) {
									if ($streuplatten[$i]['variante'][$j]['uid'] == intval($a['artikel']['streuplatte']['vid'])) {
										$html .= '<span><b>Material: </b>' . $streuplatten[$i]['variante'][$j]['name'] . '</span><br/>';
										$html .= '<span>' . $streuplatten[$i]['name'] . '</span><br/>';
									}
								}
							}
						}
						$html .= '</span>';
						$html .= '</dd>';
						$html .= '</dl>';

						$html .= '<dl class="cart-detail-dl">';
						$html .= '<dt class="cart-detail-dt">Netzanschluss</dt>';
						$html .= '<dd class="cart-detail-dd">';
						$html .= '<span>';
						for ($i = 0; $i < count($anschluss); $i++) {
							if ($anschluss[$i]['uid'] == intval($a['artikel']['netzanschluss']['uid'])) {
								for ($j = 0; $j < count($anschluss[$i]['variante']); $j++) {
									if ($anschluss[$i]['variante'][$j]['uid'] == intval($a['artikel']['netzanschluss']['vid'])) {
										$html .= '<span><b>Einbausituation: </b>' . $anschluss[$i]['variante'][$j]['name'] . '</span><br/>';
										$html .= '<span><b>Leuchtfeldausf&uuml;hrung: </b>' . $anschluss[$i]['variante'][$j]['beschreibung'] . '</span><br/>';
									}
								}
							}
						}
						$html .= '</span>';
						$html .= '</dd>';
						$html .= '</dl>';

						$html .= '<dl class="cart-detail-dl">';
						$html .= '<dt class="cart-detail-dt">Befestigung</dt>';
						$html .= '<dd class="cart-detail-dd">';
						$html .= '<span>';
						for ($i = 0; $i < count($befestigung); $i++) {
							if ($befestigung[$i]['uid'] == intval($a['artikel']['befestigung']['uid'])) {
								for ($j = 0; $j < count($anschluss[$i]['variante']); $j++) {
									if ($befestigung[$i]['variante'][$j]['uid'] == intval($a['artikel']['befestigung']['vid'])) {
										$html .= '<span><b>Montageart: </b>' . $befestigung[$i]['name'] . '</span><br/>';
										$html .= '<span><b>Zubeh&ouml;r: </b>' . $befestigung[$i]['beschreibung'] . '</span><br/>';
										$html .= '<span><b>Vertiefung: </b>' . $befestigung[$i]['variante'][$j]['name'] . '</span><br/>';
									}
								}
							}
						}
						$html .= '</span>';
						$html .= '</dd>';
						$html .= '</dl>';
					}

					$html .= '</div>';
					$html .= '</div>';
					$html .= '</div>';
					//$this->debugTypo($counter);
					//$this->debugTypo($numItems);
					//$this->debugTypo($a['artikel']['material']);
					$testCounter = ++$counter;
					if ($testCounter !== $numItems) {
						if ($a['artikel']['voucher'] == null) {
							
						} else if (($a['artikel']['material'] != null) || ($a['artikel']['profil'] != null)) {
							//$this->debugTypo('Umbruch');
							$html .= '<!--mpdf';
							$html .= '<pagebreak />';
							$html .= 'mpdf-->';
						}
					}
				}
				$html .= '</div>';
				return $html;
			}
		}
	}

	public function getFrontscheibeMass($w, $h, $artNr) {
		$w = floatval($w);
		$h = floatval($h);

		$bG = 0;
		$hG = 0;
		$bK = 0;
		$hK = 0;

		$text = '<span><b>Zuschnittsma&szlig;: </b></span> <br/>';

		if (($artNr == 'KD4') || ($artNr == 'EGL4') || ($artNr == 'KGL4')) {
			$bG = $w - 5;
			$hG = $h - 5;
		} else if (($artNr == 'KD5') || ($artNr == 'EGL5') || ($artNr == 'KGL5')) {
			$bG = $w - 16;
			$hG = $h - 16;
		}
		$bK = round(($bG - 1.6415 * $w / 1000), 2);
		$hK = round(($hG - 1.6415 * $h / 1000), 2);

		if (($artNr == 'KD4') || ($artNr == 'KD5')) {
			$text .= '<span><b>Echtglas (B/H): </b>' . $bG . ' x ' . $hG . ' mm </span><br/>';
			$text .= '<span><b>Kunstglas (B/H): </b>' . number_format($bK, 2, ',', '') . ' x ' . number_format($hK, 2, ',', '') . ' mm </span><br/>';
			$text .= '<span>W&auml;rmeausdehnungskoeffizient bei Kunstglas ber&uuml;cksichtigt. </span><br/>';
		} else if (($artNr == 'EGL4') || ($artNr == 'EGL5')) {
			$text .= '<span><b>Echtglas (B/H): </b>' . $bG . ' x ' . $hG . ' mm </span><br/>';
		} else if (($artNr == 'KGL4') || ($artNr == 'KGL5')) {
			$text .= '<span><b>Kunstglas (B/H): </b>' . number_format($bK, 2, ',', '') . ' x ' . number_format($hK, 2, ',', '') . ' mm </span><br/>';
			$text .= '<span>W&auml;rmeausdehnungskoeffizient bei Kunstglas ber&uuml;cksichtigt. </span><br/>';
		}

		return $text;
	}

	public function getPaperFooter($opt) {
		$html = '<htmlpagefooter name="myfooter">';
		$html .= '<div class="footer">';
		$html .= '<div class="footerText">';
		$html .= '<p>';
		$html .= 'Die Ware bleibt bis zur vollst&auml;ndigen Bezahlung unser Eigentum. Ferner gilt der erweiterte Eigentumsvorbehalt, sowie ein Be- und Verarbeitungsvorbehalt als vereinbart. Gerichtsstand ist Ansbach.';
		$html .= '</p>';
		$html .= '</div>';
		$html .= '<div class="footerInfo">';
		$html .= '<div class="fTelefon">';
		if ($opt == 'ab' || $opt == 'reK') {
			$html .= '<p>Telefon (0981) 487 9999 0</p>';
		}
		$html .= '<p>&nbsp;</p>';
		if ($opt == 'ab' || $opt == 'reK') {
			$html .= '<p>Telefax (0981) 1 79 51</p>';
		}
		$html .= '<p>&nbsp;</p>';
		$html .= '</div>';
		$html .= '<div class="fAnschrift">';
		if ($opt == 'ab' || $opt == 'reK') {
			$html .= '<p><b>Hausanschrift</b></p>';
			$html .= '<p>Glacryl Hedel GmbH</p>';
			$html .= '<p>Naumannstr. 13</p>';
			$html .= '<p>91522 Ansbach</p>';
		}
		$html .= '<p>&nbsp;</p>';
		$html .= '<p>&nbsp;</p>';
		$html .= '</div>';
		$html .= '<div class="fGericht">';
		if ($opt == 'ab' || $opt == 'reK') {
			$html .= '<p><b>Reg.-Gericht Ansbach</b></p>';
			$html .= '<p>HRB 1495</p>';
			$html .= '<p>Wolfgang Hedel</p>';
			$html .= '<p>Gesch&auml;ftsf&uuml;hrer</p>';
		}
		$html .= '<p>Ust-IdNr. DE131938998</p>';
		$html .= '<p>St-Nr. 203/127/50059</p>';
		if ($opt == 're') {
			$html .= '<p>&nbsp;</p>';
			$html .= '<p>&nbsp;</p>';
		}
		$html .= '</div>';
		$html .= '<div class="fBankd">';
		$html .= '<p>Postbank N&uuml;rnberg</p>';
		$html .= '<p>Sparkasse Ansbach</p>';
		$html .= '<p>&nbsp;</p>';
		$html .= '<p>&nbsp;</p>';
		if ($opt == 'ab' || $opt == 'reK') {
			$html .= '<p>&nbsp;</p>';
			$html .= '<p>&nbsp;</p>';
		}
		$html .= '</div>';
		$html .= '<div class="fKonto">';
		$html .= '<p>(BLZ 760 100 85) Kto. 125 65-854</p>';
		$html .= '<p>(BLZ 765 500 00) Kto. 291 807</p>';
		$html .= '<p>IBAN: DE74 7655 0000 0000 2918 07</p>';
		$html .= '<p>BIC: BYLADEM1ANS</p>';
		if ($opt == 'ab' || $opt == 'reK') {
			$html .= '<p>&nbsp;</p>';
			$html .= '<p>&nbsp;</p>';
		}
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</htmlpagefooter>';
		return $html;
	}

	public function getPositionTableHeader($opt) {
		$html = '<thead>';
		$html .= '<tr valign="bottom">';
		$html .= '<th width="50px" valign="bottom">Position</th>';
		$html .= '<th width="50px" valign="bottom">Anzahl</th>';
		$html .= '<th width="100px" valign="bottom">Format in mm</th>';
		$html .= '<th width="' . ( $opt == 'fe' ? '450px' : '280px' ) . '" valign="bottom" style="text-align: left;">Artikel</th>';
		if ($opt == 'ab' || $opt == 're' || $opt == 'reK') {
			$html .= '<th width="80px" valign="bottom">&euro;/Stk.</th>';
			$html .= '<th width="90px" valign="bottom" style="text-align: right;">Gesamt netto</th>';
		}
		$html .= '</tr>';
		$html .= '</thead>';
		return $html;
	}

	public function getPositionTableBody($opt) {

		$preis = 0;
		$summe_position = 0;

		$order = $this->order;
		$material = $this->konfigData['material'];
		$halter = $this->konfigData['halter'];

		$artikel = unserialize($order->getArticle());

		//$this->debugTypo($artikel);

		$html = '<tbody>';

		foreach ($artikel as $posNr => $a) {
			if ($a['artikel']['material'] != null) {
				$html .= '<tr>';
				$html .= '<td style="text-align: center;" valign="top">' . $posNr . '</td>';
				$html .= '<td style="text-align: left;">' . $a['anzahl'] . '</td>';
				$html .= '<td style="text-align: left;">' . $a['artikel']['materialConfig']['width'] . ' x ' . $a['artikel']['materialConfig']['height'] . '</td>';
				$html .= '<td style="text-align: left;">';
				for ($i = 0; $i < count($material); $i++) {
					if ($material[$i]['uid'] == $a['artikel']['material']['uid']) {
						$html .= '<span class="position">' . $material[$i]['name'];
						$html .= ' ' . $a['artikel']['material']['size'] . ' mm';
						for ($j = 0; $j < count($material[$i]['varianten']); $j++) {
							if ($material[$i]['varianten'][$j]['uid'] == $a['artikel']['material']['vid']) {
								$html .= ' ' . $material[$i]['varianten'][$j]['name'] . '</span><br />';
							}
						}
						if ($opt == 'ab') {
							$html .= '<span class="deatail1" style="margin-left: 10px;">Bearbeitungen lt. Anlage</span>';
						} else if ($opt == 'fe') {
							$kanten = $this->konfigData['kanten'];
							for ($i = 0; $i < count($kanten); $i++) {
								if ($kanten[$i]['uid'] == $a['artikel']['bearbeitungen']['kanten']['uid']) {
									$html .= '<span class="deatail1" style="margin-left: 10px;">' . $kanten[$i]['name'] . '</span><br />';
									$html .= '<span class="deatail1" style="margin-left: 10px;">Bearbeitungen lt. Zeichnung</span>';
								}
							}
							$html .= '</span>';
						} else {
							$html .= '<span class="deatail1" style="margin-left: 10px;">Bearbeitungen lt. AB Anlage</span>';
						}
					}
				}
				$html .= '</td>';
				if ($opt == 'ab' || $opt == 're' || $opt == 'reK') {
					$einzel_preis = floatval($a['preis']);
					$html .= '<td style="text-align: center;">' . number_format($einzel_preis, 2, ',', '') . ' &euro;</td>';
					$summe_position = floatval($a['preis']) * intval($a['anzahl']);
					$html .= '<td style="text-align: right;">' . number_format($summe_position, 2, ',', '') . ' &euro;</td>';
					$preis += $summe_position;
				}
				$html .= '</tr>';
			} else if ($a['artikel']['halter'] != null) {
				for ($j = 0; $j < count($halter); $j++) {
					if ($halter[$j]['uid'] == $a['artikel']['halter']['uid']) {
						for ($k = 0; $k < count($halter[$j]['varianten']); $k++) {
							if ($halter[$j]['varianten'][$k]['uid'] == $a['artikel']['halter']['vid']) {
								$html .= '<tr>';
								$html .= '<td style="text-align: center;" valign="top">' . $posNr . '</td>';
								$html .= '<td style="text-align: left;">' . $a['anzahl'] . '</td>';
								$html .= '<td style="text-align: left;">&nbsp;</td>';
								$html .= '<td style="text-align: left;">';
								$html .= '<span class="deatail1"><b>' . $halter[$j]['varianten'][$k]['name'] . '</b></span><br />';
								$html .= '<span class="deatail2"><b>Material:</b> ' . $halter[$j]['varianten'][$k]['material'] . '</span><br />';
								$html .= '<span class="deatail2"><b>Verwendung:</b> ' . $halter[$j]['varianten'][$k]['beschreibung'] . '</span><br />';
								$html .= '<span class="deatail2"><b>Art.Nr.:</b> ' . $halter[$j]['varianten'][$k]['artnr'] . '</span>';
								$html .= '</td>';
								if ($opt == 'ab' || $opt == 're' || $opt == 'reK') {
									$einzel_preis = floatval($a['preis']);
									$html .= '<td style="text-align: center;">' . number_format($einzel_preis, 2, ',', '') . ' &euro;</td>';
									$summe_position = floatval($a['preis']) * intval($a['anzahl']);
									$html .= '<td style="text-align: right;">' . number_format($summe_position, 2, ',', '') . ' &euro;</td>';
									$preis += $summe_position;
								}
								$html .= '</tr>';
							}
						}
					}
				}
			} else if ($a['artikel']['profil'] != null) {
				$profile = $this->konfigData['produktart']['profile'];
				$html .= '<tr>';
				$html .= '<td style="text-align: center;" valign="top">' . $posNr . '</td>';
				$html .= '<td style="text-align: left;">' . $a['anzahl'] . '</td>';
				$html .= '<td style="text-align: left;">' . $a['artikel']['rahmenConfig']['width'] . ' x ' . $a['artikel']['rahmenConfig']['height'] . ' mm</td>';
				$html .= '<td style="text-align: left;">';
				for ($i = 0; $i < count($profile); $i++) {
					if ($profile[$i]['uid'] == intval($a['artikel']['profil']['uid'])) {
						for ($j = 0; $j < count($profile[$i]['variante']); $j++) {
							if ($profile[$i]['variante'][$j]['uid'] == intval($a['artikel']['profil']['vid'])) {
								$html .= '<span class="position">' . $profile[$i]['name'] . ' ' . $profile[$i]['variante'][$j]['name'] . '</span><br />';
							}
						}
					}
				}
				$html .= '<span class="deatail1" style="margin-left: 10px;">Bearbeitungen lt. AB Anlage</span>';
				$html .= '</td>';
				if ($opt == 'ab' || $opt == 're' || $opt == 'reK') {
					$einzel_preis = floatval($a['preis']);
					$html .= '<td style="text-align: center;">' . number_format($einzel_preis, 2, ',', '') . ' &euro;</td>';
					$summe_position = floatval($a['preis']) * intval($a['anzahl']);
					$html .= '<td style="text-align: right;">' . number_format($summe_position, 2, ',', '') . ' &euro;</td>';
					$preis += $summe_position;
				}
				$html .= '</tr>';
			} else if ($a['artikel']['voucher'] != null) {
				$html .= '<tr>';
				$html .= '<td style="text-align: center;" valign="top">' . $posNr . '</td>';
				$html .= '<td style="text-align: left;">' . $a['anzahl'] . '</td>';
				$html .= '<td style="text-align: left;">&nbsp;</td>';
				$html .= '<td style="text-align: left;">';
				$html .= '<b>Gutschein: </b>' . $a['artikel']['voucher'];
				$html .= '</td>';
				if ($opt == 'ab' || $opt == 're' || $opt == 'reK') {
					$einzel_preis = floatval($a['preis']);
					$html .= '<td style="text-align: center;">' . number_format($einzel_preis, 2, ',', '') . ' &euro;</td>';
					$summe_position = floatval($a['preis']) * intval($a['anzahl']);
					$html .= '<td style="text-align: right;">' . number_format($summe_position, 2, ',', '') . ' &euro;</td>';
					$preis += $summe_position;
				}
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		return array('html' => $html, 'preis' => $preis);
	}

	public function getZusammenFassungPreise($data) {

		$order = $this->order;

		////$this->debugTypo($order);

		$bemerkungen = unserialize($order->getComment());
		$formular = unserialize($order->getFormular());

		$ausland = (isset($formular['ausland']) && ($formular['ausland'] == 'true') ? true : false);

		////$this->debugTypo($bemerkungen);
		//$this->debugTypo($bemerkungen);

		$versand = floatval($formular['versandkosten']);
		//$versand = floatval($bemerkungen['versand']['preis']);
		$rabatt = floatval($bemerkungen['rabatt']);
		$ewPalette = floatval($bemerkungen['ewPalette']);
		$werbeland = floatval($bemerkungen['werbelandRabatt']);
		$nachlass = $formular['nachlass'];
		$nachlassEinheit = $formular['nachlassEinheit'];

		$preis = $data['preis'];
		$zwSumme = 0;

		$html = '<div class="zusammenFassungPreise">';
		$html .= '<table>';
		$html .= '<tr>';
		$html .= '<td class="beschriftung">Summe netto</td>';
		$html .= '<td class="wert"><b>' . number_format($preis, 2, ',', '.') . ' &euro;</b></td>';
		$zwSumme += $preis;
		$html .= '</tr>';
		if (isset($rabatt) && ($rabatt != 0)) {
			$html .= '<tr>';
			$html .= '<td class="beschriftung">- Sondernachlass</td>';
			$html .= '<td class="wert">' . number_format($rabatt, 2, ',', '.') . ' &euro;</td>';
			$html .= '</tr>';
			$zwSumme = $zwSumme - $rabatt;
		}
		if (isset($nachlass) && ($nachlass != 0)) {
			$html .= '<tr>';
			$html .= '<td class="beschriftung">- Sonderrabatt ' . ($nachlassEinheit != 'EUR' ? '(' . $nachlass . '%)' : '') . '</td>';
			if ($nachlassEinheit == 'EUR') {
				$html .= '<td class="wert">' . number_format($nachlass, 2, ',', '.') . ' &euro;</td>';
				$zwSumme = $zwSumme - floatval($nachlass);
			} else {
				$berechnet = $zwSumme * $nachlass / 100;
				$html .= '<td class="wert">' . number_format($berechnet, 2, ',', '.') . ' &euro;</td>';
				$zwSumme = $zwSumme - floatval($berechnet);
			}
			$html .= '</tr>';
		}
		if (isset($ewPalette) && ($ewPalette != 0)) {
			$html .= '<tr>';
			$html .= '<td class="beschriftung">+ Aufpreis f&uuml;r Einwegpalette</td>';
			$html .= '<td class="wert">' . number_format($ewPalette, 2, ',', '.') . ' &euro;</td>';
			$html .= '</tr>';
			$zwSumme = $zwSumme + $ewPalette;
		}
		if ((isset($rabatt) && ($rabatt != 0)) || (isset($ewPalette) && ($ewPalette != 0) || (isset($nachlass) && ($nachlass != 0)))) {
			$html .= '<tr>';
			$html .= '<td class="beschriftung"><b>Zwischensumme</b></td>';
			$html .= '<td class="wert"><b>' . number_format($zwSumme, 2, ',', '.') . ' &euro;</b></td>';
			$html .= '</tr>';
		}
		if (isset($werbeland) && ($werbeland != 0)) {
			$html .= '<tr>';
			$html .= '<td class="beschriftung">- Werbelandrabatt (' . $werbeland . '%)</td>';
			$summeWerbeland = $zwSumme * $werbeland / 100;
			$html .= '<td class="wert">' . number_format($summeWerbeland, 2, ',', '.') . ' &euro;</td>';
			$html .= '</tr>';
			$zwSumme = $zwSumme - $summeWerbeland;
		}
		$html .= '<tr>';
		$html .= '<td class="beschriftung"> + Verpackung & Versand netto</td>';
		$html .= '<td class="wert">' . number_format($versand, 2, ',', '.') . ' &euro;</td>';
		$html .= '</tr>';
		$zwSumme = $zwSumme + $versand;
		$html .= '<tr>';
		$html .= '<td class="beschriftung"><b>Zwischensumme</b></td>';
		$html .= '<td class="wert"><b>' . number_format($zwSumme, 2, ',', '.') . ' &euro;</b></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td class="beschriftung">+ MwSt (' . ($ausland ? '0' : '19') . '%)</td>';
		$mwst = $zwSumme * floatval(0.19);
		$html .= '<td class="wert">' . ($ausland ? '0,00' : number_format($mwst, 2, ',', '.')) . ' &euro;</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td class="beschriftung"><b>Gesamt</b></td>';
		$gesamtPreis = ($ausland ? $zwSumme : $zwSumme + $mwst);
		$html .= '<td class="wert"><b>' . number_format($gesamtPreis, 2, ',', '.') . ' &euro;</b></td>';
		$html .= '</tr>';
		$html .= '</table>';
		$html .= '</div>';
		return array('html' => $html, 'gesamtPreis' => $gesamtPreis);
	}

	public function getZahlungsBedingung() {
		$text = '';

		$formular = unserialize($this->order->getFormular());

		if (isset($formular['zahlung']) && ($formular['zahlung'] != 0)) {
			$cond = $this->zBed;
			for ($i = 0; $i < count($cond); $i++) {
				if ($cond[$i]->getUid() == $formular['zahlung']) {
					$condition = $cond[$i];
				}
			}
		} else {
			$condition = $this->user->getPayCondition();
		}

		if ($condition->getDays() == 0) {
			$text .= 'Zahlbar innerhalb v. ' . $condition->getNetto() . ' Tagen ohne Abzug';
		} else {
			$text .= 'Bei Zahlung innerhalb von ' . $condition->getDays() . ' Tagen ' . $condition->getReduction() . '% Skonto<br/>ansonsten innerhalb von ' . $condition->getNetto() . ' Tagen netto';
		}

		return $text;
	}

	public function getZahlungsBedingungen($gesamtPreis) {

		$formular = unserialize($this->order->getFormular());

		if (isset($formular['zahlung']) && ($formular['zahlung'] != 0)) {
			$cond = $this->zBed;
			for ($i = 0; $i < count($cond); $i++) {
				if ($cond[$i]->getUid() == $formular['zahlung']) {
					$condition = $cond[$i];
				}
			}
		} else {
			$condition = $this->user->getPayCondition();
		}

		$html = '<div>';
		$html .= '<table border="0" style="border-collapse: collapse;margin-left: -1px;">';
		$html .= '<tr style="height: 45px">';
		$html .= '<td valign="top">Zahlungsbed.:</td>';
		if ($condition->getDays() == 0) {
			$html .= '<td valign="top">Zahlbar innerhalb v. ' . $condition->getNetto() . ' Tagen ohne Abzug</td>';
		} else {
			$skonto = $gesamtPreis * (floatval($condition->getReduction()) / 100);
			$html .= '<td valign="top">Bei Zahlung bis zum ' . date('d.m.Y', strtotime("+" . $condition->getDays() . " days")) . ' mit ' . $condition->getReduction() . '% Skonto (' . number_format($skonto, 2, ',', '') . ' &euro;),<br/>sonst Zahlung bis zum ' . date('d.m.Y', strtotime("+" . $condition->getNetto() . " days")) . ' netto.</td>';
		}
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td colspan="2">Bitte &uuml;berpr&uuml;fen Sie die Rechnung sofort nach Erhalt.</td>';
		$html .= '</tr>';
		$html .= '</table>';
		$html .= '</div>';
		return $html;
	}

	public function getPositionTableFooter($opt) {
		$order = $this->order;

		$artikel = unserialize($order->getArticle());
		$bemerkungen = unserialize($order->getComment());

		$gewicht = 0;
		$anzahl = 0;

		foreach ($artikel as $posNr => $a) {
			if ($a['artikel']['material'] != null) {
				$gewicht = (intval($a['artikel']['materialConfig']['width']) * intval($a['artikel']['materialConfig']['height'])) / 1000000 * floatval($a['artikel']['material']['size']) * floatval(1.2) * intval($a['anzahl']);
			}
			$anzahl = $anzahl + intval($a['anzahl']);
		}

		$html = '<tfoot>';
		if ($opt == 'fe') {
			$html .= '<tr>';
			$html .= '<td colspan="2" style="text-align: right; border-top:1px solid;">Gesamt Platten:</td>';
			$html .= '<td style="border-top:1px solid;">' . number_format($gewicht, 2, ',', '.') . ' kg</td>';
			$html .= '<td style="border-top:1px solid;">' . $anzahl . ' Stk.</td>';
			$html .= '</tr>';
		} else if ($opt == 'ls' || $opt == 'lsK') {
			$html .= '<tr style="border-top:1px solid;">';
			$html .= '<td style="border-top:1px solid;">Lieferbedingung:</td>';

			if ($bemerkungen['versand']['art'] == '') {
				$html .= '<td style="border-top:1px solid;">Selbstabholung</td>';
			} else {
				$html .= '<td style="border-top:1px solid;">Versand</td>';
			}
			$html .= '<td style="text-align: right; padding:3px;border-top:1px solid;">Gesamt:</td>';
			$html .= '<td style="text-align: left; padding:3px;border-top:1px solid;">' . $anzahl . ' Stk.</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td class="last">Lieferadresse:</td>';
			$lieferadresse = $order->getShippingaddress();
			if ($lieferadresse != null) {
				$html .= '<td colspan="3" class="last">' . $lieferadresse->getCompany() . ', ' . $lieferadresse->getPerson() . ', ' . $lieferadresse->getStreet() . ', ' . $lieferadresse->getZip() . ' ' . $lieferadresse->getCity() . '</td>';
			} else {
				$html .= '<td colspan="3" class="last">&nbsp;<td>';
			}
			$html .= '</tr>';
		}
		$html .= '</tfoot>';
		return $html;
	}

	public function getFePageFooterDaten() {
		$html = '<div class="footerDaten">';
		$html .= '<table border="1" style="border-collapse: collapse;margin-left: -1px;">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th>Gewicht</th>';
		$html .= '<th>Paketdienst</th>';
		$html .= '<th>Spedition</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$html .= '<tr>';
		$html .= '<td style="font-size: 1.5em;">&nbsp;</td>';
		$html .= '<td>&nbsp;</td>';
		$html .= '<td>&nbsp;</td>';
		$html .= '</tr>';
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '<table border="1" style="border-collapse: collapse;margin-left: -1px;">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th>Karton(Anzahl)</th>';
		$html .= '<th>Einwegpalette(Anzahl)</th>';
		$html .= '<th>Europalette(Anzahl)</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$html .= '<tr>';
		$html .= '<td style="font-size: 1.3em;">&nbsp;</td>';
		$html .= '<td>&nbsp;</td>';
		$html .= '<td>&nbsp;</td>';
		$html .= '</tr>';
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '<table border="1" style="border-collapse: collapse;margin-left: -1px;">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th>L&auml;nge(mm)</th>';
		$html .= '<th>Breite(mm)</th>';
		$html .= '<th>H&ouml;he(mm)</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$html .= '<tr>';
		$html .= '<td style="font-size: 1.5em;">&nbsp;</td>';
		$html .= '<td>&nbsp;</td>';
		$html .= '<td>&nbsp;</td>';
		$html .= '</tr>';
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '<table border="1" style="border-collapse: collapse;margin-left: -1px;">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th>Kontroliert</th>';
		$html .= '<th>Verpackt</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$html .= '<tr>';
		$html .= '<td style="font-size: 1.8em;">&nbsp;</td>';
		$html .= '<td>&nbsp;</td>';
		$html .= '</tr>';
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</div>';
		return $html;
	}

}

?>
