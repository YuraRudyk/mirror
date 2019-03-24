<?php

/* error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);

  define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

  date_default_timezone_set('Europe/Berlin');

  /** Include PHPExcel_IOFactory */
/* require_once dirname(__FILE__) . '/PHPExcel/IOFactory.php'; */

class Excel {

	const ABSCHLUSS = 'abschluss';
	const IMPORT = 'import';
	const EXPORT = 'export';

	public $objReader = null;
	public $phpExcelService = null;
	public $obj = null;
	public $mode = null;
	public $path = array(
		'abschluss' => null,
		'import' => null,
		'export' => null
	);
	public $data = null;
	public $sheetName = null;
	public $fileName = null;
	public $fileType = null;

	public function initialize($mode, $data) {
		$this->data = $data;
		$this->mode = $mode;
		$this->fileName = (isset($data['fileName']) ? $data['fileName'] : time() . '.xls');
		$this->fileType = (isset($data['fileType']) ? $data['fileType'] : 'Excel5');

		$this->iniPaths();

		/**  Create a new Reader of the type defined in $inputFileType  * */
		//$this->objReader = PHPExcel_IOFactory::createReader($this->fileType);

		$this->phpExcelService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstanceService('phpexcel');

		$this->objReader = $this->phpExcelService->getPHPExcel();
	}

	public function iniPaths() {
		$ext_path = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop');

		$this->path['abschluss'] = $ext_path . 'Resources/Private/Downloads/Excel/Abschluss/';
		$this->path['import'] = $ext_path . 'Resources/Private/Downloads/Excel/Import/';
		$this->path['export'] = $ext_path . 'Resources/Private/Downloads/Excel/Export/';
	}

	public function read($sheetName) {
		$this->sheetName = (isset($sheetName) ? $sheetName : 'Tabelle1');

		$excelReader = $this->phpExcelService->getInstanceOf('PHPExcel_Reader_Excel5', $this->objReader);

		/**  Load $file to a PHPExcel Object  * */
		$data = $excelReader->load($this->path[$this->mode] . $this->fileName);

		$sheetData = $data->getActiveSheet()->toArray(null, true, true, true);

		$this->write('Tabelle1');

		return $sheetData;
	}

	public function write($sheetName, $data) {
		$this->sheetName = (isset($sheetName) ? $sheetName : 'Tabelle1');

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Glacryl Online Shop")
				->setLastModifiedBy("Glacryl Online Shop")
				->setTitle("Monatsabschluss")
				->setSubject("")
				->setDescription("")
				->setKeywords("")
				->setCategory("");


		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

		$objPHPExcel->getActiveSheet()->setTitle('Tabelle1');

		$sheet = $objPHPExcel->setActiveSheetIndex(0);


		//$this->debugTypo($data);

		$sheet
				->setCellValue('A1', 'Nr.')
				->setCellValue('B1', 'Umsatz')
				->setCellValue('C1', 'Gegenkonto')
				->setCellValue('D1', 'Belegfeld1')
				->setCellValue('E1', 'Datum')
				->setCellValue('F1', 'Konto')
				->setCellValue('G1', 'Kd. Name');

		$pos = 2;
		$iterator = 0;
		for ($i = 0; $i < count($data); $i++) {
			$sheet
					->setCellValue('A' . ($i + $pos), ++$iterator)
					->setCellValue('B' . ($i + $pos), number_format($data[$i]['brutto'], 2, ',', ''))
					->setCellValue('C' . ($i + $pos), $data[$i]['kdNr'])
					->setCellValue('D' . ($i + $pos), 'I' . $data[$i]['rgNr'])
					->setCellValue('E' . ($i + $pos), $data[$i]['rgDatum'])
					->setCellValue('F' . ($i + $pos), '8401')
					->setCellValue('G' . ($i + $pos), $data[$i]['kdName']);
		}

		$excelWriter = $this->phpExcelService->getInstanceOf('PHPExcel_Writer_Excel5', $objPHPExcel);
		$excelWriter->save($this->path[$this->mode] . $this->fileName);

		return array('fileName' => $this->fileName);
	}

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