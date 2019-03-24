<?php

namespace Glacryl\Glshop\ViewHelpers;

Class DateViewHelper Extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    public function initializeArguments()
    {
        $this->registerArgument('date', 'object', '');
        $this->registerArgument('format', 'string', '');
    }

	/**
	 * @return string
	 */
	public function render() {
        $date = $this->arguments['date'];
        $format = $this->arguments['format'];

		$html = '';

		$html .= $date->format($format);

		return $html;
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
