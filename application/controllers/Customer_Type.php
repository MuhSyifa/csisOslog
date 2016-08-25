<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_Type extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library('form_validation','Excel_reader');
		$this->load->model(array('CustomerTypeModel', 'm_login'));
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
            //$data['gps'] = $this->GpsTypeModel->getGpsType();
            $data['content'] = 'superAdmin-modul/dashboard_admin';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            //$data['gps'] = $this->GpsTypeModel->getGpsType();
            $data['content'] = 'admin-modul/dashboard_admin';
            $this->load->view('admin-modul/template',$data);
        }else{
            //$data['gps'] = $this->GpsTypeModel->getGpsType();
            $data['content'] = 'user-modul/dashboard/dashboard_user';
            $this->load->view('user-modul/template',$data);
        }
	}

	public function excelfiles() 
	{
        $this->load->library(array('excel/Biffwriter', 'excel/Format', 'excel/OLEwriter',
        							'excel/Parser', 'excel/Workbook', 'excel/Worksheet'));
        
        $data['customer']    = $this->CustomerModel->getData()->result_object();        
        $this->load->view('rptexcel/excel_customer',$data);
    }

    /* Start Import Excel */
	public function do_upload()
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
               	$dataexcel[$i-1]['cust_name'] = $data['cells'][$i][2];
               	$dataexcel[$i-1]['cust_contact'] = $data['cells'][$i][3];
            	$dataexcel[$i-1]['cust_address'] = $data['cells'][$i][4];
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
  	/* End Import Excel */

	public function customer_type_list()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['customer_type'] = $this->CustomerTypeModel->getData()->result_object();
            $data['content'] = 'superAdmin-modul/customer_type/customer_type';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['customer_type'] = $this->CustomerTypeModel->getData()->result_object();
            $data['content'] = 'admin-modul/customer_type/customer_type';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['customer_type'] = $this->CustomerTypeModel->getData()->result_object();
            $data['content'] = 'user-modul/customer_type/customer_type';
            $this->load->view('user-modul/template',$data);
        }
	}

	public function process_insert()
	{
		$h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');

        $data = array(
					'cust_type_name' => $this->input->post('cust_type_name'),
                    'cust_type_insert' => $i,
                    'cust_type_update' => $i,
                    'cust_type_user' => $h
				);
		$this->CustomerTypeModel->insert_data($data);
		$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');	
		redirect('customer_type/customer_type_list','refresh');
	}

	public function ajax_edit($id)
    {
        $data = $this->db->get_where('customer_type',array('cust_type_id' => $id))->row();
        echo json_encode($data);
    }

    public function ajax_update()
    {
        //$this->_validate();
        $id = $this->input->post('id');
        $data = array(
                'cust_type_name' => $this->input->post('cust_type_name_edit'),
                'cust_type_update' => date('Y-m-d H:i:s'),
                'cust_type_user' => $_SESSION['name']
            );
        
        $this->db->where('cust_type_id', $id);
        $this->db->update('customer_type', $data);
        //echo json_encode(array("status" => TRUE));

        if ($this->db->affected_rows()) 
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Sudah Berhasil di Edit!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('customer_type/customer_type_list');
        }
        else
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Gagal di Edit, Mohon Edit Kembali!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('customer_type/customer_type_list');   
        }
    }

    /////////////////////////////////////////////////////////////////// Start Proses Delete Department ///////////////////////////////////////////////////////////////
    public function ajax_delete($id)
    {
        //$this->DepartmentModel->delete_data($id);
        $this->CustomerTypeModel->delete_data($id);
        echo json_encode(array("status" => TRUE));
    }
    /////////////////////////////////////////////////////////////////// End Proses Delete Department ///////////////////////////////////////////////////////////////

    public function update($id)
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['data']	= $this->db->get_where('customer_type',array('cust_type_id' => $id))->row();
            $data['content'] = 'superAdmin-modul/customer_type/form_edit';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['data']	= $this->db->get_where('customer_type',array('cust_type_id' => $id))->row();
            $data['content'] = 'admin-modul/customer_type/form_edit';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['data']	= $this->db->get_where('customer_type',array('cust_type_id' => $id))->row();
            $data['content'] = 'user-modul/customer_type/form_edit';
            $this->load->view('user-modul/template',$data);
        }
	}

	public function process_update()
	{
		$id['cust_type_id'] = $this->input->post('cust_type_id');
        $h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');
		
        $data = array(
					'cust_type_name' => $this->input->post('cust_type_name'),
                    'cust_type_update' => $i,
                    'cust_type_user' =>$h
				);
		$this->CustomerTypeModel->update_data($data,$id);
		$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil diupdate!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');	
		redirect('customer_type/customer_type_list');
	}

	public function process_delete($id)
	{
		$this->CustomerTypeModel->delete_data($id);
		$this->session->set_flashdata('info', '<div class="alert alert-info"><strong>Data berhasil dihapus!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
		redirect('customer_type/customer_type_list');
	}
}

/* End of file Customer.php */
/* Location: ./application/controllers/Customer.php */