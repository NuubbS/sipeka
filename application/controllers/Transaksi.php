<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {


    function cari_buku()
    {
    // $this->data['role'] = $this->main_m->view('user_role')->result();
    // $this->data['buku'] = $this->main_m->view('tb_buku')->result();

    $this->load->view('form_transaksi/cari_buku');
    }
    
    function cari_anggota()
    {
    // $this->data['role'] = $this->main_m->view('user_role')->result();
    // $this->data['member'] = $this->main_m->view('tb_member')->result();

    $this->load->view('form_transaksi/cari_anggota');
    }


	// menampikan data sesuai id
    function buku_fetch()
    {
    // $this->datatables->search('tb_buku.buku_id, tb_buku.judul, tb_buku.tahun,
    // tb_buku.jumlah, tb_buku.dipinjam');
    $this->datatables->select('tb_buku.buku_id, tb_buku.judul, tb_buku.tahun,
    tb_buku.jumlah, tb_buku.dipinjam');
    $this->datatables->from('tb_buku');
    $m = $this->datatables->get();
    $no = 1;
    foreach ($m as $key => $value) {
    $act = '';
    $act .= sprintf('<button onclick="detail(%s)" class="btn btn-icon btn-sm btn-info m-1" data-toggle="tooltip"
        data-placement="top" title="pilih buku"><i class="fas fa-book"></i> Pilih Buku</button>', $value['buku_id']);
    $m[$key]['as'] = $act;
    $m[$key]['buku_id'] = $no;
    $no++;
    }
    $this->datatables->render_no_keys($m);
}

    function pilih_buku($id){
        $field['detailpinjam_id'];
        $this->main_m->insert('tb_detailpinjam', '$field');
    }

	// menampikan data sesuai id
    function anggota_fetch()
    {
    $this->datatables->select('user.user_id, user.name, user.address');
    $this->datatables->from('user');
    $m = $this->datatables->get();
    $no = 1;
    foreach ($m as $key => $value) {
    $act = '';
    $act .= sprintf('<button onclick="detail(%s)" class="btn btn-icon btn-sm btn-info m-1" data-toggle="tooltip"
        data-placement="top" title="pilih user"><i class="fas fa-book"></i> Pilih user</button>', $value['user_id']);
    $m[$key]['as'] = $act;
    $m[$key]['user_id'] = $no;
    $no++;
    }
    $this->datatables->render_no_keys($m);
}



}