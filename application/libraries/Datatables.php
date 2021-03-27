<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Datatables
{

    private $table;
    private $column_order = []; //set column field database for datatable orderable
    private $column_search = []; //set column field database for datatable searchable 
    private $order = []; // default order 
    private $join = [];
    private $where = [];
    private $ci;
    private $group = [];
    private $like = [];
    private $where_in = [];
    private $select;
    private $number = false;
    private $or_where = [];

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function add_number_first()
    {
        $this->number = true;
    }

    public function select($select)
    {
        $this->select = $select;
    }

    public function from($tables = '')
    {
        $this->table = $tables;
        return $this;
    }

    public function table($tables = '')
    {
        $this->table = $tables;
        return $this;
    }

    public function where_in($columns, $data)
    {
        $this->where_in[] = ['columns' => $columns, 'data' => $data];
    }

    public function column_order($co = [])
    {
        $this->column_order = $co;
        return $this;
    }

    public function search($cs)
    {
        $this->column_search = explode(', ', $cs);
        return $this;
    }

    public function order_by($columns, $order)
    {
        $this->order[] = ['columns' => $columns, 'order' => $order];
        return $this;
    }

    public function join($table, $where, $position = 'inner')
    {
        $this->join[] = ['table' => $table, 'where' => $where, 'position' => $position];
        return $this;
    }

    public function like($column, $string)
    {
        $this->like[] = ['column' => $column, 'string' => $string];
    }

    public function where($where, $val = '')
    {
        if (is_array($where)) {
            $this->where[] = $where;
        } else {
            $this->where[] = [$where => $val];
        }
        return $this;
    }

    public function or_where($where, $val = '')
    {
        if (is_array($where)) {
            $this->or_where[] = $where;
        } else {
            $this->or_where[] = [$where => $val];
        }
        return $this;
    }

    public function group_by($group)
    {
        $this->group[] = $group;
        return $this;
    }

    private function _get_datatables_query()
    {

        if ($this->select) $this->ci->db->select($this->select);
        if ($this->where_in) {
            $this->ci->db->group_start();
            foreach ($this->where_in as $key => $val) {
                $this->ci->db->where_in($val['columns'], $val['data']);
            }
            $this->ci->db->group_end();
        }

        // if (!$this->column_search) $this->column_search = $this->ci->db->list_fields($this->table);
        if (!$this->column_search) $this->column_search = explode(',', $this->select);
        $this->column_order = $this->column_order ?: $this->column_search;

        $this->ci->db->from($this->table);

        foreach ($this->join as $key => $var) $this->ci->db->join($var['table'], $var['where'], $var['position']);
        foreach ($this->group as $key => $var) $this->ci->db->group_by($var);
        foreach ($this->where as $key => $var) $this->ci->db->where($var);
        foreach ($this->or_where as $key => $var) $this->ci->db->or_where($var);
        foreach ($this->like as $var) $this->ci->db->like($var['column'], $var['string']);

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if (@$_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) { // first loop
                    $this->ci->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->ci->db->like($item, $_POST['search']['value']);
                } else {
                    $this->ci->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->ci->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->ci->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            foreach ($order as $key => $var) {
                $this->ci->db->order_by($var['columns'], $var['order']);
            }
        }
    }

    function get()
    {

        if (@$_POST['length']) $this->ci->db->limit($_POST['length'], $_POST['start']);
        $draw = $draw = $this->ci->input->post('start') ?: '0';
        $this->_get_datatables_query();
        $result = $this->ci->db->get()->result_array();
        $data = [];
        if ($this->number) {
            foreach ($result as $key => $value)
                $data[] = array_merge(['number' => intval($draw + ($key + 1))], $value);
        } else {
            $data = $result;
        }
        return $data;
    }

    function render($data)
    {
        $output = array(
            "draw" => (@$_POST['draw']) ?: '0',
            "recordsTotal" => $this->count_all(),
            "recordsFiltered" => $this->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function render_no_keys($array)
    {
        $data = [];
        foreach ($array as $key => $value) $data[] = array_values($value);
        $output = array(
            "draw" => (@$_POST['draw']) ?: '0',
            "recordsTotal" => $this->count_all(),
            "recordsFiltered" => $this->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function generate()
    {
        $this->_get_datatables_query();
        if (@$_POST['length']) $this->ci->db->limit($_POST['length'], $_POST['start']);
        $data = $this->ci->db->get()->result_array();
        $output = array(
            "draw" => (@$_POST['draw']) ?: '0',
            "recordsTotal" => $this->count_all(),
            "recordsFiltered" => $this->count_filtered(),
            "data" => $data,
        );
        return $output;
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->ci->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_get_datatables_query();
        $query = $this->ci->db->get();
        return $query->num_rows();
    }
}