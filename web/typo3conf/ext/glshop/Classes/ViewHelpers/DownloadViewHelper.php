<?php

namespace Glacryl\Glshop\ViewHelpers;

Class DownloadViewHelper Extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    public function initializeArguments()
    {
        $this->registerArgument('type', 'string', '');
    }

	/**
	 * @return string
	 */
	Public Function render() {
        $type = $this->arguments['type'];
		switch ($type) {
			case 'abschluss':
				return $this->getAbschlussDownloads();
				break;
			default:
				break;
		}
	}

	public function getAbschlussDownloads() {
		/*$html = '';
		$path = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop') . 'Resourcen/Private/Downloads/Excel/Abschluss/';

		$log_directory = $path;

		$results_array = array();

		if (is_dir($log_directory)) {
			if ($handle = opendir($log_directory)) {
				//Notice the parentheses I added:
				while (($file = readdir($handle)) !== FALSE) {
					$results_array[] = $file;
				}
				closedir($handle);
			}
		}

		$this->debugTypo($this->getFiles($path));
//Output findings
		foreach ($results_array as $value) {
			$hmtl .= $value . '<br />';
		}
		return $html;*/
	}

	function getFiles($dir) {

		// array to hold return value
		$retval = array();

		// add trailing slash if missing
		if (substr($dir, -1) != "/")
			$dir .= "/";

		// full server path to directory
		$fulldir = $dir;

		$d = @dir($fulldir) or die("getImages: Failed opening directory $dir for reading");
		while (false !== ($entry = $d->read())) {
			// skip hidden files
			if ($entry[0] == ".")
				continue;
			$retval[] = array(
				'file' => "/$dir$entry",
				'size' => getimagesize("$fulldir$entry")
			);
		}
		$d->close();

		return $retval;
	}

	public function debugTypo($data) {
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
	}

}

?>
