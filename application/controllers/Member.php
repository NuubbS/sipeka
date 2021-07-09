<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        check_member();
        $this->load->model(['kodeotomatis_m', 'dataperpus_m', 'administrator_m']);
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
                $tersedia = sprintf('<span class="badge badge-success">Tersedia '.$val['jumlah'] .'</span>');
$m[$key]['buku_id'] =$tersedia;
}
}
$this->datatables_builder->render_no_keys($m);
}

public function buku_laporanTA_fetch()
{
$this->datatables_builder->search('judul, prodi, rak_nama, tahun');
$this->datatables_builder->select('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama, tb_buku.tahun, tb_buku.buku_id,
tb_buku.jumlah,');
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
$tersedia = sprintf('<span class="badge badge-success">Tersedia '.$val['jumlah'] .'</span>');
$m[$key]['buku_id'] =$tersedia;
}
}
$this->datatables_builder->render_no_keys($m);
}

public function buku_laporanOJT_fetch()
{
$this->datatables_builder->search('judul, prodi, rak_nama, tahun');
$this->datatables_builder->select('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama, tb_buku.tahun, tb_buku.buku_id,
tb_buku.jumlah,');
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
$tersedia = sprintf('<span class="badge badge-success">Tersedia '.$val['jumlah'] .'</span>');
$m[$key]['buku_id'] =$tersedia;
}
}
$this->datatables_builder->render_no_keys($m);
}

public function buku_mataKuliah_fetch()
{
$this->datatables_builder->search('judul, prodi, rak_nama, tahun');
$this->datatables_builder->select('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama, tb_buku.tahun, tb_buku.buku_id,
tb_buku.jumlah,');
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
$tersedia = sprintf('<span class="badge badge-success">Tersedia '.$val['jumlah'] .'</span>');
$m[$key]['buku_id'] =$tersedia;
}
}
$this->datatables_builder->render_no_keys($m);
}

public function riwayatPeminjaman_fetch()
{
$this->datatables_builder->search('judul, prodi, rak_nama');
$this->datatables_builder->select('tb_pinjam.kode_transaksi, tb_buku.judul, tb_pinjam.tanggal_pinjam,
tb_detailpinjam.tanggal_kembali, tb_detailpinjam.pinjam_id, tb_pinjam.status_id');
$this->datatables_builder->from('tb_detailpinjam');
$this->datatables_builder->join('tb_pinjam', 'tb_pinjam.pinjam_id = tb_detailpinjam.pinjam_id');
$this->datatables_builder->join('tb_buku', 'tb_detailpinjam.buku_id = tb_buku.buku_id');
$this->datatables_builder->where_in('tb_pinjam.user_id', $this->sesi->user_login()->user_id);
$this->datatables_builder->order_by('detailpinjam_id', 'desc');
$m = $this->datatables_builder->get();
foreach ($m as $key => $val) {
if($val['status_id'] == "4"){
$dipinjam = sprintf('<span class="badge badge-success">Dikembalikan</span>');
$m[$key]['pinjam_id'] = $dipinjam;
}
else if($val['tanggal_kembali'] >= date('Y-m-d')){
$tersedia = sprintf('<span class="badge badge-warning">Dipinjam</span>');
$m[$key]['pinjam_id'] =$tersedia;
}
else{
$tersedia = sprintf('<span class="badge badge-danger">Didenda</span>');
$m[$key]['pinjam_id'] =$tersedia;
}
}
$this->datatables_builder->render_no_keys($m);
}

function update_profil()
    {
        $user_id = $this->input->post('user_id');
        $no_handphone = $this->input->post('no_handphone');
        $alamat = $this->input->post('alamat');

        $data = [
            "user_id" => $user_id,
            "no_handphone" => $no_handphone,
            "alamat" => $alamat,
            "date_updated" => date('Y-m-d H:i:s'),
        ];

        // var_dump($data);
        // die;
        $update_user_id = $this->administrator_m->update_anggota($user_id, $data);
        if (@$update_user_id) {
            $message['messages'] = "Berhasil Update Data Anggota";
            $message['status'] = "1";
        } else {
            $message['messages'] = "Gagal Update Data Anggota";
            $message['status'] = "0";
        }
        echo json_encode($message);
    }
}