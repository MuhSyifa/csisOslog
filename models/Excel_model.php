<?php
class Excel_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function insert_chapter($dataarray)
    {
        for($i=1;$i<count($dataarray);$i++){
            $g = 'received';
            $data = array(
                'gsm_number'=>$dataarray[$i]['gsm_number'],
                'gsm_imsi_number'=>$dataarray[$i]['gsm_imsi_number'],
                'gsm_iccid_number'=>$dataarray[$i]['gsm_iccid_number'],
                'gsm_received_by'=>$dataarray[$i]['gsm_received_by'],
                'gsm_received_date' => date('Y-m-d'),
                'status'=>$g
            );
            $this->db->insert('gsm', $data);
        }
    }
    public function update_chapter($dataarray)
    {
        for($i=1;$i<count($dataarray);$i++){
            $data = array(
                'gsm_number'=>$dataarray[$i]['gsm_number'],
                'gsm_imsi_number'=>$dataarray[$i]['gsm_imsi_number'],
                'gsm_iccid_number'=>$dataarray[$i]['gsm_iccid_number'],
                'gsm_received_by'=>$dataarray[$i]['gsm_received_by'],
                'gsm_received_date' => date('Y-m-d', now())
            );
            $param = array(
               'gsm_number'=>$dataarray[$i]['gsm_number']
            );
            $this->db->where($param);
           return $this->db->update('gsm',$data);   
        }
    }
    public function search_chapter($dataarray){
        for($i=1;$i<count($dataarray);$i++){
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
}
?>