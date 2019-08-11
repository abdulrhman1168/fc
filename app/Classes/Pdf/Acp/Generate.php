<?php
namespace App\Classes\Pdf\Acp;

use \TCPDF;
use App\Classes\Pdf\Acp\Background;

class Generate
{
  public static function generate($html, $isRtl, $filePath)
  {

    $pdf = new Background(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set margins
    $pdf->SetTitle('القرار الاداري');
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(0);
    $pdf->SetFooterMargin(0);

    // remove default footer
    $pdf->setPrintFooter(false);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language dependent data:
    $lg = Array();
    $lg['a_meta_charset'] = 'UTF-8';

    if ($isRtl) {
      $pdf->SetFont('traditionalarabic', '', 16);
    }

    $lg['a_meta_language'] = 'ar';
    $lg['w_page'] = 'page';

    // set some language-dependent strings (optional)
    $pdf->setLanguageArray($lg);

    // add a page


    $pdf->AddPage();
    $pdf->writeHTML($html, true, false, true, false);

    //After Write
    $pdf->setRTL(true);
    // remove default header
    $pdf->setPrintHeader(false);


    // reset pointer to the last page
    $pdf->lastPage();

    if($pdf->getNumPages() > 1) {
      $lastPage = $pdf->getPage();
      $pdf->deletePage($lastPage);
    }


    $pdf->Output('Acp.pdf', 'I');
  }
}
