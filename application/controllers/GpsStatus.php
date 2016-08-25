<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GpsStatus extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('form_validation', 'Excel_reader'));
        $this->load->model(array('GpsStatusModel', 'm_login'));
        $this->auth->cek_auth();
    }

    public function index()
    {
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['content'] = 'superAdmin-modul/dashboard_admin';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['content'] = 'admin-modul/dashboard_admin';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['content'] = 'user-modul/dashboard/dashboard_user';
            $this->load->view('user-modul/template',$data);
        }
        
    }

    /*Start View Vendor */
    public function GpsStatus_list()
    {
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['data']    = $this->GpsStatusModel->tampil()->result_object();
            $data['content'] = 'superAdmin-modul/gpsStatus/gpsStatus';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['data']    = $this->GpsStatusModel->tampil()->result_object();
            $data['content'] = 'admin-modul/gpsStatus/gpsStatus';
            $this->load->view('admin-modul/template',$data);
        }elseif($stat==3){
            $data['data']    = $this->GpsStatusModel->tampil()->result_object();
            $data['content'] = 'user-modul/gpsStatus/gpsStatus';
            $this->load->view('user-modul/template',$data);
        }else{ //user
            $this->session->sess_destroy();
            redirect('login','refresh');
        }
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('gps_stat_name') == '')
        {
            $data['inputerror'][] = 'gps_stat_name';
            $data['error_string'][] = 'GPS Status name is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    public function ajax_add()
    {
        $this->_validate();

        $data = array(
            'gps_stat_name' => $this->input->post('gps_stat_name'),
            'gps_stat_insert' => date('Y-m-d H:i:s'),
            'gps_stat_update' => date('Y-m-d H:i:s'),
            'gps_stat_user' => $_SESSION['name']
            );
        $this->GpsStatusModel->insert_data($data);

        echo json_encode(array("status" => TRUE));
    }
    /*End Add Vendor */

    /*Start Update Vendor */
    public function ajax_edit($id)
    {
        $data = $this->db->get_where('gps_statuses',array('gps_stat_id' => $id))->row();
        echo json_encode($data);
    }

    public function ajax_update()
    {
        $this->_validate();
        
        $id = $this->input->post('id');
        
        $data = array(
                'gps_stat_name' => $this->input->post('gps_stat_name'),
                'gps_stat_update' => date('Y-m-d H:i:s'),
                'gps_stat_user' => $_SESSION['name']
            );
        
        $this->db->where('gps_stat_id', $id);
        $this->db->update('gps_statuses', $data);

        echo json_encode(array("status" => TRUE));
    }

    /*Start Delete Vendor */
    public function ajax_delete($id)
    {
        $this->GpsStatusModel->delete($id);
        echo json_encode(array("status" => TRUE));
    }
    /*End Delete Vendor */

}