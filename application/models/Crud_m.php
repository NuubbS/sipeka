<?php 
Class Crud_m extends CI_Model
{
    function tampil($table)
    {
        return $this->db->get($table);
    }

    function tambah($table, $field)
    {
        return $this->db->insert($table,$field);
    }

    function tampil_id($table, $id)
    {
        return $this->db->get_where($table,$id);
    }

    function tampil_stock($table, $id, $field)
    {
        return $this->db->get_where($table, $id, $field);
    }

    function edit($table, $field, $id)
    {
        $this->db->where($id);
        return $this->db->update($table, $field);
    }

    function hapus($table, $id)
    {
        return $this->db->delete($table, $id);
    }

    function tampil_order($field, $table, $order)
    {
        $this->db->order_by($field,$order);
        return $this->db->get($table);
    }

    function tampil_join($table, $tablejoin,$join, $where)
    {
        $this->db->join($tablejoin, $join);
        $this->db->where($where);
        return $this->db->get($table);
    }

    function join($table, $tablejoin , $join)
    {
        $this->db->join($tablejoin, $join);
        return $this->db->get($table);
    }


    function total($table,$total,$where)
    {
        $this->db->select('SUM('.$total.') as total');
        $this->db->where($where);
        return $this->db->get($table);
    }
}
?>