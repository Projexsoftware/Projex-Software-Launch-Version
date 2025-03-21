<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 require_once APPPATH.'/third_party/vendor/autoload.php';
 
        

class M_pdf {

    public $param;
    public $pdf;

    public function __construct($param = "'c', 'A4-L'")
    {
        $this->param =$param;
        //$this->pdf = new mPDF($this->param);
         $this->pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P']);
    }
}
