<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_model extends CI_Model {

	public function all()
	{
		$result = $this->db->get('images');
		return $result;
	}

	public function find($id)
	{
		$row = $this->db->where('id',$id)->limit(1)->get('images');
		return $row;
	}

	public function create($data)
	{
		try{
			$this->db->insert('images', $data);
			return true;
		}catch(Exception $e){
			return $e;
		}
	}

	public function update($id, $data)
	{
		try{
			$this->db->where('id',$id)->limit(1)->update('images', $data);
			return true;
		}catch(Exception $e){
			return $e;
		}
	}

	public function delete($id)
	{
		try {
			$this->db->where('id',$id)->delete('images');
			return true;
		}

		//catch exception
		catch(Exception $e) {
		  echo $e->getMessage();
		}
	}

}