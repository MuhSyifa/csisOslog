<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GpsType extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper(array('url','form'));
        $this->load->library(array('form_validation','Excel_reader'));
        $this->load->model(array('GpsTypeModel','m_login'));
        $this->auth->cek_auth();
    }

    public function index()
    {
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );
        $stat = $this->session->userdata('lvl');
        if($stat==1){//superadmin
            $data['gps'] = $this->GpsTypeModel->getData();
            $data['content'] = 'superAdmin-modul/dashboard/dashboard_super';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif ($stat==2) {//admin
            $data['gps'] = $this->GpsTypeModel->getData();
            $data['content'] = 'admin-modul/dashboard_admin';
            $this->load->view('admin-modul/template', $data);
        }elseif ($stat==3) {//user
            $data['content'] = 'user-modul/dashboard/dashboard_user';
            $data['gps'] = $this->GpsTypeModel->getData();
            $this->load->view('user-modul/template',$data);
        }else { //user
            $this->session->sess_destroy();
            redirect('login','refresh');
        }   
    }

    // List
    public function gps_type_list()
    {
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );
        $stat = $this->session->userdata('lvl');
        if($stat==1){//superadmin
            $data['sql1'] = $this->GpsTypeModel->getData()->result_object();
            $data['content'] = 'superAdmin-modul/gpsType/gps_type';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif ($stat==2) {//admin
            $data['sql1'] = $this->GpsTypeModel->getData()->result_object();
            $data['content'] = 'admin-modul/gpsType/gps_type';
            $this->load->view('admin-modul/template', $data);
        }elseif ($stat==3) {//user
            $data['sql1'] = $this->GpsTypeModel->getData()->result_object();
            $data['content'] = 'user-modul/gpsType/gps_type';
            $this->load->view('user-modul/template', $data);
        }else { //user
            $this->session->sess_destroy();
            redirect('login','refresh');
        }
    }
    // End List

    /////////////////////////////////////////////////////////////////// Start Validate Form ///////////////////////////////////////////////////////////////
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('gps_type_name') == '')
        {
            $data['inputerror'][] = 'gps_type_name';
            $data['error_string'][] = 'GPS Type name is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
    /////////////////////////////////////////////////////////////////// End Validate Form ///////////////////////////////////////////////////////////////

    public function ajax_add()
    {
        $this->_validate();

        $h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');

        $data = array(
            'gps_type_name' => $this->input->post('gps_type_name'),
            'gps_type_insert' => date('Y-m-d H:i:s'),
            'gps_type_update' => date('Y-m-d H:i:s'),
            'gps_type_user' => $_SESSION['name']
            );
        $this->GpsTypeModel->insert_data($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_edit($id)
    {
        $data = $this->db->get_where('gps_type',array('gps_type_id' => $id))->row();
        echo json_encode($data);
    }

    public function ajax_update()
    {
        $this->_validate();
        
        $id = $this->input->post('id');
        
        $data = array(
                'gps_type_name' => $this->input->post('gps_type_name'),
                'gps_type_update' => date('Y-m-d H:i:s'),
                'gps_type_user' => $_SESSION['name']
            );
        
        $this->db->where('gps_type_id', $id);
        $this->db->update('gps_type', $data);
        
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->GpsTypeModel->delete_data($id);
        echo json_encode(array("status" => TRUE));
    }
    // End Update GPS Type
}