<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VehicleModel extends CI_Model {

	public function getData()
    {
        $vehi = $this->db->query("SELECT veh_id, veh_name, veh_number_police, veh_number_flank, veh_install_date, veh_uninstall_date, veh_status, veh_qty, veh_insert, veh_update, veh_user FROM vehicles WHERE veh_status = 'Installed' ORDER BY veh_status DESC");
        return $vehi;
    }

    public function getDataUn()
    {
        $vehi = $this->db->query("SELECT veh_id, veh_name, veh_number_police, veh_number_flank, veh_install_date, veh_uninstall_date, veh_status, veh_qty, veh_insert, veh_update, veh_user FROM vehicles WHERE veh_status = 'Uninstalled' ORDER BY veh_status DESC");
        return $vehi;
    }	

	public function getDetailData()
	{
		return $this->db->get_where('vehicles', array('veh_id' => $id));
	}

	public function insert_data($data)
	{
		$this->db->insert('vehicles', $data);
	}

	public function update_data($data, $id)
	{
		$this->db->update('vehicles', $data, $id);
	}

	public function delete_data($id)
	{
		$this->db->where('veh_id', $id);
		$this->db->delete('vehicles');
	}

	/*  Start Import Excel */
	public function import_excel($dataarray)
    {
        for($i=1;$i<count($dataarray);$i++){
            $h = $_SESSION['uname'];
            $i = date('Y-m-d H:i:s');
            $data = array(
                'veh_name'=>$dataarray[$i]['veh_name'],
                'veh_type'=>$dataarray[$i]['veh_type'],
                'veh_insert' => $i,
                'veh_update' => $i,
                'veh_user' => $h
            );
            $this->db->insert('vehicles', $data);
        }
    }
    public function search_excel($dataarray){
        for($i=1;$i<count($dataarray);$i++){
            $search = array(
                'veh_id');
        }
        $data = array();
        $this->db->limit(1);
        $Q = $this->db->get('vehicles');
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