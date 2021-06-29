<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_m extends CI_Model
{

    function menu_kategori()
	{
		$this->db->select('*');
		$this->db->from('tb_kategori');
		$this->db->order_by('kategori_id', 'asc');
		return $this->db->get()->result();
	}

    public function login($post)
    {
        $this->db->select('*');
        $this->db->from('tb_user');
        $this->db->where('email', $post['email']);
        $this->db->where('password', sha1($post['password']));
        $query = $this->db->get();
        return $query;
    }
    
    public function get($id = null)
    {
        $this->db->from('tb_user');
        if($id != null){
            $this->db->where('user_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function data_peminjam($peminjam, $column)
    {
        $this->db->select('*');
        $this->db->limit('5');
        $this->db->from('tb_user');
        $this->db->like('nama', $peminjam);
        return $this->db->get()->result_array();
    }
}