<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Author : Ismo Broto, @ismo1106
 */

class Datatable {

    protected $_CI;
    private $db;

    public function __construct() {
        $this->_CI = &get_instance();
        $this->db = $this->_CI->load->database('default', TRUE);
    }

    private function _get_datatables_query($tabel = '', $column_order = array(), $column_filter = array(), $order = array(), $where = FALSE) {
        if($where != FALSE){
            $this->db->where($where);
        }
        $this->db->from($tabel);
        $i = 0;
        foreach ($column_filter as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($column_filter) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($tabel, $column_order, $column_filter, $order, $where) {
        $this->_get_datatables_query($tabel, $column_order, $column_filter, $order, $where);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($tabel, $column_order, $column_filter, $order, $where) {
        $this->_get_datatables_query($tabel, $column_order, $column_filter, $order, $where);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($table = '', $where = FALSE) {
        if($where != FALSE){
            $this->db->where($where);
        }
        $this->db->from($table);
        return $this->db->count_all_results();
    }

}
