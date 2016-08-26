<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PositionModel extends CI_Model {

	public function getData()
	{
		return $this->db->get('employees_position');
	}	

	public function getDetailData()
	{
		return $this->db->get_where('position', array('pos_id' => $id));
	}

	public function insert_data($data)
	{
		$this->db->insert('employees_position', $data);
	}

	public function update_data($data, $id)
	{
		$this->db->update('position', $data, $id);
	}

	public function delete_data($id)
	{
		$this->db->where('pos_id', $id);
		$this->db->delete('employees_position');
	}

	/*  Start Import Excel */
	public function import_excel($dataarray)
    {
        for($i=1;$i<count($dataarray);$i++){
            $h = $_SESSION['uname'];
            $i = date('Y-m-d H:i:s');
            $data = array(
                'pos_name'=>$dataarray[$i]['pos_name'],
                'pos_insert' => $i,
                'pos_update' => $i,
                'po_user' => $h
            );
            $this->db->insert('position', $data);
        }
    }
    public function search_excel($dataarray){
        for($i=1;$i<count($dataarray);$i++){
            $search = array(
                'pos_id');
        }
        $data = array();
        $this->db->limit(1);
        $Q = $this->db->get('position');
        if($Q->num_rows() > 0){
        $data = $Q->row_array();
        }
        $Q->free_result();
        return $data;
    }
    /*  End Import Excel */
}

/* End of file CustomerModel.php */
/* Location: ./application/models/CustomerModel.php */