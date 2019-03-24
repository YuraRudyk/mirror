<?php

namespace Glacryl\Glshop\ViewHelpers;

Class ProductImageViewHelper Extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    public function initializeArguments()
    {
        $this->registerArgument('img', 'string', '');
        $this->registerArgument('mini', 'bool', '');
    }


	/**
	 * @return string
	 */
	public function render() {
		$mini = $this->arguments['mini'];
		$img = $this->arguments['img'];

		if($mini == 'true'){
			return 'typo3conf/ext/glshop/Resources/Public/Img/Products/mini/' . str_replace('.jpg', 'Mini.jpg', $img);
		} else {
			return 'typo3conf/ext/glshop/Resources/Public/Img/Products/' . $img;
		}
	}

}

?>
