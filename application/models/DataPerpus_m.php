<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataPerpus_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function hapus_rak($id)
    {
        if (@$this->db->where('rak_id', $id)->delete("tb_rak")) {
            return true;
        } else {
            return false;
        }
    }
    
    // public function hapus_rak($id)
    // {
    //     if (@$this->db->set('keterangan_id', 3)->where('user_id', $id)->delete("user_crud")) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function update_rak($rak_id, $data)
    {
        if (@$this->db->where('rak_id', $rak_id)->update('tb_rak', $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function simpan_rak($data)
    {
        if ($this->db->insert("tb_rak", $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    // prodi
    public function simpan_prodi($data)
    {
        if ($this->db->insert("tb_prodi", $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function hapus_prodi($id)
    {
        if (@$this->db->where('prodi_id', $id)->delete("tb_prodi")) {
            return true;
        } else {
            return false;
        }
    }

    public function update_prodi($prodi_id, $data)
    {
        if (@$this->db->where('prodi_id', $prodi_id)->update('tb_prodi', $data)) {
            return true;
        } else {
            return false;
        }
    }
}