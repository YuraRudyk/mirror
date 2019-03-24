<?php

namespace Glacryl\Glshop\ViewHelpers;

Class ImgViewHelper Extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    public function initializeArguments()
    {
        $this->registerArgument('imgName', 'string', '');
        $this->registerArgument('type', 'string', '');
    }

	/**
	 * @return array
	 */
	public function render() {
        $imgName = $this->arguments['imgName'];
        $type = $this->arguments['type'];
		//$controller = $this->controllerContext->getRequest()->getControllerName();
		//$view = $this->controllerContext->getRequest()->getControllerActionName();
		
	
		switch ($type) {
			case 'path':
				return $this->getMiniImgPath();
				break;
			case 'name':
				return $this->getMiniImgName($imgName);
				break;
		}
	}
	
	public function getMiniImgName($imgName){
		$name = explode('.', $imgName);
		
		return $name[0].'mini.jpg';//.$name[1];
	}
	
	public function getMiniImgPath(){
		return 'mini/';
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

	public function debugTypo($data) {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
	}

}

?>
