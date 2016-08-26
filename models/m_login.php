<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class m_login extends CI_Model{
	function __construct()
	{
		parent::__construct();
		$this->tbl = "users";
	}

	function cek_user($username="",$password="")
	{
		$query = $this->db->get_where($this->tbl,array('user_username' => $username, 'user_password' => $password));
		$query = $query->result_array();
		return $query;
	}
	function ambil_user($username)
    {
        $query = $this->db->get_where($this->tbl, array('user_username' => $username));
        $query = $query->result_array();
        if($query){
            return $query[0];
        }
    }
}