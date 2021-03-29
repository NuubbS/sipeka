<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KodeOtomatis_m extends CI_Model
{
    function getMax($table = null, $field = null)
    {
        $this->db->select_max($field);
        return $this->db->get($table)->row_array()[$field];
    }
}