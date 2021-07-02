<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        check_admin();
        $this->load->model(['kodeotomatis_m', 'administrator_m']);
    }
    // =========GET DATA AJAX SELECT2============= //
    public function getDataBuku_Select()
    {
		$search = $this->input->post('search');
		// var_dump($search);
		// die;
		$results = $this->administrator_m->getDataBuku_Select($search);
		foreach ($results as $row ) {
			$select2ajax[] = array(
				'id' => $row['buku_id'],
				'text' => $row['judul']. " (". $row['tahun'].") "
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($select2ajax));
		}
    }
    
    public function getDataPeminjam_Select()
    {
		$search = $this->input->post('search');
		// var_dump($search);
		// die;
		$results = $this->administrator_m->getDataPeminjam_Select($search);
		foreach ($results as $row ) {
			$select2ajax[] = array(
				'id' => $row['user_id'],
				'text' => $row['nama']. " (". $row['alamat'].") ". " (". $row['status'].") "
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($select2ajax));
		}
    }
    // =========END GET DATA AJAX SELECT2============= //

	public function index()
	{
		check_admin();
        $data['kategori'] = $this->main_m->view('tb_kategori');
        $data['buku'] = $this->main_m->view_join_three_unwhere('tb_buku', 'tb_kategori', 'tb_prodi', 'tb_rak', 'kategori_id', 'prodi_id', 'rak_id', 'buku_id', 'desc', 0, 4);
        $data['anggota'] = $this->main_m->view_where_ordering_limit('tb_user', array('tb_user.level_id' => 2) , 'tb_user.date_created', 'desc', 0, 4);
        $this->template->load('template','administrator/data/dashboard', $data);
	}

    
    
    public function kategori()
    {
        $this->template->load('template','administrator/data/kategori');
    }
    
    public function referensi()
    {
        $data['prodi']= $this->main_m->view('tb_prodi')->result();
        $data['rak']= $this->main_m->view('tb_rak')->result();
        $this->template->load('template','administrator/data/buku_referensi', $data);
    }

    public function buku_referensi_fetch()
    {
    // $this->datatables_builder->search('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama,tb_buku.date_created,  tbdate_created');
    $this->datatables_builder->select('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama, tb_buku.jumlah, tb_buku.tahun, tb_buku.date_created,  tb_buku.buku_id');
    $this->datatables_builder->from('tb_buku');
    $this->datatables_builder->join('tb_prodi', 'tb_buku.prodi_id = tb_prodi.prodi_id');
    $this->datatables_builder->join('tb_rak', 'tb_buku.rak_id = tb_rak.rak_id');
    $this->datatables_builder->where_in('tb_buku.kategori_id', ['1']);
    $this->datatables_builder->order_by('tb_buku.date_created', 'desc');
    $m = $this->datatables_builder->get();
    foreach ($m as $key => $val) {
			$btn_update = sprintf('<button class="btn" onclick="edit(%s)"><i class="fa fa-edit text-warning"></i></button>', $val['buku_id']);
			$btn_delete = sprintf('<button class="btn" onclick="hapus(%s)"><i class="fa fa-trash text-danger"></i></button>', $val['buku_id']);
			$m[$key]['buku_id'] =$btn_update . $btn_delete;
		}
    $this->datatables_builder->render_no_keys($m);
    }

    // menyimpan data buku
    function buku_referensi_simpan()
    {
    $table = "tb_buku";
    $field = "kode_buku";

    // kode terakhir
    $lastKode = $this->kodeotomatis_m->getMax($table, $field);
    // mengambil 4 kabukuter tebukuhir
    $noUrut = (int) substr($lastKode, -4, 4);
    $noUrut++;

    $str = "B";
    $newKode = $str . sprintf('%04s', $noUrut);
    // membuat kode otomatis
    // user id
    $session_id = $this->sesi->user_login()->nama;
    //table buku
    $kode = $newKode;
    $judul = $this->input->post('judul');
    $kategori_id = 1; // kode kategori referensi
    $prodi_id = $this->input->post('prodi_id');
    $rak_id = $this->input->post('rak_id');
    $tahun = $this->input->post('tahun');
    $jumlah = $this->input->post('jumlah');

    $data = [
    "kode_buku" => $kode,
    "judul" => $judul,
    "kategori_id" => $kategori_id,
    "prodi_id" => $prodi_id,
    "rak_id" => $rak_id,
    "tahun" => $tahun,
    "jumlah" => $jumlah,
    "dipinjam" => 0,
    "date_created" => date('Y-m-d H:i:s'),
    "created_by" => $session_id,
    ];
    $insert_buku_id = $this->administrator_m->simpan_buku($data);
    if (@$insert_buku_id) {
    $message['messages'] = "Berhasil Menambah Data buku....";
    $message['status'] = "1";
    } else {
    $message['messages'] = "Gagal Mengeksekusi Query buku";
    $message['status'] = "0";
    }
    echo json_encode($message);
    }

    // mengupdate buku
    function buku_referensi_update()
    {
    //table buku
    // $buku_id = 'admin';
    $buku_id = $this->input->post('buku_id');
    $judul = $this->input->post('judul');
    $kategori = $this->input->post('kategori_id');
    $prodi_id = $this->input->post('prodi_id');
    $rak_id = $this->input->post('rak_id');
    $tahun = $this->input->post('tahun');
    $jumlah = $this->input->post('jumlah');

    $data = [
    "buku_id" => $buku_id,
    "judul" => $judul,
    "kategori_id" => $kategori,
    "prodi_id" => $prodi_id,
    "rak_id" => $rak_id,
    "tahun" => $tahun,
    "jumlah" => $jumlah,
    "date_updated" => date('Y-m-d H:i:s'),
    ];
    $update_buku_id = $this->administrator_m->update_buku($buku_id, $data);
    if (@$update_buku_id) {
    $message['messages'] = "Berhasil Update Data";
    $message['status'] = "1";
    } else {
    $message['messages'] = "Gagal Update Data";
    $message['status'] = "0";
    }
    echo json_encode($message);
    }

    // public function proposal_ta()
    // {
    //     $data['prodi']= $this->main_m->view('tb_prodi')->result();
    //     $data['rak']= $this->main_m->view('tb_rak')->result();
    //     $this->template->load('template','administrator/data/buku_proposal_ta', $data);
    // }
    
    public function laporan_ojt()
    {
        $data['prodi']= $this->main_m->view('tb_prodi')->result();
        $data['rak']= $this->main_m->view('tb_rak')->result();
        $this->template->load('template','administrator/data/buku_laporan_ojt', $data);
    }

    public function buku_laporan_ojt_fetch()
    {
    $this->datatables_builder->select('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama, tb_buku.jumlah, tb_buku.tahun, tb_buku.date_created,  tb_buku.buku_id');
    $this->datatables_builder->from('tb_buku');
    $this->datatables_builder->join('tb_prodi', 'tb_buku.prodi_id = tb_prodi.prodi_id');
    $this->datatables_builder->join('tb_rak', 'tb_buku.rak_id = tb_rak.rak_id');
    $this->datatables_builder->where_in('tb_buku.kategori_id', ['3']);
    $this->datatables_builder->order_by('tb_buku.date_created', 'desc');
    $m = $this->datatables_builder->get();
    foreach ($m as $key => $val) {
			$btn_update = sprintf('<button class="btn" onclick="edit(%s)"><i class="fa fa-edit text-warning"></i></button>', $val['buku_id']);
			$btn_delete = sprintf('<button class="btn" onclick="hapus(%s)"><i class="fa fa-trash text-danger"></i></button>', $val['buku_id']);
			$m[$key]['buku_id'] =$btn_update . $btn_delete;
		}
    $this->datatables_builder->render_no_keys($m);
    }

    // menyimpan data buku
    function buku_laporan_ojt_simpan()
    {
    $table = "tb_buku";
    $field = "kode_buku";

    // kode terakhir
    $lastKode = $this->kodeotomatis_m->getMax($table, $field);
    // mengambil 4 kabukuter tebukuhir
    $noUrut = (int) substr($lastKode, -4, 4);
    $noUrut++;

    $str = "B";
    $newKode = $str . sprintf('%04s', $noUrut);
    // membuat kode otomatis
    // user id
    $session_id = $this->sesi->user_login()->nama;
    //table buku
    $kode = $newKode;
    $judul = $this->input->post('judul');
    $kategori_id = 3; // kode kategori laporan ojt
    $prodi_id = $this->input->post('prodi_id');
    $rak_id = $this->input->post('rak_id');
    $tahun = $this->input->post('tahun');
    $jumlah = $this->input->post('jumlah');

    $data = [
    "kode_buku" => $kode,
    "judul" => $judul,
    "kategori_id" => $kategori_id,
    "prodi_id" => $prodi_id,
    "rak_id" => $rak_id,
    "tahun" => $tahun,
    "jumlah" => $jumlah,
    "dipinjam" => 0,
    "date_created" => date('Y-m-d H:i:s'),
    "created_by" => $session_id,
    ];
    $insert_buku_id = $this->administrator_m->simpan_buku($data);
    if (@$insert_buku_id) {
    $message['messages'] = "Berhasil Menambah Data buku....";
    $message['status'] = "1";
    } else {
    $message['messages'] = "Gagal Mengeksekusi Query buku";
    $message['status'] = "0";
    }
    echo json_encode($message);
    }

    public function laporan_ta()
    {
        $data['prodi']= $this->main_m->view('tb_prodi')->result();
        $data['rak']= $this->main_m->view('tb_rak')->result();
        $this->template->load('template','administrator/data/buku_laporan_ta', $data);
    }

    public function buku_laporan_ta_fetch()
    {
    $this->datatables_builder->select('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama, tb_buku.jumlah, tb_buku.tahun, tb_buku.date_created,  tb_buku.buku_id');
    $this->datatables_builder->from('tb_buku');
    $this->datatables_builder->join('tb_prodi', 'tb_buku.prodi_id = tb_prodi.prodi_id');
    $this->datatables_builder->join('tb_rak', 'tb_buku.rak_id = tb_rak.rak_id');
    $this->datatables_builder->where_in('tb_buku.kategori_id', ['2']);
    $this->datatables_builder->order_by('tb_buku.date_created', 'desc');
    $m = $this->datatables_builder->get();
    foreach ($m as $key => $val) {
			$btn_update = sprintf('<button class="btn" onclick="edit(%s)"><i class="fa fa-edit text-warning"></i></button>', $val['buku_id']);
			$btn_delete = sprintf('<button class="btn" onclick="hapus(%s)"><i class="fa fa-trash text-danger"></i></button>', $val['buku_id']);
			$m[$key]['buku_id'] =$btn_update . $btn_delete;
		}
    $this->datatables_builder->render_no_keys($m);
    }

    // menyimpan data buku
    function buku_laporan_ta_simpan()
    {
    $table = "tb_buku";
    $field = "kode_buku";

    // kode terakhir
    $lastKode = $this->kodeotomatis_m->getMax($table, $field);
    // mengambil 4 kabukuter tebukuhir
    $noUrut = (int) substr($lastKode, -4, 4);
    $noUrut++;

    $str = "B";
    $newKode = $str . sprintf('%04s', $noUrut);
    // membuat kode otomatis
    // user id
    $session_id = $this->sesi->user_login()->nama;
    //table buku
    $kode = $newKode;
    $judul = $this->input->post('judul');
    $kategori_id = 2; // kode kategori laporan ta
    $prodi_id = $this->input->post('prodi_id');
    $rak_id = $this->input->post('rak_id');
    $tahun = $this->input->post('tahun');
    $jumlah = $this->input->post('jumlah');

    $data = [
    "kode_buku" => $kode,
    "judul" => $judul,
    "kategori_id" => $kategori_id,
    "prodi_id" => $prodi_id,
    "rak_id" => $rak_id,
    "tahun" => $tahun,
    "jumlah" => $jumlah,
    "dipinjam" => 0,
    "date_created" => date('Y-m-d H:i:s'),
    "created_by" => $session_id,
    ];
    $insert_buku_id = $this->administrator_m->simpan_buku($data);
    if (@$insert_buku_id) {
    $message['messages'] = "Berhasil Menambah Data buku....";
    $message['status'] = "1";
    } else {
    $message['messages'] = "Gagal Mengeksekusi Query buku";
    $message['status'] = "0";
    }
    echo json_encode($message);
    }

    public function mata_kuliah()
    {
        $data['prodi']= $this->main_m->view('tb_prodi')->result();
        $data['rak']= $this->main_m->view('tb_rak')->result();
        $this->template->load('template','administrator/data/buku_mata_kuliah', $data);
    }

     public function buku_mata_kuliah_fetch()
    {
    $this->datatables_builder->select('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama, tb_buku.jumlah, tb_buku.tahun, tb_buku.date_created,  tb_buku.buku_id');
    $this->datatables_builder->from('tb_buku');
    $this->datatables_builder->join('tb_prodi', 'tb_buku.prodi_id = tb_prodi.prodi_id');
    $this->datatables_builder->join('tb_rak', 'tb_buku.rak_id = tb_rak.rak_id');
    $this->datatables_builder->where_in('tb_buku.kategori_id', ['4']);
    $this->datatables_builder->order_by('tb_buku.date_created', 'desc');
    $m = $this->datatables_builder->get();
    foreach ($m as $key => $val) {
			$btn_update = sprintf('<button class="btn" onclick="edit(%s)"><i class="fa fa-edit text-warning"></i></button>', $val['buku_id']);
			$btn_delete = sprintf('<button class="btn" onclick="hapus(%s)"><i class="fa fa-trash text-danger"></i></button>', $val['buku_id']);
			$m[$key]['buku_id'] =$btn_update . $btn_delete;
		}
    $this->datatables_builder->render_no_keys($m);
    }

    // menyimpan data buku
    function buku_mata_kuliah_simpan()
    {
    $table = "tb_buku";
    $field = "kode_buku";

    // kode terakhir
    $lastKode = $this->kodeotomatis_m->getMax($table, $field);
    // mengambil 4 kabukuter tebukuhir
    $noUrut = (int) substr($lastKode, -4, 4);
    $noUrut++;

    $str = "B";
    $newKode = $str . sprintf('%04s', $noUrut);
    // membuat kode otomatis
    // user id
    $session_id = $this->sesi->user_login()->nama;
    //table buku
    $kode = $newKode;
    $judul = $this->input->post('judul');
    $kategori_id = 4; // kode kategori laporan ta
    $prodi_id = $this->input->post('prodi_id');
    $rak_id = $this->input->post('rak_id');
    $tahun = $this->input->post('tahun');
    $jumlah = $this->input->post('jumlah');

    $data = [
    "kode_buku" => $kode,
    "judul" => $judul,
    "kategori_id" => $kategori_id,
    "prodi_id" => $prodi_id,
    "rak_id" => $rak_id,
    "tahun" => $tahun,
    "jumlah" => $jumlah,
    "dipinjam" => 0,
    "date_created" => date('Y-m-d H:i:s'),
    "created_by" => $session_id,
    ];
    $insert_buku_id = $this->administrator_m->simpan_buku($data);
    if (@$insert_buku_id) {
    $message['messages'] = "Berhasil Menambah Data buku....";
    $message['status'] = "1";
    } else {
    $message['messages'] = "Gagal Mengeksekusi Query buku";
    $message['status'] = "0";
    }
    echo json_encode($message);
    }

    public function buku_proposal_ta_fetch()
    {
    $this->datatables_builder->select('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama');
    $this->datatables_builder->from('tb_buku');
    $this->datatables_builder->join('tb_prodi', 'tb_buku.prodi_id = tb_prodi.prodi_id');
    $this->datatables_builder->join('tb_rak', 'tb_buku.rak_id = tb_rak.rak_id');
    $this->datatables_builder->where_in('tb_buku.kategori_id', ['2']);
    $this->datatables_builder->order_by('tb_buku.buku_id', 'desc');
    $m = $this->datatables_builder->get();
    $this->datatables_builder->render_no_keys($m);
    }

    
    public function buku_pengetahuan_umum_fetch()
    {
        $this->datatables_builder->select('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama');
        $this->datatables_builder->from('tb_buku');
        $this->datatables_builder->join('tb_prodi', 'tb_buku.prodi_id = tb_prodi.prodi_id');
        $this->datatables_builder->join('tb_rak', 'tb_buku.rak_id = tb_rak.rak_id');
        $this->datatables_builder->where_in('tb_buku.kategori_id', ['4']);
        $this->datatables_builder->order_by('tb_buku.buku_id', 'desc');
        $m = $this->datatables_builder->get();
        $this->datatables_builder->render_no_keys($m);
    }
    
    public function lama_peminjaman()
    {
        $this->template->load('template','peraturan/lama_peminjaman');
    }
    
    public function prodi()
    {
        $this->template->load('template','administrator/data/prodi');
    }
    
    public function rak()
    {
        $this->template->load('template','administrator/data/rak');
    }
    
    public function denda()
    {
        $this->template->load('template','administrator/data/denda');
    }

    // data pengguna

    public function petugas()
    {
        $this->template->load('template','administrator/data/petugas');
    }

    # Untuk menampilkan data petugas
    function admin_fetch()
    {
        // === == === NORMAL === == === //
        // === == === END NORMAL === == === //

            // $this->datatables_builder->search('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama,tb_buku.date_created,  date_created');
            $this->datatables_builder->select('nama, email, alamat, no_handphone, date_created, date_updated, user_id');
            $this->datatables_builder->from('tb_user');
            $this->datatables_builder->where_in('level_id', ['1']);
            $this->datatables_builder->order_by('date_created', 'desc');
            $m = $this->datatables_builder->get();
            foreach ($m as $key => $val) {
            		$btn_update = sprintf('<button class="btn" onclick="edit(%s)"><i class="fa fa-edit text-warning"></i></button>', $val['user_id']);
            		$btn_delete = sprintf('<button class="btn" onclick="hapus(%s)"><i class="fa fa-trash text-danger"></i></button>', $val['user_id']);
            		$m[$key]['user_id'] =$btn_update . $btn_delete;
            	}
                $this->datatables_builder->render_no_keys($m);

        // === == === NORMAL === == === //
        // === == === END NORMAL === == === //
    }

    // menyimpan data admin
    function admin_simpan()
    {
    $session_id = $this->sesi->user_login()->nama;
    //table rak
    $email = $this->input->post('email');
    $nama = $this->input->post('nama');
    $password = sha1($this->input->post('password'));
    $alamat = $this->input->post('alamat');
    $no_handphone = $this->input->post('no_handphone');

    $data = [
    "email" => $email,
    "password" => $password,
    "nama" => $nama,
    "alamat" => $alamat,
    "no_handphone" => $no_handphone,
    "date_created" => date('Y-m-d H:i:s'),
    "level_id" => 1,
    ];
    $insert_admin_id = $this->administrator_m->simpan_admin($data);
    if (@$insert_admin_id) {
    $message['messages'] = "Berhasil Menambah Data Petugas....";
    $message['status'] = "1";
    } else {
    $message['messages'] = "Gagal Mengeksekusi Query Petugas";
    $message['status'] = "0";
    }
    echo json_encode($message);
    }

    function admin_edit($id)
    {
    // $this->data['role'] = $this->main_m->view('user_role')->result();
    $this->data['level'] = $this->main_m->view('tb_level')->result();
    $this->data['user'] = $this->main_m->view_where('tb_user', ['user_id' => $id])->row();

    $this->load->view('form_update/anggota_update', $this->data);
    }

    // menghapus data admin
    function admin_hapus()
    {
        $id = $this->input->post('id');
        $del = $this->administrator_m->hapus_admin($id);
        if (@$del) {
        echo json_encode(true);
        } else {
        echo json_encode(false);
        }
    }

    function admin_update()
    {
    $user_id = $this->input->post('user_id');
    $level_id = $this->input->post('level_id');

    $data = [
    "user_id" => $user_id,
    "level_id" => $level_id,
    "date_updated" => date('Y-m-d H:i:s'),
    ];
    // var_dump($data);
    // die;
    $update_user_id = $this->administrator_m->update_petugas($user_id, $data);
    if (@$update_user_id) {
    $message['messages'] = "Berhasil Update Data Petugas";
    $message['status'] = "1";
    } else {
    $message['messages'] = "Gagal Update Data Petugas";
    $message['status'] = "0";
    }
    echo json_encode($message);
    }
    
    public function anggota()
    {
        $this->template->load('template','administrator/data/anggota');
    }

    # Untuk menampilkan data anggota
    function member_fetch()
    {
        // === == === NORMAL === == === //
        // === == === END NORMAL === == === //

            // $this->datatables_builder->search('tb_buku.judul, tb_prodi.prodi, tb_rak.rak_nama,tb_buku.date_created,  date_created');
            $this->datatables_builder->select('nama, email, alamat, no_handphone, date_created, date_updated, user_id');
            $this->datatables_builder->from('tb_user');
            $this->datatables_builder->where_in('level_id', ['2']);
            $this->datatables_builder->order_by('date_created', 'desc');
            $m = $this->datatables_builder->get();
            foreach ($m as $key => $val) {
            		$btn_update = sprintf('<button class="btn" onclick="edit(%s)"><i class="fa fa-edit text-warning"></i></button>', $val['user_id']);
            		$btn_delete = sprintf('<button class="btn" onclick="hapus(%s)"><i class="fa fa-trash text-danger"></i></button>', $val['user_id']);
            		$m[$key]['user_id'] =$btn_update . $btn_delete;
            	}
                $this->datatables_builder->render_no_keys($m);

        // === == === NORMAL === == === //
        // === == === END NORMAL === == === //
    }

    // menyimpan data member
    function member_simpan()
    {
    $session_id = $this->sesi->user_login()->nama;
    //table rak
    $email = $this->input->post('email');
    $nama = $this->input->post('nama');
    $password = sha1($this->input->post('password'));
    $alamat = $this->input->post('alamat');
    $no_handphone = $this->input->post('no_handphone');

    $data = [
    "email" => $email,
    "password" => $password,
    "nama" => $nama,
    "alamat" => $alamat,
    "no_handphone" => $no_handphone,
    "date_created" => date('Y-m-d H:i:s'),
    "level_id" => 2,
    ];
    $insert_member_id = $this->administrator_m->simpan_member($data);
    if (@$insert_member_id) {
    $message['messages'] = "Berhasil Menambah Data Anggota....";
    $message['status'] = "1";
    } else {
    $message['messages'] = "Gagal Mengeksekusi Query Anggota";
    $message['status'] = "0";
    }
    echo json_encode($message);
    }

    function member_edit($id)
    {
    // $this->data['role'] = $this->main_m->view('user_role')->result();
    $this->data['level'] = $this->main_m->view('tb_level')->result();
    $this->data['user'] = $this->main_m->view_where('tb_user', ['user_id' => $id])->row();

    $this->load->view('form_update/anggota_update', $this->data);
    }

    // menghapus data member
    function member_hapus()
    {
        $id = $this->input->post('id');
        $del = $this->administrator_m->hapus_member($id);
        if (@$del) {
        echo json_encode(true);
        } else {
        echo json_encode(false);
        }
    }

    function member_update()
    {
    $user_id = $this->input->post('user_id');
    $level_id = $this->input->post('level_id');

    $data = [
    "user_id" => $user_id,
    "level_id" => $level_id,
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
    

    // = = = = = = = = = = = = = = = = = = = //
    // ==========PROSES TRANSAKSI============//
    //= = = = = = = = = = = = = = = = = = = =//
    public function peminjaman()
    {
        // ===== Kode Otomatis Transaksi ===== //
        $table= "tb_pinjam";
        $field= "kode_transaksi";
        $today= date('ymd');
        $prefix= "TR".$today;
        
        $lastKode= $this->administrator_m->getMax_Today($prefix, $table, $field);
        $noUrut= (int) substr($lastKode, -3, 3);
        $noUrut++;

        // $newKode= $prefix . sprintf('%03s', $noUrut);
        /// var_dump($newKode);
        // die;
        // cek data
        $pinjam = $this->crud_m->tampil_order('pinjam_id', 'tb_pinjam', 'DESC')->row();
        if (empty($pinjam)) {
            $data['kode_jual'] = 1;
            $kode['pinjam_id'] = 1;
        } else {
            $data['kode_jual'] = $pinjam->pinjam_id + 1;
            $kode['pinjam_id'] = $pinjam->pinjam_id + 1;
        }
        $data['newKode']= $prefix . sprintf('%03s', $noUrut);
        $data['detailPinjam'] = $this->crud_m->tampil_join('tb_buku', 'tb_detailpinjam', 'tb_buku.buku_id=tb_detailpinjam.buku_id', $kode)->result();
        $this->template->load('template', 'transaksi/peminjaman', $data);
        
    }

    public function peminjaman2()
    {
        // ===== Kode Otomatis Transaksi ===== //
        $table= "tb_pinjam";
        $field= "kode_transaksi";
        $today= date('ymd');
        $prefix= "TR".$today;
        
        $lastKode= $this->kodeotomatis_m->getMax_Today($prefix, $table, $field);
        $noUrut= (int) substr($lastKode, -3, 3);
        $noUrut++;

        // var_dump($newKode);
        // die;
        // cek data
        $pinjam = $this->crud_m->tampil_order('pinjam_id', 'tb_pinjam', 'DESC')->row();
        if (empty($pinjam)) {
            $data['kode_jual'] = 1;
            $kode['pinjam_id'] = 1;
        } else {
            $data['kode_jual'] = $pinjam->pinjam_id + 1;
            $kode['pinjam_id'] = $pinjam->pinjam_id + 1;
        }
        $data['newKode']= $prefix . sprintf('%03s', $noUrut);
        $data['detailPinjam'] = $this->crud_m->tampil_join('tb_buku', 'tb_detailpinjam', 'tb_buku.buku_id=tb_detailpinjam.buku_id', $kode)->result();
        $this->template->load('template', 'transaksi/peminjaman2', $data);
        
    }

    public function pinjamBuku()
    {
        $pinjam= $this->input->post('pinjam_id');
        $buku = $this->input->post('buku_id');
        $dataPinjamBuku = array();
        foreach($buku as $key){
            array_push($dataInputPinjam, array(
            'pinjam_id' => $pinjam,
            'buku_id' => $key,
            'tanggal_kembali' => date('Y-m-d H:i:s'),
            'status_id' => 1
            ));
        }
        if($this->administrator_m->insertDataPinjam($dataInputPinjam) > 0){
            echo 'berhasil';
        }else{
            echo 'gagal';
        }
    }

    // = = = = = = = = = = = = = = = = = = = //
    // ==========PROSES TRANSAKSI============//
    //= = = = = = = = = = = = = = = = = = = =//
    
    public function getData_peminjam()
    {
        $peminjam = $this->input->get('peminjam');
        $query = $this->user_m->data_peminjam($peminjam, 'nama');		
		echo json_encode($query);
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

    public function pdflaporan_ojt()
    {
        $this->load->view('laporan/laporanojt_pdf');
    }

    // =======> CRUD DATA <=======
    // Untuk menampilkan data rak
	function rak_fetch()
	{
        $this->datatables_builder->select('rak_kode, rak_nama, rak_keterangan, date_created, rak_id');
        $this->datatables_builder->from('tb_rak');
        $this->datatables_builder->order_by('tb_rak.date_created', 'desc');
        $m = $this->datatables_builder->get();
        foreach ($m as $key => $val) {
            $btn_update = sprintf('<button onclick="edit(%s)" class="btn btn-icon btn-sm btn-primary m-1" data-toggle="tooltip" data-placement="top" title="Edit rak"><i class="fas fa-user-edit"></i></button>', $val['rak_id']);
            $btn_delete = sprintf('<button onclick="hapus(%s)" class="btn btn-icon btn-sm btn-danger m-1" data-toggle="tooltip" data-placement="top" title="Hapus rak"><i class="fas fa-trash-alt"></button>', $val['rak_id']);
            $m[$key]['rak_id'] = $btn_update . $btn_delete;
        }
        $this->datatables_builder->render_no_keys($m);

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
        $session_id = $this->sesi->user_login()->nama;
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
        $insert_rak_id = $this->administrator_m->simpan_rak($data);
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
$this->data['tb_user'] = $this->main_m->view_where('tb_user', ['user_id' => $id])->row();

$this->load->view('administrator/data/user_detail', $this->data);
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
$update_rak_id = $this->administrator_m->update_rak($rak_id, $data);
if (@$update_rak_id) {
$message['messages'] = "Berhasil Update Data";
$message['status'] = "1";
} else {
$message['messages'] = "Gagal Update Data";
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
$message['messages'] = "Berhasil Update Data";
$message['status'] = "1";
} else {
$message['messages'] = "Gagal Update Data";
$message['status'] = "0";
}
echo json_encode($message);
}

// menghapus data rak
function rak_hapus()
{
$id = $this->input->post('id');
$del = $this->administrator_m->hapus_rak($id);
if (@$del) {
echo json_encode(true);
} else {
echo json_encode(false);
}
}
// buku proses
// Untuk menampilkan data buku
// function buku_fetch()
// {
// $this->datatables->search('tb_buku.buku_id, tb_buku.judul, tb_kategori.kategori, tb_prodi.prodi, tb_rak.rak_nama');
// $this->datatables->select('tb_buku.buku_id, tb_buku.judul, tb_kategori.kategori, tb_prodi.prodi, tb_rak.rak_nama');
// $this->datatables->from('tb_buku');
// $this->datatables->join('tb_kategori', 'tb_buku.kategori_id = tb_kategori.kategori_id');
// $this->datatables->join('tb_prodi', 'tb_buku.prodi_id = tb_prodi.prodi_id');
// $this->datatables->join('tb_rak', 'tb_buku.rak_id = tb_rak.rak_id');
// // $this->datatables->where('tb_buku.jumlah !=', '0');
// $this->datatables->order_by('buku_id', 'asc');
// $m = $this->datatables->get();
// $no = 1;
// foreach ($m as $key => $value) {
// $act = '';
// $act .= sprintf('<button onclick="detail(%s)" class="btn btn-icon btn-sm btn-info m-1" data-toggle="tooltip"
//     data-placement="top" title="Detail buku"><i class="fas fa-user-edit"></i></button>', $value['buku_id']);
// $act .= sprintf('<button onclick="edit(%s)" class="btn btn-icon btn-sm btn-primary m-1" data-toggle="tooltip"
//     data-placement="top" title="Edit buku"><i class="fas fa-user-edit"></i></button>', $value['buku_id']);
// $act .= sprintf('<button onclick="hapus(%s)" class="btn btn-icon btn-sm btn-danger m-1" data-toggle="tooltip"
//     data-placement="top" title="Hapus buku"><i class="fas fa-trash-alt"></button>', $value['buku_id']);
// if($value['jumlah'] != "0"){
// $act .= sprintf('<button onclick="detail(%s)" class="btn btn-icon btn-sm btn-info m-1" data-toggle="tooltip"
//     data-placement="top" title="Detail buku"><i class="fas fa-user-edit"></i></button>', $value['buku_id']);
// $act .= sprintf('<button onclick="edit(%s)" class="btn btn-icon btn-sm btn-primary m-1" data-toggle="tooltip"
//     data-placement="top" title="Edit buku"><i class="fas fa-user-edit"></i></button>', $value['buku_id']);
// // $act .= sprintf('<button onclick="hapus(%s)" class="btn btn-icon btn-sm btn-danger m-1" data-toggle="tooltip"
// //     data-placement="top" title="Hapus buku"><i class="fas fa-trash-alt"></button>', $value['buku_id']);
// }else{
//     $act .= sprintf('<button onclick="edit(%s)" class="btn btn-icon btn-sm btn-primary m-1" data-toggle="tooltip"
//     data-placement="top" title="Edit buku"><i class="fas fa-user-edit"></i></button>', $value['buku_id']);
// }
// $m[$key]['as'] = $act;
// $m[$key]['buku_id'] = $no;
// $no++;
// }
// $this->datatables->render_no_keys($m);
// }

// Untuk menampilkan data buku
function bukumember_fetch()
{
$this->datatables->search('tb_buku.buku_id, tb_buku.judul, tb_kategori.kategori, tb_prodi.prodi, tb_rak.rak_nama');
$this->datatables->select('tb_buku.buku_id, tb_buku.judul, tb_kategori.kategori, tb_prodi.prodi, tb_rak.rak_nama');
$this->datatables->from('tb_buku');
$this->datatables->join('tb_kategori', 'tb_buku.kategori_id = tb_kategori.kategori_id');
$this->datatables->join('tb_prodi', 'tb_buku.prodi_id = tb_prodi.prodi_id');
$this->datatables->join('tb_rak', 'tb_buku.rak_id = tb_rak.rak_id');
// $this->datatables->where('tb_buku.jumlah !=', '0');
// $this->datatables->order_by('date_created', 'DESC');
$m = $this->datatables->get();
$no = 1;
foreach ($m as $key => $value) {
$act = '';
$act .= sprintf('<button onclick="detail(%s)" class="btn btn-icon btn-sm btn-info m-1" data-toggle="tooltip" data-placement="top" title="Detail buku"><i class="fas fa-user-edit"></i></button>', $value['buku_id']);
// $act .= sprintf('<button onclick="edit(%s)" class="btn btn-icon btn-sm btn-primary m-1" data-toggle="tooltip"
//     data-placement="top" title="Edit buku"><i class="fas fa-user-edit"></i></button>', $value['buku_id']);
// $act .= sprintf('<button onclick="hapus(%s)" class="btn btn-icon btn-sm btn-danger m-1" data-toggle="tooltip"
//     data-placement="top" title="Hapus buku"><i class="fas fa-trash-alt"></button>', $value['buku_id']);
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
// mengambil 4 kabukuter tebukuhir
$noUrut = (int) substr($lastKode, -4, 4);
$noUrut++;

$str = "B";
$newKode = $str . sprintf('%04s', $noUrut);
// membuat kode otomatis
// user id
$session_id = $this->sesi->user_login()->nama;
//table buku
$kode = $newKode;
$judul = $this->input->post('judul');
$kategori_id = $this->input->post('kategori_id');
$prodi_id = $this->input->post('prodi_id');
$rak_id = $this->input->post('rak_id');
$tahun = $this->input->post('tahun');
$jumlah = $this->input->post('jumlah');

$data = [
"kode_buku" => $kode,
"judul" => $judul,
"kategori_id" => $kategori_id,
"prodi_id" => $prodi_id,
"rak_id" => $rak_id,
"tahun" => $tahun,
"jumlah" => $jumlah,
"dipinjam" => 0,
"date_created" => date('Y-m-d H:i:s'),
"created_by" => $session_id,
];
$insert_buku_id = $this->administrator_m->simpan_buku($data);
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
$data['kategori'] = $this->main_m->view('tb_kategori')->result();
$data['prodi']= $this->main_m->view('tb_prodi')->result();
$data['rak']= $this->main_m->view('tb_rak')->result();
$data['buku'] = $this->main_m->view_where('tb_buku', ['buku_id' => $id])->row();

$this->load->view('form_update/buku_update', $data);
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
$message['messages'] = "Berhasil Update Data";
$message['status'] = "1";
} else {
$message['messages'] = "Gagal Update Data";
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
$judul = $this->input->post('judul');
// $kategori = $this->input->post('kategori_id');
$prodi_id = $this->input->post('prodi_id');
$rak_id = $this->input->post('rak_id');
$tahun = $this->input->post('tahun');
$jumlah = $this->input->post('jumlah');

$data = [
"buku_id" => $buku_id,
"judul" => $judul,
// "kategori_id" => $kategori,
"prodi_id" => $prodi_id,
"rak_id" => $rak_id,
"tahun" => $tahun,
"jumlah" => $jumlah,
"date_updated" => date('Y-m-d H:i:s'),
];
$update_buku_id = $this->administrator_m->update_buku($buku_id, $data);
if (@$update_buku_id) {
$message['messages'] = "Berhasil Update Data";
$message['status'] = "1";
} else {
$message['messages'] = "Gagal Update Data";
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
// $message['messages'] = "Berhasil Update Data";
// $message['status'] = "1";
// } else {
// $message['messages'] = "Gagal Update Data";
// $message['status'] = "0";
// }
// echo json_encode($message);
// }

// menghapus data buku
function buku_hapus()
{
$id = $this->input->post('id');
$del = $this->administrator_m->hapus_buku($id);
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
    $this->datatables_builder->select('prodi, date_created, prodi_id');
    $this->datatables_builder->from('tb_prodi');
    $this->datatables_builder->order_by('tb_prodi.date_created', 'desc');
    $m = $this->datatables_builder->get();
    foreach ($m as $key => $val) {
        $btn_update = sprintf('<button onclick="edit(%s)" class="btn btn-icon btn-sm btn-primary m-1" data-toggle="tooltip" data-placement="top" title="Edit prodi"><i class="fas fa-user-edit"></i></button>', $val['prodi_id']);
        $btn_delete = sprintf('<button onclick="hapus(%s)" class="btn btn-icon btn-sm btn-danger m-1" data-toggle="tooltip" data-placement="top" title="Hapus prodi"><i class="fas fa-trash-alt"></button>', $val['prodi_id']);
        $m[$key]['prodi_id'] = $btn_update . $btn_delete;
    }
    $this->datatables_builder->render_no_keys($m);


// $this->datatables->search('prodi_id, prodi, date_created');
// $this->datatables->select('prodi_id, prodi, date_created');
// $this->datatables->from('tb_prodi');
// $m = $this->datatables->get();
// // $no = 1;
// foreach ($m as $key => $value) {
// $act = '';
// // $act .= sprintf('<button onclick="detail(%s)" class="btn btn-icon btn-sm btn-info m-1" data-toggle="tooltip"
// //     data-placement="top" title="Detail prodi"><i class="fas fa-user-edit"></i></button>', $value['prodi_id']);
// $act .= sprintf('<button onclick="edit(%s)" class="btn btn-icon btn-sm btn-primary m-1" data-toggle="tooltip"
//     data-placement="top" title="Edit prodi"><i class="fas fa-user-edit"></i></button>', $value['prodi_id']);
// $act .= sprintf('<button onclick="hapus(%s)" class="btn btn-icon btn-sm btn-danger m-1" data-toggle="tooltip"
//     data-placement="top" title="Hapus prodi"><i class="fas fa-trash-alt"></button>', $value['prodi_id']);
// $m[$key]['as'] = $act;
// // $m[$key]['prodi_id'] = $no;
// // $no++;
// }
// $this->datatables->render_no_keys($m);
}

// menyimpan data prodi
function prodi_simpan()
{
// b0001 kode awal
// RK01
// user id
$session_id = $this->sesi->user_login()->nama;
//table rak
$prodi = $this->input->post('prodi');

$data = [
"prodi" => $prodi,
"date_created" => date('Y-m-d H:i:s'),
"created_by" => $session_id,
];
$insert_prodi_id = $this->administrator_m->simpan_prodi($data);
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
$del = $this->administrator_m->hapus_prodi($id);
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
$update_prodi_id = $this->administrator_m->update_prodi($prodi_id, $data);
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
    $this->datatables_builder->select('kategori, date_created, kategori_id');
        $this->datatables_builder->from('tb_kategori');
        $this->datatables_builder->order_by('tb_kategori.date_created', 'desc');
        $m = $this->datatables_builder->get();
        foreach ($m as $key => $val) {
            $btn_update = sprintf('<button onclick="edit(%s)" class="btn btn-icon btn-sm btn-primary m-1" data-toggle="tooltip" data-placement="top" title="Edit kategori"><i class="fas fa-user-edit"></i></button>', $val['kategori_id']);
            $btn_delete = sprintf('<button onclick="hapus(%s)" class="btn btn-icon btn-sm btn-danger m-1" data-toggle="tooltip" data-placement="top" title="Hapus kategori"><i class="fas fa-trash-alt"></button>', $val['kategori_id']);
            $m[$key]['kategori_id'] = $btn_update . $btn_delete;
        }
        $this->datatables_builder->render_no_keys($m);

    }


function kategori_simpan()
{
// b0001 kode awal
// RK01
// user id
$session_id = $this->sesi->user_login()->nama;
//table kategori
$kategori = $this->input->post('kategori');

$data = [
"kategori" => $kategori,
"date_created" => date('Y-m-d H:i:s'),
"created_by" => $session_id,
];
$insert_kategori_id = $this->administrator_m->simpan_kategori($data);
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
$del = $this->administrator_m->hapus_kategori($id);
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
$update_kategori_id = $this->administrator_m->update_kategori($kategori_id, $data);
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

function coba_fetch()
{
$this->datatables_builder->select('tb_buku.judul, tb_kategori.kategori, tb_prodi.prodi, tb_rak.rak_nama');
// $this->datatables_builder->select('judul, kategori, prodi, rak_nama');
$this->datatables_builder->from('tb_buku');
$this->datatables_builder->join('tb_kategori', 'tb_buku.kategori_id = tb_kategori.kategori_id');
$this->datatables_builder->join('tb_prodi', 'tb_buku.prodi_id = tb_prodi.prodi_id');
$this->datatables_builder->join('tb_rak', 'tb_buku.rak_id = tb_rak.rak_id');
$this->datatables_builder->group_by('tb_buku.buku_id', 'desc');
$m = $this->datatables_builder->get();
$this->datatables_builder->render_no_keys($m);
}


    // =======> CRUD DATA <=======
    
}