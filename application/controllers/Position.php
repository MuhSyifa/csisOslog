<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Position extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library('form_validation','Excel_reader');
		$this->load->model(array('PositionModel', 'm_login'));
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

	public function position_list()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['position'] = $this->PositionModel->getData()->result_object();
            $data['content'] = 'superAdmin-modul/position/position';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['position'] = $this->PositionModel->getData()->result_object();
            $data['content'] = 'admin-modul/position/position';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['position'] = $this->PositionModel->getData()->result_object();
            $data['content'] = 'user-modul/position/position';
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

        if($this->input->post('pos_name') == '')
        {
            $data['inputerror'][] = 'pos_name';
            $data['error_string'][] = 'Position name is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
    /////////////////////////////////////////////////////////////////// End Validate Form ///////////////////////////////////////////////////////////////

	/////////////////////////////////////////////////////////////////// Start Proses Save Position ///////////////////////////////////////////////////////////////
    public function ajax_add()
	{
		$this->_validate();

        $h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');

        $data = array(
					'pos_name' => $this->input->post('pos_name'),
                    'pos_insert' => $i,
                    'pos_update' => $i,
                    'pos_user' => $h
				);
		$this->PositionModel->insert_data($data);
        echo json_encode(array("status" => TRUE));
	}
    /////////////////////////////////////////////////////////////////// End Proses Save Position ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Get Edit Position ///////////////////////////////////////////////////////////////
    public function ajax_edit($id)
    {
        $data = $this->db->get_where('employees_position',array('pos_id' => $id))->row();
        echo json_encode($data);
    }
    /////////////////////////////////////////////////////////////////// End Get Edit Position ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Proses Update Position ///////////////////////////////////////////////////////////////
    public function ajax_update()
    {
        $this->_validate();

        $id = $this->input->post('id');
        $data = array(
                'pos_name' => $this->input->post('pos_name'),
                'pos_update' => date('Y-m-d H:i:s'),
                'pos_user' => $_SESSION['name']
            );
        
        $this->db->where('pos_id', $id);
        $this->db->update('employees_position', $data);
        echo json_encode(array("status" => TRUE));
    }
    /////////////////////////////////////////////////////////////////// End Proses Update Position ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Proses Delete Position ///////////////////////////////////////////////////////////////
    public function ajax_delete($id)
    {
        $this->PositionModel->delete_data($id);
        echo json_encode(array("status" => TRUE));
    }
    /////////////////////////////////////////////////////////////////// End Proses Delete Position ///////////////////////////////////////////////////////////////
}

/* End of file Customer.php */
/* Location: ./application/controllers/Customer.php */