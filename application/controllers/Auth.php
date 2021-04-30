<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function index()
	{
		check_already_login();
		$this->load->view('auth/login');
	}

	public function process()
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
				$this->session->set_userdata($params);
				echo "<script>
						alert('Selamat, login berhasil');
						window.location='".site_url('pages/dashboard')."';
					</script>";
			} else {
				echo "<script>
						alert('Login gagal, username / password salah');
						window.location='".site_url('auth')."';
					</script>";
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