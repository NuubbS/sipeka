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
}