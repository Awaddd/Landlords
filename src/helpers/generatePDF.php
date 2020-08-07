<?php
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin');
$pdf->SetTitle($data['member']->first_name . " " . $data['member']->last_name);
$pdf->SetSubject('Member Details');
$pdf->SetKeywords('Member, Details');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', 'BI', 20);

// add a page
$pdf->AddPage();

// set some text to print
// $txt = <<<EOD
// TCPDF Example 002

// Default page header and footer are disabled using setPrintHeader() and setPrintFooter() methods.
// EOD;

$txt = <<<EOD
Member Details
--------------
Full name: {$data['member']->first_name} {$data['member']->last_name}
Membership expiration date: {$data['member']->expiry_date}
EOD;

// print a block of text using Write()
$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

// ---------------------------------------------------------
$filename = $data['member']->id .'_' .$data['member']->first_name .'_' .$data['member']->last_name .'.pdf';

//Close and output PDF document
$pdf->Output($filename, 'I');