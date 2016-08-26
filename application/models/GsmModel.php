<?php

class GsmModel extends CI_model
{
	
	//var $table = 'gsm';

    public function index()
	{

	}

    public function activeDashboard()
    {
        $data = $this->db->query("SELECT gsm_number, gsm_imsi_number, gsm_iccid_number, vendor_id, gsm_cond_id, 
                                gsm_received_date, gsm_received_by, status, count(gsm_number) AS stock 
                                FROM gsm WHERE status='Received' AND gsm_cond_id=2
                                GROUP BY gsm_number, gsm_imsi_number, gsm_iccid_number, gsm_cond_id, vendor_id, gsm_received_date, gsm_received_by, status");
        return $data;
    }

     public function nonactiveDashboard()
    {
        $data = $this->db->query("SELECT gsm_number, gsm_imsi_number, gsm_iccid_number, vendor_id, gsm_cond_id, 
                                gsm_received_date, gsm_received_by, status, count(gsm_number) AS stock 
                                FROM gsm WHERE status='Received' AND gsm_cond_id=3
                                GROUP BY gsm_number, gsm_imsi_number, gsm_iccid_number, gsm_cond_id, vendor_id, gsm_received_date, gsm_received_by, status");
        return $data;
    }

    public function getGsmForPies()
    {
        $data = $this->db->query("SELECT vendor.vendor_name, vendor.vendor_type, 
                                    gsm_conditions.gsm_cond_id, gsm_conditions.gsm_cond_name, 
                                    COUNT(gsm.gsm_number) 
                                    FROM gsm 
                                    JOIN vendor ON gsm.vendor_id=vendor.vendor_id
                                    JOIN gsm_conditions ON gsm.gsm_cond_id=gsm_conditions.gsm_cond_id
                                    Where status = 'Received' 
                                    GROUP BY gsm_number, gsm_imsi_number, gsm_iccid_number, gsm_cond_name, vendor_id, status");
        return $data;
    }

	/* Start view GSM Received */
    public function tampil()
	{
		$sql=$this->db->query("SELECT gsm_id, gsm_number, gsm_imsi_number, gsm_iccid_number, vendor_id, gsm_received_date, gsm_received_by, (SELECT vendor.vendor_name AS is_vendor FROM public.vendor WHERE vendor.vendor_id = gsm.vendor_id), gsm.status  FROM gsm WHERE status='Received' order by gsm_id");
		return $sql;
	}

    //public function get_by_id($id)
    //{
    //    $this->db->from($this->table);
    //    $this->db->where('gsm_id',$id);
    //    $query = $this->db->get();

    //    return $query->row();
    //}
    /* End view GSM Received */

    public function delete($param)
    {
        return $this->db->delete('gsm',array('gsm_id'=>$param));
    }

    /* Start view GSM Active */
	public function gsmActive(){
		
		$sql=$this->db->query("SELECT gsm.gsm_id, gsm.gsm_number, gsm.gsm_imsi_number, gsm.gsm_iccid_number, vendor.vendor_name, 
                            gsm.gsm_received_by, gsm.gsm_received_date, gsm.gsm_activated_date, gsm.gsm_activated_by, gsm.gsm_install_date,
                            gsm.gsm_install_by, gsm.gsm_uninstall_date, gsm.gsm_uninstall_by, gsm.gsm_disable_date, gsm.gsm_disable_by, 
                            gsm.status FROM gsm JOIN vendor ON gsm.vendor_id=vendor.vendor_id WHERE status = 'Activated' ");
		return $sql;

	}

    public function gsmActiveDashboard()
    {
        $data = $this->db->query("SELECT gsm_number, gsm_imsi_number, gsm_iccid_number, vendor_id, gsm_cond_id, 
                                gsm_received_date, gsm_received_by, status, count(gsm_number) AS stock 
                                FROM gsm WHERE status='Activated' AND gsm_cond_id=2
                                GROUP BY gsm_number, gsm_imsi_number, gsm_iccid_number, gsm_cond_id, vendor_id, gsm_received_date, gsm_received_by, status");
        return $data;
    }

     public function gsmNonactiveDashboard()
    {
        $data = $this->db->query("SELECT gsm_number, gsm_imsi_number, gsm_iccid_number, vendor_id, gsm_cond_id, 
                                gsm_received_date, gsm_received_by, status, count(gsm_number) AS stock 
                                FROM gsm WHERE status='Activated' AND gsm_cond_id=3
                                GROUP BY gsm_number, gsm_imsi_number, gsm_iccid_number, gsm_cond_id, vendor_id, gsm_received_date, gsm_received_by, status");
        return $data;
    }
    /* End view GSM Active */
	
	/* Start view GSM Disable */
    public function gsmDisable(){
		
		$sql=$this->db->query("SELECT gsm.gsm_id, gsm.gsm_number, gsm.gsm_imsi_number, gsm.gsm_iccid_number, vendor.vendor_name,
                            gsm.gsm_received_by, gsm.gsm_received_date, gsm.gsm_activated_date, gsm.gsm_activated_by, gsm.gsm_install_date,
                            gsm.gsm_install_by, gsm.gsm_uninstall_date, gsm.gsm_uninstall_by, gsm.gsm_disable_date, gsm.gsm_disable_by, 
                            gsm.status FROM gsm JOIN vendor ON gsm.vendor_id=vendor.vendor_id WHERE status = 'Disable'");
		return $sql;

	}

    public function disableActiveDashboard()
    {
        $data = $this->db->query("SELECT gsm_number, gsm_imsi_number, gsm_iccid_number, vendor_id, gsm_cond_id, 
                                gsm_received_date, gsm_received_by, status, count(gsm_number) AS stock 
                                FROM gsm WHERE status='Disable' AND gsm_cond_id=2
                                GROUP BY gsm_number, gsm_imsi_number, gsm_iccid_number, gsm_cond_id, vendor_id, gsm_received_date, gsm_received_by, status");
        return $data;
    }

     public function disableNonactiveDashboard()
    {
        $data = $this->db->query("SELECT gsm_number, gsm_imsi_number, gsm_iccid_number, vendor_id, gsm_cond_id, 
                                gsm_received_date, gsm_received_by, status, count(gsm_number) AS stock 
                                FROM gsm WHERE status='Disable' AND gsm_cond_id=3
                                GROUP BY gsm_number, gsm_imsi_number, gsm_iccid_number, gsm_cond_id, vendor_id, gsm_received_date, gsm_received_by, status");
        return $data;
    }
    /* Start view GSM Disable */

	/* Start insert GSM */
    public function insert_data($data)
    {
        $this->db->insert('gsm', $data);
    }

    public function insert()
	{
		$a = $this->input->post('gsm_number');
		$b = $this->input->post('gsm_imsi_number');
		$c = $this->input->post('gsm_iccid_number');
		$d = $this->input->post('vendor_id');
        $j = $this->input->post('gsm_cond_id');
		$e = $this->input->post('gsm_received_date');
		$f = $this->input->post('gsm_received_by');
		$g = 'Received';
        $h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');

		$object = array(
			'gsm_number' => $a,
			'gsm_imsi_number' => $b,
			'gsm_iccid_number' => $c,
			'vendor_id' => $d,
            'gsm_cond_id' => $j,
			'gsm_received_date' => $e,
			'gsm_received_by' => $f,
			'status' => $g,
            'gsm_insert' => $i,
            'gsm_update' => $i,
            'gsm_user' => $h
				 );
		return $this->db->insert('gsm', $object);
	}
	/* End insert GSM */

	/*  Start Import Excel */
	public function import_excel($dataexcel)
    {
        for($i=1;$i<count($dataexcel);$i++){
            $data = array(
                'gsm_number'=>$dataexcel[$i]['gsm_number'],
                'gsm_imsi_number'=>$dataexcel[$i]['gsm_imsi_number'],
                'gsm_iccid_number'=>$dataexcel[$i]['gsm_iccid_number'],
                'vendor_id'=>'3',
                'gsm_received_by'=>$_SESSION['uname'],
                'gsm_received_date' => date('Y-m-d'),
                'status'=>'received'
            );
            $this->db->insert('gsm', $data);
        }
    }
    
    public function search_excel($dataexcel){
        for($i=1;$i<count($dataexcel);$i++){
            $search = array(
                'gsm_id');
        }
        $data = array();
        $this->db->limit(1);
        $Q = $this->db->get('gsm');
        if($Q->num_rows() > 0){
        $data = $Q->row_array();
        }
        $Q->free_result();
        return $data;
    }
    /*  End Import Excel */
}
?>