<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GsmCondition extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('form_validation', 'Excel_reader'));
        $this->load->model(array('GsmConditionModel', 'm_login'));
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
        }elseif($stat==3){
            $data['content'] = 'user-modul/dashboard/dashboard_user';
            $this->load->view('user-modul/template',$data);
        }else{ //user
            $this->session->sess_destroy();
            redirect('login','refresh');
        }    
    }

    /////////////////////////////////////////////////////////////////// Start List Data GSM Condition ///////////////////////////////////////////////////////////////
    public function GsmCondition_list()
    {
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['data']    = $this->GsmConditionModel->tampil()->result_object();
            $data['content'] = 'superAdmin-modul/gsmCondition/gsmCondition';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['data']    = $this->GsmConditionModel->tampil()->result_object();
            $data['content'] = 'admin-modul/gsmCondition/gsmCondition';
            $this->load->view('admin-modul/template',$data);
        }elseif($stat==3){
            $data['data']    = $this->GsmConditionModel->tampil()->result_object();
            $data['content'] = 'user-modul/gsmCondition/gsmCondition';
            $this->load->view('user-modul/template',$data);
        }else{ //user
            $this->session->sess_destroy();
            redirect('login','refresh');
        }
    }
    /////////////////////////////////////////////////////////////////// End List Data GSM Condition ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Validate Form ///////////////////////////////////////////////////////////////
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('gsm_cond_name') == '')
        {
            $data['inputerror'][] = 'gsm_cond_name';
            $data['error_string'][] = 'Condition GPS Name is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
    /////////////////////////////////////////////////////////////////// End Validate Form ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Proses Save GSM Condition ///////////////////////////////////////////////////////////////
    public function ajax_add()
    {
        $this->_validate();

        $data = array(
            'gsm_cond_name' => $this->input->post('gsm_cond_name'),
            'gsm_cond_insert' => date('Y-m-d H:i:s'),
            'gsm_cond_update' => date('Y-m-d H:i:s'),
            'gsm_cond_user' => $_SESSION['name']
            );
        $this->GsmConditionModel->insert_data($data);
        echo json_encode(array("status" => TRUE));
    }
    /////////////////////////////////////////////////////////////////// End Proses Save GSM Condition ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Get Edit GSM Condition ///////////////////////////////////////////////////////////////
    public function ajax_edit($id)
    {
        $data = $this->db->get_where('gsm_conditions',array('gsm_cond_id' => $id))->row();
        echo json_encode($data);
    }
    /////////////////////////////////////////////////////////////////// End Get Edit GSM Condition ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Proses Update GSM Condition ///////////////////////////////////////////////////////////////
    public function ajax_update()
    {
        $this->_validate();
        
        $id = $this->input->post('id');
        $data = array(
                'gsm_cond_name' => $this->input->post('gsm_cond_name'),
                'gsm_cond_update' => date('Y-m-d H:i:s'),
                'gsm_cond_user' => $_SESSION['name']
            );
        
        $this->db->where('gsm_cond_id', $id);
        $this->db->update('gsm_conditions', $data);
        
        echo json_encode(array("status" => TRUE));
    }
    /////////////////////////////////////////////////////////////////// End Proses Update GSM Condition ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Proses Delete GSM Condition ///////////////////////////////////////////////////////////////
    public function ajax_delete($id)
    {
        $this->GsmConditionModel->delete($id);
        echo json_encode(array("status" => TRUE));
    }
    /////////////////////////////////////////////////////////////////// End Proses Delete GSM Condition ///////////////////////////////////////////////////////////////
}