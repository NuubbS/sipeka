<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PrintPdf extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function laporan_ojt(){

    $data = array(
        "dataku" => array(
            'anjayani'
        )
    );

    $this->load->library('pdf');

    $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->setFileName = "laporan-petanikode.pdf";
    $this->pdf->LoadView('laporan/laporanojt_pdf', $data);


}
}