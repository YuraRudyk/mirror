<?php

namespace Glacryl\Glshop\ViewHelpers;

Class RahmenViewHelper Extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    public function initializeArguments()
    {
        $this->registerArgument('frontscheiben', 'array', '');
        $this->registerArgument('sicherheit', 'boolean', '');
        $this->registerArgument('montagen', 'array', '');
        $this->registerArgument('edit', 'array', '');
        $this->registerArgument('imgPath', 'string', '');
    }

	/**
	 * @return string
	 */
	public function render() {
        $frontscheiben = $this->arguments['frontscheiben'];
        $sicherheit = $this->arguments['sicherheit'];
        $montagen = $this->arguments['montagen'];
        $edit = $this->arguments['edit'];
        $imgPath = $this->arguments['imgPath'];

		$html = '';

		//$this->debugTypo($frontscheiben, 'Frontscheiben');

		if (isset($frontscheiben)) {
			$html = $this->sicherheitHtml($frontscheiben, $edit);
		} else if (isset($montagen)) {
			$html = $this->montageHtml($montagen, $edit, $imgPath);
		}

		return $html;
	}

	public function sicherheitHtml($frontscheiben, $edit) {

		$editScheibe = (isset($edit['rahmen']['frontscheibe']) ? $edit['rahmen']['frontscheibe']['sicherheit'] : -1);
		$typen = array();
		foreach ($frontscheiben as $k => $f) {
			foreach ($f->getVariante() as $k => $v) {
				if ($v->getSicherheit() == 0) {
					$typen[0] = 'Ohne Sicherheitseigenschaften';
				} else if ($v->getSicherheit() == 1) {
					$typen[1] = 'Mit Sicherheitseigenschaften';
				}
			}
		}


		for ($i = 0; $i < count($typen); $i++) {
			$html .= '<p><input id="sicherheit' . $i . '"';
			if ($editScheibe == $i) {
				$html .= 'checked="checked"';
			}
			$html .= 'class="addFrontSicherheit" type="radio" name="sicherheit" value="' . $i . '"><label for="sicherheit' . $i . '">' . $typen[$i] . '</label></p>';
		}
		return $html;
	}

	public function montageHtml($montagen, $edit, $imgPath) {
		$html = '';
		$montageTypen = array();
		$startBild = array(
			'bild' => '',
			'name' => '',
			'miniName' => '',
			'imgPath' => $imgPath
		);
		foreach ($montagen as $k => $v) {
			
			if($v->getArtNr() == 'WAMONMITABH'){
				$startBild['bild'] = $v->getBild();
				$startBild['name'] = $v->getName();
				$name = explode('.', $v->getBild());
				$startBild['miniName'] = $name[0].'mini.jpg';
			}
			
			$typArr = explode(' ', $v->getName());
			if (!isset($montageTypen[$typArr[0]])) {
				$montageTypen[$typArr[0]] = array();
			}
			if (!in_array($typArr[1] . ' ' . $typArr[2], $montageTypen[$typArr[0]])) {
				array_push($montageTypen[$typArr[0]], array(
					'uid' => $v->getUid(),
					'name' => $typArr[1] . ' ' . $typArr[2],
					'varianten' => $v->getVariante(),
				));
			}
		}

		//$this->debugTypo($startBild);

		foreach ($montageTypen as $typ => $daten) {
			$html .= '<div class="panel panel-default">';
			$html .= '<div class="panel-heading" role="tab" id="title-panel-montage-' . $typ . '">';
			$html .= '<h4 class="panel-title">';
			$html .= '<a data-toggle="collapse" data-parent="#konfigurator-view-befestigung" href="#panel-montage-' . $typ . '" aria-expanded="true" aria-controls="panel-montage-' . $typ . '">' . $typ . '</a>';
			$html .= '</h4>';
			$html .= '<span class="right info-icon montage">i</span>';
			$html .= '</div>';
			$html .= '<div id="panel-montage-' . $typ . '" class="content panel-collapse collapse out" role="tabpanel" aria-labelledby="title-panel-montage-' . $daten['uid'] . '">';
			$html .= '<div class="panel-body">';
			$html .= '<div class="error"></div>';
			$html .= '<div class="row">';
			$html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
			$html .= '<select class="view-montagetyp-auswahl">';
			$html .= '<option value="choose">Bitte w&auml;hlen</option>';
			for ($i = 0; $i < count($daten); $i++) {
				$html .= '<option value="' . $daten[$i]['uid'] . '">' . $daten[$i]['name'] . '</option>';
			}
			$html .= '</select>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="row">';
			$html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 view-montage-varianten-auswahl">';
			/*foreach ($daten[0]['varianten'] as $key => $var) {
				$html .= '<p><input class="addMontageVarianteBtn" id="montageTypVariante_' . $var->getUid() . '" type="radio" name="montagetypvariante" value="' . $var->getUid() . '"><label for="montageTypVariante_' . $var->getUid() . '">' . $var->getName() . '</label></p>';
			}*/
			$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="row">';
			$html .= '<div id="view-montage-img" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
			$html .= '<a href="' . $startBild['imgPath'] . $startBild['bild'] . '" data-lightbox="anschlussImg" data-title="' . $startBild['name'] . '" >';
			$html .= '<img class="img-responsive" src="' . $startBild['imgPath'] . 'mini/' . $startBild['miniName'] . '"/>';
			$html .= '</a>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
		}
		return $html;
	}

	public function debugTypo($data, $name = "RahmenViewHelper") {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data, $name);
	}

}

?>
