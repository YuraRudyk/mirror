<?php

namespace Glacryl\Glshop\ViewHelpers;

Class KundenzuschnittViewHelper Extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    public function initializeArguments()
    {
        $this->registerArgument('w', 'float', '');
        $this->registerArgument('h', 'float', '');
        $this->registerArgument('artNr', 'string', '');
    }

	/**
	 * @return string
	 */
	Public Function render() {
        $w = $this->arguments['w'];
        $h = $this->arguments['h'];
        $artNr = $this->arguments['artNr'];

		$w = floatval($w);
		$h = floatval($h);

		$bG = 0;
		$hG = 0;
		$bK = 0;
		$hK = 0;

		$text = '';

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
			$text .= '<span>W&auml;rmeausdehnungskoeffizient bei Kunstglas berücksichtigt. </span><br/>';
		} else if (($artNr == 'EGL4') || ($artNr == 'EGL5')) {
			$text .= '<span><b>Echtglas (B/H): </b>' . $bG . ' x ' . $hG . ' mm </span><br/>';
		} else if (($artNr == 'KGL4') || ($artNr == 'KGL5')) {
			$text .= '<span><b>Kunstglas (B/H): </b>' . number_format($bK, 2, ',', '') . ' x ' . number_format($hK, 2, ',', '') . ' mm </span><br/>';
			$text .= '<span>W&auml;rmeausdehnungskoeffizient bei Kunstglas berücksichtigt. </span><br/>';
		}

		return $text;
	}

	public function debugTypo($data) {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
	}

}

?>
