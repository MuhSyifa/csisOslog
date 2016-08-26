<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DepartmentModel extends CI_Model {

	public function getData()
	{
		return $this->db->get('employees_department');
	}	

	public function getDetailData()
	{
		return $this->db->get_where('department', array('dep_id' => $id));
	}

	public function insert_data($data)
	{
		$this->db->insert('employees_department', $data);
	}

	public function update_data($data, $id)
	{
		$this->db->update('employees_department', $data, $id);
	}

	public function delete_data($id)
	{
		$this->db->where('dep_id', $id);
		$this->db->delete('employees_department');
	}

	/*  Start Import Excel */
	public function import_excel($dataarray)
    {
        for($i=1;$i<count($dataarray);$i++){
            $h = $_SESSION['uname'];
            $i = date('Y-m-d H:i:s');
            $data = array(
                'dep_name'=>$dataarray[$i]['dep_name'],
                'dep_insert' => $i,
                'dep_update' => $i,
                'dep_user' => $h
            );
            $this->db->insert('department', $data);
        }
    }
    public function search_excel($dataarray){
        for($i=1;$i<count($dataarray);$i++){
            $search = array(
                'dep_id');
        }
        $data = array();
        $this->db->limit(1);
        $Q = $this->db->get('department');
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