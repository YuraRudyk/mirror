<?php
namespace Glacryl\T3Glacryl\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class ReferrerViewHelper extends AbstractViewHelper
{

    /**
     * @return string
     */
    public function render()
    {
        $referrer = '';
        $url = parse_url(GeneralUtility::getIndpEnv('HTTP_REFERER'));
        if($url['host'] === GeneralUtility::getIndpEnv('TYPO3_HOST_ONLY')){
            $referrer = (string)GeneralUtility::getIndpEnv('HTTP_REFERER');
        }
        return $referrer;
    }

}
