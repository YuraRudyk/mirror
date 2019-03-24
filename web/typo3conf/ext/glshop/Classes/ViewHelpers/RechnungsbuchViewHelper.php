<?php

namespace Glacryl\Glshop\ViewHelpers;

Class RechnungsbuchViewHelper Extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    public function initializeArguments()
    {
        $this->registerArgument('opt', 'string', '');
        $this->registerArgument('brutto', 'float', '');
        $this->registerArgument('skonto', 'float', '');
    }

	/**
	 * @return string
	 */
	public function render() {
        $opt = $this->arguments['opt'];
        $brutto = $this->arguments['brutto'];
        $skonto = $this->arguments['skonto'];

		$html = '';
		
		switch ($opt){
			case 'skonto' :
				$html .= $this->calculateSkonto($brutto, $skonto) . " &euro;";
				break;
		}
		
		return $html;
	}
	
	public function calculateSkonto($brutto, $skonto){
		return number_format(($brutto * (100-$skonto)/100),2,',', '.');
	}

	/**
	 * @param $data
	 */
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
