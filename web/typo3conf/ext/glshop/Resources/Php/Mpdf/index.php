<?php
include('mpdf.php');
include('./glvorlagen/ab.php');
include('./glvorlagen/fe.php');
include('./glvorlagen/ls.php');
include('./glvorlagen/lsK.php');
include('./glvorlagen/re.php');
include('./glvorlagen/reK.php');

$mpdf=new mPDF('utf8','A4','','',25,5,20,10,9);// AB FE;
#$mpdf=new mPDF('utf8','A4','','',20,5,20,5,9); // Rechnung Rechnung-Kopie Lieferschein
$mpdf->useOnlyCoreFonts = true;    // false is default
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("Glacryl Hedel GmbH - Rechnung");
$mpdf->SetAuthor("Glacryl Hedel GmbH");
$mpdf->SetDisplayMode('fullpage');

$vorlagen = array(
    'ab' => array('glvorlagen/ab.html', 'glvorlagen/styleAb.css'),
    'fe' => array('glvorlagen/fe.html', 'glvorlagen/styleFe.css'),
    're' => array('glvorlagen/re.html', 'glvorlagen/styleRe.css'),
    'reK' => array('glvorlagen/reK.html', 'glvorlagen/styleReK.css'),
    'ls' => array('glvorlagen/ls.html', 'glvorlagen/styleLs.css'),
    'lsK' => array('glvorlagen/lsK.html', 'glvorlagen/styleLsK.css'),
);

$show = 're';

#$html = file_get_contents($vorlagen[$show][0]);
$html = getRe();
$css = file_get_contents($vorlagen[$show][1]);

$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html,2);


#$mpdf->Output();
$mpdf->Output('../../Bestellungen/Test.pdf', 'F');
exit;
?>
