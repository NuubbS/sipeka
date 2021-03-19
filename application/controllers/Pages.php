<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends CI_Controller
{
    public function dashboard()
    {
        // $this->template->load('nama template','isi content/main content');
        $this->template->load('template','petugas/dashboard');
    }
    
    public function coba()
    {
        $this->template->load('template','petugas/coba');
    }
}