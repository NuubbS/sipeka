<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_m extends CI_Model
{
    public function inputPinjam($data, $type, $user_id)
    {
        $this->db->set('status_id', 2, FALSE);
        $this->db->where('user_id', $user_id);
        $this->db->update('tb_user'); // gives UPDATE mytable SET field = field+1 WHERE id = 2
        if ($type == 'tb_pinjam') {
            $this->db->insert('tb_pinjam', $data);
            return $this->db->insert_id();
        }else{
            $this->db->insert_batch('tb_detailpinjam', $data);
            return $this->db->affected_rows();
        }
    }

    public function input_pinjam($data)
    {
        $this->db->insert('tb_pinjam', $data);
        return $this->db->affected_rows();
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

    public function laporanPinjam()
    {
        $this->db->from('tb_pinjam');
        $this->db->join('tb_user', 'tb_user.user_id = tb_pinjam.user_id');
        return $this->db->get()->result_array();
    }

    public function hapus_peminjaman($id)
    {
        if (@$this->db->where('pinjam_id', $id)->delete("tb_pinjam")) {
            $this->db->join('tb_detailpinjam', 'tb_detailpinjam.pinjam_id = tb_pinjam.pinjam_id');
            // UPDATE tb_buku SET jumlah = jumlah + old.jumlah_pinjam WHERE tb_buku.buku_id = old.buku_id;
            return true;
        } else {
            return false;
        }
    }
}