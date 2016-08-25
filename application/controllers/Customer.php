<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library('form_validation','Excel_reader');
		$this->load->model(array('CustomerModel', 'm_login'));
		$this->auth->cek_auth();
	}

	public function index()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
					'user' => $ambil_akun
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

    public function customer_company_excel() 
    {
        $this->load->library(array('excel/Biffwriter', 'excel/Format', 'excel/OLEwriter',
                                    'excel/Parser', 'excel/Workbook', 'excel/Worksheet'));
        
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['company_excel'] = $this->CustomerModel->getCustCompany()->result_object();
            $this->load->view('superAdmin-modul/customer/company_excel',$data);
        }elseif($stat==2){ //user
            $data['company_excel'] = $this->CustomerModel->getCustCompany()->result_object();
            $this->load->view('admin-modul/customer/company_excel',$data);
        }else{
            $data['company_excel'] = $this->CustomerModel->getCustCompany()->result_object();
            $this->load->view('user-modul/customer/company_excel',$data);
        }
    }

    public function customer_personal_excel() 
    {
        $this->load->library(array('excel/Biffwriter', 'excel/Format', 'excel/OLEwriter',
                                    'excel/Parser', 'excel/Workbook', 'excel/Worksheet'));
        
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['personal_excel'] = $this->CustomerModel->getCustList()->result_object();
            $this->load->view('superAdmin-modul/customer/personal_excel',$data);
        }elseif($stat==2){ //user
            $data['personal_excel'] = $this->CustomerModel->getCustList()->result_object();
            $this->load->view('admin-modul/customer/personal_excel',$data);
        }else{
            $data['personal_excel'] = $this->CustomerModel->getCustList()->result_object();
            $this->load->view('user-modul/customer/personal_excel',$data);
        }
    }

	public function exsport_excel($type) 
	{
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            if($type==1)
            {
                $this->load->library(array('excel/Biffwriter', 'excel/Format', 'excel/OLEwriter',
                                    'excel/Parser', 'excel/Workbook', 'excel/Worksheet'));

                $data['cust_personal']  = $this->CustomerModel->getCustList()->result_object(); 
                $this->load->view('superAdmin-modul/customer/cust_excel_personal', $data);    
            }
            elseif($type==2)
            {
                $this->load->library(array('excel/Biffwriter', 'excel/Format', 'excel/OLEwriter',
                                    'excel/Parser', 'excel/Workbook', 'excel/Worksheet'));

                $datas['cus_company']  = $this->CustomerModel->getCustCompany()->result_object();
                $this->load->view('superAdmin-modul/customer/cust_excel_company', $datas);
            }
            
        }elseif($stat==2){ //user
            if($type==1)
            {
                $data['data']   = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'1'))->row();
                $data['content'] = 'superAdmin-modul/customer/form_edit';
                $this->load->view('superAdmin-modul/template', $data);    
            }
            elseif($type==2)
            {
                $datas['datas']   = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'2'))->row();
                $datas['content'] = 'superAdmin-modul/customer/form_edit_company';
                $this->load->view('superAdmin-modul/template', $datas);
            }

        }else{
            if($type==1)
            {
                $data['data']   = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'1'))->row();
                $data['content'] = 'superAdmin-modul/customer/form_edit';
                $this->load->view('superAdmin-modul/template', $data);    
            }
            elseif($type==2)
            {
                $datas['datas']   = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'2'))->row();
                $datas['content'] = 'superAdmin-modul/customer/form_edit_company';
                $this->load->view('superAdmin-modul/template', $datas);
            }
        }
    }

    /* Start Import Excel */
	public function do_upload_personal()
	{
    	$config['upload_path'] = './temp_upload/';
    	$config['allowed_types'] = 'xls';
                
    	$this->load->library('upload', $config);

     	if ( ! $this->upload->do_upload())
     	{
            $data = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Insert failed. Please check your file, only .xls file allowed.</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
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
               	$dataexcel[$i-1]['cust_code'] = $data['cells'][$i][1];
               	$dataexcel[$i-1]['cust_type_id'] = $data['cells'][$i][2];
               	$dataexcel[$i-1]['cust_full_name'] = $data['cells'][$i][3];
            	$dataexcel[$i-1]['cust_short_name'] = $data['cells'][$i][4];
                $dataexcel[$i-1]['cust_gender'] = $data['cells'][$i][5];
                $dataexcel[$i-1]['cust_religion_id'] = $data['cells'][$i][6];
                $dataexcel[$i-1]['cust_personal_email'] = $data['cells'][$i][7];
                $dataexcel[$i-1]['cust_personal_phone'] = $data['cells'][$i][8];
                $dataexcel[$i-1]['cust_personal_mobile_phone'] = $data['cells'][$i][9];
                $dataexcel[$i-1]['cust_personal_address'] = $data['cells'][$i][10];
                $dataexcel[$i-1]['cust_start_date_contract'] = $data['cells'][$i][11];
                $dataexcel[$i-1]['cust_end_date_contract'] = $data['cells'][$i][12];
                $dataexcel[$i-1]['cust_maintenance_contract'] = $data['cells'][$i][13];
            }
    	//cek data
    	$check= $this->CustomerModel->search_excel($dataexcel);
    	if (count($check) > 0)
    	{
	      	$this->CustomerModel->import_excel($dataexcel);
	      	// set pesan
	      	$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Importing Data Success</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
	  		}
  		}
  		redirect('customer/customer_list');
  	}

    public function do_upload_company()
    {
        $config['upload_path'] = './temp_upload/';
        $config['allowed_types'] = 'xls';
                
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload())
        {
            $data = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Insert failed. Please check your file, only .xls file allowed.</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
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
                $dataexcel[$i-1]['cust_code'] = $data['cells'][$i][1];
                $dataexcel[$i-1]['cust_type_id'] = $data['cells'][$i][2];
                $dataexcel[$i-1]['cust_company_name'] = $data['cells'][$i][3];
                $dataexcel[$i-1]['cust_business_type'] = $data['cells'][$i][4];
                $dataexcel[$i-1]['cust_company_address'] = $data['cells'][$i][5];
                $dataexcel[$i-1]['cust_company_address2'] = $data['cells'][$i][6];
                $dataexcel[$i-1]['cust_company_address3'] = $data['cells'][$i][7];
                $dataexcel[$i-1]['cust_company_codepos'] = $data['cells'][$i][8];
                $dataexcel[$i-1]['cust_company_city'] = $data['cells'][$i][9];
                $dataexcel[$i-1]['cust_company_phone'] = $data['cells'][$i][10];
                $dataexcel[$i-1]['cust_company_email'] = $data['cells'][$i][11];
                $dataexcel[$i-1]['cust_start_date_contract'] = $data['cells'][$i][12];
                $dataexcel[$i-1]['cust_end_date_contract'] = $data['cells'][$i][13];
                $dataexcel[$i-1]['cust_maintenance_contract'] = $data['cells'][$i][14];
            }
        //cek data
        $check= $this->CustomerModel->search_excel($dataexcel);
        if (count($check) > 0)
        {
            $this->CustomerModel->import_company_excel($dataexcel);
            // set pesan
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Importing Data Success</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            }
        }
        redirect('customer/customer_list');
    }
  	/* End Import Excel */

	public function customer_list()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['customer'] = $this->CustomerModel->getData()->result_object();
            $data['content'] = 'superAdmin-modul/customer/customer';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['customer'] = $this->CustomerModel->getData()->result_object();
            $data['content'] = 'admin-modul/customer/customer';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['customer'] = $this->CustomerModel->getData()->result_object();
            $data['content'] = 'user-modul/customer/customer';
            $this->load->view('user-modul/template',$data);
        }
	}

    public function customer_personal_list()
    {
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['customer'] = $this->CustomerModel->getCustPerson()->result_object();
            $data['content'] = 'superAdmin-modul/customer/customer_personal';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['customer'] = $this->CustomerModel->getCustPerson()->result_object();
            $data['content'] = 'admin-modul/customer/customer_personal';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['customer'] = $this->CustomerModel->getCustPerson()->result_object();
            $data['content'] = 'user-modul/customer/customer_personal';
            $this->load->view('user-modul/template',$data);
        }
    }

    public function customer_company_list()
    {
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['customer'] = $this->CustomerModel->getCustComp()->result_object();
            $data['content'] = 'superAdmin-modul/customer/customer_company';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['customer'] = $this->CustomerModel->getCustComp()->result_object();
            $data['content'] = 'admin-modul/customer/customer_company';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['customer'] = $this->CustomerModel->getCustComp()->result_object();
            $data['content'] = 'user-modul/customer/customer_company';
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

        if($this->input->post('cust_code') == '')
        {
            $data['inputerror'][] = 'cust_code';
            $data['error_string'][] = 'Customer Code is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('cust_name') == '')
        {
            $data['inputerror'][] = 'cust_name';
            $data['error_string'][] = 'Customer Name is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('cust_birth_date') == '')
        {
            $data['inputerror'][] = 'cust_birth_date';
            $data['error_string'][] = 'Customer Birth Date is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('cust_gender') == '')
        {
            $data['inputerror'][] = 'cust_gender';
            $data['error_string'][] = 'Please Choose Customer Gender';
            $data['status'] = FALSE;
        }

        if($this->input->post('cust_personal_mobile_phone') == '')
        {
            $data['inputerror'][] = 'cust_personal_mobile_phone';
            $data['error_string'][] = 'Customer Mobile Phone is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('cust_personal_phone') == '')
        {
            $data['inputerror'][] = 'cust_personal_phone';
            $data['error_string'][] = 'Customer Phone is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('cust_personal_email') == '')
        {
            $data['inputerror'][] = 'cust_personal_email';
            $data['error_string'][] = 'Customer Email is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('cust_personal_address') == '')
        {
            $data['inputerror'][] = 'cust_personal_address';
            $data['error_string'][] = 'Customer Address is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('cust_start_date_contract') == '')
        {
            $data['inputerror'][] = 'cust_start_date_contract';
            $data['error_string'][] = 'Start Date Contract is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('cust_end_date_contract') == '')
        {
            $data['inputerror'][] = 'cust_end_date_contract';
            $data['error_string'][] = 'End Date Contract is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('cust_religion_id') == '')
        {
            $data['inputerror'][] = 'cust_religion_id';
            $data['error_string'][] = 'Please select Religion';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
    /////////////////////////////////////////////////////////////////// End Validate Form ///////////////////////////////////////////////////////////////

    public function add_personal()
    {
        $h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');

        $data = array(
            'cust_code' => $this->input->post('cust_code'),
            'cust_name' => $this->input->post('cust_name'),
            'cust_gender' => $this->input->post('cust_gender'),
            'cust_birth_date' => $this->input->post('cust_birth_date'),
            'cust_religion_id' => $this->input->post('cust_religion_id'),
            'cust_personal_email' => $this->input->post('cust_personal_email'),
            'cust_personal_phone' => $this->input->post('cust_personal_phone'),
            'cust_personal_mobile_phone' => $this->input->post('cust_personal_mobile_phone'),
            'cust_personal_address' => $this->input->post('cust_personal_address'),
            'status' => 'Active',
            'cust_start_date_contract' => $this->input->post('cust_start_date_contract'),
            'cust_end_date_contract' => $this->input->post('cust_end_date_contract'),
            'cust_type_id' => '1',

            'cust_personal_insert' => date('Y-m-d H:i:s'),
            'cust_personal_update' => date('Y-m-d H:i:s'),
            'cust_personal_user' => $_SESSION['name']
            );

        $this->CustomerModel->insert_personal_data($data);

        $this->db->select_max('cust_personal_id');
        $query = $this->db->get('customer_personal');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $lastId_cust_personal = $row->cust_personal_id;
            $newId_cust_personal = $lastId_cust_personal + 1;
        }

        $data_cust = array('cust_code' => $this->input->post('cust_code'),
                    'cust_type_id' => '1',
                    'cust_personal_id' => $lastId_cust_personal,
                    'cust_insert' => $i,
                    'cust_update' => $i,
                    'cust_user' => $h
                    );

        $this->CustomerModel->insert_data_cust($data_cust);

        $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>'); 
        redirect('customer/customer_personal_list','refresh');        
    }

    /////////////////////////////////////////////////////////////////// Start Proses Save GSM Condition ///////////////////////////////////////////////////////////////
    public function ajax_add()
    {
        $this->_validate();

        $data = array(
            'cust_code' => $this->input->post('cust_code'),
            'cust_name' => $this->input->post('cust_name'),
            'cust_gender' => $this->input->post('cust_gender'),
            'cust_birth_date' => $this->input->post('cust_birth_date'),
            'cust_religion_id' => $this->input->post('cust_religion_id'),
            'cust_personal_email' => $this->input->post('cust_personal_email'),
            'cust_personal_phone' => $this->input->post('cust_personal_phone'),
            'cust_personal_mobile_phone' => $this->input->post('cust_personal_mobile_phone'),
            'cust_personal_address' => $this->input->post('cust_personal_address'),
            'status' => 'Active',
            'cust_start_date_contract' => $this->input->post('cust_start_date_contract'),
            'cust_end_date_contract' => $this->input->post('cust_end_date_contract'),
            'cust_type_id' => '1',

            'cust_personal_insert' => date('Y-m-d H:i:s'),
            'cust_personal_update' => date('Y-m-d H:i:s'),
            'cust_personal_user' => $_SESSION['name']
            );
        $this->CustomerModel->insert_personal_data($data);
        echo json_encode(array("status" => TRUE));
    }
    /////////////////////////////////////////////////////////////////// End Proses Save GSM Condition ///////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////// Start Proses Update GSM Card /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function ajax_update_personal()
    {
        $this->_validate();

        $id = $this->input->post('id');
        $data = array(
            'cust_code' => $this->input->post('cust_code_edit'),
            'cust_name' => $this->input->post('cust_name_edit'),
            'cust_gender' => $this->input->post('cust_gender_edit'),
            'cust_birth_date' => $this->input->post('cust_birth_date_edit'),
            'cust_religion_id' => $this->input->post('cust_religion_id_edit'),
            'cust_personal_email' => $this->input->post('cust_personal_email_edit'),
            'cust_personal_phone' => $this->input->post('cust_personal_phone_edit'),
            'cust_personal_mobile_phone' => $this->input->post('cust_personal_mobile_phone_edit'),
            'cust_personal_address' => $this->input->post('cust_personal_address_edit'),
            'status' => $this->input->post('cust_status_edit'),
            'cust_start_date_contract' => $this->input->post('cust_start_date_contract_edit'),
            'cust_end_date_contract' => $this->input->post('cust_end_date_contract_edit'),
            'cust_personal_update' => date('Y-m-d H:i:s'),
            'cust_personal_user' => $_SESSION['name']
            );
        
        $this->db->where('cust_personal_id', $id);
        $this->db->update('customer_personal', $data);

        echo json_encode(array("status" => TRUE));
    }
    ///////////////////////////////////////////////////////////////// End Proses Update GSM Card /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function ajax_detail_personal($id)
    {
        $data = $this->db->query("SELECT --customer_religion.cust_religion_id, customer_religion.cust_religion_name,
                                customer_personal.cust_personal_id, customer_personal.cust_code, customer_personal.cust_name, 
                                customer_personal.cust_birth_date, customer_personal.cust_type_id, customer_personal.cust_gender, 
                                customer_personal.cust_religion_id, customer_personal.cust_personal_email,
                                customer_personal.cust_personal_phone, customer_personal.cust_personal_mobile_phone, customer_personal.cust_personal_address, 
                                customer_personal.cust_start_date_contract, customer_personal.cust_end_date_contract, customer_personal.cust_personal_insert, 
                                customer_personal.cust_personal_update, customer_personal.cust_personal_user, customer_personal.status
                                FROM customer_personal 
                                

                                WHERE customer_personal.cust_personal_id='$id' ")->row();
        echo json_encode($data);
    }

    public function ajax_edit_personal($id)
    {
        $data = $this->db->query("SELECT --customer_religion.cust_religion_id, customer_religion.cust_religion_name,
                                customer_personal.cust_personal_id, customer_personal.cust_code, customer_personal.cust_name, 
                                customer_personal.cust_birth_date, customer_personal.cust_type_id, customer_personal.cust_gender, 
                                customer_personal.cust_religion_id, customer_personal.cust_personal_email,
                                customer_personal.cust_personal_phone, customer_personal.cust_personal_mobile_phone, customer_personal.cust_personal_address, 
                                customer_personal.cust_start_date_contract, customer_personal.cust_end_date_contract, customer_personal.cust_personal_insert, 
                                customer_personal.cust_personal_update, customer_personal.cust_personal_user, customer_personal.status
                                FROM customer_personal 
                                

                                WHERE customer_personal.cust_personal_id='$id' ")->row();
        echo json_encode($data);
    }

    public function add_company()
    {
        $h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');

        $data_pic_contact = array('cust_name' => $this->input->post('cust_name'),
                    'cust_position' => $this->input->post('cust_position'),
                    'cust_department' => $this->input->post('cust_department'),
                    'cust_mobile_phone' => $this->input->post('cust_mobile_phone'),
                    'cust_email' => $this->input->post('cust_email'),
                    'cust_religion_id' => $this->input->post('cust_religion_id'),
                    'cust_birth_date' => $this->input->post('cust_birth_date'),
                    'cust_address' => $this->input->post('cust_address'),
                    'cust_insert' => $i,
                    'cust_update' => $i,
                    'cust_user' => $h
                    );

        $this->db->select_max('cust_pic_contact_id');
        $query = $this->db->get('customers_pic_contact');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $lastId_company = $row->cust_pic_contact_id;
            $newId_company = $lastId_company + 1;
        }

        $this->CustomerModel->insert_pic_contact($data_pic_contact);

        $data_cust_company = array(
                    'cust_code' =>  $this->input->post('cust_code'),
                    'cust_company_name' => $this->input->post('cust_company_name'),
                    'cust_type_id' => '2',
                    'cust_business_type' => $this->input->post('cust_business_type_id'),
                    'cust_pic_contact' => $lastId_company,
                    'cust_company_phone' => $this->input->post('cust_company_phone'),
                    'cust_company_email' => $this->input->post('cust_company_email'),
                    'cust_company_address' => $this->input->post('cust_company_address'),
                    'status' => 'Active',
                    'cust_start_date_contract' => $this->input->post('cust_start_date_contract'),
                    'cust_end_date_contract' => $this->input->post('cust_end_date_contract'),
                    'cust_company_insert' => $i,
                    'cust_company_update' => $i,
                    'cust_company_user' => $h
                    );

        $this->CustomerModel->insert_data($data_cust_company);

        $this->db->select_max('cust_company_id');
        $query = $this->db->get('customer_company');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $lastId_cust_company = $row->cust_company_id;
            $newId_cust_company = $lastId_cust_company + 1;
        }

        $data_cust = array('cust_code' => $this->input->post('cust_code'),
                    'cust_type_id' => '2',
                    'cust_company_id' => $lastId_cust_company,
                    'cust_insert' => $i,
                    'cust_update' => $i,
                    'cust_user' => $h
                    );

        $this->CustomerModel->insert_data_cust($data_cust);

        $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>'); 
        redirect('customer/customer_company_list','refresh');        
    }

    public function add_pic()
    {
        $h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');

        $data_pic_contact = array('cust_name' => $this->input->post('cust_name_add'),
                    'cust_position' => $this->input->post('cust_position_add'),
                    'cust_department' => $this->input->post('cust_department_add'),
                    'cust_mobile_phone' => $this->input->post('cust_mobile_phone_add'),
                    'cust_email' => $this->input->post('cust_email_add'),
                    'cust_religion_id' => $this->input->post('cust_religion_id_add'),
                    'cust_birth_date' => $this->input->post('cust_birth_date_add'),
                    'cust_address' => $this->input->post('cust_address_add'),
                    'cust_insert' => $i,
                    'cust_update' => $i,
                    'cust_user' => $h
                    );

        $this->db->select_max('cust_pic_contact_id');
        $query = $this->db->get('customers_pic_contact');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $lastId_company = $row->cust_pic_contact_id;
            $newId_company = $lastId_company + 1;
        }

        $this->CustomerModel->insert_pic_contact($data_pic_contact);

        $data_cust_company = array(
                    'cust_code' =>  $this->input->post('cust_code_add'),
                    'cust_company_name' => $this->input->post('cust_company_name_add'),
                    'cust_type_id' => '2',
                    'cust_business_type' => $this->input->post('cust_business_type_id_add'),
                    'cust_pic_contact' => $newId_company,
                    'cust_company_phone' => $this->input->post('cust_company_phone_add'),
                    'cust_company_email' => $this->input->post('cust_company_email_add'),
                    'cust_company_address' => $this->input->post('cust_company_address_add'),
                    'status' => 'Active',
                    'cust_start_date_contract' => $this->input->post('cust_start_date_contract_add'),
                    'cust_end_date_contract' => $this->input->post('cust_end_date_contract_add'),
                    'cust_company_insert' => $i,
                    'cust_company_update' => $i,
                    'cust_company_user' => $h
                    );

        $this->CustomerModel->insert_data($data_cust_company);

        /*$this->db->select_max('cust_company_id');
        $query = $this->db->get('customer_company');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $lastId_cust_company = $row->cust_company_id;
            $newId_cust_company = $lastId_cust_company + 1;
        }

        $data_cust = array('cust_code' => $this->input->post('cust_code'),
                    'cust_type_id' => '2',
                    'cust_company_id' => $lastId_cust_company,
                    'cust_insert' => $i,
                    'cust_update' => $i,
                    'cust_user' => $h
                    );

        $this->CustomerModel->insert_data_cust($data_cust);*/

        $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>'); 
        redirect('customer/customer_company_list','refresh');   
    }

    public function ajax_update_company()
    {
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $pic = $this->input->post('pic');

        $h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');
        
        $object = array(
                    'cust_name' => $this->input->post('cust_name_edit'),
                    'cust_position' => $this->input->post('cust_position_edit'),
                    'cust_department' => $this->input->post('cust_department_edit'),
                    'cust_mobile_phone' => $this->input->post('cust_mobile_phone_edit'),
                    'cust_email' => $this->input->post('cust_email_edit'),
                    'cust_religion_id' => $this->input->post('cust_religion_id_edit'),
                    'cust_birth_date' => $this->input->post('cust_birth_date_edit'),
                    'cust_address' => $this->input->post('cust_address_edit'),
                    'cust_insert' => $i,
                    'cust_update' =>$i,
                    'cust_user' => $h
                     );
        $this->db->where('cust_pic_contact_id', $pic);
        $this->db->update('customers_pic_contact', $object);

        
        $object1 = array(
                    'cust_code' => $this->input->post('cust_code_edit'),
                    'cust_company_name' => $this->input->post('cust_company_name_edit'),
                    'cust_type_id' => '2',
                    'cust_business_type' => $this->input->post('cust_business_type_edit'),
                    'cust_pic_contact' => $pic,
                    'cust_company_phone' => $this->input->post('cust_company_phone_edit'),
                    'cust_company_email' => $this->input->post('cust_company_email_edit'),
                    'cust_company_address' => $this->input->post('cust_company_address_edit'),
                    'status' => $this->input->post('status_edit'),
                    'cust_start_date_contract' => $this->input->post('cust_start_date_contract_edit'),
                    'cust_end_date_contract' => $this->input->post('cust_end_date_contract_edit'),
                    'cust_company_insert' => $i, 
                    'cust_company_update' => $i,
                    'cust_company_user' => $h
                    );
        $this->db->where('cust_company_id', $id);
        $this->db->update('customer_company', $object1);

        if ($this->db->affected_rows()) 
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('customer/customer_company_list');
        }
        else
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data Gagal disimpan!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('customer/customer_company_list');   
        }
    }

    public function ajax_detail_company($id)
    {
        $data = $this->db->query("SELECT customer_company.cust_company_id, customer_company.cust_code, customer_company.status, customer_company.cust_company_name, customer_company.cust_type_id, customer_company.cust_business_type, customer_company.cust_pic_contact, customer_company.cust_company_phone, 
                                customer_company.cust_company_email, customer_company.cust_company_address, customer_company.status, customer_company.cust_start_date_contract, customer_company.cust_end_date_contract, customer_company.cust_company_insert, 
                                customer_company.cust_company_update, customer_company.cust_company_user,

                                (SELECT customer_type.cust_type_name FROM customer_type WHERE customer_type.cust_type_id = customer_company.cust_type_id),

                                (SELECT customer_business_type.cust_business_type_name FROM customer_business_type WHERE customer_business_type.cust_business_type_id = customer_company.cust_business_type),

                                (SELECT customers_pic_contact.cust_name FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_position FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_department FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_mobile_phone FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_email FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_religion_id FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_birth_date FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_address FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_insert FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_update FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_user FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact)

                                FROM customer_company WHERE cust_company_id='$id' order by cust_company_name DESC")->row();

        echo json_encode($data);
    }

    public function ajax_edit_company($id)
    {
        $data = $this->db->query("SELECT customer_company.cust_company_id, customer_company.cust_code, customer_company.status, customer_company.cust_company_name, customer_company.cust_type_id, customer_company.cust_business_type, customer_company.cust_pic_contact, customer_company.cust_company_phone, 
                                customer_company.cust_company_email, customer_company.cust_company_address, customer_company.status, customer_company.cust_start_date_contract, customer_company.cust_end_date_contract, customer_company.cust_company_insert, 
                                customer_company.cust_company_update, customer_company.cust_company_user,

                                (SELECT customer_type.cust_type_name FROM customer_type WHERE customer_type.cust_type_id = customer_company.cust_type_id),

                                (SELECT customer_business_type.cust_business_type_name FROM customer_business_type WHERE customer_business_type.cust_business_type_id = customer_company.cust_business_type),

                                (SELECT customers_pic_contact.cust_name FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_position FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_department FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_mobile_phone FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_email FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_religion_id FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_birth_date FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_address FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_insert FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_update FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_user FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact)

                                FROM customer_company WHERE cust_company_id='$id' order by cust_company_name DESC")->row();

        echo json_encode($data);
    }

    public function process_insert_company()
	{
		$h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');

        $data_cust_company = array(
                        'cust_company_name' => $this->input->post('cust_company_name'),
                        'cust_business_type' => $this->input->post('cust_business_type'),
                        'cust_company_address' => $this->input->post('cust_company_address'),
                        'cust_company_address2' => $this->input->post('cust_company_address2'),
                        'cust_company_address3' => $this->input->post('cust_company_address3'),
                        'cust_company_codepos' => $this->input->post('cust_company_codepos'),
                        'cust_company_city' => $this->input->post('cust_company_city'),
                        'cust_company_phone' => $this->input->post('cust_company_phone'),
                        'cust_company_email' => $this->input->post('cust_company_email'),
                        'cust_company_insert' => $i,
                        'cust_company_update' => $i,
                        'cust_company_user' => $h
                    );

        $this->db->select_max('cust_company_detail_id');
        $query = $this->db->get('customer_company_detail');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $lastId_company = $row->cust_company_detail_id;
            $newId_company = $lastId_company + 1;
        }

        $this->CustomerModel->insert_company_detail($data_cust_company);

        $cust_code = $this->input->post('cust_code');

        $query = $this->db->get_where('customer', array(
            'cust_code' => $cust_code
        ));

        $count = $query->num_rows();

        if($count === 0)
        {
            $data = array(
                    'cust_code' => $cust_code,
                    'cust_type_id' => '2',
                    'cust_company_detail_id' => $newId_company,
                    //'cust_personal_detail_id' => $newId_personal,
                    'cust_start_date_contract' => $this->input->post('cust_start_date_contract'),
                    'cust_end_date_contract' => $this->input->post('cust_end_date_contract'),
                    'cust_maintenance_contract' => $this->input->post('cust_maintenance_contract'),
                    'cust_insert' => $i,
                    'cust_update' => $i,
                    'cust_user' => $h
                );
            $this->CustomerModel->insert_data($data);
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>'); 
            redirect('customer/customer_list','refresh');
        }
        else
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data Gagal disimpan, Customer Code Sudah Ada!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>'); 
            redirect('customer/customer_list','refresh');
        }        
	}

    /*public function read($id,$type)
    {    
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            if($type==1)
            {
                $data['data']   = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'1'))->row();
                $data['content'] = 'superAdmin-modul/customer/read_personal';
                $this->load->view('superAdmin-modul/template', $data);    
            }
            elseif($type==2)
            {
                $datas['datas']   = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'2'))->row();
                $datas['content'] = 'superAdmin-modul/customer/read_company';
                $this->load->view('superAdmin-modul/template', $datas);
            }
            
        }elseif($stat==2){ //user
            if($type==1)
            {
                $data['data']   = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'1'))->row();
                $data['content'] = 'admin-modul/customer/read_personal';
                $this->load->view('admin-modul/template', $data);    
            }
            elseif($type==2)
            {
                $datas['datas']   = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'2'))->row();
                $datas['content'] = 'admin-modul/customer/read_company';
                $this->load->view('admin-modul/template', $datas);
            }

        }else{
            if($type==1)
            {
                $data['data']   = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'1'))->row();
                $data['content'] = 'user-modul/customer/read_personal';
                $this->load->view('superAdmin-modul/template', $data);    
            }
            elseif($type==2)
            {
                $datas['datas']   = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'2'))->row();
                $datas['content'] = 'user-modul/customer/read_company';
                $this->load->view('superAdmin-modul/template', $datas);
            }

        }
    }*/

    public function ajax_detail($id,$type)
    {
        $data = $this->db->query("SELECT customer_personal.cust_personal_id, customer_personal.cust_code, customer_personal.cust_name, 
                                customer_personal.cust_birth_date, customer_personal.cust_type_id, customer_personal.cust_gender, 
                                customer_personal.cust_religion_id, customer_personal.cust_personal_email,
                                customer_personal.cust_personal_phone, customer_personal.cust_personal_mobile_phone, customer_personal.cust_personal_address, 
                                customer_personal.cust_start_date_contract, customer_personal.cust_end_date_contract, customer_personal.cust_personal_insert, 
                                customer_personal.cust_personal_update, customer_personal.cust_personal_user, customer_personal.status
                                
                                FROM customer_personal 
                                
                                JOIN customer_religion ON customer_personal.cust_religion_id=customer_religion.cust_religion_id
                                JOIN customer_type ON customer_personal.cust_type_id=customer_type.cust_type_id
                                
                                WHERE customer_type.cust_type_id = 1 and cust_personal_id=$id ")->row();
        echo json_encode($data);

        if($type==1)
        {
            /*$data = $this->db->query("SELECT  customer.cust_id, customer.cust_code, customer.cust_type_id, customer.cust_company_detail_id, customer.cust_personal_detail_id, customer.cust_start_date_contract, customer.cust_end_date_contract, customer.cust_maintenance_contract, customer.cust_insert, customer.cust_update, customer.cust_user,
                                
                                (SELECT customer_type.cust_type_name AS is_cust_type FROM customer_type WHERE customer_type.cust_type_id = customer.cust_type_id),
                                
                                (SELECT customer_personal_detail.cust_name FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_gender FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_religion_id FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),

                                (SELECT customer_personal_detail.cust_personal_email FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_personal_phone FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_personal_mobile_phone FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_birth_date FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_personal_address FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.status FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_personal_insert FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_personal_update FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_personal_user FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id)

                                FROM customer WHERE cust_id='$id' and cust_type_id='1' order by cust_id DESC ")->row();*/
            $data = $this->db->query("SELECT customer_personal.cust_personal_id, customer_personal.cust_code, customer_personal.cust_name, 
                                customer_personal.cust_birth_date, customer_personal.cust_type_id, customer_personal.cust_gender, 
                                customer_personal.cust_religion_id, customer_personal.cust_personal_email,
                                customer_personal.cust_personal_phone, customer_personal.cust_personal_mobile_phone, customer_personal.cust_personal_address, 
                                customer_personal.cust_start_date_contract, customer_personal.cust_end_date_contract, customer_personal.cust_personal_insert, 
                                customer_personal.cust_personal_update, customer_personal.cust_personal_user, customer_personal.status
                                
                                FROM customer_personal 
                                
                                JOIN customer_religion ON customer_personal.cust_religion_id=customer_religion.cust_religion_id
                                JOIN customer_type ON customer_personal.cust_type_id=customer_type.cust_type_id
                                
                                WHERE customer_type.cust_type_id = 1");
            echo json_encode($data);
        }
        elseif($type==2)
        {
            $data = $this->db->query("SELECT cust_id, cust_code, cust_type_id, cust_company_detail_id, cust_personal_detail_id, cust_start_date_contract, cust_end_date_contract, cust_maintenance_contract, cust_insert, cust_update, cust_user, 
                               (SELECT customer_type.cust_type_name AS is_cust_type FROM public.customer_type WHERE customer_type.cust_type_id = customer.cust_type_id),

                               (SELECT customer_company_detail.cust_company_name FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_business_type AS is_business FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_address FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_address2 FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_address3 FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_codepos FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_city FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_phone FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_email FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_insert FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_update FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_user FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id)
                                FROM customer WHERE cust_type_id='2' order by cust_id DESC")->row();
            echo json_encode($data);    
        }
        
    }
    
    public function ajax_add_pic($id)
    {
        $data = $this->db->query("SELECT customer_company.cust_company_id, customer_company.cust_code, customer_company.status, customer_company.cust_company_name, customer_company.cust_type_id, customer_company.cust_business_type, customer_company.cust_pic_contact, customer_company.cust_company_phone, 
                                customer_company.cust_company_email, customer_company.cust_company_address, customer_company.status, customer_company.cust_start_date_contract, customer_company.cust_end_date_contract, customer_company.cust_company_insert, 
                                customer_company.cust_company_update, customer_company.cust_company_user,

                                (SELECT customer_type.cust_type_name FROM customer_type WHERE customer_type.cust_type_id = customer_company.cust_type_id),

                                (SELECT customer_business_type.cust_business_type_name FROM customer_business_type WHERE customer_business_type.cust_business_type_id = customer_company.cust_business_type),

                                (SELECT customers_pic_contact.cust_name FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_position FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_department FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_mobile_phone FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_email FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_religion_id FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_birth_date FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_address FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_insert FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_update FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_user FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact)

                                FROM customer_company WHERE cust_company_id='$id' order by cust_company_name DESC")->row();

        echo json_encode($data);
    }

    public function ajax_edit($id,$type)
    {
        if($type==1)
        {
            $data = $this->db->query("SELECT  customer.cust_id, customer.cust_code, customer.cust_type_id, customer.cust_company_detail_id, customer.cust_personal_detail_id, customer.cust_start_date_contract, customer.cust_end_date_contract, customer.cust_maintenance_contract, customer.cust_insert, customer.cust_update, customer.cust_user,
                                
                                (SELECT customer_type.cust_type_name AS is_cust_type FROM customer_type WHERE customer_type.cust_type_id = customer.cust_type_id),
                                
                                (SELECT customer_personal_detail.cust_name FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_gender FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_religion_id FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),

                                (SELECT customer_personal_detail.cust_personal_email FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_personal_phone FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_personal_mobile_phone FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_birth_date FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_personal_address FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.status FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_personal_insert FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_personal_update FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                                (SELECT customer_personal_detail.cust_personal_user FROM customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id)

                                FROM customer WHERE cust_id='$id' and cust_type_id='1' order by cust_id DESC ")->row();
            echo json_encode($data);
        }
        elseif($type==2)
        {
            //$data = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'2'))->row();
            $data = $this->db->query("SELECT cust_id, cust_code, cust_type_id, cust_company_detail_id, cust_personal_detail_id, cust_start_date_contract, cust_end_date_contract, cust_maintenance_contract, cust_insert, cust_update, cust_user, 
                               (SELECT customer_type.cust_type_name AS is_cust_type FROM public.customer_type WHERE customer_type.cust_type_id = customer.cust_type_id),

                               (SELECT customer_company_detail.cust_company_name FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_business_type AS is_business FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_address FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_address2 FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_address3 FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_codepos FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_city FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_phone FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_email FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_insert FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_update FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_user FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id)
                                FROM customer WHERE cust_type_id='2' order by cust_id DESC")->row();
            echo json_encode($data);    
        }
        
    }

    public function ajax_update()
    {
        $id = $this->input->post('id');
        $type = $this->input->post('type');

        $h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');
        
        $object = array(
                    'cust_code' => $this->input->post('cust_code_edit'),
                    'cust_type_id' => $type,
                    'cust_start_date_contract' => $this->input->post('cust_start_date_contract_edit'),
                    'cust_end_date_contract' => $this->input->post('cust_end_date_contract_edit'),
                    'cust_maintenance_contract' => $this->input->post('cust_maintenance_contract_edit'),
                    'cust_update' => $i,
                    'cust_user' => $h
                     );
        $this->db->where('cust_id', $id);
        $this->db->update('customer', $object);

        $id_personal = $this->input->post('detail_id');
        $object1 = array(
                    'cust_name' => $this->input->post('cust_name_edit'),
                    'cust_birth_date' => $this->input->post('cust_birth_date_edit'),
                    'cust_gender' => $this->input->post('cust_gender_edit'),
                    'cust_religion_id' => $this->input->post('cust_religion_id_edit'),
                    'cust_personal_email' => $this->input->post('cust_personal_email_edit'),
                    'cust_personal_phone' => $this->input->post('cust_personal_phone_edit'),
                    'cust_personal_mobile_phone' => $this->input->post('cust_personal_mobile_phone_edit'),
                    'cust_personal_address' => $this->input->post('cust_address_edit'),
                    'cust_personal_update' => $i,
                    'cust_personal_user' => $h
                    );
        $this->db->where('cust_personal_detail_id', $id_personal);
        $this->db->update('customer_personal_detail', $object1);

        //$this->_validate();
        /*$id = $this->input->post('id');
        $data = array(
                'gsm_number' => $this->input->post('gsm_number_edit'),
                'gsm_imsi_number' => $this->input->post('gsm_imsi_number_edit'),
                'gsm_iccid_number' => $this->input->post('gsm_iccid_number_edit'),
                'vendor_id' => $this->input->post('vendor_id_edit'),
                'gsm_cond_id' => $this->input->post('gsm_cond_id_edit'),
                'gsm_update' => date('Y-m-d H:i:s'),
                'gsm_user' => $_SESSION['name']
            );
        
        $this->db->where('gsm_id', $id);
        $this->db->update('gsm', $data);*/
        //echo json_encode(array("status" => TRUE));

        if ($this->db->affected_rows()) 
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Sudah Berhasil di Edit!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('customer/customer_personal_list');
        }
        else
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Gagal di Edit, Mohon Edit Kembali!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('customer/customer_personal_list');   
        }
    }

	public function update($id,$type)
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            if($type==1)
            {
                $data['data']   = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'1'))->row();
                $data['content'] = 'superAdmin-modul/customer/form_edit';
                $this->load->view('superAdmin-modul/template', $data);    
            }
            elseif($type==2)
            {
                $datas['datas']   = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'2'))->row();
                $datas['content'] = 'superAdmin-modul/customer/form_edit_company';
                $this->load->view('superAdmin-modul/template', $datas);
            }
            
        }elseif($stat==2){ //user
            if($type==1)
            {
                $data['data']   = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'1'))->row();
                $data['content'] = 'admin-modul/customer/form_edit';
                $this->load->view('admin-modul/template', $data);    
            }
            elseif($type==2)
            {
                $datas['datas']   = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'2'))->row();
                $datas['content'] = 'admin-modul/customer/form_edit_company';
                $this->load->view('admin-modul/template', $datas);
            }

        }else{
            if($type==1)
            {
                $data['data']   = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'1'))->row();
                $data['content'] = 'user-modul/customer/form_edit';
                $this->load->view('user-modul/template', $data);    
            }
            elseif($type==2)
            {
                $datas['datas']   = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'2'))->row();
                $datas['content'] = 'user-modul/customer/form_edit_company';
                $this->load->view('user-modul/template', $datas);
            }
        }
	}

	public function process_update_personal()
	{
		$id = $this->input->post('cust_id');
        $h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');
		
        $object = array(
                    'cust_code' => $this->input->post('cust_code'),
                    'cust_type_id' => '1',
                    'cust_start_date_contract' => $this->input->post('cust_start_date_contract'),
                    'cust_end_date_contract' => $this->input->post('cust_end_date_contract'),
                    'cust_maintenance_contract' => $this->input->post('cust_maintenance_contract'),
                    'cust_update' => $i,
                    'cust_user' => $h
                     );
        $this->db->where('cust_id', $id);
        $this->db->update('customer', $object);

        $id_personal = $this->input->post('cust_personal_detail_id');
        $object1 = array(
                    'cust_full_name' => $this->input->post('cust_full_name'),
                    'cust_short_name' => $this->input->post('cust_short_name'),
                    'cust_gender' => $this->input->post('cust_gender'),
                    'cust_religion_id' => $this->input->post('cust_religion_id'),
                    'cust_personal_email' => $this->input->post('cust_personal_email'),
                    'cust_personal_phone' => $this->input->post('cust_personal_phone'),
                    'cust_personal_mobile_phone' => $this->input->post('cust_personal_mobile_phone'),
                    'cust_personal_address' => $this->input->post('cust_personal_address'),
                    'cust_personal_update' => $i,
                    'cust_personal_user' => $h
                    );
        $this->db->where('cust_personal_detail_id', $id_personal);
        $this->db->update('customer_personal_detail', $object1);

        if ($this->db->affected_rows()) 
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('customer/customer_list');
        }
        else
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data Gagal disimpan!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('customer/customer_list');   
        }
	}

    public function process_update_company()
    {
        $id = $this->input->post('cust_id');
        $h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');
        
        $object = array(
                    'cust_code' => $this->input->post('cust_code'),
                    'cust_type_id' => '2',
                    'cust_start_date_contract' => $this->input->post('cust_start_date_contract'),
                    'cust_end_date_contract' => $this->input->post('cust_end_date_contract'),
                    'cust_maintenance_contract' => $this->input->post('cust_maintenance_contract'),
                    'cust_update' => $i,
                    'cust_user' => $h
                     );
        $this->db->where('cust_id', $id);
        $this->db->update('customer', $object);

        $id_company = $this->input->post('cust_company_detail_id');
        $object1 = array(
                    'cust_company_name' => $this->input->post('cust_company_name'),
                    'cust_business_type' => $this->input->post('cust_business_type'),
                    'cust_company_address' => $this->input->post('cust_company_address'),
                    'cust_company_address2' => $this->input->post('cust_company_address2'),
                    'cust_company_address3' => $this->input->post('cust_company_address3'),
                    'cust_company_codepos' => $this->input->post('cust_company_codepos'),
                    'cust_company_city' => $this->input->post('cust_company_city'),
                    'cust_company_email' => $this->input->post('cust_company_email'),
                    'cust_company_update' => $i,
                    'cust_company_user' => $h
                    );
        $this->db->where('cust_company_detail_id', $id_company);
        $this->db->update('customer_company_detail', $object1);

        if ($this->db->affected_rows()) 
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('customer/customer_list');
        }
        else
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data Gagal disimpan!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('customer/customer_list');   
        }
    }

    /////////////////////////////////////////////////////////////////// Start Proses Delete Department ///////////////////////////////////////////////////////////////
    public function ajax_delete($id)
    {
        $this->CustomerModel->delete_personal($id);
        echo json_encode(array("status" => TRUE));
    }
    /////////////////////////////////////////////////////////////////// End Proses Delete Department ///////////////////////////////////////////////////////////////

	public function ajax_delete_company($id,$pic)
    {
        $this->CustomerModel->delete_company($id,$pic);
        echo json_encode(array("status" => TRUE));
    }

    public function process_delete($id)
	{
		$this->CustomerModel->delete_data($id);
		$this->session->set_flashdata('info', '<div class="alert alert-info"><strong>Data berhasil dihapus!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
		redirect('customer/customer_list');
	}
}

/* End of file Customer.php */
/* Location: ./application/controllers/Customer.php */
