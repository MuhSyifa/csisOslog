<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsersModel extends CI_Model {

	public function getData()
	{
		return $this->db->get('users');
	}

	public function getDetailData()
	{
		return $this->db->get_where('users', array('user_id' => $id));
	}

	public function insert_data($data)
	{
		$this->db->insert('users', $data);
	}

	public function update_data($data, $id)
	{
		$this->db->update('users', $data, $id);
	}

	public function delete_data($id)
	{
		$this->db->where('user_id', $id);
		$this->db->delete('users');
	}
}

/* End of file UsersModel.php */
/* Location: ./application/models/UsersModel.php */