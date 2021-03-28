<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_perpus extends CI_Controller
{

	// rak proses

	// Untuk menampilkan data rak
	function rak_fetch()
	{
        $this->datatables->search('tb_rak.rak_id, tb_rak.rak_nama, tb_rak.keterangan, tb_rak.date_created, tb_rak.date_updated, tb_rak.created_by');
        $this->datatables->select('rak_id, rak_nama, keterangan, date_created, date_updated, created_by');
        $this->datatables->from('tb_rak');
		$this->datatables->order_by('tb_rak.date_created', "DESC");
        $m = $this->datatables->get();
        $no = 1;
        foreach ($m as $key => $value) {
            $act = '';
            $act .= sprintf('<button onclick="edit(%s)" class="btn btn-icon btn-sm btn-primary m-1" data-toggle="tooltip" data-placement="top" title="Edit Rak"><i class="fas fa-user-edit"></i></button>', $value['rak_id']);
            $act .= sprintf('<button onclick="hapus(%s)" class="btn btn-icon btn-sm btn-danger m-1" data-toggle="tooltip" data-placement="top" title="Hapus Rak"><i class="fas fa-trash-alt"></button>', $value['rak_id']);
            $m[$key]['as'] = $act;
            $m[$key]['rak_id'] = $no;
            $no++;
        }
        $this->datatables->render_no_keys($m);
    } 

	// menyimpan data rak
	function rak_simpan()
    {
        // user id
        $session_id = $this->session->userdata('user_id');
        //table soal
        $kategori = $this->input->post('intervensi_kategori');
        $nama = $this->input->post('nama');
        $status = $this->input->post('status');

        $data = [
            "nama" => $nama,
            "intervensi_kategori_id" => $kategori,
            "created_time" => date('Y-m-d H:i:s'),
            "created_by" => $session_id,
            "status" => $status
        ];
        $insert_soal_id = $this->model_caseconference->simpan_soal($data);
        if (@$insert_soal_id) {
            $message['messages'] = "Berhasil Menambah Data Soal....";
            $message['status'] = "1";
        } else {
            $message['messages'] = "Gagal Mengeksekusi Query Soal";
            $message['status'] = "0";
        }
        echo json_encode($message);
    }

    // menampikan data sesuai id
    function rak_edit($id)
    {
        $this->data['role'] = $this->main_m->view('user_role')->result();
        $this->data['user'] = $this->main_m->view_where('user', ['user_id' => $id])->row();

        $this->load->view('administrator/user_update', $this->data);
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

    function user_profile_update()
    {
        //table soal
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
        $del = $this->model_caseconference->hapus_soal($id);
        if (@$del) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }
	// rak proses
}