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

    // pages
	public function profil()
	{
        $data['title'] = "PERPUS KAMPUS | Profil Saya";
        $data['member'] = $this->main_m->view_where('tb_user', ['user_id' => $this->sesi->user_login()->user_id])->row();
        $this->template->load('template_m','member/profile', $data);
	}
    
    public function referensi()
    {
        $data['title'] = "PERPUS KAMPUS | Buku Referensi";
        $this->template->load('template_m','member/bukuReferensi', $data);
    }

    public function laporan_ta()
    {
        $data['title'] = "PERPUS KAMPUS | Buku Laporan Tugas Akhir";
        $this->template->load('template_m','member/laporanTA', $data);
    }

    public function laporan_ojt()
    {
        $data['title'] = "PERPUS KAMPUS | Buku Laporan On The Job Training";
        $this->template->load('template_m','member/laporanOJT', $data);
    }

    public function mata_kuliah()
    {
        $data['title'] = "PERPUS KAMPUS | Buku Mata Kuliah";
        $this->template->load('template_m','member/mataKuliah', $data);
    }

    public function histori()
    {
        $data['title'] = "PERPUS KAMPUS | Riwayat Peminjaman Buku";
        $this->template->load('template_m','member/riwayatPeminjaman', $data);
    }
    // end pages

    // $act .= sprintf('<button onclick="detail(%s)" class="btn btn-icon btn-sm btn-info m-1" data-toggle="tooltip" data-placement="top" title="Detail buku"><i class="fas fa-user-edit"></i></button>', $value['buku_id']);
    // Untuk menampilkan data buku
    
    public function buku_referensi_fetch()
    {
    $this->datatables_builder->search('judul, prodi, rak_nama, tahun');
    $this->datatables_builder->select('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama, tb_buku.tahun, tb_buku.buku_id, tb_buku.jumlah,');
    $this->datatables_builder->from('tb_buku');
    $this->datatables_builder->join('tb_prodi', 'tb_buku.prodi_id = tb_prodi.prodi_id');
    $this->datatables_builder->join('tb_rak', 'tb_buku.rak_id = tb_rak.rak_id');
    $this->datatables_builder->where_in('tb_buku.kategori_id', ['1']);
    $m = $this->datatables_builder->get();
    foreach ($m as $key => $val) {
			if($val['jumlah'] == "0"){
                $dipinjam = sprintf('<span class="badge badge-danger">Dipinjam</span>');
                $m[$key]['buku_id'] = $dipinjam;
            }
            else{
                $tersedia = sprintf('<span class="badge badge-success">Tersedia</span>');
                $m[$key]['buku_id'] =$tersedia;
                }
		}
    $this->datatables_builder->render_no_keys($m);
    }

    public function buku_laporanTA_fetch()
    {
    $this->datatables_builder->search('judul, prodi, rak_nama, tahun');
    $this->datatables_builder->select('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama, tb_buku.tahun, tb_buku.buku_id, tb_buku.jumlah,');
    $this->datatables_builder->from('tb_buku');
    $this->datatables_builder->join('tb_prodi', 'tb_buku.prodi_id = tb_prodi.prodi_id');
    $this->datatables_builder->join('tb_rak', 'tb_buku.rak_id = tb_rak.rak_id');
    $this->datatables_builder->where_in('tb_buku.kategori_id', ['2']);
    $m = $this->datatables_builder->get();
    foreach ($m as $key => $val) {
			if($val['jumlah'] == "0"){
                $dipinjam = sprintf('<span class="badge badge-danger">Dipinjam</span>');
                $m[$key]['buku_id'] = $dipinjam;
            }
            else{
                $tersedia = sprintf('<span class="badge badge-success">Tersedia</span>');
                $m[$key]['buku_id'] =$tersedia;
                }
		}
    $this->datatables_builder->render_no_keys($m);
    }

    public function buku_laporanOJT_fetch()
    {
    $this->datatables_builder->search('judul, prodi, rak_nama, tahun');
    $this->datatables_builder->select('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama, tb_buku.tahun, tb_buku.buku_id, tb_buku.jumlah,');
    $this->datatables_builder->from('tb_buku');
    $this->datatables_builder->join('tb_prodi', 'tb_buku.prodi_id = tb_prodi.prodi_id');
    $this->datatables_builder->join('tb_rak', 'tb_buku.rak_id = tb_rak.rak_id');
    $this->datatables_builder->where_in('tb_buku.kategori_id', ['3']);
    $m = $this->datatables_builder->get();
    foreach ($m as $key => $val) {
			if($val['jumlah'] == "0"){
                $dipinjam = sprintf('<span class="badge badge-danger">Dipinjam</span>');
                $m[$key]['buku_id'] = $dipinjam;
            }
            else{
                $tersedia = sprintf('<span class="badge badge-success">Tersedia</span>');
                $m[$key]['buku_id'] =$tersedia;
                }
		}
    $this->datatables_builder->render_no_keys($m);
    }
    
    public function buku_mataKuliah_fetch()
    {
    $this->datatables_builder->search('judul, prodi, rak_nama, tahun');
    $this->datatables_builder->select('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama, tb_buku.tahun, tb_buku.buku_id, tb_buku.jumlah,');
    $this->datatables_builder->from('tb_buku');
    $this->datatables_builder->join('tb_prodi', 'tb_buku.prodi_id = tb_prodi.prodi_id');
    $this->datatables_builder->join('tb_rak', 'tb_buku.rak_id = tb_rak.rak_id');
    $this->datatables_builder->where_in('tb_buku.kategori_id', ['4']);
    $m = $this->datatables_builder->get();
    foreach ($m as $key => $val) {
			if($val['jumlah'] == "0"){
                $dipinjam = sprintf('<span class="badge badge-danger">Dipinjam</span>');
                $m[$key]['buku_id'] = $dipinjam;
            }
            else{
                $tersedia = sprintf('<span class="badge badge-success">Tersedia</span>');
                $m[$key]['buku_id'] =$tersedia;
                }
		}
    $this->datatables_builder->render_no_keys($m);
    }

    public function riwayatPeminjaman_fetch()
    {
    $this->datatables_builder->search('judul, prodi, rak_nama, date_created, date_created');
    $this->datatables_builder->select('tb_pinjam.kode_transaksi, tb_buku.judul, tb_pinjam.tanggal_pinjam, tb_detailpinjam.tanggal_kembali, tb_detailpinjam.pinjam_id, tb_pinjam.status_id');
    $this->datatables_builder->from('tb_detailpinjam');
    $this->datatables_builder->join('tb_pinjam', 'tb_pinjam.pinjam_id = tb_detailpinjam.pinjam_id');
    $this->datatables_builder->join('tb_buku', 'tb_detailpinjam.buku_id = tb_buku.buku_id');
    $this->datatables_builder->where('tb_pinjam.user_id', $this->sesi->user_login()->user_id);
    $this->datatables_builder->order_by('tb_buku.date_created', 'desc');
    $m = $this->datatables_builder->get();
    foreach ($m as $key => $val) {
			if($val['status_id'] == "3"){
                $dipinjam = sprintf('<span class="badge badge-warning">Dipinjam</span>');
                $m[$key]['pinjam_id'] = $dipinjam;
            }
            else{
                $tersedia = sprintf('<span class="badge badge-success">Dikembalikan</span>');
                $m[$key]['pinjam_id'] =$tersedia;
                }
		}
    $this->datatables_builder->render_no_keys($m);
    }
}