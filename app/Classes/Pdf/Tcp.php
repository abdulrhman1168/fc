<?php
namespace App\Classes\Pdf;

use \TCPDF;

class Tcp
{
  public static function generate($html, $isRtl, $filePath)
  {
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set some language dependent data:
    $lg = Array();
    $lg['a_meta_charset'] = 'UTF-8';

    if ($isRtl) {
      $lg['a_meta_dir'] = 'rtl';
      $pdf->SetFont('aealarabiya', '', 14);
    }

    $lg['a_meta_language'] = 'fa';
    $lg['w_page'] = 'page';

    // set some language-dependent strings (optional)
    $pdf->setLanguageArray($lg);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    // add a page
    $pdf->AddPage();
    $pdf->writeHTML($html, true, false, true, false);
    // reset pointer to the last page
    $pdf->lastPage();
    $pdf->Output($filePath, 'F');
  }
}
