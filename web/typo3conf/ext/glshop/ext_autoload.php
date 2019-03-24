<?php

$libraryClassesPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop') . 'Resources/Php/';
return array(
	///'Reader' => $libraryClassesPath . 'ExcelReader/PHPExcel.php',
    'mPDF' => $libraryClassesPath . 'Mpdf/mpdf.php',
	'Vorlagen' => $libraryClassesPath . 'Vorlagen.php',
	'Schild' => $libraryClassesPath . 'Schild.php',
	'Excel' => $libraryClassesPath . 'Excel.php',
	'DXF' => $libraryClassesPath . 'DXF.php'
);

?>