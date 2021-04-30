<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['kodeotomatis_m', 'dataperpus_m']);
    }
    
    public function dashboard()
    {
        check_not_login();
        // $this->template->load('nama template','isi content/main content');
        $this->template->load('template','petugas/dashboard');
    }
    
    public function coba()
    {
        $this->template->load('template','petugas/coba');
    }

    // data perpus

    public function buku()
	{
		$this->template->load('template','data_perpus/buku');
    }
    
    public function kategori()
    {
        $this->template->load('template','data_perpus/kategori');
    }
    
    public function lama_peminjaman()
    {
        $this->template->load('template','peraturan/lama_peminjaman');
    }
    
    public function prodi()
    {
        $this->template->load('template','data_perpus/prodi');
    }
    
    public function rak()
    {
        $this->template->load('template','data_perpus/rak');
    }
    
    public function denda()
    {
        $this->template->load('template','data_perpus/denda');
    }

    // data pengguna

    public function petugas()
    {
        $this->template->load('template','data_pengguna/petugas');
    }
    
    public function anggota()
    {
        $this->template->load('template','data_pengguna/anggota');
    }
    
    public function peminjaman()
    {
        $data['buku'] = $this->main_m->view('tb_buku')->result();

        $this->template->load('template','transaksi/peminjaman', $data);
    }

    public function pengembalian()
    {
        $this->template->load('template','transaksi/peminjaman');
    }
    
    // aplikasi
    public function maintenance()
    {
        $this->template->load('template','aplikasi/maintenance');
    }
    
    public function kontak()
    {
        $this->template->load('template','aplikasi/kontak');
    }
    
    // laporan
    public function laporan_ojt()
    {
        $this->template->load('template','laporan/ojt');
    }

    public function pdflaporan_ojt()
    {
        $this->load->view('laporan/laporanojt_pdf');
    }
    

}