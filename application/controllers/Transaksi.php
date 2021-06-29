<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        check_admin();
        $this->load->model(['kodeotomatis_m', 'administrator_m', 'transaksi_m']);
    }

    // pages
    public function peminjaman()
    {
        // ===== Kode Otomatis Transaksi ===== //
        $table= "tb_pinjam";
        $field= "kode_transaksi";
        $today= date('ymd');
        $prefix= "TR".$today;
        
        $lastKode = $this->kodeotomatis_m->getMax_Today($prefix, $table, $field);
        // ambil 3 karakter e belakang
        $noUrut = (int) substr($lastKode, -3, 3);
        $noUrut++;

        $newKode= $prefix . sprintf('%03s', $noUrut);
        // var_dump($newKode);
        // die;


        // $pinjam = $this->crud_m->tampil_order('pinjam_id', 'tb_pinjam', 'DESC')->row();
        // if (empty($pinjam)) {
        //     $data['kode_jual'] = 1;
        //     $kode['pinjam_id'] = 1;
        // } else {
        //     $data['kode_jual'] = $pinjam->pinjam_id + 1;
        //     $kode['pinjam_id'] = $pinjam->pinjam_id + 1;
        // }
        $data['newKode']= $prefix . sprintf('%03s', $noUrut);
        // $data['detailPinjam'] = $this->crud_m->tampil_join('tb_buku', 'tb_detailpinjam', 'tb_buku.buku_id=tb_detailpinjam.buku_id', $kode)->result();

        // validasi
        $this->form_validation->set_rules('user_id', 'Peminjam', 'trim|required');
        $this->form_validation->set_rules('buku_id[]', 'Buku', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->template->load('template', 'transaksi/peminjaman', $data);
        }else{
            $kode_transaksi = $this->input->post('kode_transaksi');
            $user_id = $this->input->post('user_id');
            $tanggal_pinjam = $this->input->post('tanggal_pinjam');
            $tanggal_kembali = $this->input->post('tanggal_kembali');
            $created_by = $this->sesi->user_login()->nama;
            $data=[
                'kode_transaksi' => $kode_transaksi,
                'user_id' => $user_id,
                'tanggal_pinjam' => $tanggal_pinjam,
                'jumlah_buku' => 1,
                'created_by' => $created_by,
            ];
            $DataPinjam = $this->transaksi_m->inputPinjam($data, 'tb_pinjam');
            $buku = $this->input->post('buku_id[]');
            $data2 = array();
            foreach ($buku as $key) {
                array_push($data2, array(
                    'pinjam_id' => $DataPinjam,
                    'buku_id' => $key,
                    'tanggal_kembali' => $tanggal_kembali,
                    'status_id' => 3
                ));
            }
            if($this->transaksi_m->inputPinjam($data2, 'tb_detailpinjam') > 0){
                redirect('transaksi/peminjamanBuku');
            }else{
                redirect('transaksi/peminjaman');
            }
        }
        
    }

    public function peminjamanBuku()
    {
        $this->template->load('template','administrator/transaksi/peminjamanBuku');
    }

    public function pengembalianBuku()
    {
        $this->template->load('template','administrator/transaksi/peminjamanBuku');
    }
    // end pages
    
    // daftar transaksi
    public function daftarPinjamBuku_fetch()
    {
        $this->datatables_builder->select('tb_pinjam.kode_transaksi, tb_user.nama, tb_pinjam.tanggal_pinjam, tb_pinjam.created_by, tb_pinjam.pinjam_id');
        $this->datatables_builder->from('tb_pinjam');
        $this->datatables_builder->join('tb_user', 'tb_pinjam.user_id = tb_user.user_id');
        // $this->datatables_builder->join('tb_detailpinjam', 'tb_pinjam.pinjam_id = tb_detailpinjam.pinjam_id');
        $this->datatables_builder->join('tb_status', 'tb_pinjam.status_id = tb_status.status_id');
        $this->datatables_builder->where_in('tb_pinjam.status_id', ['3']);
        $this->datatables_builder->order_by('pinjam_id', 'desc');
        $m = $this->datatables_builder->get();
        foreach ($m as $key => $val) {
                    $btn_kembali = sprintf('<button onclick="pilihPeminjam(%s)" class="btn btn-icon btn-sm btn-warning m-1" data-toggle="tooltip" data-placement="top" title="Pilih"><i class="fas fa-check"></i> Dikembalikan</button>', $val['pinjam_id']);
                    $btn_detail = sprintf('<button onclick="pilihPeminjam(%s)" class="btn btn-icon btn-sm btn-info m-1" data-toggle="tooltip" data-placement="top" title="Pilih"><i class="fas fa-info"></i> Detail Pinjam</button>', $val['pinjam_id']);
                $m[$key]['pinjam_id'] = $btn_kembali.$btn_detail;
                
            }
        
        $this->datatables_builder->render_no_keys($m);
    }
    // end daftar transaksi
    function dataBuku()
    {
    $this->load->view('form_transaksi/cari_buku');
    }
    
    function dataPeminjam()
    {
    $this->data['anggota'] = $this->main_m->view('tb_user')->result();

    $this->load->view('form_transaksi/dataPeminjam');
    }


	// menampikan data sesuai id
    function buku_fetch()
    {
    $this->datatables_builder->select('judul, tahun, jumlah, dipinjam, buku_id');
        $this->datatables_builder->from('tb_buku');
        $this->datatables_builder->order_by('date_created', 'desc');
        $m = $this->datatables_builder->get();
            foreach ($m as $key => $val) {
                if($val['jumlah'] == "0"){
                    $btn_info = sprintf('<a href="#" class="btn disabled btn-icon btn-sm btn-danger m-1 btn-progress"><i class="fas fa-user-times"> Banned</button>');
                    $m[$key]['buku_id'] =$btn_info;
                }
                else{
                    $btn_pilih = sprintf('<button onclick="pilihPeminjam(%s)" class="btn btn-icon btn-sm btn-primary m-1" data-toggle="tooltip" data-placement="top" title="Pilih"><i class="fas fa-user-check"></i> Pilih</button>', $val['buku_id']);
                $m[$key]['buku_id'] = $btn_pilih;
                }
                
            }
        
        $this->datatables_builder->render_no_keys($m);
}

    function pilih_anggota($id){
        $data['aggota'] = $this->main_m->view_where('tb_user', $id)->row();
        $this->template->load('template','transaksi/peminjaman', $data);
    }

    function pilih_buku($id){
        $field['pinjam_id'] = 1001; 
        $field['buku_id'] = $id; 
        $field['tanggal_kembali'] = date('Y-m-d H:i:s'); 
        $field['status_id'] = 1; 
        $this->crud_m->tambah('tb_detailpinjam', $field);
        redirect(base_url().'pages/peminjaman');
    }

	// menampikan data sesuai id
   function dataPeminjam_fetch()
	{
        $this->datatables_builder->select('nama, alamat, no_handphone, user_id, status_id');
        $this->datatables_builder->from('tb_user');
        $this->datatables_builder->order_by('date_created', 'desc');
        $m = $this->datatables_builder->get();
            foreach ($m as $key => $val) {
                if($val['status_id'] == "2"){
                    $btn_info = sprintf('<a href="#" class="btn disabled btn-icon btn-sm btn-danger m-1 btn-progress"><i class="fas fa-user-times"> Banned</button>');
                    $m[$key]['user_id'] =$btn_info;
                }
                else{
                    $btn_pilih = sprintf('<button onclick="pilihPeminjam(%s)" class="btn btn-icon btn-sm btn-primary m-1" data-toggle="tooltip" data-placement="top" title="Pilih"><i class="fas fa-user-check"></i> Pilih</button>', $val['user_id']);
                $m[$key]['user_id'] = $btn_pilih;
                }
                
            }
        
        $this->datatables_builder->render_no_keys($m);

        }



}