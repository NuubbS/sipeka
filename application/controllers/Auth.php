<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function login2()
	{
		check_already_login();
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('auth/login');
		}else{
			$this->_process();
		}
	}

	public function index()
	{
		check_already_login();
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('auth/loginv2');
		}else{
			$this->_process();
		}
	}

	private function _process()
	{
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
				$this->session->set_flashdata('eror', "Periksa kembali username dan password anda !");
				$this->load->view('auth/login');
			}
		}
	}

	public function logout()
	{
		$params = array('user_id', 'level_id');
		$this->session->unset_userdata($params);
		redirect('auth');
	}
}