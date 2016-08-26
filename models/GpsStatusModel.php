<?php

class GpsStatusModel extends CI_model
{
	
	public function index()
	{

	}
	public function tampil()
	{
		return $this->db->get('gps_statuses');
	}
	public function delete($param)
	{
		return $this->db->delete('gps_statuses',array('gps_stat_id'=>$param));
	}
	public function insert_data($data)
	{
		$this->db->insert('gps_statuses', $data);
	}
	
}
?>