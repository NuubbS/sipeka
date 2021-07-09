<?php

use phpDocumentor\Reflection\PseudoTypes\True_;

defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        check_admin();
        $this->load->model(['kodeotomatis_m', 'administrator_m', 'transaksi_m']);
    }

    // =========== TRANSAKSI ========== //

    // PEMINJAMAN
    public function peminjaman()
    {
        // validasi
        $this->form_validation->set_rules('user_id', 'Peminjam', 'trim|required');
        $this->form_validation->set_rules('buku_id[]', 'Buku', 'trim|required');
        
        if ($this->form_validation->run() == false) {
            $data['kode'] = $this->kodeotomatis_m->kodeT();
            $data['title'] = "Pinjam Buku";
            $this->template->load('template', 'administrator/transaksi/peminjaman', $data);
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
                'created_by' => $created_by,
                'status_id' => 3
            ];
            $DataPinjam = $this->transaksi_m->inputPinjam($data, 'tb_pinjam', $user_id);
            $buku = $this->input->post('buku_id[]');
            $data2 = array();
            foreach ($buku as $key) {
                array_push($data2, array(
                    'pinjam_id' => $DataPinjam,
                    'buku_id' => $key,
                    'jumlah_pinjam' => 1,
                    'tanggal_kembali' => $tanggal_kembali,
                ));
            }
            if($this->transaksi_m->inputPinjam($data2, 'tb_detailpinjam', $user_id) > 0){
                redirect('transaksi/peminjamanBuku');
            }else{
                redirect('transaksi/peminjaman');
            }
        }
        
    }

    // daftar peminjaman
    public function peminjamanBuku()
    {
        $data['title'] = "Daftar Peminjaman";
        $this->template->load('template','administrator/transaksi/peminjamanBuku', $data);
    }

    // daftar transaksi peminjaman
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
                    $btn_kembali = sprintf('<button onclick="kembali(%s)" class="btn btn-icon btn-sm btn-warning m-1" data-toggle="tooltip" data-placement="top" title="Konfirmasi Pengembalian"><i class="fas fa-check"></i> Konfirmasi</button>', $val['pinjam_id']);
                    $btn_detail = sprintf('<button onclick="detail(%s)" class="btn btn-icon btn-sm btn-info m-1" data-toggle="tooltip" data-placement="top" title="Detail Peminjaman"><i class="fas fa-info"></i> Detail</button>', $val['pinjam_id']);
                    // $btn_hapus = sprintf('<button onclick="hapus(%s)" class="btn btn-icon btn-sm btn-danger m-1" data-toggle="tooltip" data-placement="top" title="Pilih"><i class="fas fa-trash"></i> Hapus</button>', $val['pinjam_id']);
                $m[$key]['pinjam_id'] = $btn_kembali.$btn_detail;
                
            }
        
        $this->datatables_builder->render_no_keys($m);
    }

    // pengembalian buku
    public function pengembalianBuku()
    {
        $data['title'] = "Daftar Pengembalian";
        $this->template->load('template','administrator/transaksi/pengembalianBuku', $data);
    }

    // daftar pengembalian buku
    public function daftarPengembalianBuku_fetch()
    {
        $this->datatables_builder->select('tb_pinjam.kode_transaksi, tb_user.nama, tb_pinjam.tanggal_pinjam, tb_pinjam.created_by, tb_status.status,    tb_pinjam.pinjam_id');
        $this->datatables_builder->from('tb_pinjam');
        $this->datatables_builder->join('tb_user', 'tb_pinjam.user_id = tb_user.user_id');
        // $this->datatables_builder->join('tb_detailpinjam', 'tb_pinjam.pinjam_id = tb_detailpinjam.pinjam_id');
        $this->datatables_builder->join('tb_status', 'tb_pinjam.status_id = tb_status.status_id');
        $this->datatables_builder->where_in('tb_pinjam.status_id', ['4']);
        $this->datatables_builder->order_by('pinjam_id', 'desc');
        $m = $this->datatables_builder->get();
        foreach ($m as $key => $val) {
                    $btn_hapus = sprintf('<button onclick="hapus(%s)" class="btn btn-icon btn-sm btn-danger m-1" data-toggle="tooltip" data-placement="top" title="Pilih"><i class="fas fa-trash"></i> Hapus</button>', $val['pinjam_id']);
                    $btn_detail = sprintf('<button onclick="detail(%s)" class="btn btn-icon btn-sm btn-info m-1" data-toggle="tooltip" data-placement="top" title="Pilih"><i class="fas fa-info"></i> Detail</button>', $val['pinjam_id']);
                $m[$key]['pinjam_id'] = $btn_detail.$btn_hapus;
                
            }
        
        $this->datatables_builder->render_no_keys($m);
    }

	// mengkonfirmasi pengembalian buku
        public function kembalikanBuku()
        {
            $pinjam_id = $this->input->post('id');
            $data = [
                'pinjam_id' => $pinjam_id,
                'status_id' => 4,
            ];
            $this->transaksi_m->konfirmasiPengembalian($pinjam_id, $data, 'tb_pinjam');
            $tanggal_kembali = date('Y-m-d');
            $data2 = [
                'tanggal_kembali' => $tanggal_kembali
            ];
            if($this->transaksi_m->konfirmasiPengembalian($pinjam_id, $data2, 'tb_detailpinjam') > 0){
                echo json_encode(true);
            }else{
                echo json_encode(false);
            }
        }

        // eksport pengembalian pdf
        public function eksportPDF()
        {
            $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
            $datapeminjaman = $this->main_m->view_eksportPDF('tb_pinjam', 'tb_user', 'tb_detailpinjam', 'tb_buku', 'user_id', 'pinjam_id', 'buku_id', array('tb_pinjam.status_id' => 4), 'tanggal_pinjam', 'desc');
            // $datapeminjaman = $this->main_m->view_join_one('tb_pinjam', 'tb_user', 'user_id', 'pinjam_id', 'desc');
            $data = $this->load->view('administrator/laporan/peminjamanPDF', ['datakembali' => $datapeminjaman], TRUE);
            // var_dump($data);
            // die;
            $mpdf->WriteHTML($data);
            $mpdf->Output();
        }

        // eksport pengembalian excel
        public function eksportExcel()
        {
            $data['title'] = 'Laporan Peminjaman Buku';
            $data['peminjaman'] = $this->main_m->view_eksportPDF('tb_pinjam', 'tb_user', 'tb_detailpinjam', 'tb_buku', 'user_id', 'pinjam_id', 'buku_id', array('tb_pinjam.status_id' => 4), 'tanggal_pinjam', 'desc');
            $this->load->view('administrator/laporan/peminjamanExcel', $data);
        }

        // eksport pengembalian grafik
        public function eksportGrafik()
        {
            $data['title'] = 'Laporan Peminjaman Buku';
            $data['peminjaman'] = $this->main_m->view_eksportPDF('tb_pinjam', 'tb_user', 'tb_detailpinjam', 'tb_buku', 'user_id', 'pinjam_id', 'buku_id', array('tb_pinjam.status_id' => 4), 'tanggal_pinjam', 'desc');
            $this->load->view('administrator/laporan/peminjamanGrafik', $data);
        }

        public function peminjaman_hapus()
        {
            $id = $this->input->post('id');
            $del = $this->transaksi_m->hapus_peminjaman($id);
            if (@$del) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        }

        public function daftar_anggota()
        {

        $this->load->view('form_transaksi/daftar_anggota');
        }

        public function anggota_fetch()
        {
            $this->datatables_builder->select('nama, email, alamat, no_handphone, user_id, status_id');
            $this->datatables_builder->from('tb_user');
            $this->datatables_builder->order_by('date_created', 'desc');
            $m = $this->datatables_builder->get();
            foreach ($m as $key => $val) {
                if ($val['status_id'] == 2) {
                    $btn_pilih = sprintf('<button onclick="pilih(%s)" class="btn btn-icon btn-sm btn-progress btn-danger m-1" data-toggle="tooltip" data-placement="top" title="Pilih"><i class="fas fa-check"></i> Pilih</button>', $val['user_id']);
                $m[$key]['user_id'] = $btn_pilih;
                }else{
                    $btn_pilih = sprintf('<button onclick="pilih(%s)" class="btn btn-icon btn-sm btn-success m-1" data-toggle="tooltip" data-placement="top" title="Pilih"><i class="fas fa-check"></i> Pilih</button>', $val['user_id']);
                $m[$key]['user_id'] = $btn_pilih;
                }
                }
            $this->datatables_builder->render_no_keys($m);
        }

        public function daftar_buku()
        {

        $this->load->view('form_transaksi/daftar_buku');
        }

        public function buku_fetch()
        {
            $this->datatables_builder->select('tb_buku.judul, tb_prodi.prodi, tb_buku.tahun, tb_buku.jumlah, tb_buku.dipinjam,  tb_buku.buku_id');
            $this->datatables_builder->from('tb_buku');
            $this->datatables_builder->join('tb_prodi', 'tb_buku.prodi_id = tb_prodi.prodi_id');
            $this->datatables_builder->join('tb_rak', 'tb_buku.rak_id = tb_rak.rak_id');
            $this->datatables_builder->order_by('tb_buku.buku_id', 'desc');
            $m = $this->datatables_builder->get();
            foreach ($m as $key => $val) {
                if ($val['jumlah'] == 0) {
                    $btn_pilih = sprintf('<button  class="btn btn-icon btn-sm btn-progress btn-danger m-1" data-toggle="tooltip" data-placement="top" title="Pilih"><i class="fas fa-check"></i> Pilih</button>', $val['buku_id']);
                $m[$key]['buku_id'] = $btn_pilih;
                }else{
                    $btn_pilih = sprintf('<button onclick="pinjam_buku(%s)" class="btn btn-icon btn-sm btn-success m-1" data-toggle="tooltip" data-placement="top" title="Pilih"><i class="fas fa-check"></i> Pilih</button>', $val['buku_id']);
                $m[$key]['buku_id'] = $btn_pilih;
                }
                }
            $this->datatables_builder->render_no_keys($m);
        }

        public function buku_pinjam($id)
        {
            // tanggal kembali defaultt 3 hari
            $kembali = mktime(0,0,0, date("n"), date("j") + 3, date("Y"));
            $tgl_kembali = date('Y-m-d', $kembali);

            // mengambil i pinjam terakhir
            $pinjam_id = $this->crud_m->tampil_order('pinjam_id', 'tb_pinjam', 'DESC')->row();
            if (empty($pinjam_id)) {
                $kode_pinjam = 1;
            } else {
                $kode_pinjam = $pinjam_id->pinjam_id + 1;
            }

            // cek buku di keranjang
            $whereCheck = [
                'buku_id' => $id,
                'pinjam_id' => $kode_pinjam
            ];
            $cekPinjam = $this->crud_m->tampil_id('tb_detailpinjam', $whereCheck)->row();
            if (empty($cekPinjam)) {
                $field= [
                    'pinjam_id' => $kode_pinjam,
                    'buku_id' => $id,
                    'jumlah_pinjam' => 1,
                    'tanggal_kembali' => $tgl_kembali
                ];
                $this->crud_m->tambah('tb_detailpinjam', $field);
                
            } else {
                $field= [
                    'jumlah_pinjam' => $cekPinjam->jumlah_pinjam + 1
                ];
                $this->crud_m->edit('tb_detailpinjam', $field, $whereCheck);
            }
        }

        public function hapus_detailpinjam($id)
        {
            $crack = explode('-', $id);
            $where = [
                'pinjam_id' => $crack[0],
                'buku_id' => $crack[1]
            ];
            $this->crud_m->hapus('tb_detailpinjam', $where);
            redirect('administrator/peminjaman2');
        }

        public function detailpinjam($id)
        {
            $data['pinjambuku'] = $this->main_m->view_join_whereno('tb_detailpinjam', 'tb_buku', 'buku_id', ['pinjam_id' => $id]);
            $this->load->view('form_detail/detail_pinjam', $data);
        }

        public function detailkembali($id)
        {
            $data['pinjambuku'] = $this->main_m->view_join_whereno('tb_detailpinjam', 'tb_buku', 'buku_id', ['pinjam_id' => $id]);
            $this->load->view('form_detail/detail_kembali', $data);
        }

        // ===========  END TRANSAKSI ========== //

}