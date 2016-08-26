<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerBusinessModel extends CI_Model {

	public function getData()
	{
		return $this->db->get('customer_business_type');
	}	

	public function getDetailData()
	{
		return $this->db->get_where('customer_business_type', array('cust_business_type_id' => $id));
	}

	public function insert_data($data)
	{
		$this->db->insert('customer_business_type', $data);
	}

	public function update_data($data, $id)
	{
		$this->db->update('customer_business_type', $data, $id);
	}

	public function delete_data($id)
	{
		$this->db->where('cust_business_type_id', $id);
		$this->db->delete('customer_business_type');
	}
}

/* End of file CustomerModel.php */
/* Location: ./application/models/CustomerModel.php */
