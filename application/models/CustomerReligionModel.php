<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerReligionModel extends CI_Model {

	public function getData()
	{
		return $this->db->get('customer_religion');
	}	

	public function getDetailData()
	{
		return $this->db->get_where('customer_religion', array('cust_religion_id' => $id));
	}

	public function insert_data($data)
	{
		$this->db->insert('customer_religion', $data);
	}

	public function update_data($data, $id)
	{
		$this->db->update('customer_religion', $data, $id);
	}

	public function delete_data($id)
	{
		$this->db->where('cust_religion_id', $id);
		$this->db->delete('customer_religion');
	}
}

/* End of file CustomerModel.php */
/* Location: ./application/models/CustomerModel.php */