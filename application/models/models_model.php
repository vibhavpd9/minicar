<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Models_model extends CI_Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function record_manufacturer_count()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('manufacturer');
        $this->db->save_queries = false;

        return $query->num_rows();
    }

    public function fetch_manufacturer_data($limit, $start)
    {
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('manufacturer');

        $result = $query->result();

        $this->db->save_queries = false;

        return $result;
    }

    public function record_models_count()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('models');
        $this->db->save_queries = false;

        return $query->num_rows();
    }

    public function fetch_models_data($limit, $start)
    {
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('models');

        $result = $query->result();

        $this->db->save_queries = false;

        return $result;
    }

    public function record_label_count()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('models');
        $this->db->save_queries = false;

        return $query->num_rows();
    }

    public function fetch_label_data($limit, $start)
    {
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('models');

        $result = $query->result();

        $this->db->save_queries = false;

        return $result;
    }
}
