<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        check_member();
        $this->load->model(['kodeotomatis_m', 'dataperpus_m']);
    }

	public function index()
	{
        $this->template->load('template_m','member/dashboard');
	}
}