<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(FCPATH . 'vendor/autoload.php');

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf_gen
{
    public function generate($view, $data = array(), $filename = 'Laporan', $paper = 'A4', $orientation = 'portrait')
    {
        $CI =& get_instance();

        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);

        $dompdf = new Dompdf($options);

        $html = $CI->load->view($view, $data, TRUE);

        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();

        $dompdf->stream($filename . ".pdf", array("Attachment" => 0));
    }
}