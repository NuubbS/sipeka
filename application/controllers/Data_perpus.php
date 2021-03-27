<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_perpus extends CI_Controller
{
	public function rak()
	{
		$this->template->load('template','data_perpus/buku');
	}
}