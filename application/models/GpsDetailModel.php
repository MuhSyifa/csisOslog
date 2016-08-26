<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GpsDetailModel extends CI_Model {

    public function getData()
    {
        return $this->db->get('gps_details');
    }

    public function getDetails()
    {
        $getDet = $this->db->query('SELECT gps_details.gps_det_id, gps_type.gps_type_name, gps.gps_imei_number,
                                    gps_conditions.gps_cond_name, gps_statuses.gps_stat_name, gps_details.gps_det_qty as gps_det_qty, (gps_details.gps_det_qty - gps_qty) as gps_stock, gps_det_insert, gps_det_update, gps_det_user
                                    FROM gps_details
                                    JOIN gps ON gps_details.gps_id = gps.gps_id
                                    JOIN gps_type ON gps_details.gps_type_id = gps_type.gps_type_id
                                    JOIN gps_conditions ON gps_details.gps_cond_id = gps_conditions.gps_cond_id
                                    JOIN gps_statuses ON gps_details.gps_stat_id = gps_statuses.gps_stat_id');
        return $getDet;
    }
    public function getDetail()
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

    public function getDetailInstall()
    {
        $data = $this->db->query("SELECT gps_type.gps_type_name, gps_conditions.gps_cond_name, gps_statuses.gps_stat_name, COUNT(gps.gps_qty) as gps_qty, gps.status FROM gps JOIN gps_type ON gps.gps_type_id=gps_type.gps_type_id JOIN gps_conditions ON gps.gps_cond_id=gps_conditions.gps_cond_id JOIN gps_statuses ON gps.gps_stat_id=gps_statuses.gps_stat_id WHERE status = 'Installed' GROUP BY gps_type_name, gps_cond_name, gps_stat_name, status");
        return $data;
    }

    public function getDetailUninstall()
    {
        $data = $this->db->query("SELECT gps_type.gps_type_name, gps_conditions.gps_cond_name, gps_statuses.gps_stat_name, COUNT(gps.gps_qty) as gps_qty, gps.status FROM gps JOIN gps_type ON gps.gps_type_id=gps_type.gps_type_id JOIN gps_conditions ON gps.gps_cond_id=gps_conditions.gps_cond_id JOIN gps_statuses ON gps.gps_stat_id=gps_statuses.gps_stat_id WHERE status = 'Uninstall' GROUP BY gps_type_name, gps_cond_name, gps_stat_name, status");
        return $data;
    }

    public function getDetailData()
    {
        return $this->db->get_where('gps_details', array('gps_det_id' => $id));
    }

    public function insert_data($data)
    {
        $this->db->insert('gps_details', $data);
    }

    public function update_data($data, $id)
    {
        $this->db->update('gps_details', $data, $id);
    }

    public function delete_data($id)
    {
        $this->db->where('gps_det_id', $id);
        $this->db->delete('gps_details');
    }   

}