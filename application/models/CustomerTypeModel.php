<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerTypeModel extends CI_Model {

	public function getData()
	{
		return $this->db->get('customer_type');
	}	

	public function getDetailData()
	{
		return $this->db->get_where('customer_type', array('cust_type_id' => $id));
	}

	public function insert_data($data)
	{
		$this->db->insert('customer_type', $data);
	}

	public function update_data($data, $id)
	{
		$this->db->update('customer_type', $data, $id);
	}

	public function delete_data($id)
	{
		$this->db->where('cust_type_id', $id);
		$this->db->delete('customer_type');
	}
}

/* End of file CustomerModel.php */
/* Location: ./application/models/CustomerModel.php */