<?php

class GpsConditionModel extends CI_model
{
	
	public function index()
	{

	}
	public function tampil()
	{
		return $this->db->get('gps_conditions');
	}
	public function delete($param)
	{
		return $this->db->delete('gps_conditions',array('gps_cond_id'=>$param));
	}
	public function insert_data($data)
	{
		$this->db->insert('gps_conditions', $data);
	}
	
}
?>