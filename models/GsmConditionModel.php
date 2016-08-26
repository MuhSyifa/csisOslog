<?php

class GsmConditionModel extends CI_model
{
	
	public function index()
	{

	}
	public function tampil()
	{
		return $this->db->get('gsm_conditions');
	}
	public function delete($param)
	{
		return $this->db->delete('gsm_conditions',array('gsm_cond_id'=>$param));
	}
	public function insert_data($data)
	{
		$this->db->insert('gsm_conditions', $data);
	}
	
}
?>