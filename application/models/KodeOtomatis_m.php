<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KodeOtomatis_m extends CI_Model
{
    function getMax($table = null, $field = null)
    {
        $this->db->select_max($field);
        return $this->db->get($table)->row_array()[$field];
    }

    function getMax_Today($prefix = null, $table = null, $field = null)
    {
        $this->db->select('kode_transaksi');
        $this->db->like($field, $prefix, 'after');
        $this->db->order_by($field, 'desc');
        $this->db->limit(1);
        
            return $this->db->get($table)->row_array()[$field];
        // if ($this->db->get($table)->row_array()) {
        //     return $this->db->get($table)->row_array();
        // }else{
        //     return $this->db->get($table)->row();
        // }
    }

    function kodeT()
    {
        $query = $this->db->query("SELECT MAX(MID(kode_transaksi, 9, 4)) AS kodeT FROM tb_pinjam WHERE MID(kode_transaksi, 3, 6) = DATE_FORMAT(CURDATE(), '%y%m%d')");
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $n = ((int)$row->kodeT) + 1;
            $no = sprintf("%'.04d", $n);
        }else{
            $no = "0001";
        }
        $KT = "PK".date('ymd').$no;
        return $KT;
    }
}