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

    public function konfirmasiPengembalian($pinjam_id, $data, $type)
    {
        if ($type == 'tb_pinjam') {
            $this->db->where('pinjam_id', $pinjam_id)->update('tb_pinjam', $data);
        }else{
            $this->db->where('pinjam_id', $pinjam_id)->update('tb_detailpinjam', $data);
            // return $this->db->affected_rows();
        }
    }
}