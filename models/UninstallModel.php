<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UninstallModel extends CI_Model {

	public function getData()
	{
		return $this->db->get('department');
	}	

	public function getDetailData()
	{
		return $this->db->get_where('gps', array('status' => 'Uninstall'));
	}

    public function getGpsList()
    {
        $sql=$this->db->query("SELECT gps_id, no_purchase_order, gps_purchase_order, gps_imei_number, gps_sn, gps_type_id, vendor_id, gps_cond_id, gps_stat_id, gps_received_date, gps_received_by, gps_uninstall_date, gps_uninstall_by, gps_information, gps_insert, gps_update, gps_user, 
                               (SELECT gps_type.gps_type_name AS is_gps_type FROM public.gps_type WHERE gps_type.gps_type_id = gps.gps_type_id),
                               (SELECT vendor.vendor_name AS is_vendor FROM public.vendor WHERE vendor.vendor_id = gps.vendor_id),
                               (SELECT gps_conditions.gps_cond_name AS is_gps_conditions FROM public.gps_conditions WHERE gps_conditions.gps_cond_id = gps.gps_cond_id),
                               (SELECT gps_statuses.gps_stat_name AS is_gps_statuses FROM public.gps_statuses WHERE gps_statuses.gps_stat_id = gps.gps_stat_id),
                                gps.status  FROM gps WHERE status='Uninstall' order by gps_type_id DESC");
        return $sql;
    }

    public function getGsmList()
    {
        $sql=$this->db->query("SELECT gsm_id, gsm_number, gsm_imsi_number, gsm_iccid_number, vendor_id, gsm_uninstall_date, gsm_uninstall_by, gsm_received_date, gsm_received_by, (SELECT vendor.vendor_name AS is_vendor FROM public.vendor WHERE vendor.vendor_id = gsm.vendor_id), gsm.status  FROM gsm WHERE status='Uninstall' order by gsm_id");
        return $sql;
    }

    public function getDetailGsm()
    {
        return $this->db->get_where('gsm', array('status' => 'Uninstall'));
    }

	public function insert_data($data)
	{
		$this->db->insert('department', $data);
	}

	public function update_data($data, $id)
	{
		$this->db->update('department', $data, $id);
	}

	public function delete_data($id)
	{
		$this->db->where('dep_id', $id);
		$this->db->delete('department');
	}

	/*  Start Import Excel */
	public function import_excel($dataarray)
    {
        for($i=1;$i<count($dataarray);$i++){
            $h = $_SESSION['uname'];
            $i = date('Y-m-d H:i:s');
            $data = array(
                'dep_name'=>$dataarray[$i]['dep_name'],
                'dep_insert' => $i,
                'dep_update' => $i,
                'dep_user' => $h
            );
            $this->db->insert('department', $data);
        }
    }
    public function search_excel($dataarray){
        for($i=1;$i<count($dataarray);$i++){
            $search = array(
                'dep_id');
        }
        $data = array();
        $this->db->limit(1);
        $Q = $this->db->get('department');
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