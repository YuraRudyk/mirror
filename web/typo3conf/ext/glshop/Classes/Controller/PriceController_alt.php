<?php

namespace Glacryl\Glshop\Controller;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Petro Dikij <petro.dikij@glacryl.de>, Glacryl Hedel GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * ProductController
 */
class PriceController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	protected $debugMode = false;

	/**
	 * ShopRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\ShopRepository
	 * @inject
	 */
	protected $shopRepository;

	/**
	 * PriceRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\PriceRepository
	 * @inject
	 */
	protected $priceRepository;

	/**
	 * CartRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\CartRepository
	 * @inject
	 */
	protected $cartRepository;

	/**
	 * MaterialRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\MaterialRepository
	 * @inject
	 */
	protected $materialRepository;

	/**
	 * DrillRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\DrillRepository
	 * @inject
	 */
	protected $drillRepository;

	/**
	 * BordereditingRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\BordereditingRepository
	 * @inject
	 */
	protected $bordereditingRepository;

	/**
	 * CornereditingRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\CornereditingRepository
	 * @inject
	 */
	protected $cornereditingRepository;

	/**
	 * FixingRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\FixingRepository
	 * @inject
	 */
	protected $fixingRepository;

	/**
	 * ProduktartRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\ProduktartRepository
	 * @inject
	 */
	protected $produktartRepository = NULL;

	/**
	 * RahmenproduktRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\RahmenproduktRepository
	 * @inject
	 */
	protected $rahmenproduktRepository = NULL;

	/**
	 * RahmenproduktvarianteRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\RahmenproduktvarianteRepository
	 * @inject
	 */
	protected $rahmenproduktvarianteRepository = NULL;

	/**
	 * Material
	 * 
	 */
	protected $material;

	/**
	 * Kanten
	 * 
	 */
	protected $kanten;

	/**
	 * Ecken
	 * 
	 */
	protected $ecken;

	/**
	 * Bohrungen
	 * 
	 */
	protected $bohrungen;

	/**
	 * Halter
	 * 
	 */
	protected $halter;

	/**
	 * CartItems
	 * 
	 */
	protected $cartItems;

	/**
	 * Faktoren
	 * 
	 */
	protected $faktoren;

	/**
	 * Prices
	 * 
	 */
	protected $prices = array();

	/**
	 * Mengenrabatt
	 * 
	 */
	protected $rabatt = 0;

	/**
	 * Palettenbau
	 * 
	 */
	protected $ewPalette = 0;

	/**
	 * RahmenGewicht
	 * 
	 */
	protected $rahmenGewicht = 0;

	/**
	 * Rahmenversand
	 */
	protected $rahmenSpedition = false;

	/**
	 * Usergroup
	 * 
	 */
	protected $group;

	/**
	 * Rahmen
	 * 
	 */
	protected $rahmen;

	/**
	 *
	 * Frontscheiben
	 */
	protected $frontscheiben;

	/**
	 *  Streuplatten
	 * 
	 */
	protected $streuplatten;

	/**
	 * LED's
	 * 
	 */
	protected $leds;

	/**
	 * Montage
	 * 
	 */
	protected $montagen;

	/**
	 * Anschluss
	 * 
	 */
	protected $anschlusse;

	/**
	 * Rueckwand
	 * 
	 */
	protected $rueckwand;

	/**
	 * Zubehoer
	 * 
	 */
	protected $zubehoer;

	/**
	 * mFactorArry
	 * 
	 */
	protected $mFactorArry;
	protected $konstanten = array(
		'arbeitsfaktor' => 0.8,
		'kZuschnitt1' => 0.000000219748,
		'kZuschnitt2' => 0.000495982,
		'kZuschnitt3' => 16.4172,
		'kSchwabeln1' => 0.00000000123527,
		'kSchwabeln2' => 0.00479476,
		'kSchwabeln3' => 2,
		'kFassen1' => 0.00099607182,
		'kFassen2' => 0.2,
		'kFacette1' => 0.003,
		'kPacket1' => 0.3934,
		'kPacket2' => 4,
		'kPallete1' => 0.35, // €/kg
		'kPallete2' => 4,
		'sZuschnitt' => 30,
		'sMacryl' => 60,
		'sSchwabeln' => 30,
		'sLaser' => 100,
		'sBohrungen' => 30,
		'minZuschnitt' => 5, // Zeit zum Holen des Materials
		'vZuschnitt1' => 2000, // 1. Schnitt => Geschwindigkeit in mm/min 
		'vZuschnitt2' => 1500, // 2. Schnitt => Geschwindigkeit in mm/min 
		'segeBlattZuschnitt' => 3, // Dicke des Sägeblattes
		'plattenBreite' => 2030, // Breite der Platte
		'vSchwabeln' => 1200, // Schwabeln => Geschwindigkeit in mm/min 
		'vMacryl' => 200, //Macryl geschwindichkeit in Milimeter/Minute
		'tMacryl' => 2, // Zeit zum wenden in Minuten
		'tFacette' => 20, //Zeit zum Rüsten der Facette
		'rLaser' => 13, // Zeit zum Rüsten vom Laser
		'tLaser1' => 3, //Zeit zum auflegen einer Plate auf den Lasertisch
		'tLaser2' => 1, //Zeit zum Nehmen eines Stückes vom Laser in Sekunden
		'tLaser3' => 10, //Zeit zum ablegen eines Stapels vom Laser in Sekunden
		'aLaser' => 3.35, // Flächeninhalt einer Platte in m^2
		'tBSLaser' => 10, //Zeit zum Einstellen von einem Bohrung/Senkung am Laser in Sekunden
		'tBSEinstellen' => 180, //Zeit zum Einstellen von einem Bohrung/Senkung in Sekunden 5 * 60
		'tBohrungen' => 15, //Zeit zum Bohren eines Bohrlochs in Sekunden
		'tSenkungen' => 10, //Zeit zum Senken in Sekunden
		'tLREcken1' => 15, //Zeit zum Rundecken einrüsten vom Laser pro Ecke in Sekunden
		'tLREcken2' => 2, //Zeit zum Rundecken schneiden in Sekunden
		'tLSEcken1' => 15, //Zeit zum Schrägecken einrüsten vom Laser pro Ecke in Sekunden
		'tLSEcken2' => 2, //Zeit zum Schrägecken schneiden in Sekunden
		'tZSEcken1' => 60, //Zeit zum Schrägecken einrüsten vom Zuschnitt pro Ecke in Sekunden
		'tZSEcken2' => 1.5 //Zeit zum Schrägecken schneiden in Sekunden
	);
	protected $laserzeit = array(
		'1' => 3750,
		'2' => 3250,
		'2.5' => 2500,
		'3' => 2200,
		'4' => 1800,
		'5' => 1600,
		'6' => 1400,
		'8' => 600,
		'10' => 500,
		'12' => 400,
		'15' => 300,
		'20' => 230
	);
	protected $bearbeitungen = array(
		array(
			'id' => 1,
			'label' => "ges&auml;gte Kante",
			'functions' => array('berechneZuschnitt'),
		), array(
			'id' => 2,
			'label' => "Laserkante",
			'functions' => array('berechneLaser'),
		), array(
			'id' => 3,
			'label' => "ges&auml;gt &amp; gefasst",
			'functions' => array('berechneZuschnitt', 'berechneKantenFasen'),
		), array(
			'id' => 4,
			'label' => "Laserkante gefasst",
			'functions' => array('berechneLaser', 'berechneKantenFasen')
		), array(
			'id' => 5,
			'label' => "diamantpoliert &amp; gefasst",
			'functions' => array('berechneZuschnitt', 'berechneMacryl', 'berechneSchwabeln', 'berechneKantenFasen'),
		), array(
			'id' => 6,
			'label' => "facettiert &amp; poliert",
			'functions' => array('berechneZuschnitt', 'berechneMacryl', 'berechneSchwabeln', 'berechneKantenFasen', 'berechneFacette'),
		)
	);
	protected $shipping = array(
		'Paketdienst' => array(
			'preise' => array(
				2 => 5.62,
				3 => 5.80,
				5 => 6.17,
				8 => 6.90,
				10 => 7.92,
				15 => 9.21,
				20 => 10.96,
				25 => 13.93,
				32 => 16.84,
				40 => 19.83
			),
			'gurtmass' => array(
				'MAX' => 3000,
				'H' => 600,
				'B' => 800,
				'L' => 2000
			),
			'express' => array(
				'basis' => 17.93,
				'extraKg' => 0.87
			)
		),
		'Spedition' => array(
			'wMin' => 0,
			'wMax' => 2500,
			'minPreis' => 35.8,
			'dieselZuschlag' => 4,
			'matrix' => array(
				'50' => array(
					'1' => 26.4,
					'2' => 26.4,
					'3' => 26.4,
					'4' => 26.4,
					'5' => 26.4,
					'6' => 26.4,
					'7' => 26.5,
					'8' => 27,
					'9' => 27.20
				),
				'75' => array(
					'1' => 26.4,
					'2' => 26.4,
					'3' => 26.4,
					'4' => 27.6,
					'5' => 30.2,
					'6' => 32.4,
					'7' => 33.9,
					'8' => 34.5,
					'9' => 34.8
				),
				'100' => array(
					'1' => 26.4,
					'2' => 26.4,
					'3' => 28.4,
					'4' => 33.4,
					'5' => 36.5,
					'6' => 39.2,
					'7' => 41.1,
					'8' => 41.9,
					'9' => 42.1
				),
				'140' => array(
					'1' => 29,
					'2' => 35.5,
					'3' => 39.1,
					'4' => 46.1,
					'5' => 50.4,
					'6' => 54.3,
					'7' => 56.6,
					'8' => 57.8,
					'9' => 58.1
				),
				'180' => array(
					'1' => 33.4,
					'2' => 41.1,
					'3' => 45.2,
					'4' => 53.1,
					'5' => 58.1,
					'6' => 62.7,
					'7' => 65.4,
					'8' => 66.6,
					'9' => 67.2
				),
				'220' => array(
					'1' => 41.4,
					'2' => 50.9,
					'3' => 55.9,
					'4' => 65.8,
					'5' => 72,
					'6' => 77.6,
					'7' => 81,
					'8' => 82.6,
					'9' => 83.1
				),
				'260' => array(
					'1' => 45.7,
					'2' => 56.2,
					'3' => 61.8,
					'4' => 72.7,
					'5' => 79.5,
					'6' => 85.7,
					'7' => 89.5,
					'8' => 91.2,
					'9' => 91.8
				),
				'300' => array(
					'1' => 49.6,
					'2' => 61,
					'3' => 67.2,
					'4' => 78.9,
					'5' => 86.5,
					'6' => 93.1,
					'7' => 97.2,
					'8' => 98.9,
					'9' => 99.7
				),
				'340' => array(
					'1' => 56.7,
					'2' => 69.8,
					'3' => 76.8,
					'4' => 90.4,
					'5' => 98.9,
					'6' => 106.5,
					'7' => 111.1,
					'8' => 113.2,
					'9' => 114.1
				),
				'380' => array(
					'1' => 60.5,
					'2' => 74.4,
					'3' => 81.9,
					'4' => 96.4,
					'5' => 105.5,
					'6' => 113.6,
					'7' => 118.6,
					'8' => 120.9,
					'9' => 121.7
				),
				'420' => array(
					'1' => 67,
					'2' => 82.4,
					'3' => 90.7,
					'4' => 106.7,
					'5' => 116.8,
					'6' => 125.8,
					'7' => 131.2,
					'8' => 133.8,
					'9' => 134.7
				),
				'460' => array(
					'1' => 70.4,
					'2' => 86.7,
					'3' => 95.4,
					'4' => 112.3,
					'5' => 123,
					'6' => 132.4,
					'7' => 138.2,
					'8' => 140.8,
					'9' => 141.8
				),
				'500' => array(
					'1' => 73.8,
					'2' => 90.7,
					'3' => 99.8,
					'4' => 117.4,
					'5' => 128.6,
					'6' => 138.4,
					'7' => 144.5,
					'8' => 147.2,
					'9' => 148.3
				),
				'600' => array(
					'1' => 85,
					'2' => 104.5,
					'3' => 115,
					'4' => 135.3,
					'5' => 148.2,
					'6' => 159.5,
					'7' => 166.4,
					'8' => 169.6,
					'9' => 170.8
				),
				'700' => array(
					'1' => 95.1,
					'2' => 117,
					'3' => 128.7,
					'4' => 151.4,
					'5' => 165.8,
					'6' => 178.,
					'7' => 186.3,
					'8' => 189.9,
					'9' => 191.2
				),
				'800' => array(
					'1' => 103,
					'2' => 126.5,
					'3' => 139.3,
					'4' => 163.9,
					'5' => 179.4,
					'6' => 193.2,
					'7' => 201.7,
					'8' => 205.5,
					'9' => 206.9
				),
				'900' => array(
					'1' => 113,
					'2' => 139,
					'3' => 152.9,
					'4' => 180.1,
					'5' => 197.1,
					'6' => 212.2,
					'7' => 221.5,
					'8' => 225.8,
					'9' => 227.3
				),
				'1000' => array(
					'1' => 117.2,
					'2' => 144,
					'3' => 158.5,
					'4' => 186.6,
					'5' => 204.1,
					'6' => 219.8,
					'7' => 229.4,
					'8' => 233.8,
					'9' => 235.4
				),
				'1100' => array(
					'1' => 121.4,
					'2' => 149.3,
					'3' => 164.2,
					'4' => 193.3,
					'5' => 211.6,
					'6' => 227.9,
					'7' => 237.9,
					'8' => 242.4,
					'9' => 244.2
				),
				'1200' => array(
					'1' => 127.8,
					'2' => 157.1,
					'3' => 172.9,
					'4' => 203.6,
					'5' => 222.8,
					'6' => 239.8,
					'7' => 250.3,
					'8' => 255.1,
					'9' => 256.8
				),
				'1300' => array(
					'1' => 133.7,
					'2' => 164.4,
					'3' => 180.9,
					'4' => 213,
					'5' => 233.1,
					'6' => 251,
					'7' => 262,
					'8' => 267,
					'9' => 268.8
				),
				'1400' => array(
					'1' => 139.5,
					'2' => 171.5,
					'3' => 188.7,
					'4' => 222.2,
					'5' => 243.2,
					'6' => 261.9,
					'7' => 273.3,
					'8' => 278.6,
					'9' => 280.5
				),
				'1500' => array(
					'1' => 144.8,
					'2' => 178,
					'3' => 195.8,
					'4' => 230.7,
					'5' => 252.4,
					'6' => 271.7,
					'7' => 283.7,
					'8' => 289.2,
					'9' => 291.2
				),
				'1750' => array(
					'1' => 155.2,
					'2' => 190.9,
					'3' => 210,
					'4' => 247.1,
					'5' => 270.5,
					'6' => 291.3,
					'7' => 304,
					'8' => 309.9,
					'9' => 312
				),
				'2000' => array(
					'1' => 169,
					'2' => 207.7,
					'3' => 228.5,
					'4' => 269.1,
					'5' => 294.6,
					'6' => 317.1,
					'7' => 331,
					'8' => 337.4,
					'9' => 339.7
				),
				'2250' => array(
					'1' => 180.2,
					'2' => 221.6,
					'3' => 243.8,
					'4' => 286.9,
					'5' => 314.1,
					'6' => 338.1,
					'7' => 352.9,
					'8' => 359.8,
					'9' => 362.3
				),
				'2500' => array(
					'1' => 189.5,
					'2' => 233,
					'3' => 256.4,
					'4' => 301.8,
					'5' => 330.3,
					'6' => 355.6,
					'7' => 371.2,
					'8' => 378.4,
					'9' => 380.9
				),
				'3000' => array(
					'1' => 196.6,
					'2' => 235.9,
					'3' => 259.4,
					'4' => 306.6,
					'5' => 338.1,
					'6' => 361.7,
					'7' => 377.4,
					'8' => 385.3,
					'9' => 393.2
				)
			),
			'zonen' => array(
				'01' => 6,
				'02' => 6,
				'03' => 7,
				'04' => 5,
				'06' => 5,
				'07' => 4,
				'08' => 4,
				'09' => 5,
				'10' => 7,
				'12' => 7,
				'13' => 7,
				'14' => 7,
				'15' => 7,
				'16' => 7,
				'17' => 8,
				'18' => 9,
				'19' => 8,
				'20' => 8,
				'21' => 8,
				'22' => 8,
				'23' => 8,
				'24' => 9,
				'25' => 9,
				'26' => 8,
				'27' => 8,
				'28' => 8,
				'29' => 7,
				'30' => 6,
				'31' => 6,
				'32' => 6,
				'33' => 6,
				'34' => 5,
				'35' => 5,
				'36' => 4,
				'37' => 5,
				'38' => 6,
				'39' => 6,
				'40' => 6,
				'41' => 6,
				'42' => 6,
				'44' => 6,
				'45' => 6,
				'46' => 7,
				'47' => 7,
				'48' => 7,
				'49' => 7,
				'50' => 6,
				'51' => 6,
				'52' => 6,
				'53' => 6,
				'54' => 6,
				'55' => 5,
				'56' => 5,
				'57' => 5,
				'58' => 6,
				'59' => 6,
				'60' => 4,
				'61' => 4,
				'63' => 3,
				'64' => 4,
				'65' => 4,
				'66' => 5,
				'67' => 4,
				'68' => 4,
				'69' => 3,
				'70' => 3,
				'71' => 3,
				'72' => 4,
				'73' => 3,
				'74' => 3,
				'75' => 4,
				'76' => 4,
				'77' => 5,
				'78' => 5,
				'79' => 5,
				'80' => 4,
				'81' => 4,
				'82' => 4,
				'83' => 5,
				'84' => 4,
				'85' => 3,
				'86' => 3,
				'87' => 4,
				'88' => 4,
				'89' => 3,
				'90' => 2,
				'91' => 1,
				'92' => 3,
				'93' => 3,
				'94' => 4,
				'95' => 3,
				'96' => 3,
				'97' => 3,
				'98' => 4,
				'99' => 5
			),
			'express' => 35
		)
	);
	protected $euroPalette = null;

	public function getPrices() {
		return $this->prices;
	}

	public function getRabatt() {
		return $this->rabatt;
	}

	public function getEwPalette() {
		return $this->ewPalette;
	}

	public function init($cartItems) {
		$this->debugTypo(true, 'Neue Kalkulation');
		$this->resetData();
		$this->cartItems = $cartItems;
		$this->iniShopData();
		$this->getFaktoren();
		$this->startCalculation();
		$this->debugMode = false;
	}

	public function resetData() {
		$this->cartItems = null;

		$this->material = null;
		$this->kanten = null;
		$this->ecken = null;
		$this->bohrungen = null;
		$this->halter = null;

		$this->group = null;
		$this->mFactorArry = null;

		$this->prices = array();
		$this->rabatt = 0;
		$this->ewPalette = 0;
		$this->euroPalette = null;
	}

	public function setDebugMode($on) {
		$this->debugMode = $on;
	}

	public function startCalculation() {
		foreach ($this->cartItems as $cartItem) {
			$this->prices[$cartItem->getUid()] = $this->calculate($cartItem);
		}
	}

	public function iniShopData() {
		$this->material = $this->materialRepository->findAll();
		$this->kanten = $this->bordereditingRepository->findAll();
		$this->ecken = $this->cornereditingRepository->findAll();
		$this->bohrungen = $this->drillRepository->findAll();
		$this->halter = $this->fixingRepository->findAll();

		$this->rahmen = $this->produktartRepository->findByName('Rahmen')->getFirst()->getProdukt();
		$this->frontscheiben = $this->produktartRepository->findByName('Frontscheibe')->getFirst()->getProdukt();
		$this->streuplatten = $this->produktartRepository->findByName('Streuplatte')->getFirst()->getProdukt();
		$this->leds = $this->produktartRepository->findByName('LED')->getFirst()->getProdukt();
		$this->montagen = $this->produktartRepository->findByName('Montage')->getFirst()->getProdukt();
		$this->anschlusse = $this->produktartRepository->findByName('Anschluss')->getFirst()->getProdukt();
		$this->rueckwand = $this->produktartRepository->findByName('Rueckwand')->getFirst()->getProdukt();
		$this->zubehoer = $this->produktartRepository->findByName('Zubehoer')->getFirst()->getProdukt();

		$this->group = intval($GLOBALS['TSFE']->fe_user->user['usergroup']);
		$this->mFactorArry = $this->priceRepository->getPriceFactorByGroup($this->group);

		$this->debugTypo($this->material, 'Material');
		$this->debugTypo($this->kanten, 'Kanten');
		$this->debugTypo($this->ecken, 'Ecken');
		$this->debugTypo($this->bohrungen, 'Bohrungen');
		$this->debugTypo($this->halter, 'Halter');
	}

	public function getFaktoren() {
		$cartItems = $this->cartItems;

		$mFactor = floatval(1);
		$preis = floatval(0);
		$gesQty = intval(0);

		$mFactorInflation = ($this->group == 4 ? $this->shopRepository->findByAKey('demoFactor')->getFirst()->getAValue() : ($this->group == 3 ? $this->shopRepository->findByAKey('materialPrivatFactor')->getFirst()->getAValue() : $this->shopRepository->findByAKey('materialFactor')->getFirst()->getAValue()));

		$cutoff = (floatval($this->shopRepository->findByAKey('cutoff')->getFirst()->getAValue()) / 100) + 1;

		$temperQty = 0;
		$temperKilo = 0;

		$this->debugTypo($this->mFactorArry, 'Materialrabatte');

		$gleichesMaterial = array();


		foreach ($cartItems as $cartItem) {

			$cartData = unserialize($cartItem->getArticle());
			$material = $cartData['material'];

			if ($material != null) {
				$mPreis = floatval(0);
				$shildSize = $cartData['materialConfig'];
				$tempernSet = ($cartData['bearbeitungen']['tempern']['tempern'] === 'true' ? true : false);

				if ($tempernSet) {
					$temperQty += $cartItem->getQty();
					$temperKilo += (intval($shildSize['width']) / 1000 * intval($shildSize['height']) / 1000) * 1.2 * floatval($material['size']) * $cartItem->getQty();
				}

				foreach ($this->material as $m) {
					if ($m->getUid() == $material['uid']) {
						foreach ($m->getMaterialoption() as $v) {
							if ($v->getUid() == $material['vid']) {
								foreach ($v->getMaterialoptiontype() as $f) {
									$dicke = floatval($material['size']);
									if (floatval($f->getSize()) == $dicke) {
										$mPreis += floatval($f->getPrice()) * (intval($shildSize['width']) / 1000 * intval($shildSize['height']) / 1000);
										$this->debugTypo(floatval($f->getPrice()), 'Material EK / m²: ');
										$this->debugTypo((intval($shildSize['width']) / 1000 * intval($shildSize['height']) / 1000), 'Material Fläche: ');
										if ($gleichesMaterial[$material['uid']][$material['vid']][$dicke] == null) {
											$gleichesMaterial[$material['uid']][$material['vid']][$dicke] = 0;
										}
										$gleichesMaterial[$material['uid']][$material['vid']][$dicke] ++;
									}
								}
							}
						}
					}
				}
				$preis += $mPreis * $cartItem->getQty() * $cutoff * $mFactorInflation;
				$gesQty += $cartItem->getQty();
			}
		}

		$this->debugTypo($gleichesMaterial, 'Gleiches Material und dicke im Warenkorb');

		for ($i = 0; $i < count($this->mFactorArry); $i++) {
			if (($preis > $this->mFactorArry[$i]['from']) && ($preis <= $this->mFactorArry[$i]['to'])) {
				$mFactor = $this->mFactorArry[$i]['factor'];
			}
		}

		$this->debugTypo($preis, 'Gesamtpreis für Material im WK: ');
		$this->debugTypo($mFactor, 'Aufschlag für Material im WK: ');

		$tempernStk = $this->berechneTempern($temperQty, $temperKilo);

		$this->debugTypo($tempernStk, 'Tempernpreis / Stück bei ' . $temperQty . ' die getempert werden müssen');

		$this->faktoren = array('mFactor' => $mFactor, 'tempernStk' => $tempernStk, 'gleich' => $gleichesMaterial);
	}

	public function calculate($cartItem) {

		$faktoren = $this->faktoren;

		$this->debugTypo($cartItem, 'Kalkulationstart');

		$preis = floatval(0);
		$mPreis = floatval(0);

		$cartData = unserialize($cartItem->getArticle());

		$mFactorInflation = ($this->group == 4 ? $this->shopRepository->findByAKey('demoFactor')->getFirst()->getAValue() : ($this->group == 3 ? $this->shopRepository->findByAKey('materialPrivatFactor')->getFirst()->getAValue() : $this->shopRepository->findByAKey('materialFactor')->getFirst()->getAValue()));
		$pFactorInflation = ($this->group == 4 ? $this->shopRepository->findByAKey('demoFactor')->getFirst()->getAValue() : ($this->group == 3 ? $this->shopRepository->findByAKey('productPrivatFactor')->getFirst()->getAValue() : $this->shopRepository->findByAKey('productFactor')->getFirst()->getAValue()));
		$eFactorInflation = ($this->group == 4 ? $this->shopRepository->findByAKey('demoFactor')->getFirst()->getAValue() : ($this->group == 3 ? $this->shopRepository->findByAKey('editPrivatFactor')->getFirst()->getAValue() : $this->shopRepository->findByAKey('editFactor')->getFirst()->getAValue()));
		$cutoff = floatval($this->shopRepository->findByAKey('cutoff')->getFirst()->getAValue()) / 100 + 1;

		$this->debugTypo($cutoff, 'Verschnitt: ');


		$this->debugTypo($cartData, 'Artikel: ');

		$material = $cartData['material'];
		$shildSize = $cartData['materialConfig'];
		$kanten = $cartData['bearbeitungen']['kanten'];
		$ecken = $cartData['bearbeitungen']['ecken'];
		$bohrungen = $cartData['bearbeitungen']['bohrungen'];
		$senkungen = $cartData['bearbeitungen']['senkungen'];
		$tempernSet = ($cartData['bearbeitungen']['tempern']['tempern'] === 'true' ? true : false);
		$temperKilo = 0;
		$halter = $cartData['halter'];

		$this->debugTypo($material, 'Material');




		if ($material != NULL) {
			// Material Preis
			foreach ($this->material as $m) {
				if ($m->getUid() == $material['uid']) {
					foreach ($m->getMaterialoption() as $v) {
						if ($v->getUid() == $material['vid']) {
							foreach ($v->getMaterialoptiontype() as $f) {
								if (floatval($f->getSize()) == floatval($material['size'])) {
									$mPreis += floatval($f->getPrice()) * (intval($shildSize['width']) / 1000 * intval($shildSize['height']) / 1000);
								}
							}
						}
					}
				}
			}

			if ($tempernSet) {
				$temperKilo += intval($shildSize['width']) / 1000 * intval($shildSize['height']) / 1000 * 1.2 * $material['size'] * $cartItem->getQty();
			}

			$mPreis = $mPreis * $cartItem->getQty() * $cutoff * $mFactorInflation;

			$this->debugTypo($mPreis, 'Materialgespreis bei Anz.: ' . $cartItem->getQty() . ', Verschnitt: ' . $cutoff . ', Teuerung: ' . $mFactorInflation);

			$materialFaktor = 1;

			for ($i = 0; $i < count($this->mFactorArry); $i++) {
				if (($mPreis > $this->mFactorArry[$i]['from']) && ($mPreis <= $this->mFactorArry[$i]['to'])) {
					$materialFaktor = $this->mFactorArry[$i]['factor'];
				}
			}

			$this->debugTypo($materialFaktor, 'Material Rabatt / Position: ');

			$this->debugTypo($faktoren['mFactor'], 'Material Faktor über warenkorb ');


			$preis += $mPreis * $materialFaktor;



			$this->rabatt += round($preis - ($mPreis * $faktoren['mFactor']), 2);

			$this->debugTypo($preis, 'Preis des Materials');
			$this->debugTypo($mPreis * $faktoren['mFactor'], 'Rabattierer Preis der Position im Warenkorb mit sonder RAbatt');
			$this->debugTypo($this->rabatt, 'Gesamt Rabatt');

			$eZeit = floatval(0);


			$eckenQty = $this->getEckenQty($ecken);

			$daten = array(
				'uid' => $material['uid'],
				'vid' => $material['vid'],
				'l' => floatval($shildSize['height']),
				'b' => floatval($shildSize['width']),
				't' => floatval($material['size']),
				'qty' => intval($cartItem->getQty()),
				'bearbeitung' => intval($kanten['uid']),
				'drill' => $this->getBohrQty($bohrungen),
				'senk' => $this->getSenkQty($senkungen),
				'rundecken' => $eckenQty['rund'],
				'schrägecken' => $eckenQty['schraeg'],
				'gleich' => $faktoren['gleich']
			);


			// Kantenbearbeitung
			for ($i = 0; $i < count($this->bearbeitungen); $i++) {
				if ($this->bearbeitungen[$i]['id'] == intval($kanten['uid'])) {
					for ($k = 0; $k < count($this->bearbeitungen[$i]['functions']); $k++) {
						$execFunction = $this->bearbeitungen[$i]['functions'][$k];
						$eZeit += $this->$execFunction($daten);
					}
					break;
				}
			}

			$eZeit += $this->berechneBohrungen($daten);
			$eZeit += $this->berechneRundEcken($daten);
			$eZeit += $this->berechneSchraegEcken($daten);

			$eZeit += $this->berechnePacken($cartItem);

			$this->debugTypo(($this->berechnePacken($cartItem) / $cartItem->getQty()), 'Packzeit pro Stück');

			$this->debugTypo(round($this->konstanten['arbeitsfaktor'] * $eZeit * $eFactorInflation, 2), 'Gesamtbearbeitungszeit in €, Faktor: ' . $this->konstanten['arbeitsfaktor']);

			$preis += round($this->konstanten['arbeitsfaktor'] * $eZeit * $eFactorInflation, 2);

			if (($halter != null) && (count($halter) > 0)) {
				$halterGesamtPreis = 0;

				$this->debugTypo($halter, 'Halter der Aktuellen Position');

				for ($i = 0; $i < count($halter); $i++) {
					$realQty = intval($halter[$i]['qty']) * intval($cartItem->getQty());
					$this->debugTypo($realQty, 'Gesamt Anzahl Halter / Variante: ');

					$halterEinzelPreis = floatval($this->getProductPrice($halter[$i]['hid'], $halter[$i]['vid'], 'halter')) * $pFactorInflation;
					$this->debugTypo($halterEinzelPreis, 'Halter Preis: ');

					$halterGesamtPreis += ($halterEinzelPreis * $realQty);
				}

				$this->debugTypo($halterGesamtPreis, 'Gesamtpreis der halter');
				$preis += $halterGesamtPreis;
			}

			$this->debugTypo($preis, 'Ges. Preis inkl. Halter:');
		} else if (($halter != NULL) && ($material == null)) {
			$halterEinzelPreis = $this->getProductPrice($halter['uid'], $halter['vid'], 'halter') * $pFactorInflation;
			$this->debugTypo($halterEinzelPreis, 'Einzelpreis des Halters: ');
			$preis = $halterEinzelPreis * $cartItem->getQty();
		} else {
			$preis = $this->calculateRahmenPreis($cartData, $cartItem->getQty());
			//$this->debugTypo($preis, 'Gesamtrahmenpreis', true);
		}

		$temperPreis = ($tempernSet ? ($this->berechneTempern($cartItem->getQty(), $temperKilo) * $cartItem->getQty()) : 0);

		$simulatetTemperPreis = ($tempernSet ? ($faktoren['tempernStk'] * $cartItem->getQty()) : 0);

		if ($tempernSet) {
			$this->rabatt += $temperPreis - $simulatetTemperPreis;
		}

		$this->debugTypo($temperPreis, 'Preis zum Tempern / Position');

		return round(($preis + $temperPreis) / $cartItem->getQty(), 2);
	}

	protected $rahmenData = array(
		'konstanten' => array(
			'arbeitsfaktor' => 0.8,
			'kPacket1' => 0.6550, //0.3934,
			'kPacket2' => 15,
			'kPallete1' => 1, //0.35, // €/kg
			'kPallete2' => 20
		),
		'faktoren' => array(
			'AUXO' => array(
				'EV1' => array(
					'stange' => 2.25,
					'fix' => 3.25
				),
				'NIRO' => array(
					'stange' => 2.5,
					'fix' => 3.5
				),
				'SW' => array(
					'stange' => 2.25,
					'fix' => 3.25
				),
				'WS' => array(
					'stange' => 2.25,
					'fix' => 3.25
				)
			),
			'THALLO' => array(
				'EV1' => array(
					'stange' => 2.25,
					'fix' => 3.25
				),
				'NIRO' => array(
					'stange' => 2.5,
					'fix' => 3.5
				),
				'SW' => array(
					'stange' => 2.25,
					'fix' => 3.25
				),
				'WS' => array(
					'stange' => 2.25,
					'fix' => 3.25
				)
			)
		),
		'components' => array(// Stueckzahlen pro Rahmen
			'winkelverbinder' => 1, // Set aus 4 Stk.
			'haengeblech' => array(// Ohne/Mit Abhebesicherung
				'ohne' => 2,
				'mit' => 4
			),
			'nutenstein' => 4, // Stk. abklaeren!
		),
		'dependencies' => array(
			'trafo' => array(
				'TRAFO15W' => array(
					'vertiefung' => false
				),
				'TRAFO30W' => array(
					'vertiefung' => true
				),
				'TRAFO60W' => array(
					'vertiefung' => true
				)
			),
			'anschluss' => array(
				'40' => array(// IDs
					'vertiefung' => false
				),
				'41' => array(
					'vertiefung' => true
				),
				'42' => array(
					'vertiefung' => true
				)
			),
			'montage' => array(
				'excenter' => array(//Ohne/Mit Abhebesicherung
					'ohne' => 2,
					'mit' => 4
				),
				'vertiefung' => array(//Ohne/Mit Abhebesicherung
					'ohne' => 2,
					'mit' => 4
				)
			)
		),
		'montage' => array(// Preis bis m²
			array('bis' => 1, 'preis' => 40.50),
			array('bis' => 2, 'preis' => 67.50),
			array('bis' => 3, 'preis' => 79.80)),
		'zuschnitt' => array(// Preis bis Stk. Gehrung 45° pro Rahmen
			array('bis' => 2, 'preis' => 18),
			array('bis' => 5, 'preis' => 14.5),
			array('bis' => 10, 'preis' => 10.7),
			array('ab' => 10, 'preis' => 9.60))
	);

	public function calculateRahmenPreis($cartData, $qty) {
		$gesamtKosten = 0;

		$gesamtKosten += $this->getRahmenPreis($cartData, $qty);
		$gesamtKosten += $this->getFrontscheibenPreis($cartData, $qty);
		$gesamtKosten += $this->getRueckwandPreis($cartData, $qty);
		$gesamtKosten += $this->getZubehoerPreis($qty);
		$gesamtKosten += $this->getLEDPreis($cartData, $qty);
		$gesamtKosten += $this->getStreuplattenPreis($cartData, $qty);
		$gesamtKosten += $this->getNetzanschlussPreis($cartData, $qty);
		$gesamtKosten += $this->getMontagePreis($cartData, $qty);
		$gesamtKosten += $this->getZuschnittPreis($qty);
		$gesamtKosten += $this->getZusammenbauPreis($cartData, $qty);
		$gesamtKosten += $this->getPackenPreis($cartData, $qty);

		$preis = $this->getRabattForRahmen($qty) * $gesamtKosten;

		return round($preis, 2);
	}

	public function getRabattForRahmen($qty) {
		$rabatt = 0.9922 * pow($qty, -0.064);
		return round($rabatt, 2);
	}

	public function getZuschnittPreis($qty) {
		$staffel = $this->rahmenData['zuschnitt'];
		$preis = 0;
		for ($i = 0; $i < count($staffel); $i++) {
			if (isset($staffel[$i]['bis'])) {
				if ($qty < $staffel[$i]['bis']) {
					$preis = $staffel[$i]['preis'] * $qty;
					break;
				}
			} else {
				if ($qty >= ($staffel[$i]['ab'])) {
					$preis = $staffel[$i]['preis'] * $qty;
					break;
				}
			}
		}
		//$this->debugTypo($preis, 'Preis Zuschnitt Rahmen', true);
		return round($preis, 2);
	}

	public function getZusammenbauPreis($cartData, $qty) {
		$staffel = $this->rahmenData['montage'];

		$w = $cartData['rahmenConfig']['width'];
		$h = $cartData['rahmenConfig']['height'];

		$qm = $w * $h / 1000000;
		$preis = 0;

		for ($i = 0; $i < count($staffel); $i++) {
			if ($qm < $staffel[$i]['bis']) {
				$preis = $staffel[$i]['preis'] * $qty;
				break;
			}
		}

		//$this->debugTypo($preis, 'Zusammenbaupreis', true);
		return round($preis, 2);
	}

	public function getProfilHelper($uid, $vid) {
		$rahmen = $this->rahmen;
		$data = array('r' => null, 'v' => null);
		foreach ($rahmen as $r) {
			if ($r->getUid() == $uid) {
				$data['r'] = $r;
				foreach ($r->getVariante() as $v) {
					if ($v->getUid() == $vid) {
						$data['v'] = $v;
					}
				}
			}
		}
		return $data;
	}

	public function getFrontscheibeHelper($uid, $vid) {
		$front = $this->frontscheiben;
		$data = array('f' => null, 'v' => null);
		foreach ($front as $f) {
			if ($f->getUid() == $uid) {
				$data['f'] = $f;
				foreach ($f->getVariante() as $v) {
					if ($v->getUid() == $vid) {
						$data['v'] = $v;
					}
				}
			}
		}
		return $data;
	}

	public function getLedHelper($uid, $vid) {
		$leds = $this->leds;
		$data = array('l' => null, 'v' => null);
		foreach ($leds as $l) {
			if ($l->getUid() == $uid) {
				$data['l'] = $l;
				foreach ($l->getVariante() as $v) {
					if ($v->getUid() == $vid) {
						$data['v'] = $v;
					}
				}
			}
		}
		return $data;
	}

	public function getStreuplattenHelper($uid, $vid) {
		$platten = $this->streuplatten;
		$data = array('p' => null, 'v' => null);
		foreach ($platten as $p) {
			if ($p->getUid() == $uid) {
				$data['p'] = $p;
				foreach ($p->getVariante() as $v) {
					if ($v->getUid() == $vid) {
						$data['v'] = $v;
					}
				}
			}
		}
		return $data;
	}

	public function getAnschlussHelper($uid, $vid) {
		$anschlusse = $this->anschlusse;
		$data = array('a' => null, 'v' => null);
		foreach ($anschlusse as $a) {
			if ($a->getUid() == $uid) {
				$data['a'] = $a;
				foreach ($a->getVariante() as $v) {
					if ($v->getUid() == $vid) {
						$data['v'] = $v;
					}
				}
			}
		}
		return $data;
	}

	public function getMontageHelper($uid, $vid) {
		$montagen = $this->montagen;
		$data = array('m' => null, 'v' => null);
		foreach ($montagen as $m) {
			if ($m->getUid() == $uid) {
				$data['m'] = $m;
				foreach ($m->getVariante() as $v) {
					if ($v->getUid() == $vid) {
						$data['v'] = $v;
					}
				}
			}
		}
		return $data;
	}

	public function getRueckwandHelper($uid) {
		$ruckwand = $this->rueckwand;
		foreach ($ruckwand as $r) {
			if ($r->getUid() == $uid) {
				return $r;
			}
		}
	}

	public function getZubehoerHelper($vid) {
		$zubehoer = $this->zubehoer;

		foreach ($zubehoer as $z) {
			foreach ($z->getVariante() as $v) {
				if ($v->getUid() == $vid) {
					return $v;
				}
			}
		}
	}

	public function getRahmenPreis($cartData, $qty) {
		$current = $cartData['profil'];
		$w = $cartData['rahmenConfig']['width'];
		$h = $cartData['rahmenConfig']['height'];
		$rahmen = $this->getProfilHelper($current['uid'], $current['vid']);

		$demoFaktor = 1.0;
		if ($this->group == 4) {
			$demoFaktor = floatval($this->shopRepository->findByAKey('demoFactor')->getFirst()->getAValue()) * 1.5;
		}

		$faktor = 0;
		$preis = 0;
		$lfm = (($w + $h) * 2) / 1000;
		if (isset($rahmen['v'])) {
			$ek = $rahmen['v']->getPreis() * $demoFaktor;
			$faktor = $this->rahmenData['faktoren'][$rahmen['r']->getArtNr()][$rahmen['v']->getArtNr()]['fix'];
			$preis += $ek * $faktor * $lfm * $qty;
		}

		//$this->debugTypo($preis, 'Rahmenpreis', true);
		return round($preis, 2);
	}

	public function getFrontscheibenPreis($cartData, $qty) {
		$current = $cartData['frontscheibe'];
		$front = $this->getFrontscheibeHelper($current['uid'], $current['vid']);

		$w = $cartData['rahmenConfig']['width'];
		$h = $cartData['rahmenConfig']['height'];

		$demoFaktor = 1.0;
		if ($this->group == 4) {
			$demoFaktor = floatval($this->shopRepository->findByAKey('demoFactor')->getFirst()->getAValue()) * 1.5;
		}

		$preis = 0;
		$qm = $w * $h / 1000000;
		if (isset($front['v'])) {
			$preis += $qm * $front['v']->getPreis() * $demoFaktor * $qty;
		}

		//$this->debugTypo($preis, 'Frontscheibenpreis: ', true);
		return round($preis, 2);
	}

	public function getRueckwandPreis($cartData, $qty) {
		$preis = 0;

		$w = $cartData['rahmenConfig']['width'];
		$h = $cartData['rahmenConfig']['height'];

		$wand = $this->getRueckwandHelper(18);

		$demoFaktor = 1.0;
		if ($this->group == 4) {
			$demoFaktor = floatval($this->shopRepository->findByAKey('demoFactor')->getFirst()->getAValue()) * 1.5;
		}

		$qm = $w * $h / 1000000;
		$preis += $wand->getPreis() * $demoFaktor * $qm * $qty;

		//$this->debugTypo($preis, 'Rückwandpreis: ', true);
		return round($preis, 2);
	}

	public function getZubehoerPreis($qty) {
		$preis = 0;
		$components = $this->rahmenData['components'];

		$demoFaktor = 1.0;
		if ($this->group == 4) {
			$demoFaktor = floatval($this->shopRepository->findByAKey('demoFactor')->getFirst()->getAValue()) * 1.5;
		}

		$preis += $components['winkelverbinder'] * $qty * $this->getZubehoerHelper(60)->getPreis() * $demoFaktor;
		$preis += $components['nutenstein'] * $qty * $this->getZubehoerHelper(57)->getPreis() * $demoFaktor;

		//$this->debugTypo($preis, 'Zubehörpreis: ', true);
		return round($preis, 2);
	}

	public function getLEDPreis($cartData, $qty) {
		$current = $cartData['led'];
		$led = $this->getLedHelper($current['uid'], $current['vid']);

		$w = $cartData['rahmenConfig']['width'];
		$h = $cartData['rahmenConfig']['height'];

		$demoFaktor = 1.0;
		if ($this->group == 4) {
			$demoFaktor = floatval($this->shopRepository->findByAKey('demoFactor')->getFirst()->getAValue()) * 1.5;
		}

		$preis = 0;
		$lfm = 0;
		$kanten = $cartData['kanten'];
		if (isset($led['v'])) {
			if ($kanten['Links'] == 'true') {
				$lfm += $h;
			}
			if ($kanten['Oben'] == 'true') {
				$lfm += $w;
			}
			if ($kanten['Rechts'] == 'true') {
				$lfm += $h;
			}
			if ($kanten['Unten'] == 'true') {
				$lfm += $w;
			}

			$lfm = $lfm / 1000;

			$preis += $led['v']->getPreis() * $demoFaktor * $qty;

			$traffo = array(
				array('bis' => 1, 'preis' => 18),
				array('bis' => 2, 'preis' => 36),
				array('bis' => 3, 'preis' => 54),
				array('bis' => 4, 'preis' => 72),
				array('bis' => 6, 'preis' => 48),
				array('ab' => 6, 'preis' => 18)
			);

			$traffoPreis = 0;
			for ($i = 0; $i < count($traffo); $i++) {
				if (isset($traffo[$i]['bis'])) {
					if ($lfm <= $traffo[$i]['bis']) {
						$traffoPreis = $traffo[$i]['preis'] * $qty;
						break;
					}
				} else {
					if ($lfm > $traffo[$i]['ab']) {
						$traffoPreis = $traffo[$i]['preis'] * $qty;
						break;
					}
				}
			}

			$preis += $traffoPreis;

			$preis += $led['l']->getPreis() * $demoFaktor * $lfm * $qty;
		}

		//$this->debugTypo($preis, 'LED Preis: ', true);
		return round($preis, 2);
	}

	public function getStreuplattenPreis($cartData, $qty) {
		$current = $cartData['streuplatte'];
		$platte = $this->getStreuplattenHelper($current['uid'], $current['vid']);

		$w = $cartData['rahmenConfig']['width'];
		$h = $cartData['rahmenConfig']['height'];

		$demoFaktor = 1.0;
		if ($this->group == 4) {
			$demoFaktor = floatval($this->shopRepository->findByAKey('demoFactor')->getFirst()->getAValue()) * 1.5;
		}

		$preis = 0;
		$qm = $w * $h / 1000000;

		if (isset($platte['v'])) {
			$preis += $platte['v']->getPreis() * $demoFaktor * $qm * $qty;
		}
		//$this->debugTypo($preis, 'Streuplatten Preis: ', true);
		return round($preis, 2);
	}

	public function getNetzanschlussPreis($cartData, $qty) {
		$current = $cartData['netzanschluss'];
		$anschluss = $this->getAnschlussHelper($current['uid'], $current['vid']);

		$demoFaktor = 1.0;
		if ($this->group == 4) {
			$demoFaktor = floatval($this->shopRepository->findByAKey('demoFactor')->getFirst()->getAValue()) * 1.5;
		}

		$preis = 0;
		if (isset($anschluss['v'])) {
			$preis += $anschluss['v']->getPreis() * $demoFaktor * $qty;
		}

		//$this->debugTypo($preis, 'Anschluss Preis: ', true);
		return round($preis, 2);
	}

	public function getMontagePreis($cartData, $qty) {
		$current = $cartData['befestigung'];
		$montage = $this->getMontageHelper($current['uid'], $current['vid']);

		$demoFaktor = 1.0;
		if ($this->group == 4) {
			$demoFaktor = floatval($this->shopRepository->findByAKey('demoFactor')->getFirst()->getAValue()) * 1.5;
		}

		$preis = 0;
		$blechQty = 0;
		$mit = false;

		if (isset($montage['v'])) {

			if ($montage['m']->getArtNr() == 'WAMONOHNEABH') {
				$blechQty = 2;
				if ($montage['v']->getArtNr() == 'OHNEEXCEN2') {
					$mit = false;
				} else {
					$mit = true;
				}
			} else {
				$blechQty = 4;
				if ($montage['v']->getArtNr() == 'OHNEEXCEN4') {
					$mit = false;
				} else {
					$mit = true;
				}
			}

			if ($mit) {
				$preis += $blechQty * $qty * $this->getZubehoerHelper(56)->getPreis() * $demoFaktor; // Haengeblech
				$preis += $blechQty * $qty * $this->getZubehoerHelper(58)->getPreis() * $demoFaktor; // Excenter
				$preis += $blechQty * $qty * $this->getZubehoerHelper(59)->getPreis() * $demoFaktor; // Excentervertiefung
			} else {
				$preis += $blechQty * $qty * $this->getZubehoerHelper(56)->getPreis() * $demoFaktor; // Haengeblech
				$preis += $blechQty * $qty * $this->getZubehoerHelper(58)->getPreis() * $demoFaktor; // Excenter
			}
		}

		//$this->debugTypo($preis, 'Montage Preis: ', true);
		return round($preis, 2);
	}

	public function getPackenPreis($cartData, $qty) {

		$w = $cartData['rahmenConfig']['width'];
		$h = $cartData['rahmenConfig']['height'];

		$zeit = 0;
		$kilo = 0;
		$laenge = 60;
		$breite = 60;
		$dicke = 0;

		if ($w > $h) {
			$laenge += $w;
			$breite += $h;
		} else {
			$laenge += $h;
			$breite += $w;
		}
		$dicke += 35 * qty;

		$a = $laenge * $breite / 1000000;

		$kilo += 25 * $a * $qty;

		if (($kilo > 38) || ($laenge + 2 * $breite + 2 * $dicke > 3000)) {
			if (($laenge > 1200) && ($breite > 800)) {
				$zeit += 40;
			}
			$zeit += $this->rahmenData['konstanten']['kPallete1'] * $qty + $this->rahmenData['konstanten']['kPallete2'];
			$this->rahmenSpedition = true;
		} else {
			$zeit = $this->rahmenData['konstanten']['kPacket1'] * $qty * ($laenge * $breite / 1000000) + $this->rahmenData['konstanten']['kPacket2'];
		}
		$this->rahmenGewicht += $kilo;
		return round($zeit * $this->rahmenData['konstanten']['arbeitsfaktor'], 2);
	}

	public function getSchwabelStapel($daten) {
		$h = 0;
		$A = $daten['b'] * $daten['l'] / 1000000;

		if ($daten['t'] > 10) {
			$h = $daten['t'];
		} else if (($daten['t'] > 5) && ($daten['t'] <= 10)) {
			if ($A <= 0.3) {
				$h = $daten['t'] * 2;
			} else {
				$h = $daten['t'];
			}
		} else if (($daten['t'] > 0) && ($daten['t'] <= 5)) {
			if ($A <= 0.3) {
				$h = $daten['t'] * 4;
			} else {
				$h = $daten['t'];
			}
		}

		$this->debugTypo($h, 'Schwabelstapel');
		return $h;
	}

	public function getZuschnittStapel($daten) {
		$h = 0;
		$A = $daten['b'] * $daten['l'] / 1000000;

		if ($daten['t'] > 10) {
			$h = $daten['t'];
		} else if (($daten['t'] >= 6) && ($daten['t'] <= 10)) {
			if ($A <= 0.3) {
				$h = 30;
			} else {
				$h = $daten['t'];
			}
		} else if (($daten['t'] > 0) && ($daten['t'] < 5)) {
			if ($A <= 0.06) {
				$h = 25;
			} else {
				$h = $daten['t'];
			}
		} else if ($daten['t'] == 5) {
			if ($A <= 0.06) {
				$h = 60;
			} else if ($A <= 0.08) {
				$h = 30;
			} else {
				$h = $daten['t'];
			}
		}
		return $h;
	}

	public function berechneTempern($qty, $temperKilo) {
	
		if (($qty == null) || ($qty == 0)) {
			$qty = 1;
		}
	
		$preis = 0;
		$aufpreisStk = 1;
		$stkOhneAufpreis = 5;
		$tempern = floatval($this->shopRepository->findByAKey('tempern')->getFirst()->getAValue());

		$aufschlag = ($qty > $stkOhneAufpreis ? ($temperKilo / $qty * ($qty - $stkOhneAufpreis) * $aufpreisStk) : 0);

		$preis = $tempern + $aufschlag;
		return round(($preis / $qty), 2);
	}

	public function berechneZuschnitt($daten) {
		$zeit = 0;
		$zeitR = 0;

		$qty = $daten['qty'];
		$rQty = 0;
		$teilen = false;

		foreach ($daten['gleich'] as $uid => $variante) {
			if ($daten['uid'] == $uid) {
				foreach ($variante as $vid => $size) {
					if ($daten['vid'] == $vid) {
						foreach ($size as $mSize => $mQty) {
							if ($daten['t'] == $mSize) {
								if ($mQty > 1) {
									$rQty = $mQty;
									$teilen = true;
								}
							}
						}
					}
				}
			}
		}

		$l = $daten['l'];
		$b = $daten['b'];
		if ($b > $this->konstanten['plattenBreite']) {
			$b = $daten['l'];
			$l = $daten['b'];
		}

		$zeit += $this->konstanten['minZuschnitt'] + ($this->konstanten['plattenBreite'] / $this->konstanten['vZuschnitt1'] * ceil($qty / floor($this->konstanten['plattenBreite'] / ($b + $this->konstanten['segeBlattZuschnitt'])))) + (((($l + $this->konstanten['segeBlattZuschnitt']) / $this->konstanten['vZuschnitt2']) * min(array($qty + 1, floor($this->konstanten['plattenBreite'] / ($b + $this->konstanten['segeBlattZuschnitt'])) + 1))) * ceil(ceil($qty / floor($this->konstanten['plattenBreite'] / ($b + $this->konstanten['segeBlattZuschnitt']))) * $daten['t'] / $this->getZuschnittStapel($daten)));
		if (($qty == 1) && ($teilen)) {
			$zeitR += $this->konstanten['minZuschnitt'] + ($this->konstanten['plattenBreite'] / $this->konstanten['vZuschnitt1'] * ceil($rQty / floor($this->konstanten['plattenBreite'] / ($b + $this->konstanten['segeBlattZuschnitt'])))) + (((($l + $this->konstanten['segeBlattZuschnitt']) / $this->konstanten['vZuschnitt2']) * min(array($rQty + 1, floor($this->konstanten['plattenBreite'] / ($b + $this->konstanten['segeBlattZuschnitt'])) + 1))) * ceil(ceil($rQty / floor($this->konstanten['plattenBreite'] / ($b + $this->konstanten['segeBlattZuschnitt']))) * $daten['t'] / $this->getZuschnittStapel($daten)));

			//$this->debug(round($zeit, 2), 'Tatsächliche Zeit / Position');
			//$this->debug($zeitR, 'Zeit beim Virtuellen rabatieren von ' . $rQty . ' Stück');
			//$this->debug(($zeit - $zeitR / $rQty) * $this->konstanten['arbeitsfaktor'], 'Rabatt beim Zuschnitt in €');
			$this->rabatt += ($zeit - $zeitR / $rQty) * $this->konstanten['arbeitsfaktor'];
		}
		$this->debugTypo(round($zeit, 2), 'Zuschnittszeit');
		return round($zeit, 2);
	}

	public function berechneMacryl($daten) {
		$U = ($daten['l'] + $daten['b']) * 2;

		$zeit = 0;
		$zeitR = 0;

		$qty = $daten['qty'];
		$rQty = 0;
		$teilen = false;

		foreach ($daten['gleich'] as $uid => $variante) {
			if ($daten['uid'] == $uid) {
				foreach ($variante as $vid => $size) {
					if ($daten['vid'] == $vid) {
						foreach ($size as $mSize => $mQty) {
							if ($daten['t'] == $mSize) {
								if ($mQty > 1) {
									$rQty = $mQty;
									$teilen = true;
								}
							}
						}
					}
				}
			}
		}

		$zeit = ($U / $this->konstanten['vMacryl'] + $this->konstanten['tMacryl']) * ceil($daten['t'] * $qty / $this->konstanten['sMacryl']);
		if (($qty == 1) && ($teilen)) {
			$zeitR = ($U / $this->konstanten['vMacryl'] + $this->konstanten['tMacryl']) * ceil($daten['t'] * $rQty / $this->konstanten['sMacryl']);
		}
		if (isset($daten['schrägecken']) && ($daten['schrägecken'] > 0)) {
			$zeit += (40 * $daten['schrägecken'] / $this->konstanten['vMacryl'] + $this->konstanten['tMacryl']) * ceil($daten['t'] * $qty / $this->konstanten['sMacryl']);
			if (($qty == 1) && ($teilen)) {
				$zeitR += (40 * $daten['schrägecken'] / $this->konstanten['vMacryl'] + $this->konstanten['tMacryl']) * ceil($daten['t'] * $rQty / $this->konstanten['sMacryl']);
			}
		}


		if (($qty == 1) && ($teilen)) {
			$this->rabatt += ($zeit - $zeitR / $rQty) * $this->konstanten['arbeitsfaktor'];
		}

		$this->debugTypo(round($zeit, 2), 'Macryl polieren');
		return round($zeit, 2);
	}

	public function berechneSchwabeln($daten) {
		$U = ($daten['l'] + $daten['b']) * 2;

		$zeitR = 0;

		$qty = $daten['qty'];
		$rQty = 0;
		$teilen = false;

		foreach ($daten['gleich'] as $uid => $variante) {
			if ($daten['uid'] == $uid) {
				foreach ($variante as $vid => $size) {
					if ($daten['vid'] == $vid) {
						foreach ($size as $mSize => $mQty) {
							if ($daten['t'] == $mSize) {
								if ($mQty > 1) {
									$rQty = $mQty;
									$teilen = true;
								}
							}
						}
					}
				}
			}
		}

		$zeit = $U / $this->konstanten['vSchwabeln'] * ceil($daten['t'] * $qty / $this->getSchwabelStapel($daten));
		if (($qty == 1) && ($teilen)) {
			$zeitR = $U / $this->konstanten['vSchwabeln'] * ceil($daten['t'] * $rQty / $this->getSchwabelStapel($daten));

			$this->rabatt += ($zeit - $zeitR / $rQty) * $this->konstanten['arbeitsfaktor'];
		}
		$this->debugTypo(round($zeit, 2), 'Schwabeln');
		return round($zeit, 2);
	}

	public function berechneKantenFasen($daten) {
		$U = ($daten['l'] + $daten['b']) * 2;
		$zeitR = 0;

		$qty = $daten['qty'];
		$rQty = 0;
		$teilen = false;

		foreach ($daten['gleich'] as $uid => $variante) {
			if ($daten['uid'] == $uid) {
				foreach ($variante as $vid => $size) {
					if ($daten['vid'] == $vid) {
						foreach ($size as $mSize => $mQty) {
							if ($daten['t'] == $mSize) {
								if ($mQty > 1) {
									$rQty = $mQty;
									$teilen = true;
								}
							}
						}
					}
				}
			}
		}

		$zeit = $this->konstanten['kFassen1'] * $U * $qty + $this->konstanten['kFassen2'];
		if (($qty == 1) && ($teilen)) {
			$zeitR = $this->konstanten['kFassen1'] * $U * $rQty + $this->konstanten['kFassen2'];

			$this->rabatt += ($zeit - $zeitR / $rQty) * $this->konstanten['arbeitsfaktor'];
		}
		//$this->debugTypo(round($zeit * $this->konstanten['arbeitsfaktor'], 2), 'Fasenzeit in € ', true);
		$this->debugTypo(round($zeit, 2), 'Fasenzeit');
		return round($zeit, 2);
	}

	public function berechneFacette($daten) {
		$U = ($daten['l'] + $daten['b']) * 2;
		$zeitR = 0;

		$qty = $daten['qty'];
		$rQty = 0;
		$teilen = false;

		foreach ($daten['gleich'] as $uid => $variante) {
			if ($daten['uid'] == $uid) {
				foreach ($variante as $vid => $size) {
					if ($daten['vid'] == $vid) {
						foreach ($size as $mSize => $mQty) {
							if ($daten['t'] == $mSize) {
								if ($mQty > 1) {
									$rQty = $mQty;
									$teilen = true;
								}
							}
						}
					}
				}
			}
		}

		$zeit = $this->konstanten['tFacette'] + $this->konstanten['kFacette1'] * $U * $qty;

		if (($qty == 1) && ($teilen)) {
			$zeitR = $this->konstanten['tFacette'] + $this->konstanten['kFacette1'] * $U * $rQty;

			$this->rabatt += ($zeit - $zeitR / $rQty) * $this->konstanten['arbeitsfaktor'];
		}

		$this->debugTypo(round($zeit, 2), 'Facettenzeit');
		return round($zeit, 2);
	}

	public function berechneLaser($daten) {
		$zeit = 0;
		$U = ($daten['l'] + $daten['b']) * 2;
		$A = $daten['l'] * $daten['b'] / 1000000;

		$zeitR = 0;
		$refZeit = 0;
		$plattenR = 0;

		$qty = $daten['qty'];
		$rQty = 0;
		$teilen = false;

		foreach ($daten['gleich'] as $uid => $variante) {
			if ($daten['uid'] == $uid) {
				foreach ($variante as $vid => $size) {
					if ($daten['vid'] == $vid) {
						foreach ($size as $mSize => $mQty) {
							if ($daten['t'] == $mSize) {
								if ($mQty > 1) {
									$rQty = $mQty;
									$teilen = true;
								}
							}
						}
					}
				}
			}
		}

		//$this->debugTypo($A, 'Fläche des Laserteils');

		$qtyProPlatte = floor($this->konstanten['aLaser'] / $A);

		//$this->debugTypo($qtyProPlatte, 'QTY / Platte');

		$platten = round($qty / $qtyProPlatte, 4);

		if (($qty == 1) && ($teilen)) {
			$plattenR = round($rQty / $qtyProPlatte, 4);
		}

		//$this->debugTypo($platten, 'Anzahl der Platten');

		$stapelProPlatte = ($qtyProPlatte * $daten['t'] / $this->konstanten['sLaser']);

		//Rüsten
		$zeit += $this->konstanten['rLaser'];

		//Auflegen
		$zeit += 3 + $this->konstanten['tLaser1'] * $platten;

		if (($qty == 1) && ($teilen)) {
			$refZeit += 3 + $this->konstanten['tLaser1'] * $platten;
			$zeitR += 3 + $this->konstanten['tLaser1'] * $plattenR;
		}

		$this->debugTypo($zeit, 'Laser Auflegen in min');

		//Lasern
		foreach ($this->laserzeit as $idx => $val) {
			if ($daten['t'] <= floatval($idx)) {
				$zeit += $U * $qty / $this->laserzeit[$idx];
				if (($qty == 1) && ($teilen)) {
					$refZeit += $U * $qty / $this->laserzeit[$idx];
					$zeitR += $U * $rQty / $this->laserzeit[$idx];
				}
				break;
			}
		}

		$this->debugTypo($zeit, 'Auflegen + Lasern in min');

		//Abraeumen
		$zeit += ($qty * $this->konstanten['tLaser2'] + ($stapelProPlatte * ($platten - 1) + ceil(($qty - ($qtyProPlatte * ($platten - 1))) * $daten['t'] / $this->konstanten['sLaser'])) * $this->konstanten['tLaser3']) / 60;
		if (($qty == 1) && ($teilen)) {
			$refZeit += ($qty * $this->konstanten['tLaser2'] + ($stapelProPlatte * ($platten - 1) + ceil(($qty - ($qtyProPlatte * ($platten - 1))) * $daten['t'] / $this->konstanten['sLaser'])) * $this->konstanten['tLaser3']) / 60;
			$zeitR += ($rQty * $this->konstanten['tLaser2'] + ($stapelProPlatte * ($plattenR - 1) + ceil(($rQty - ($qtyProPlatte * ($plattenR - 1))) * $daten['t'] / $this->konstanten['sLaser'])) * $this->konstanten['tLaser3']) / 60;

			$this->rabatt += ($refZeit - $zeitR / $rQty) * $this->konstanten['arbeitsfaktor'];
		}

		$this->debugTypo(round($zeit, 2), 'Ges. Laserzeit in min');
		return round($zeit, 2);
	}

	public function berechneBohrungen($daten) {
		$zeitb = 0;
		$zeits = 0;
		$zeitbR = 0;
		$zeitsR = 0;

		$qty = $daten['qty'];
		$rQty = 0;
		$teilen = false;

		foreach ($daten['gleich'] as $uid => $variante) {
			if ($daten['uid'] == $uid) {
				foreach ($variante as $vid => $size) {
					if ($daten['vid'] == $vid) {
						foreach ($size as $mSize => $mQty) {
							if ($daten['t'] == $mSize) {
								if ($mQty > 1) {
									$rQty = $mQty;
									$teilen = true;
								}
							}
						}
					}
				}
			}
		}

		if (($daten['bearbeitung'] == 2) || ($daten['bearbeitung'] == 4)) {
			if ($daten['drill'] != 0) {
				$zeitb = $this->konstanten['tBSLaser'] + $daten['drill'] * $this->konstanten['tBohrungen'] * $qty;
				if (($qty == 1) && ($teilen)) {
					$zeitbR = $this->konstanten['tBSLaser'] + $daten['drill'] * $this->konstanten['tBohrungen'] * $rQty;
				}
			}
			if ($daten['senk'] != 0) {
				$zeits = $this->konstanten['tBSLaser'] + $daten['senk'] * ($this->konstanten['tBohrungen'] + $this->konstanten['tSenkungen']) * $qty;
				if (($qty == 1) && ($teilen)) {
					$zeitsR = $this->konstanten['tBSLaser'] + $daten['senk'] * ($this->konstanten['tBohrungen'] + $this->konstanten['tSenkungen']) * $rQty;
				}
			}
		} else {
			if ($daten['drill'] != 0) {
				$zeitb = $this->konstanten['tBSEinstellen'] + $daten['drill'] * ceil($daten['t'] * $qty / $this->konstanten['sBohrungen']) * $this->konstanten['tBohrungen'];
				if (($qty == 1) && ($teilen)) {
					$zeitbR = $this->konstanten['tBSEinstellen'] + $daten['drill'] * ceil($daten['t'] * $rQty / $this->konstanten['sBohrungen']) * $this->konstanten['tBohrungen'];
				}

				$this->debugTypo($this->konstanten['tBSEinstellen'] . ' + ' . $daten['drill'] . ' * ceil( ' . $daten['t'] . ' * ' . $qty . ' / ' . $this->konstanten['sBohrungen'] . ')  * ' . $this->konstanten['tBohrungen'], 'Bohrfunktion');
			}
			if ($daten['senk'] != 0) {
				$zeits = $this->konstanten['tBSEinstellen'] + $daten['senk'] * ceil($daten['t'] * $qty / $this->konstanten['sBohrungen']) * $this->konstanten['tBohrungen'] + $daten['senk'] * $this->konstanten['tSenkungen'] * $qty;
				if (($qty == 1) && ($teilen)) {
					$zeitsR = $this->konstanten['tBSEinstellen'] + $daten['senk'] * ceil($daten['t'] * $rQty / $this->konstanten['sBohrungen']) * $this->konstanten['tBohrungen'] + $daten['senk'] * $this->konstanten['tSenkungen'] * $rQty;
				}
			}
		}

		$this->debugTypo(round(($zeitb + $zeits) / 60, 2), 'Bohrzeit: ');
		$zeit = ($zeitb + $zeits) / 60;

		if (($qty == 1) && ($teilen)) {
			$zeitR = ($zeitbR + $zeitsR) / 60;
			$this->rabatt += ($zeit - $zeitR / $rQty) * $this->konstanten['arbeitsfaktor'];
		}
		return round($zeit, 2);
	}

	public function berechneRundEcken($daten) {
		$zeit = 0;
		$zeitR = 0;

		$qty = $daten['qty'];


		if (($daten['bearbeitung'] == 2) || ($daten['bearbeitung'] == 4)) {
			$zeit = $this->konstanten['tLREcken1'] * $daten['rundecken'] * (1 + ($qty + 1) * $this->konstanten['tLREcken2']);
		}

		$zeit = $zeit / 60;
		$this->debugTypo(round($zeit, 2), 'Rundecken: ');

		return round($zeit, 2);
	}

	public function berechneSchraegEcken($daten) {
		$zeit = 0;
		$zeitR = 0;

		$qty = $daten['qty'];
		$rQty = 0;
		$teilen = false;

		foreach ($daten['gleich'] as $uid => $variante) {
			if ($daten['uid'] == $uid) {
				foreach ($variante as $vid => $size) {
					if ($daten['vid'] == $vid) {
						foreach ($size as $mSize => $mQty) {
							if ($daten['t'] == $mSize) {
								if ($mQty > 1) {
									$rQty = $mQty;
									$teilen = true;
								}
							}
						}
					}
				}
			}
		}

		if (($daten['bearbeitung'] == 2) || ($daten['bearbeitung'] == 4)) {
			$zeit = $this->konstanten['tLSEcken1'] * $daten['schrägecken'] * (1 + ($qty + 1) * $this->konstanten['tLSEcken2']);
		} else if (($daten['bearbeitung'] != 5) && ($daten['bearbeitung'] != 6)) {
			$zeit = $this->konstanten['tZSEcken1'] * $daten['schrägecken'] * (0.5 + ($qty + 1) * $this->konstanten['tZSEcken2']);
			if (($qty == 1) && ($teilen)) {
				$zeitR = $this->konstanten['tZSEcken1'] * $daten['schrägecken'] * (0.5 + ($rQty + 1) * $this->konstanten['tZSEcken2']);
			}
		} else {
			$zeit = ($this->konstanten['tZSEcken1'] * $daten['schrägecken'] * (0.5 + ($qty + 1) * $this->konstanten['tZSEcken2'])) / 60;
			$zeit += (40 * $daten['schrägecken'] / $this->konstanten['vMacryl'] + $this->konstanten['tMacryl']) * ceil($daten['t'] * $qty / $this->konstanten['sMacryl']);
			if (($qty == 1) && ($teilen)) {
				$zeitR = ($this->konstanten['tZSEcken1'] * $daten['schrägecken'] * (0.5 + ($rQty + 1) * $this->konstanten['tZSEcken2'])) / 60;
				$zeitR += (40 * $daten['schrägecken'] / $this->konstanten['vMacryl'] + $this->konstanten['tMacryl']) * ceil($daten['t'] * $rQty / $this->konstanten['sMacryl']);
			}
			return $zeit;
		}

		$zeit = $zeit / 60;

		$this->debugTypo(round($zeit, 2), 'Schrägecken: ');
		if (($qty == 1) && ($teilen)) {
			$zeitR = $zeitR / 60;
			$this->rabatt += ($zeit - $zeitR / $rQty) * $this->konstanten['arbeitsfaktor'];
		}
		return round($zeit, 2);
	}

	public function getEckenQty($ecken) {
		$qty = array('rund' => 0, 'schraeg' => 0);
		if (isset($ecken) && (count($ecken) > 0)) {
			for ($i = 0; $i < count($ecken); $i++) {
				if ($ecken[$i]['radius'] == null) {
					$qty['schraeg'] += ($ecken[$i]['corner'] == 'ALLE' ? 4 : 1);
				} else {
					$qty['rund'] += ($ecken[$i]['corner'] == 'ALLE' ? 4 : 1);
				}
			}
		}
		return $qty;
	}

	public function getBohrQty($bohrungen) {
		$qty = 0;

		if (isset($bohrungen) && (count($bohrungen) > 0)) {
			for ($i = 0; $i < count($bohrungen); $i++) {
				$qty += ($bohrungen[$i]['corner'] == 'ALLE' ? 4 : 1);
			}
		}
		return $qty;
	}

	public function getSenkQty($senkungen) {
		$qty = 0;
		if (isset($senkungen) && (count($senkungen) > 0)) {
			for ($i = 0; $i < count($senkungen); $i++) {
				$qty += ($senkungen[$i]['corner'] == 'ALLE' ? 4 : 1);
			}
		}
		return $qty;
	}

	public function berechnePacken($cartItem) {
		$zeit = 0;
		$kilo = 0;
		$laenge = 0;
		$breite = 0;
		$dicke = 0;
		$qty = 0;

		$this->debugTypo($cartItem, 'Position zum Verpacken');

		$artikel = unserialize($cartItem->getArticle());

		$halterWeight = 0.05;

		if (isset($artikel['material'])) {
			$kilo += 1.2 * $artikel['materialConfig']['width'] * $artikel['materialConfig']['height'] * $artikel['material']['size'] * $cartItem->getQty() / 1000000;
			if (isset($artikel['halter'])) {
				$qtyHalter = $cartItem->getQty() * count($artikel['halter']);
				$kilo += $halterWeight * $qtyHalter;
			}
		}

		if (isset($artikel['material'])) {
			if ($artikel['materialConfig']['width'] > $artikel['materialConfig']['height']) {
				if ($artikel['materialConfig']['width'] > $laenge)
					$laenge = $artikel['materialConfig']['width'];
				if ($artikel['materialConfig']['height'] > $breite)
					$breite = $artikel['materialConfig']['height'];
			} else {
				if ($artikel['materialConfig']['height'] > $laenge)
					$laenge = $artikel['materialConfig']['height'];
				if ($artikel['materialConfig']['width'] > $breite)
					$breite = $artikel['materialConfig']['width'];
			}
			$dicke += $artikel['material']['size'] * $cartItem->getQty();
			$qty += $cartItem->getQty();
		}
		//$ePalette = false;
		
		if ($laenge > $breite) {
			$gurtmass = $laenge + 2 * $breite + 2 * ($dicke + 10);
		} else {
			$gurtmass = $breite + 2 * $laenge + 2 * ($dicke + 10);
		}

		if ($kilo > 40) {
			$zeit += $this->konstanten['kPallete1'] * $kilo;
			$this->euroPalette = true;
			if (($laenge > 1200) || ($breite > 800)) {
				$this->ewPalette = $this->konstanten['arbeitsfaktor'] * 40;
				$this->euroPalette = false;
			}
		} else {
			if ($laenge < 600 && $breite < 600) {
				$zeit = $this->konstanten['kPacket1'] * $qty * ($laenge * $breite / 1000000);
			} else {
				if ($gurtmass > 3000) {
					$zeit += $this->konstanten['kPallete1'] * $kilo;
					$this->euroPalette = true;
					if (($laenge > 1200) || ($breite > 800)) {
						$this->ewPalette = $this->konstanten['arbeitsfaktor'] * 40;
						$this->euroPalette = false;
					}
				} else {
					$zeit = $this->konstanten['kPacket1'] * $qty * ($laenge * $breite / 1000000);
				}
			}
		}
		return round($zeit, 2);
	}

	public function getProductPrice($uid, $vid, $type) {
		$price = 0;
		if ($type == 'halter') {
			foreach ($this->halter as $h) {
				if ($h->getUid() == $uid) {
					foreach ($h->getFixingoption() as $v) {
						if ($v->getUid() == $vid) {
							$price = $v->getPrice();
						}
					}
				}
			}
		}
		return $price;
	}

	public function calculateShipping($cartItems, $user, $zip = null) {

		$shipping = 0;
		$express = 0;
		$weight = 0.6; // 0.6 = Tara
		$gurtmass = 0;
		$aGurtmass = 0;

		$laenge = 0;
		$breite = 0;
		$dicke = 0;

		$masse = array('H' => 0, 'B' => 0, 'L' => 0);
		$aMasse = array('H' => 0, 'B' => 0, 'L' => 0);

		foreach ($cartItems as $cartItem) {
			$artikel = ($zip != null ? unserialize($cartItem->getArticle()) : $cartItem->getArticle());

			$halter = $artikel['halter'];

			if (isset($artikel['material'])) {
				$materialConfig = $artikel['materialConfig'];
				$material = $artikel['material'];
				$weight += (floatval($materialConfig['width']) / 1000) * (floatval($materialConfig['height']) / 1000) * 1.2 * floatval($material['size']) * intval($cartItem->getQty());
				if ($halter != NULL) {
					if (count($halter) > 0) {
						for ($i = 0; $i < count($halter); $i++) {
							foreach ($this->halter as $h) {
								if ($h->getUid() == $halter[$i]['hid']) {
									foreach ($h->getFixingoption() as $v) {
										if ($v->getUid() == $halter[$i]['vid']) {
											if ($v->getWeight() != 0.0) {
												$weight += ($v->getWeight() / 1000) * intval($cartItem->getQty());
											} else {
												$weight += 0.12 * intval($cartItem->getQty());
											}
										}
									}
								}
							}
						}
					}
				}

				if ($artikel['materialConfig']['width'] > $artikel['materialConfig']['height']) {
					if ($artikel['materialConfig']['width'] > $laenge)
						$laenge = $artikel['materialConfig']['width'];
					if ($artikel['materialConfig']['height'] > $breite)
						$breite = $artikel['materialConfig']['height'];
				} else {
					if ($artikel['materialConfig']['height'] > $laenge)
						$laenge = $artikel['materialConfig']['height'];
					if ($artikel['materialConfig']['width'] > $breite)
						$breite = $artikel['materialConfig']['width'];
				}
				$dicke += $artikel['material']['size'] * $cartItem->getQty() + 10;
			} else if ($halter != NULL) {
				foreach ($this->halter as $h) {
					if ($h->getUid() == $halter['uid']) {
						foreach ($h->getFixingoption() as $v) {
							if ($v->getUid() == $halter['vid']) {
								if ($v->getWeight() != 0.0) {
									$weight += ($v->getWeight() / 1000) * intval($cartItem->getQty());
								} else {
									$weight += 0.12 * intval($cartItem->getQty());
								}
							}
						}
					}
				}
			}
		}

		$weight += $this->rahmenGewicht;
		
		if ($laenge > $breite) {
			$aGurtmass = $laenge + 2 * $breite + 2 * $dicke;
		} else {
			$aGurtmass = $breite + 2 * $laenge + 2 * $dicke;
		}

		if ($weight < 38) {
			$aW = 0;

			$this->debugTypo(array('Laenge' => $laenge, 'Breite' => $breite, 'Dicke' => $dicke, 'Gewicht' => $weight, 'Gurtmass' => $aGurtmass), 'Masse', false);

			if (($this->shipping['Paketdienst']['gurtmass']['MAX'] > $aGurtmass) && (!$this->rahmenSpedition)) {
				if (($this->shipping['Paketdienst']['gurtmass']['L'] >= $laenge) && ($this->shipping['Paketdienst']['gurtmass']['B'] >= $breite)) { //&& ($this->shipping['Paketdienst']['gurtmass']['H'] >= $dicke)
					$pPreise = $this->shipping['Paketdienst']['preise'];
					$this->debugTypo($pPreise, 'Versandkosten');
					foreach ($pPreise as $key => $value) {
						if (($weight > $aW) && ($weight <= floatval($key))) {
							$shipping = $value;
							break;
						}
						$aW = floatval($key);
					}
					$express = $shipping + $this->shipping['Paketdienst']['express']['basis'] + ($this->shipping['Paketdienst']['express']['extraKg'] * (ceil($weight) - 1));
				} else {
					$shipping = $shipping + $this->shipping['Paketdienst']['express']['basis'] + ($this->shipping['Paketdienst']['express']['extraKg'] * (ceil($weight) - 1));
					$express = $this->shipping['Paketdienst']['express']['basis'] + ($this->shipping['Paketdienst']['express']['extraKg'] * (ceil($weight) - 1));	
				}
				$this->debugTypo($shipping, 'Kosten');
			} else {
				$plz = null;
				if (isset($zip)) {
					$plz = substr($zip, 0, 2);
				} else {
					$plz = substr($user->getZip(), 0, 2);
				}

				$zone = $this->shipping['Spedition']['zonen'][$plz];
				$matrix = $this->shipping['Spedition']['matrix'];
				$weight = $weight + 40; //Palettengewicht

				if ($this->euroPalette) {
					if ($weight < 150) {
						$weight = 150;
					}
				}

				if (($weight >= $this->shipping['Spedition']['wMin']) && ($weight <= $this->shipping['Spedition']['wMax'])) {
					foreach ($matrix as $bisGewicht => $spedPreis) {
						if ($weight <= $bisGewicht) {
							$shipping = $spedPreis[$zone];
							break;
						}
					}
				}
				$shipping = $shipping / (1 - ($this->shipping['Spedition']['dieselZuschlag'] / 100));
				$express = $shipping + $this->shipping['Spedition']['express'];
			}
		} else {
			$plz = null;
			if (isset($zip)) {
				$plz = substr($zip, 0, 2);
			} else {
				$plz = substr($user->getZip(), 0, 2);
			}

			$zone = $this->shipping['Spedition']['zonen'][$plz];
			$matrix = $this->shipping['Spedition']['matrix'];
			$weight = $weight + 40; //Palettengewicht

			if ($this->euroPalette) {
				if ($weight < 150) {
					$weight = 150;
				}
			}

			if (($weight >= $this->shipping['Spedition']['wMin']) && ($weight <= $this->shipping['Spedition']['wMax'])) {
				foreach ($matrix as $bisGewicht => $spedPreis) {
					if ($weight <= $bisGewicht) {
						$shipping = $spedPreis[$zone];
						break;
					}
				}
			}
			$shipping = $shipping / (1 - ($this->shipping['Spedition']['dieselZuschlag'] / 100));
			$express = $shipping + $this->shipping['Spedition']['express'];
		}

		return array('standard' => round($shipping, 2), 'express' => round($express, 2));
	}

	public function debugTypo($data, $name, $print = false) {
		if (($this->debugMode) || $print) {
			\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data, $name);
		}
	}

	public function debug($data, $name) {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data, $name);
	}

}
