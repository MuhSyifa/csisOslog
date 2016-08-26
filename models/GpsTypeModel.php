<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GpsTypeModel extends CI_Model {

    public function getData()
    {
        return $this->db->get('gps_type');
    }   

    public function getDetailData()
    {
        return $this->db->get_where('gps_type', array('gps_type_id' => $id));
    }

    public function insert_data($data)
    {
        $this->db->insert('gps_type', $data);
    }

    public function update_data($data, $id)
    {
        $this->db->update('gps_type', $data, $id);
    }

    public function delete_data($id)
    {
        $this->db->where('gps_type_id', $id);
        $this->db->delete('gps_type');
    }

}

/* End of file M_gps_condition.php */
/* Location: ./application/models/M_gps_condition.php */