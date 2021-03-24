<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_perpus extends CI_Controller
{
	public function data_perpus()
	{
		$this->data_perpus->load('buku');
	}
}
