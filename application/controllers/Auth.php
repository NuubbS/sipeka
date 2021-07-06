<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function index()
	{
		check_already_login();
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == false) {
			// $this->session->set_flashdata('eror', "Periksa kembali username dan password anda !");
			$this->load->view('auth/loginv2');
		}else{
			// $this->_process();
			$post = $this->input->post(null,TRUE);
		if(isset($post['login'])) {
			$this->load->model('user_m');
			$query = $this->user_m->login($post);
			if($query->num_rows() > 0) {
				$row = $query->row();
				$params = array(
					'user_id' => $row->user_id,
					'level_id' => $row->level_id
				);
				if($params['level_id'] != 1){
					$this->session->set_userdata($params);
					redirect('member/profil');
				}else{
					$this->session->set_userdata($params);
				redirect('administrator');
				}
			} else {
				$this->session->set_flashdata('eror', 'anjay');
                redirect('auth');
			}
		}
		$this->session->set_flashdata('eror', 'anjay');
		redirect('auth');
		}
	}
	
	public function logout()
	{
		$params = array('user_id', 'level_id');
		$this->session->unset_userdata($params);
		$this->session->set_flashdata('warning', 'anjay');
		redirect('auth');
	}

	public function register()
	{
		$this->load->model('administrator_m');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[tb_user.email]');
		$this->form_validation->set_rules('password', 'password', 'required|min_length[5]');
        $this->form_validation->set_rules('passwordconfig', 'Konfirmasi Password', 'matches[password]',
        array('matches' => '%s tidak sesuai dengan password!')
    );
	$this->form_validation->set_rules('alamat', 'Alamat', 'required');
	$this->form_validation->set_rules('no_handphone', 'No Handohone', 'required');
	// custom pesan
	$this->form_validation->set_message('required', 'Harap masukkan %s !');
	$this->form_validation->set_message('min_length', 'minimal %s 5 
	digit!');
	$this->form_validation->set_message('email', 'Harap masukkan %s !');
		if ($this->form_validation->run() == false) {
			$this->load->view('auth/register');
		}else{
			$email = $this->input->post('email');
			$password = sha1($this->input->post('password'));
			$nama = $this->input->post('nama');
			$alamat = $this->input->post('alamat');
			$no_handphone = $this->input->post('no_handphone');
			
			$data = [
				"email" => $email,
				"password" => $password,
				"nama" => $nama,
				"alamat" => $alamat,
				"no_handphone" => $no_handphone,
				"level_id" => 2,
				"status_id" => 1 #bisa pinjam buku
			];
			// var_dump($data);
			// die;
			$this->administrator_m->simpan_member($data);
			$this->session->set_flashdata('sukses', "Data Berhasil Ditambahkan");
			redirect('auth');
		}
	}
}