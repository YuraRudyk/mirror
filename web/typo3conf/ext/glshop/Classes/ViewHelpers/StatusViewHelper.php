<?php

namespace Glacryl\Glshop\ViewHelpers;

Class StatusViewHelper Extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    public function initializeArguments()
    {
        $this->registerArgument('statusse', 'object', '');
    }

	/**
	 * @return string
	 */
	public function render() {
        $statusse = $this->arguments['statusse'];

		$html = '';
		$lastStatus = null;

		//$this->debugTypo($statusse);

		foreach ($statusse as $status) {
			if($status->getOrderstate()->getValue() == 0) {
				$lastStatus = $status->getOrderstate();
				break;
			} else {
				if (($lastStatus != null)) {
					if ($status->getOrderstate()->getValue() > $lastStatus->getValue()) {
						$lastStatus = $status->getOrderstate();
					}
				} else {
					$lastStatus = $status->getOrderstate();
				}
			}
		}


		//$this->debugTypo($lastStatus);

		if ($lastStatus->getValue() != 0) {
			$html .= '<span style="color:green;">' . $lastStatus->getName() . '</span>';
		} else {
			$html .= '<span style="color:red;">' . $lastStatus->getName() . '</span>';
		}
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
