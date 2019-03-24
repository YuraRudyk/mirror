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
 * NoticelistController
 */
class NoticelistController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * noticelistRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\NoticelistRepository
	 * @inject
	 */
	protected $noticelistRepository = NULL;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$noticelists = $this->noticelistRepository->findAll();
		$this->view->assign('noticelists', $noticelists);
	}

	/**
	 * function getNoticeDetail
	 * 
	 * @param \Glacryl\Glshop\Domain\Model\Noticelist $noticelist
	 * @param array $data
	 * @return array Noticedetail
	 */
	public function getNoticeDetail($noticelist, $data) {
		$detail = array(
			'qty' => $noticelist->getQty(),
			'price' => $noticelist->getPrice(),
			'pic' => $noticelist->getPic(),
			'position' => $noticelist->getPosition(),
			'article' => $this->formatArticle(unserialize($noticelist->getArticle()), $data),
			'noticeName' => $noticelist->getNoticeName(),
			'create' => $noticelist->getDate()->format('d.m.Y H:i'),
			'expire' => $noticelist->getExpire()->format('d.m.Y H:i'),
			'details' => unserialize($noticelist->getDetails())
		);

		//$this->debugTypo($data, 'Konfiguratordata');

		return $detail;
	}

	public function formatArticle($article, $data) {
		//$this->debugTypo($article, 'Article');
		//$this->debugTypo($data, 'Data');
		if (isset($article['material'])) {
			return array(
				'schild' => array(
					'qty' => $article['materialConfig']['qty'],
					'width' => $article['materialConfig']['width'],
					'height' => $article['materialConfig']['height'],
					'material' => $this->getMaterialDetail($article['material']['uid'], $article['material']['vid'], $data['material']),
					'size' => $article['material']['size'],
					'edit' => array(
						'border' => $this->getKantenDetail($article['bearbeitungen']['kanten'], $data['kanten']),
						'corner' => $this->getEckenDetail($article['bearbeitungen']['ecken'], $data['ecken']),
						'drill' => $this->getBohrungDetail($article['bearbeitungen']['bohrungen'], $data['bohrungen']),
						'senkDrill' => $this->getSenkungDetail($article['bearbeitungen']['senkungen'], $data['bohrungen']),
						'tempern' => $article['bearbeitungen']['tempern']['tempern']
					),
					'fixing' => $this->getHalterDetail($article['halter'], $data['halter'])
				)
			);
		} else if (isset($article['profil'])) {
			return array(
				'rahmen' => array(
					'qty' => $article['rahmenConfig']['qty'],
					'width' => $article['rahmenConfig']['width'],
					'height' => $article['rahmenConfig']['height'],
					'profil' => $this->getRahmenDetail($article['profil']['uid'], $article['profil']['vid'], $data['produktart']['profile']),
					'frontscheibe' => $this->getRahmenDetail($article['frontscheibe']['uid'], $article['frontscheibe']['vid'], $data['produktart']['frontscheiben']),
					'led' => $this->getRahmenDetail($article['led']['uid'], $article['led']['vid'], $data['produktart']['leds']),
					'kanten' => $article['kanten'],
					'streuplatte' => $this->getRahmenDetail($article['streuplatte']['uid'], $article['streuplatte']['vid'], $data['produktart']['streuplatten']),
					'anschluss' => $this->getRahmenDetail($article['netzanschluss']['uid'], $article['netzanschluss']['vid'], $data['produktart']['anschluss']),
					'befestigung' => $this->getRahmenDetail($article['befestigung']['uid'], $article['befestigung']['vid'], $data['produktart']['montage'])
				)
			);
		} else {
			return array(
				'product' => array(
					'fixing' => $this->getHalterProductDetail($article['halter'], $data['halter'])
				)
			);
		}
	}

	public function getRahmenDetail($uid, $vid, $data) {
		$uid = intval($uid);
		$vid = intval($vid);
		$res = array(
			'name' => null,
			'beschreibung' => null,
			'variantenName' => null,
			'variantenBeschreibung' => null,
			'variantenSicherheit' => null,
		);
		for ($i = 0; $i < count($data); $i++) {
			if ($data[$i]['uid'] == $uid) {
				$res['name'] = $data[$i]['name'];
				$res['beschreibung'] = $data[$i]['beschreibung'];
				for ($j = 0; $j < count($data[$i]['variante']); $j++) {
					if ($data[$i]['variante'][$j]['uid'] == $vid) {
						$res['variantenName'] = $data[$i]['variante'][$j]['name'];
						$res['variantenBeschreibung'] = $data[$i]['variante'][$j]['beschreibung'];
						$res['variantenSicherheit'] = $data[$i]['variante'][$j]['sicherheit'];
					}
				}
			}
		}
		return $res;
	}

	public function getMaterialDetail($uid, $vid, $material) {
		foreach ($material as $m) {
			if ($m['uid'] == $uid) {
				foreach ($m['varianten'] as $v) {
					if ($v['uid'] == $vid) {
						return array(
							'name' => $m['name'],
							'variante' => $v['name']
						);
					}
				}
			}
		}
	}

	public function getHalterProductDetail($fixing, $halter) {
		foreach ($halter as $h) {
			if ($h['uid'] == $fixing['uid']) {
				foreach ($h['varianten'] as $v) {
					if ($v['uid'] == $fixing['vid']) {
						//$this->debugTypo($h, 'Halter');
						return array(
							'name' => $h['name'],
							'vName' => $v['name'],
							'artnr' => $v['artnr'],
							'material' => $v['material'],
							'bild' => $v['bild'],
							'wa' => $v['wandabstand'],
							'passing' => array('von' => $v['materialVon'], 'bis' => $v['materialBis'], 'sandwitch' => $v['sandwitch']),
							'size' => array(
								'form' => ($v['halterkantenlaenge'] == 0 ? 'round' : 'normal'),
								'size' => ($v['halterkantenlaenge'] == 0 ? $v['durchmesser'] : $v['halterkantenlaenge'])
							),
						);
					}
				}
			}
		}
	}

	public function getHalterDetail($fixing, $halter) {
		$data = array();
		foreach ($fixing as $f) {
			foreach ($halter as $h) {
				if ($h['uid'] == $f['hid']) {
					foreach ($h['varianten'] as $v) {
						if ($v['uid'] == $f['vid']) {
							array_push($data, array(
								'name' => $h['name'],
								'vName' => $v['name'],
								'corner' => $f['corner'],
								'qty' => $f['qty'],
								'x' => $f['x'],
								'y' => $f['y'],
								'artnr' => $v['artnr'],
								'material' => $v['material'],
								'bild' => $v['bild'],
							));
						}
					}
				}
			}
		}
		return $data;
	}

	public function getKantenDetail($edit, $kanten) {
		foreach ($kanten as $k) {
			if ($k['uid'] == $edit['uid']) {
				return array(
					'name' => $k['name'],
					'facette' => $edit['facette'],
					'angle' => $edit['angle']
				);
			}
		}
	}

	public function getEckenDetail($edit, $ecken) {
		$data = array();
		foreach ($edit as $c) {
			foreach ($ecken as $e) {
				if ($e['uid'] == $c['uid']) {
					array_push($data, array(
						'name' => $e['name'],
						'corner' => $c['corner'],
						'radius' => $c['radius'],
						'x' => $c['x'],
						'y' => $c['y']
					));
				}
			}
		}
		return $data;
	}

	public function getBohrungDetail($edit, $bohrungen) {
		$data = array();
		foreach ($edit as $d) {
			foreach ($bohrungen as $b) {
				if ($b['uid'] == $d['uid']) {
					array_push($data, array(
						'name' => $b['name'],
						'corner' => $d['corner'],
						'dB' => $d['dB'],
						'x' => $d['x'],
						'y' => $d['y']
					));
				}
			}
		}
		return $data;
	}

	public function getSenkungDetail($edit, $bohrungen) {
		$data = array();
		foreach ($edit as $d) {
			foreach ($bohrungen as $b) {
				if ($b['uid'] == $d['uid']) {
					array_push($data, array(
						'name' => $b['name'],
						'corner' => $d['corner'],
						'dB' => $d['dB'],
						'dS' => $d['dS'],
						'x' => $d['x'],
						'y' => $d['y']
					));
				}
			}
		}
		return $data;
	}

	/**
	 * action show
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Noticelist $noticelist
	 * @return void
	 */
	public function showAction(\Glacryl\Glshop\Domain\Model\Noticelist $noticelist) {
		$this->view->assign('noticelist', $noticelist);
	}

	/**
	 * action new
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Noticelist $newNoticelist
	 * @ignorevalidation $newNoticelist
	 * @return void
	 */
	public function newAction(\Glacryl\Glshop\Domain\Model\Noticelist $newNoticelist = NULL) {
		$this->view->assign('newNoticelist', $newNoticelist);
	}

	/**
	 * action create
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Noticelist $newNoticelist
	 * @return void
	 */
	public function createAction(\Glacryl\Glshop\Domain\Model\Noticelist $newNoticelist) {
		$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->noticelistRepository->add($newNoticelist);
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \Glacryl\Glshop\Domain\Model\Noticelist $noticelist
	 * @return void
	 */
	public function deleteAction(\Glacryl\Glshop\Domain\Model\Noticelist $noticelist) {
		$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->noticelistRepository->remove($noticelist);
		$this->redirect('list');
	}

	public function debugTypo($data, $name) {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data, $name);
	}

}
