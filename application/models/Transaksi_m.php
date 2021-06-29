<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_m extends CI_Model
{
    public function inputPinjam($data, $type)
    {
        if ($type == 'tb_pinjam') {
            $this->db->insert('tb_pinjam', $data);
            return $this->db->insert_id();
        }else{
            $this->db->insert_batch('tb_detailpinjam', $data);
            return $this->db->affected_rows();
        }
    }
}