<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_perpus extends CI_Controller
{

    // global function
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['kodeotomatis_m', 'dataperpus_m']);
    }
    
	// rak proses

	// Untuk menampilkan data rak
	function rak_fetch()
	{
        $this->datatables->search('tb_rak.rak_id, tb_rak.rak_kode, tb_rak.rak_nama, tb_rak.rak_keterangan, tb_rak.date_created, tb_rak.date_updated, tb_rak.created_by');
        $this->datatables->select('rak_id, rak_kode, rak_nama, rak_keterangan, date_created, date_updated, created_by');
        $this->datatables->from('tb_rak');
		$this->datatables->order_by('date_created', 'DESC');
        $m = $this->datatables->get();
        $no = 1;
        foreach ($m as $key => $value) {
        $act = '';
        $act .= sprintf('<button onclick="edit(%s)" class="btn btn-icon btn-sm btn-primary m-1" data-toggle="tooltip" data-placement="top" title="Edit Rak"><i class="fas fa-user-edit"></i></button>', $value['rak_id']);
        $act .= sprintf('<button onclick="hapus(%s)" class="btn btn-icon btn-sm btn-danger m-1" data-toggle="tooltip"data-placement="top" title="Hapus Rak"><i class="fas fa-trash-alt"></button>', $value['rak_id']);
        $m[$key]['as'] = $act;
        $m[$key]['rak_id'] = $no;
        $no++;
}
$this->datatables->render_no_keys($m);
}

// menyimpan data rak
function rak_simpan()
{
// b0001 kode awal
// RK01
$table = "tb_rak";
$field = "rak_kode";

// kode terakhir
$lastKode = $this->kodeotomatis_m->getMax($table, $field);
// mengambil 2 karakter terakhir
$noUrut = (int) substr($lastKode, -2, 2);
$noUrut++;

$str = "RK";
$newKode = $str . sprintf('%02s', $noUrut);
// membuat kode otomatis

// user id
$session_id = 'admin';
//table rak
$kode = $newKode;
$nama = $this->input->post('rak_nama');
$keterangan = $this->input->post('rak_keterangan');

$data = [
"rak_kode" => $kode,
"rak_nama" => $nama,
"rak_keterangan" => $keterangan,
"date_created" => date('Y-m-d H:i:s'),
"created_by" => $session_id,
];
$insert_rak_id = $this->dataperpus_m->simpan_rak($data);
if (@$insert_rak_id) {
$message['messages'] = "Berhasil Menambah Data rak....";
$message['status'] = "1";
} else {
$message['messages'] = "Gagal Mengeksekusi Query rak";
$message['status'] = "0";
}
echo json_encode($message);
}

// menampikan data sesuai id
function rak_edit($id)
{
// $this->data['role'] = $this->main_m->view('user_role')->result();
$this->data['rak'] = $this->main_m->view_where('tb_rak', ['rak_id' => $id])->row();

$this->load->view('form_update/rak_update', $this->data);
}

// menampikan data sesuai id
function rak_print()
{
// $this->data['role'] = $this->main_m->view('user_role')->result();
$this->load->library('pdf');

$data['rak'] = $this->main_m->view('tb_rak')->row();
$this->pdf->setPaper('A4', 'potrait');
$this->pdf->setFileName = "laporan-rak.pdf";
$this->pdf->LoadView('laporan/laporan_rak', $data);
// $this->load->view('laporan/laporan_rak', $this->data);
}

// menampilkan detail rak
function rak_detail($id)
{
$this->data['role'] = $this->main_m->view('user_role')->result();
$this->data['user'] = $this->main_m->view_where('user', ['user_id' => $id])->row();

$this->load->view('administrator/user_detail', $this->data);
}

// mengupdate rak
function rak_update()
{
//table rak
// $rak_id = 'admin';
$rak_id = $this->input->post('rak_id');
$nama = $this->input->post('rak_nama');
$keterangan = $this->input->post('rak_keterangan');

$data = [
"rak_id" => $rak_id,
"rak_nama" => $nama,
"rak_keterangan" => $keterangan,
"date_updated" => date('Y-m-d H:i:s'),
];
$update_rak_id = $this->dataperpus_m->update_rak($rak_id, $data);
if (@$update_rak_id) {
$message['messages'] = "Berhasil Update Data user";
$message['status'] = "1";
} else {
$message['messages'] = "Gagal Update Data User";
$message['status'] = "0";
}
echo json_encode($message);
}

function user_profile_update()
{
//table rak
$user_id = $this->input->post('user_id');
$nama = $this->input->post('nama');
$alamat = $this->input->post('alamat');
$no_hp = $this->input->post('no_hp');

$data = [
"nama" => $nama,
"alamat" => $alamat,
"no_hp" => $no_hp,
"date_updated" => date('Y-m-d H:i:s'),
];

$update_user_id = $this->user_m->update_user($user_id, $data);
if (@$update_user_id) {
$message['messages'] = "Berhasil Update Data user";
$message['status'] = "1";
} else {
$message['messages'] = "Gagal Update Data User";
$message['status'] = "0";
}
echo json_encode($message);
}

// menghapus data rak
function rak_hapus()
{
$id = $this->input->post('id');
$del = $this->dataperpus_m->hapus_rak($id);
if (@$del) {
echo json_encode(true);
} else {
echo json_encode(false);
}
}
// rak proses
}