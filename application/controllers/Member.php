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

    public function buku_dipinjam_fetch()
    {
    // $this->datatables_builder->search('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama,tb_buku.date_created,  tbdate_created');
    $this->datatables_builder->select('tb_pinjam.kode_transaksi, tb_buku.judul, tb_pinjam.tanggal_pinjam, tb_pinjam.status_id, tb_detailpinjam.tanggal_kembali, tb_detailpinjam.detailpinjam_id');
    $this->datatables_builder->from('tb_detailpinjam');
    $this->datatables_builder->join('tb_buku', 'tb_detailpinjam.kode_buku = tb_buku.kode_buku');
    $this->datatables_builder->join('tb_pinjam', 'tb_detailpinjam.pinjam_id = tb_pinjam.pinjam_id');
    $this->datatables_builder->where_in('tb_pinjam.user_id', [$this->sesi->user_login()->user_id]);
    $this->datatables_builder->order_by('tb_buku.date_created', 'desc');
    $m = $this->datatables_builder->get();
    foreach ($m as $key => $val) {
			$btn_update = sprintf('<button class="btn" onclick="edit(%s)"><i class="fa fa-edit text-warning"></i></button>', $val['detailpinjam_id']);
			$btn_delete = sprintf('<button class="btn" onclick="hapus(%s)"><i class="fa fa-trash text-danger"></i></button>', $val['detailpinjam_id']);
			$m[$key]['detailpinjam_id'] =$btn_update . $btn_delete;
		}
    $this->datatables_builder->render_no_keys($m);
    }
}