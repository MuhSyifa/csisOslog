<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('form_validation', 'Excel_reader'));
        $this->load->model(array('VendorModel', 'm_login'));
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

    /////////////////////////////////////////////////////////////////// Start Validate Form ///////////////////////////////////////////////////////////////
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('vendor_name') == '')
        {
            $data['inputerror'][] = 'vendor_name';
            $data['error_string'][] = 'Vendor name is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('vendor_type') == '')
        {
            $data['inputerror'][] = 'vendor_type';
            $data['error_string'][] = 'Please select Vendor Type';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
    /////////////////////////////////////////////////////////////////// End Validate Form ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Proses Save Vendor ///////////////////////////////////////////////////////////////
    public function ajax_add()
    {
        $vendor_name = $this->input->post('vendor_name');
        
        $query = $this->db->get_where('vendor', array(
                    'vendor_name' => $vendor_name
                ));

        $count = $query->num_rows();

        if($count === 0)
        {
            $this->_validate();
            $data = array(
                    'vendor_name' => $this->input->post('vendor_name'),
                    'vendor_type' => $this->input->post('vendor_type'),
                    'vendor_insert' => date('Y-m-d H:i:s'),
                    'vendor_update' => date('Y-m-d H:i:s'),
                    'vendor_user' => $_SESSION['uname']
                );
            
            $this->VendorModel->insert_data($data);
            echo json_encode(array("status" => TRUE));
        }
        else
        {
            echo json_encode(array("validate_status" => TRUE));
        }
    }
    /////////////////////////////////////////////////////////////////// End Proses Save Vendor ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Get Edit Vendor ///////////////////////////////////////////////////////////////
    public function ajax_edit($id)
    {
        $data = $this->db->get_where('vendor',array('vendor_id' => $id))->row();
        echo json_encode($data);
    }
    /////////////////////////////////////////////////////////////////// End Get Edit Vendor ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Proses Update vendor ///////////////////////////////////////////////////////////////
    public function ajax_update()
    {
        $this->_validate();
        
        $id = $this->input->post('id');
        $data = array(
                'vendor_name' => $this->input->post('vendor_name'),
                'vendor_type' => $this->input->post('vendor_type'),
                'vendor_update' => date('Y-m-d H:i:s'),
                'vendor_user' => $_SESSION['name']
            );
        
        $this->db->where('vendor_id', $id);
        $this->db->update('vendor', $data);
        
        echo json_encode(array("status" => TRUE));
    }
    /////////////////////////////////////////////////////////////////// End Proses Update Vendor ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Proses Delete Vendor ///////////////////////////////////////////////////////////////
    public function ajax_delete($id)
    {
        $this->VendorModel->delete($id);
        echo json_encode(array("status" => TRUE));
    }
    /////////////////////////////////////////////////////////////////// End Proses Delete Vendor ///////////////////////////////////////////////////////////////

    public function excel_vendor() 
    {    
        $this->load->library(array('excel/Biffwriter', 'excel/Format', 'excel/OLEwriter',
                                    'excel/Parser', 'excel/Workbook', 'excel/Worksheet'));
        
        $data['data']    = $this->VendorModel->tampil()->result_object();        
        $this->load->view('rptexcel/excelfiles_vendor',$data);
    }

    /* Start Import */
    public function import()
    {
        if ($this->input->post('submit'))
        {   
            $this->do_upload();
        }
        else
        {
            $this->load->view('excel');
        }
    }

    public function do_upload()
    {
        $config['upload_path'] = './temp_upload/';
        $config['allowed_types'] = 'xls';
                
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload())
        {
            $data = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('msg_excel', 'Insert failed. Please check your file, only .xls file allowed.');
        }
        else
        {
            $data = array('error' => false);
            $upload_data = $this->upload->data();

            $this->load->library('excel_reader');
            $this->excel_reader->setOutputEncoding('CP1251');

            $file =  $upload_data['full_path'];
            $this->excel_reader->read($file);
            error_reporting(E_ALL ^ E_NOTICE);

            // Sheet 1
            $data = $this->excel_reader->sheets[0] ;
            $dataexcel = Array();
            for ($i = 1; $i <= $data['numRows']; $i++) {
                if($data['cells'][$i][1] == '') break;
                $dataexcel[$i-1]['vendor_name'] = $data['cells'][$i][1];
                $dataexcel[$i-1]['vendor_type'] = $data['cells'][$i][2];
            }
        //cek data
        $check= $this->VendorModel->search_chapter($dataexcel);
        if (count($check) > 0)
        {
            $this->VendorModel->insert_chapter($dataexcel);
            // set pesan
            $this->session->set_flashdata('msg_excel', 'inserting data success');
            }
        }
        redirect('vendor/vendor_list');
    }
    /* End Import */

    /////////////////////////////////////////////////////////////////// Start List Vendor ///////////////////////////////////////////////////////////////
    public function vendor_list()
    {
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['data']    = $this->VendorModel->tampil()->result_object();
            $data['content'] = 'superAdmin-modul/vendor/vendor';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['data']    = $this->VendorModel->tampil()->result_object();
            $data['content'] = 'admin-modul/vendor/vendor';
            $this->load->view('admin-modul/template',$data);
        }elseif($stat==3){
            $data['data']    = $this->VendorModel->tampil()->result_object();
            $data['content'] = 'user-modul/vendor/vendor';
            $this->load->view('user-modul/template',$data);
        }else{ //user
            $this->session->sess_destroy();
            redirect('login','refresh');
        }
    }
    /////////////////////////////////////////////////////////////////// End List Vendor ///////////////////////////////////////////////////////////////

    public function vendor_dashboard()
    {
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['vendorStock']    = $this->VendorModel->vendorDashboard()->result_object();
            $data['data']    = $this->VendorModel->tampil()->result_object();
            $data['content'] = 'superAdmin-modul/vendor/vendor_dashboard';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['vendorStock']    = $this->VendorModel->vendorDashboard()->result_object();
            $data['data']    = $this->VendorModel->tampil()->result_object();
            $data['content'] = 'admin-modul/vendor/vendor_dashboard';
            $this->load->view('admin-modul/template',$data);
        }elseif($stat==3){
            $data['vendorStock']    = $this->VendorModel->vendorDashboard()->result_object();
            $data['gsmStock']    = $this->VendorModel->gsmDashboard()->result_object();
            $data['gpsStock']    = $this->VendorModel->gpsDashboard()->result_object();
            $data['data']    = $this->VendorModel->tampil()->result_object();
            $data['content'] = 'user-modul/vendor/vendor_dashboard';
            $this->load->view('user-modul/template',$data);
        }else{ //user
            $this->session->sess_destroy();
            redirect('login','refresh');
        }
    }
}