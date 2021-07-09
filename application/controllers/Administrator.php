<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        check_admin();
        $this->load->model(['kodeotomatis_m', 'administrator_m', 'transaksi_m']);
    }

    // ========== DASHBOARD ========== //
    public function index()
	{
		check_admin();
        $data['title'] = "Dashboard";
        $data['buku'] = $this->main_m->view_join_three_unwhere('tb_buku', 'tb_kategori', 'tb_prodi', 'tb_rak', 'kategori_id', 'prodi_id', 'rak_id', 'buku_id', 'desc', 0, 4);
        $data['anggota'] = $this->main_m->view_where_ordering_limit('tb_user', array('tb_user.level_id' => 2) , 'tb_user.date_created', 'desc', 0, 4);
        $data['peminjaman'] = $this->main_m->view_join_one_where('tb_pinjam', 'tb_user', 'user_id', array('tb_pinjam.status_id' => 3) , 'tb_pinjam.pinjam_id', 'desc', 0, 4);
        $data['pengembalian'] = $this->main_m->view_join_one_where('tb_pinjam', 'tb_user', 'user_id', array('tb_pinjam.status_id' => 4) , 'tb_pinjam.pinjam_id', 'desc', 0, 4);
        $this->template->load('template','administrator/data/dashboard', $data);
	}
    // ========== END DASHBOARD ========== //

    // ========== MASTERDATA ========== //

    // program studi
    public function prodi()
    {
        $data['title'] = "Prodi";
        $this->template->load('template','administrator/data/prodi', $data);
    }

    // menampilkan daftar prodi
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
    }

    // menyimpan data prodi
    function prodi_simpan()
        {
        $session_id = $this->sesi->user_login()->nama;
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
        $message['messages'] = "Gagal Menambahkan Data Prodi";
        $message['status'] = "0";
        }
        echo json_encode($message);
    }

    function prodi_edit($id)
    {
        $this->data['prodi'] = $this->main_m->view_where('tb_prodi', ['prodi_id' => $id])->row();
        $this->load->view('form_update/prodi_update', $this->data);
    }

    // mengupdate prodi
    function prodi_update()
    {
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

    // kategori
    public function kategori()
    {
        $data['title'] = "Kategori Buku";
        $this->template->load('template','administrator/data/kategori', $data);
    }

    // menampilakan kategori buku
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

    // menyimpan data kategori
    function kategori_simpan()
    {
        $session_id = $this->sesi->user_login()->nama;
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
            $message['messages'] = "Gagal Menambahkan Data Kategori Buku";
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

    // menampilkan data edit
    function kategori_edit($id)
    {
        $this->data['kategori'] = $this->main_m->view_where('tb_kategori', ['kategori_id' => $id])->row();
        $this->load->view('form_update/kategori_update', $this->data);
    }

    // mengupdate kategori
    function kategori_update()
    {
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

    // rak
    public function rak()
    {
        $data['title'] = "Rak";
        $this->template->load('template','administrator/data/rak', $data);
    }

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
            $message['messages'] = "Gagal Menambahkan Data rak";
            $message['status'] = "0";
        }
        echo json_encode($message);
        }

    // menampikan data sesuai id
    function rak_edit($id)
    {
        $this->data['rak'] = $this->main_m->view_where('tb_rak', ['rak_id' => $id])->row();
        $this->load->view('form_update/rak_update', $this->data);
    }

    // mengupdate rak
    function rak_update()
    {
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
    // ========== END MASTERDATA ========== //

    // ========== BUKU ========== //

    // buku referensi
    public function referensi()
    {
        $data = [
            'title' => 'Buku Refrensi',
            'prodi' => $this->main_m->view('tb_prodi')->result(),
            'rak' => $this->main_m->view('tb_rak')->result()
        ];
        $this->template->load('template','administrator/data/buku_referensi', $data);
    }

    // menampilkan data buku refrensi
    public function buku_referensi_fetch()
    {
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
            $message['messages'] = "Gagal Menambahkan Data buku";
            $message['status'] = "0";
        }
        echo json_encode($message);
    }

    // mengupdate buku global
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

    // menampikan data sesuai id
    function buku_edit($id)
    {
        $data['kategori'] = $this->main_m->view('tb_kategori')->result();
        $data['prodi']= $this->main_m->view('tb_prodi')->result();
        $data['rak']= $this->main_m->view('tb_rak')->result();
        $data['buku'] = $this->main_m->view_where('tb_buku', ['buku_id' => $id])->row();

        $this->load->view('form_update/buku_update', $data);
    }

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

    // buku laporan tugas akhir
     public function laporan_ta()
    {
        $data = [
            'title' => 'Buku Laporan Tugas Akhir',
            'prodi' => $this->main_m->view('tb_prodi')->result(),
            'rak' => $this->main_m->view('tb_rak')->result()
        ];
        $this->template->load('template','administrator/data/buku_laporan_ta', $data);
    }
    // menampilkan daftar buku laporan tugas akhir
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

    // menyimpan data buku laporan tugas akhir
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
            $message['messages'] = "Gagal Menambahkan Data buku";
            $message['status'] = "0";
        }
        echo json_encode($message);
    }

    // buku laporan ojt
    public function laporan_ojt()
    {
        $data = [
            'title' => 'Buku Laporan On the Job Training',
            'prodi' => $this->main_m->view('tb_prodi')->result(),
            'rak' => $this->main_m->view('tb_rak')->result()
        ];
        $this->template->load('template','administrator/data/buku_laporan_ojt', $data);
    }

    // menmpilkan daftar buku laporan ojt
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

    // menyimpan data buku laporan ojt
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
            $message['messages'] = "Gagal Menambahkan Data buku";
            $message['status'] = "0";
        }
        echo json_encode($message);
    }
    
    // buku mata kuliah
    public function mata_kuliah()
    {
        $data = [
            'title' => 'Buku Mata Kuliah',
            'prodi' => $this->main_m->view('tb_prodi')->result(),
            'rak' => $this->main_m->view('tb_rak')->result()
        ];
        $this->template->load('template','administrator/data/buku_mata_kuliah', $data);
    }

    // menampilkan daftar buku mata kuliah
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

    // menyimpan data buku mata kuliah
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
            $message['messages'] = "Gagal Menambahkan Data buku";
            $message['status'] = "0";
        }
        echo json_encode($message);
    }
    
    // ========== END BUKU ========== //
    
    // ========== DATA PENGGUNA ========== //

    // anggota
    public function anggota()
    {
        $data['title'] = "Anggota";
        $this->template->load('template','administrator/data/anggota', $data);
    }

    # Untuk menampilkan data anggota
    function member_fetch()
    {
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
    }

    // menyimpan data member
    function member_simpan()
    {
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
            "status_id" => 1 #bisa pinjam buku
        ];
        $insert_member_id = $this->administrator_m->simpan_member($data);
        if (@$insert_member_id) {
            $message['messages'] = "Berhasil Menambah Data Anggota....";
            $message['status'] = "1";
        } else {
            $message['messages'] = "Gagal Menambahkan Data Anggota";
            $message['status'] = "0";
        }
        echo json_encode($message);
    }

    // menampikan data member
    function member_edit($id)
    {
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

    // mengupdate member
    function member_update()
    {
        $user_id = $this->input->post('user_id');
        $level_id = $this->input->post('level_id');

        $data = [
            "user_id" => $user_id,
            "level_id" => $level_id,
            "date_updated" => date('Y-m-d H:i:s'),
        ];
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

    // petugas
    public function petugas()
    {
        $data['title'] = "Petugas";
        $this->template->load('template','administrator/data/petugas', $data);
    }

    # Untuk menampilkan data petugas
    function admin_fetch()
    {
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
    }

    // menyimpan data admin
    function admin_simpan()
    {
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
            "status_id" => 1,
        ];
        $insert_admin_id = $this->administrator_m->simpan_admin($data);
        if (@$insert_admin_id) {
            $message['messages'] = "Berhasil Menambah Data Petugas....";
            $message['status'] = "1";
        } else {
            $message['messages'] = "Gagal Menambahkan Data Petugas";
            $message['status'] = "0";
        }
        echo json_encode($message);
    }

    // menampilkan data petugas
    function admin_edit($id)
    {
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
    // ========== END DATA PENGGUNA ========== //

    // ========== PENGATURAN ========== //

    // profil saya
    public function profil()
    {
        $data = [
            'title' => "Profil Saya",
            'admin' => $this->main_m->view_where('tb_user', ['user_id' => $this->sesi->user_login()->user_id])->row()
        ];
        $this->template->load('template','administrator/pengaturan/profil', $data);
        // $this->template->load('template', 'administrator/pangaturan/profil');
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

    // ========== END PENGATURAN ========== //

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
				'text' => $row['nama']. " (". $row['alamat'].") ",
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($select2ajax));
		}
    }
    // =========END GET DATA AJAX SELECT2============= //

    public function peminjaman2()
    {
        
        // validasi
        $this->form_validation->set_rules('user_id', 'Peminjam', 'trim|required',
        array('required' => 'Harap memasukkan Nama %s.')
        );
        
        if ($this->form_validation->run() == false) {
            // mengambil i pinjam terakhir
            $pinjam_id = $this->crud_m->tampil_order('pinjam_id', 'tb_pinjam', 'DESC')->row();
            if (empty($pinjam_id)) {
                // $data['kode_pinjam'] = 1;
                $kode['pinjam_id'] = 1; #untuk menampilkan detail pinjam
                $data =[
                    'title' => "Peminjaman2",
                    'kode_pinjam' => 1,
                    'kode' => $this->kodeotomatis_m->kodeT(),
                    // 'detail_pinjam' => $this->crud_m->tampil_id('tb_detailpinjam' , $kode)->result()
                    'detail_pinjam' => $this->crud_m->tampil_join('tb_buku', 'tb_detailpinjam', 'tb_buku.buku_id=tb_detailpinjam.buku_id', $kode)->result()
                ];
            } else {
                $kode['pinjam_id'] = $pinjam_id->pinjam_id + 1; #untuk menampilkan detail pinjam
                $data =[
                    'kode_pinjam' => $pinjam_id->pinjam_id + 1,
                    'title' => "Peminjaman2",
                    'kode' => $this->kodeotomatis_m->kodeT(),
                    // 'detail_pinjam' => $this->crud_m->tampil_id('tb_detailpinjam' , $kode)->result()
                    'detail_pinjam' => $this->crud_m->tampil_join('tb_buku', 'tb_detailpinjam', 'tb_buku.buku_id=tb_detailpinjam.buku_id', $kode)->result()
                    ];
            }
            $this->template->load('template','administrator/transaksi/peminjaman2', $data);
        }else{
            $kode_transaksi = $this->input->post('kode_transaksi');
            $user_id = $this->input->post('user_id');
            $tanggal_pinjam = $this->input->post('tanggal_pinjam');
            $created_by = $this->sesi->user_login()->nama;
            $data=[
                'kode_transaksi' => $kode_transaksi,
                'user_id' => $user_id,
                'tanggal_pinjam' => $tanggal_pinjam,
                'created_by' => $created_by,
                'status_id' => 3
            ];
            if($this->transaksi_m->input_pinjam($data) > 0){
                redirect('transaksi/peminjamanBuku');
            }else{
                redirect('transaksi/peminjaman');
            }
        }
        
    }


}