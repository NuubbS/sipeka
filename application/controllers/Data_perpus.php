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
$session_id = $this->sesi->user_login()->name;
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
// buku proses
// Untuk menampilkan data buku
function buku_fetch()
{
$this->datatables->search('tb_buku.buku_id, tb_buku.kode_buku, tb_buku.judul, tb_kategori.kategori, tb_buku.tahun,
tb_buku.jumlah, tb_buku.dipinjam');
$this->datatables->select('tb_buku.buku_id, tb_buku.kode_buku, tb_buku.judul, tb_kategori.kategori, tb_buku.tahun,
tb_buku.jumlah, tb_buku.dipinjam');
$this->datatables->from('tb_buku');
$this->datatables->join('tb_kategori', 'tb_buku.kategori_id = tb_kategori.kategori_id');
$this->datatables->order_by('date_created', 'DESC');
$m = $this->datatables->get();
$no = 1;
foreach ($m as $key => $value) {
$act = '';
$act .= sprintf('<button onclick="detail(%s)" class="btn btn-icon btn-sm btn-info m-1" data-toggle="tooltip"
    data-placement="top" title="Detail buku"><i class="fas fa-user-edit"></i></button>', $value['buku_id']);
$act .= sprintf('<button onclick="edit(%s)" class="btn btn-icon btn-sm btn-primary m-1" data-toggle="tooltip"
    data-placement="top" title="Edit buku"><i class="fas fa-user-edit"></i></button>', $value['buku_id']);
$act .= sprintf('<button onclick="hapus(%s)" class="btn btn-icon btn-sm btn-danger m-1" data-toggle="tooltip"
    data-placement="top" title="Hapus buku"><i class="fas fa-trash-alt"></button>', $value['buku_id']);
$m[$key]['as'] = $act;
$m[$key]['buku_id'] = $no;
$no++;
}
$this->datatables->render_no_keys($m);
}

// menyimpan data buku
function buku_simpan()
{
// b0001 kode awal
// RK01
$table = "tb_buku";
$field = "kode_buku";

// kode tebukuhir
$lastKode = $this->kodeotomatis_m->getMax($table, $field);
// mengambil 2 kabukuter tebukuhir
$noUrut = (int) substr($lastKode, -2, 2);
$noUrut++;

$str = "B";
$newKode = $str . sprintf('%02s', $noUrut);
// membuat kode otomatis

// user id
$session_id = 'admin';
//table buku
$kode = $newKode;
$nama = $this->input->post('buku_nama');
$keterangan = $this->input->post('kategori_id');

$data = [
"kode_buku" => $kode,
"nama_buku" => $nama,
"kategori_id" => $keterangan,
"date_created" => date('Y-m-d H:i:s'),
"created_by" => $session_id,
];
$insert_buku_id = $this->dataperpus_m->simpan_buku($data);
if (@$insert_buku_id) {
$message['messages'] = "Berhasil Menambah Data buku....";
$message['status'] = "1";
} else {
$message['messages'] = "Gagal Mengeksekusi Query buku";
$message['status'] = "0";
}
echo json_encode($message);
}

// menampikan data sesuai id
function buku_edit($id)
{
// $this->data['role'] = $this->main_m->view('user_role')->result();
$this->data['buku'] = $this->main_m->view_where('tb_buku', ['buku_id' => $id])->row();

$this->load->view('form_update/buku_update', $this->data);
}

// menampikan data sesuai id
function buku_print()
{
// $this->data['role'] = $this->main_m->view('user_role')->result();
$this->load->library('pdf');

$data['buku'] = $this->main_m->view('tb_buku')->row();
$this->pdf->setPaper('A4', 'potrait');
$this->pdf->setFileName = "laporan-buku.pdf";
$this->pdf->LoadView('laporan/laporan_buku', $data);
// $this->load->view('laporan/laporan_buku', $this->data);
}

// menampilkan detail buku
function buku_detail($id)
{
$this->data['buku'] = $this->main_m->view_where('tb_buku', ['buku_id' => $id])->row();

$this->load->view('form_detail/detail_buku', $this->data);
}

function buku_tampildetail()
{
//table soal
$user_id = $this->input->post('user_id');
$role_id = $this->input->post('role_id');

$data = [
"role_id" => $role_id,
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

// mengupdate buku
function buku_update()
{
//table buku
// $buku_id = 'admin';
$buku_id = $this->input->post('buku_id');
$nama = $this->input->post('nama_buku');
$keterangan = $this->input->post('kategori_id');

$data = [
"buku_id" => $buku_id,
"nama_buku" => $nama,
"kategori_id" => $keterangan,
"date_updated" => date('Y-m-d H:i:s'),
];
$update_buku_id = $this->dataperpus_m->update_buku($buku_id, $data);
if (@$update_buku_id) {
$message['messages'] = "Berhasil Update Data user";
$message['status'] = "1";
} else {
$message['messages'] = "Gagal Update Data User";
$message['status'] = "0";
}
echo json_encode($message);
}

// function user_profile_update()
// {
// //table buku
// $user_id = $this->input->post('user_id');
// $nama = $this->input->post('nama');
// $alamat = $this->input->post('alamat');
// $no_hp = $this->input->post('no_hp');

// $data = [
// "nama" => $nama,
// "alamat" => $alamat,
// "no_hp" => $no_hp,
// "date_updated" => date('Y-m-d H:i:s'),
// ];

// $update_user_id = $this->user_m->update_user($user_id, $data);
// if (@$update_user_id) {
// $message['messages'] = "Berhasil Update Data user";
// $message['status'] = "1";
// } else {
// $message['messages'] = "Gagal Update Data User";
// $message['status'] = "0";
// }
// echo json_encode($message);
// }

// menghapus data buku
function buku_hapus()
{
$id = $this->input->post('id');
$del = $this->dataperpus_m->hapus_buku($id);
if (@$del) {
echo json_encode(true);
} else {
echo json_encode(false);
}
}
// buku proses

// program studi
function prodi_fetch()
{
$this->datatables->search('tb_prodi.prodi_id, tb_prodi.prodi');
$this->datatables->select('tb_prodi.prodi_id, tb_prodi.prodi');
$this->datatables->from('tb_prodi');
$m = $this->datatables->get();
$no = 1;
foreach ($m as $key => $value) {
$act = '';
$act .= sprintf('<button onclick="detail(%s)" class="btn btn-icon btn-sm btn-info m-1" data-toggle="tooltip"
    data-placement="top" title="Detail prodi"><i class="fas fa-user-edit"></i></button>', $value['prodi_id']);
$act .= sprintf('<button onclick="edit(%s)" class="btn btn-icon btn-sm btn-primary m-1" data-toggle="tooltip"
    data-placement="top" title="Edit prodi"><i class="fas fa-user-edit"></i></button>', $value['prodi_id']);
$act .= sprintf('<button onclick="hapus(%s)" class="btn btn-icon btn-sm btn-danger m-1" data-toggle="tooltip"
    data-placement="top" title="Hapus prodi"><i class="fas fa-trash-alt"></button>', $value['prodi_id']);
$m[$key]['as'] = $act;
$m[$key]['prodi_id'] = $no;
$no++;
}
$this->datatables->render_no_keys($m);
}

// menyimpan data prodi
function prodi_simpan()
{
// b0001 kode awal
// RK01
// user id
$session_id = $this->sesi->user_login()->name;
//table rak
$prodi = $this->input->post('prodi');

$data = [
"prodi" => $prodi,
"date_created" => date('Y-m-d H:i:s'),
"created_by" => $session_id,
];
$insert_prodi_id = $this->dataperpus_m->simpan_prodi($data);
if (@$insert_prodi_id) {
$message['messages'] = "Berhasil Menambah Data Prodi....";
$message['status'] = "1";
} else {
$message['messages'] = "Gagal Mengeksekusi Query Prodi";
$message['status'] = "0";
}
echo json_encode($message);
}

// menghapus data prodi
function prodi_hapus()
{
$id = $this->input->post('id');
$del = $this->dataperpus_m->hapus_prodi($id);
if (@$del) {
echo json_encode(true);
} else {
echo json_encode(false);
}
}

function prodi_edit($id)
{
// $this->data['role'] = $this->main_m->view('user_role')->result();
$this->data['prodi'] = $this->main_m->view_where('tb_prodi', ['prodi_id' => $id])->row();

$this->load->view('form_update/prodi_update', $this->data);
}

// mengupdate prodi
function prodi_update()
{
//table prodi

// $prodi = 'admin';
$prodi_id = $this->input->post('prodi_id');
$prodi = $this->input->post('prodi');

$data = [
"prodi_id" => $prodi_id,
"prodi" => $prodi,
"date_updated" => date('Y-m-d H:i:s'),
];
$update_prodi_id = $this->dataperpus_m->update_prodi($prodi_id, $data);
if (@$update_prodi_id) {
$message['messages'] = "Berhasil Update Data Prodi";
$message['status'] = "1";
} else {
$message['messages'] = "Gagal Update Data Prodi";
$message['status'] = "0";
}
echo json_encode($message);
}
// program studi

// kategori
function kategori_fetch()
{
$this->datatables->search('tb_kategori.kategori_id, tb_kategori.kategori');
$this->datatables->select('tb_kategori.kategori_id, tb_kategori.kategori');
$this->datatables->from('tb_kategori');
$m = $this->datatables->get();
$no = 1;
foreach ($m as $key => $value) {
$act = '';
$act .= sprintf('<button onclick="detail(%s)" class="btn btn-icon btn-sm btn-info m-1" data-toggle="tooltip"
    data-placement="top" title="Detail kategori"><i class="fas fa-user-edit"></i></button>', $value['kategori_id']);
$act .= sprintf('<button onclick="edit(%s)" class="btn btn-icon btn-sm btn-primary m-1" data-toggle="tooltip"
    data-placement="top" title="Edit kategori"><i class="fas fa-user-edit"></i></button>', $value['kategori_id']);
$act .= sprintf('<button onclick="hapus(%s)" class="btn btn-icon btn-sm btn-danger m-1" data-toggle="tooltip"
    data-placement="top" title="Hapus kategori"><i class="fas fa-trash-alt"></button>', $value['kategori_id']);
$m[$key]['as'] = $act;
$m[$key]['kategori_id'] = $no;
$no++;
}
$this->datatables->render_no_keys($m);
}
function kategori_simpan()
{
// b0001 kode awal
// RK01
// user id
$session_id = $this->sesi->user_login()->name;
//table kategori
$kategori = $this->input->post('kategori');

$data = [
"kategori" => $kategori,
"date_created" => date('Y-m-d H:i:s'),
"created_by" => $session_id,
];
$insert_kategori_id = $this->dataperpus_m->simpan_kategori($data);
if (@$insert_kategori_id) {
$message['messages'] = "Berhasil Menambah Data Kategori Buku....";
$message['status'] = "1";
} else {
$message['messages'] = "Gagal Mengeksekusi Query Kategori Buku";
$message['status'] = "0";
}
echo json_encode($message);
}

// menghapus data kategori
function kategori_hapus()
{
$id = $this->input->post('id');
$del = $this->dataperpus_m->hapus_kategori($id);
if (@$del) {
echo json_encode(true);
} else {
echo json_encode(false);
}
}

function kategori_edit($id)
{
// $this->data['role'] = $this->main_m->view('user_role')->result();
$this->data['kategori'] = $this->main_m->view_where('tb_kategori', ['kategori_id' => $id])->row();

$this->load->view('form_update/kategori_update', $this->data);
}

// mengupdate kategori
function kategori_update()
{
//table kategori

// $kategori = 'admin';
$kategori_id = $this->input->post('kategori_id');
$kategori = $this->input->post('kategori');

$data = [
"kategori_id" => $kategori_id,
"kategori" => $kategori,
"date_updated" => date('Y-m-d H:i:s'),
];
$update_kategori_id = $this->dataperpus_m->update_kategori($kategori_id, $data);
if (@$update_kategori_id) {
$message['messages'] = "Berhasil Update Data Kategori Buku";
$message['status'] = "1";
} else {
$message['messages'] = "Gagal Update Data Kategori Buku";
$message['status'] = "0";
}
echo json_encode($message);
}
// kategori







}