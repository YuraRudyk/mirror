<?php
	header('Set-Cookie: fileDownload=true; path=/');
	header('Cache-Control: max-age=60, must-revalidate');
	header("Content-type: application/pdf");
	header('Content-Disposition: attachment; filename="Test.pdf"');
	readfile('Test.pdf')
?>
