<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function index()
	{
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
					'userid' => $row->user_id,
					'level' => $row->level
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
}
