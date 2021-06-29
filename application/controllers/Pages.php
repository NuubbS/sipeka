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
        check_admin();
        $data['buku'] = $this->main_m->view_join_three_unwhere('tb_buku', 'tb_kategori', 'tb_prodi', 'tb_rak', 'kategori_id', 'prodi_id', 'rak_id', 'buku_id', 'desc', 0, 4);
        $data['anggota'] = $this->main_m->view_where_ordering_limit('tb_user', array('tb_user.level_id' => 2) , 'tb_user.date_created', 'desc', 0, 4);
        $this->template->load('template','petugas/dashboard', $data);
    }

    public function dashboard_m()
    {
    $this->template->load('template_m','member/dashboard');
    }
    
    public function coba()
    {
        $this->template->load('template','petugas/coba');
    }

    // data perpus

    public function buku()
	{
        $data['kategori'] = $this->main_m->view('tb_kategori')->result();
        $data['prodi']= $this->main_m->view('tb_prodi')->result();
        $data['rak']= $this->main_m->view('tb_rak')->result();
		$this->template->load('template','data_perpus/buku', $data);
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
        // $data['buku'] = $this->main_m->view('tb_buku')->result();

        $data['anggota'] = $this->main_m->view('tb_user')->result();
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