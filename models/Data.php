<?php

/*
 * ***************************************************************
 * Script : 
 * Version : 
 * Date :
 * Author : Pudyasto Adi W.
 * Email : mr.pudyasto@gmail.com
 * Description : 
 * ***************************************************************
 */

/**
 * Description of Data
 *
 * @author Pudyasto
 */
class Data extends CI_Model {
    //put your code here
    function __construct(){
        parent::__construct();
    }
    
    function select_data($param) {
        if(!empty($param)){
            $this->db->where('gsm_id',$param);
        }
        $query = $this->db->get('gsm');
        return $query->result();
    }
}