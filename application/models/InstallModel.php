<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InstallModel extends CI_Model {

	public function getInstall()
	{
		$pgsql = $this->db->query("SELECT ins_id, ins_type_number, ins_number, 
									(SELECT customer.cust_code AS is_customer FROM public.customer WHERE customer.cust_id = installs.cust_id),
									(SELECT employees.emp_name AS is_employees FROM public.employees WHERE employees.emp_id = installs.emp_id),
									ins_location, 
									(SELECT gsm.gsm_number AS is_gsm FROM public.gsm WHERE gsm.gsm_id = installs.gsm_id and gsm.status='Uninstall'),
									(SELECT gps.gps_imei_number AS is_gps FROM public.gps WHERE gps.gps_id = installs.gps_id and gps.status='Uninstall'),
									(SELECT vehicles.veh_name AS is_vehicles FROM public.vehicles WHERE vehicles.veh_id = installs.veh_id), 
									ins_date, ins_insert, ins_update, ins_user
									FROM installs where ins_status = 'Installed' Order By ins_number DESC;
								");
		return $pgsql;
	}

	public function getDetailGps()
	{
		return $this->db->get_where('gps', array('status' => 'Installed'));
	}

    public function getDetailGsm()
    {
        return $this->db->get_where('gsm', array('status' => 'Installed'));
    }
	
	public function getData()
	{
		return $this->db->get('installs');
	}
	
	public function getDetailData()
	{
		return $this->db->get_where('installs', array('ins_id' => $id));
	}

	public function insert_data($data)
	{
		$this->db->insert('installs', $data);
	}

	public function insert_vehicle($datas)
	{
		$this->db->insert('vehicles', $datas);
	}

	public function get_vehicle()
	{
		return $this->db->get('vehicles');
	}

	public function update_data($data, $id)
	{
		$this->db->update('installs', $data, $id);
	}

	public function delete_data($id)
	{
		$this->db->where('ins_id', $id);
		$this->db->delete('installs');
	}
}

/* End of file InstallModel.php */
/* Location: ./application/models/InstallModel.php */