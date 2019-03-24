<?php

namespace Glacryl\Glshop\ViewHelpers;

Class MenueViewHelper Extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    public function initializeArguments()
    {
        $this->registerArgument('page', 'string', '');
        $this->registerArgument('subPage', 'string', '');
        $this->registerArgument('icon', 'string', '');
        $this->registerArgument('action', 'string', '');
    }

	/**
	 * @return string
	 */
	public function render() {
        $page = $this->arguments['page'];
        $subPage = $this->arguments['subPage'];
        $icon = $this->arguments['icon'];
        $action = $this->arguments['action'];

		$controller = $this->renderingContext->getControllerContext()->getRequest()->getControllerName();
		$view = $this->renderingContext->getControllerContext()->getRequest()->getControllerActionName();

		/* $debug = array(
		  'Menue Item' => $page,
		  'Menue Action' => $action,
		  'Subpage' => $subPage,
		  'icon' => $icon,
		  'Current Controller' => $controller,
		  'Current Action' => $view,
		  );

		  $this->debugTypo($debug); */

		if (!isset($icon)) {
			if (!isset($action)) {
				if (($controller == $page) || (isset($subPage) && ($subPage == $controller))) {
					return 'active';
				}
			} else {
				if (($controller == $page) && ($view == $action)) {
					return 'active';
				} else {
					return '';
				}
			}
		} else {
			if (strpos($action, ',') !== FALSE) {
				$actions = explode(',', $action);
				if (in_array($view, $actions)) {
					return '_active';
				}
			} else {
				if (($controller == $page) && ($view == $action)) {
					return '_active';
				} else {
					if ((isset($subPage) && ($page == $controller)) || (isset($subPage) && ($subPage == $controller))) {
						return '_active';
					}
				}
			}
		}
		return '';
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
