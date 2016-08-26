<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GpsModel extends CI_Model {

    public function getGpsList()
    {
        $sql=$this->db->query("SELECT gps_id, gps_purchase_order, gps_date_check, no_purchase_order, gps_imei_number, gps_sn, gps_type_id, vendor_id, gps_cond_id, gps_stat_id, gps_received_date, gps_received_by, gps_information, gps_insert, gps_update, gps_user, 
                               (SELECT gps_type.gps_type_name AS is_gps_type FROM public.gps_type WHERE gps_type.gps_type_id = gps.gps_type_id),
                               (SELECT vendor.vendor_name AS is_vendor FROM public.vendor WHERE vendor.vendor_id = gps.vendor_id),
                               (SELECT gps_conditions.gps_cond_name AS is_gps_conditions FROM public.gps_conditions WHERE gps_conditions.gps_cond_id = gps.gps_cond_id),
                               (SELECT gps_statuses.gps_stat_name AS is_gps_statuses FROM public.gps_statuses WHERE gps_statuses.gps_stat_id = gps.gps_stat_id),
                                gps.status  FROM gps WHERE status='Received' order by gps_type_id DESC");
        return $sql;
    }

    public function getGps(){
        $sql=$this->db->query("SELECT gps.gps_id, gps.gps_purchase_order, gps.gps_imei_number, 
                                        gps.gps_sn, gps_type.gps_type_name, vendor.vendor_name, 
                                        gps_conditions.gps_cond_name, gps_statuses.gps_stat_name,
                                        gps.gps_received_date, gps.gps_received_by, gps.status, gps.gps_information, 
                                        gps.gps_insert, gps.gps_update, gps.gps_user
                                        FROM gps JOIN vendor ON gps.vendor_id=vendor.vendor_id 
                                        JOIN gps_type ON gps.gps_type_id=gps_type.gps_type_id
                                        JOIN gps_conditions ON gps.gps_cond_id=gps_conditions.gps_cond_id
                                        JOIN gps_statuses ON gps.gps_stat_id=gps_statuses.gps_stat_id
                                        WHERE status = 'Received' ");
        return $sql;
    }

    public function getGpsForPie()
    {
        $data = $this->db->query("SELECT gps_type_name, COUNT(gps_qty) gps_qty
                                    FROM gps JOIN gps_type ON gps.gps_type_id=gps_type.gps_type_id
                                    Where status = 'Received' GROUP BY gps_type_name;");
        return $data;
    }

    public function getGpsForPies()
    {
        $data = $this->db->query("SELECT gps_type.gps_type_name, 
                                    gps_conditions.gps_cond_name, gps_statuses.gps_stat_name,
                                    COUNT(gps.gps_qty) as gps_qty, gps.status
                                    FROM gps 
                                    JOIN gps_type ON gps.gps_type_id=gps_type.gps_type_id
                                    JOIN gps_conditions ON gps.gps_cond_id=gps_conditions.gps_cond_id
                                    JOIN gps_statuses ON gps.gps_stat_id=gps_statuses.gps_stat_id
                                    Where status = 'Received' 
                                    GROUP BY gps_type_name, gps_cond_name, gps_stat_name, status");
        return $data;
    }

    /* Model Crud */
    public function insert_data($data)
    {
        $this->db->insert('gps', $data);
    }
    // get data by id
    function get_by_id($id)
    {
        $this->db->where('gps_id', $id);
        return $this->db->get('gps')->row();
    }

    public function update_data($data, $id)
    {
        $this->db->update('gps', $data, $id);
    }

    public function delete_data($id)
    {
        $this->db->where('gps_id', $id);
        $this->db->delete('gps');
    }
    /* End Model Crud */

    /*  Start Import Excel */
    public function import_excel($dataexcel)
    {
        for($i=1;$i<count($dataexcel);$i++){
            $g = 'Received';
            $q = '1';
            $data = array(
                'no_purchase_order'=>$dataexcel[$i]['no_purchase_order'],
                'gps_purchase_order'=>$dataexcel[$i]['gps_purchase_order'],
                'vendor_id'=>$dataexcel[$i]['vendor_id'],
                'gps_type_id'=>$dataexcel[$i]['gps_type_id'],
                'gps_imei_number'=>$dataexcel[$i]['gps_imei_number'],
                'gps_information'=>$dataexcel[$i]['gps_information'],
                'gps_sn'=>$dataexcel[$i]['gps_sn'],
                'gps_cond_id' => '1',
                'gps_stat_id' => '1',
                'gps_received_by'=>$_SESSION['name'],
                'gps_received_date' => date('Y-m-d'),
                'status'=>$g,
                'gps_qty'=>$q
            );
            $this->db->insert('gps', $data);
        }
    }
    public function search_excel($dataexcel)
    {
        for($i=1;$i<count($dataexcel);$i++){
            $search = array(
                'gps_id');
        }
        $data = array();
        $this->db->limit(1);
        $Q = $this->db->get('gps');
        if($Q->num_rows() > 0){
        $data = $Q->row_array();
        }
        $Q->free_result();
        return $data;
    }
    /*  End Import Excel */

}

/* End of file M_gps.php */
/* Location: ./application/models/M_gps.php */