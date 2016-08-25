<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gps extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form', 'exportexcel'));
		$this->load->library(array('form_validation', 'Excel_reader'));
		$this->load->model(array('GpsModel', 'VendorModel', 'GpsTypeModel', 'm_login'));
		$this->auth->cek_auth();
	}	

	public function index()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
		if($stat==1){//superadmin
			$data['gps'] = $this->GpsTypeModel->getGpsType();
			$data['content'] = 'superAdmin-modul/dashboard_admin';
			$this->load->view('superAdmin-modul/template', $data);
		}elseif ($stat==2) {//admin
			$data['gps'] = $this->GpsTypeModel->getGpsType();
			$data['content'] = 'admin-modul/dashboard_admin';
			$this->load->view('admin-modul/template', $data);
		}elseif ($stat==3) {//user
			$data['content'] = 'user-modul/dashboard/dashboard_user';
			$data['gps'] = $this->GpsTypeModel->getGpsType();
			$this->load->view('user-modul/template',$data);
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}		
	}

	/////////////////////////////////////////////////////////////////// Start List view GPS ///////////////////////////////////////////////////////////////
	public function gps_list()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
		if($stat==1){//superadmin
			$data['sql1'] = $this->GpsModel->getGpsList()->result_object();
	        $data['content'] = 'superAdmin-modul/gps/gps';
	        $this->load->view('superAdmin-modul/template',$data);
		}elseif ($stat==2) {//admin
			$data['sql1'] = $this->GpsModel->getGpsList()->result_object();
	        $data['content'] = 'admin-modul/gps/gps';
	        $this->load->view('admin-modul/template',$data);
		}elseif ($stat==3) {//user
			$data['sql1'] = $this->GpsModel->getGpsList()->result_object();
	        $data['content'] = 'user-modul/gps/gps';
	        $this->load->view('user-modul/template',$data);
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
	}
	/////////////////////////////////////////////////////////////////// End List view GPS ///////////////////////////////////////////////////////////////

	/////////////////////////////////////////////////////////////////// Start Proses Save GPS Received ///////////////////////////////////////////////////////////////
	public function ajax_add()
    {
        $gps_imei_number = $this->input->post('gps_imei_number');
        
        $query = $this->db->get_where('gps', array(
                    'gps_imei_number' => $gps_imei_number
                ));

        $count = $query->num_rows();

        if($count === 0)
        {
            $this->_validate();

			$data = array(
						'gps_purchase_order' => $this->input->post('gps_purchase_order'),
						'no_purchase_order' => $this->input->post('no_purchase_order'),
						'gps_imei_number' => $gps_imei_number,
						'gps_sn' => $this->input->post('gps_sn'),
						'gps_type_id' => $this->input->post('gps_type_id'),
						'vendor_id' => $this->input->post('vendor_id'),
						'gps_cond_id' => $this->input->post('gps_cond_id'),
						'gps_stat_id' => $this->input->post('gps_stat_id'),
						'gps_received_by' => $this->input->post('gps_received_by'),
						'gps_received_date' => $this->input->post('gps_received_date'),
						'gps_information' => $this->input->post('gps_information'),
						'gps_date_check' => $this->input->post('gps_date_check'),
						'status' => 'Received',
						'gps_qty' => '1',
						'gps_insert' => date('Y-m-d H:i:s'),
						'gps_update' => date('Y-m-d H:i:s'),
						'gps_user' => $_SESSION['name']
					);
			$this->GpsModel->insert_data($data);
            
            echo json_encode(array("status" => TRUE));
        }
        else
        {
            echo json_encode(array("validate_status" => TRUE));
        }
    }
	/////////////////////////////////////////////////////////////////// End Proses Save GPS Received ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Validate Form ///////////////////////////////////////////////////////////////
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('gps_purchase_order') == '')
        {
            $data['inputerror'][] = 'gps_purchase_order';
            $data['error_string'][] = 'Date PO GPS is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('no_purchase_order') == '')
        {
            $data['inputerror'][] = 'no_purchase_order';
            $data['error_string'][] = 'Number PO GPS is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('gps_imei_number') == '')
        {
            $data['inputerror'][] = 'gps_imei_number';
            $data['error_string'][] = 'Number IMEI GPS is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('gps_sn') == '')
        {
            $data['inputerror'][] = 'gps_sn';
            $data['error_string'][] = 'Serial Number GPS is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('gps_type_id') == '')
        {
            $data['inputerror'][] = 'gps_type_id';
            $data['error_string'][] = 'Please select Type GPS';
            $data['status'] = FALSE;
        }

        if($this->input->post('vendor_id') == '')
        {
            $data['inputerror'][] = 'vendor_id';
            $data['error_string'][] = 'Please select Vendor';
            $data['status'] = FALSE;
        }

        if($this->input->post('gps_cond_id') == '')
        {
            $data['inputerror'][] = 'gps_cond_id';
            $data['error_string'][] = 'Please select Condition GPS';
            $data['status'] = FALSE;
        }

        if($this->input->post('gps_stat_id') == '')
        {
            $data['inputerror'][] = 'gps_stat_id';
            $data['error_string'][] = 'Please select Status GPS';
            $data['status'] = FALSE;
        }

        if($this->input->post('gps_received_date') == '')
        {
            $data['inputerror'][] = 'gps_received_date';
            $data['error_string'][] = 'GPS Received Date is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('gps_received_by') == '')
        {
            $data['inputerror'][] = 'gps_received_by';
            $data['error_string'][] = 'GPS Received By is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('gps_date_check') == '')
        {
            $data['inputerror'][] = 'gps_date_check';
            $data['error_string'][] = 'GPS Check Date is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
    /////////////////////////////////////////////////////////////////// End Validate Form ///////////////////////////////////////////////////////////////

	/////////////////////////////////////////////////////////////////// Start Get Detail GPS Received ///////////////////////////////////////////////////////////////
	public function ajax_detail($id)
	{
		$data = $this->db->query("SELECT gps.gps_id, gps.gps_purchase_order, gps.gps_date_check, gps.no_purchase_order, gps.gps_imei_number, gps.gps_sn, gps.gps_type_id, gps.vendor_id, gps.gps_cond_id, gps.gps_stat_id, gps.gps_received_date, gps.gps_received_by, gps.gps_information, gps.gps_insert, gps.gps_update, gps.gps_user, 
                               (SELECT gps_type.gps_type_name AS is_gps_type FROM public.gps_type WHERE gps_type.gps_type_id = gps.gps_type_id),
                               (SELECT vendor.vendor_name AS is_vendor FROM public.vendor WHERE vendor.vendor_id = gps.vendor_id),
                               (SELECT gps_conditions.gps_cond_name AS is_gps_conditions FROM public.gps_conditions WHERE gps_conditions.gps_cond_id = gps.gps_cond_id),
                               (SELECT gps_statuses.gps_stat_name AS is_gps_statuses FROM public.gps_statuses WHERE gps_statuses.gps_stat_id = gps.gps_stat_id),
                                gps.status  FROM gps WHERE status='Received' AND gps_id='$id' order by gps_id DESC ")->row();
		echo json_encode($data);
	}
	/////////////////////////////////////////////////////////////////// End Get Detail GPS Received ///////////////////////////////////////////////////////////////

	/////////////////////////////////////////////////////////////////// Start Get Edit GPS Received ///////////////////////////////////////////////////////////////
	public function ajax_edit($id)
	{
		$data = $this->db->get_where('gps',array('gps_id' => $id))->row();
		echo json_encode($data);
	}
	/////////////////////////////////////////////////////////////////// End Get Edit GPS Received ///////////////////////////////////////////////////////////////

	/////////////////////////////////////////////////////////////////// Start Proses Update GPS Received ///////////////////////////////////////////////////////////////
	public function ajax_update()
	{
		$this->_validate();
		
		$id = $this->input->post('id');
		
		$data = array(
				'gps_purchase_order' => $this->input->post('gps_purchase_order'),
				'no_purchase_order' => $this->input->post('no_purchase_order'),
				'gps_imei_number' => $this->input->post('gps_imei_number'),
				'gps_sn' => $this->input->post('gps_sn'),
				'gps_type_id' => $this->input->post('gps_type_id'),
				'gps_cond_id' => $this->input->post('gps_cond_id'),
				'gps_stat_id' => $this->input->post('gps_stat_id'),
				'vendor_id' => $this->input->post('vendor_id'),
				'gps_received_by' => $this->input->post('gps_received_by'),
				'gps_received_date' => $this->input->post('gps_received_date'),
				'gps_date_check' => $this->input->post('gps_date_check'),
				'gps_information' => $this->input->post('gps_information'),
				'status' => 'Received',
				'gps_qty' => '1',
				'gps_update' => date('Y-m-d H:i:s'),
				'gps_user' => $_SESSION['name']
			);
		
		$this->db->where('gps_id', $id);
		$this->db->update('gps', $data);
		
		echo json_encode(array("status" => TRUE));

	}
	/////////////////////////////////////////////////////////////////// End Proses Update GPS Received ///////////////////////////////////////////////////////////////

	/////////////////////////////////////////////////////////////////// Start Proses Delete Department ///////////////////////////////////////////////////////////////
    public function ajax_delete($id)
    {
        $this->GpsModel->delete_data($id);
        echo json_encode(array("status" => TRUE));
    }
	/////////////////////////////////////////////////////////////////// End Proses Delete Department ///////////////////////////////////////////////////////////////
	
	///////////////////////////////////////////////////////////////// Start Import Excel ///////////////////////////////////////////////////////////
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
               	$dataexcel[$i-1]['no_purchase_order'] = $data['cells'][$i][2];
               	$dataexcel[$i-1]['gps_purchase_order'] = $data['cells'][$i][3];
               	$dataexcel[$i-1]['vendor_id'] = $data['cells'][$i][6];
               	$dataexcel[$i-1]['gps_type_id'] = $data['cells'][$i][8];
               	$dataexcel[$i-1]['gps_sn'] = $data['cells'][$i][10];
               	$dataexcel[$i-1]['gps_imei_number'] = $data['cells'][$i][11];
               	$dataexcel[$i-1]['gps_cond_id'] = '1';
               	$dataexcel[$i-1]['gps_stat_id'] = '1';
                $dataexcel[$i-1]['gps_received_by'] = $_SESSION['name'];
            	$dataexcel[$i-1]['gps_information'] = $data['cells'][$i][15];
            	$dataexcel[$i-1]['gps_received_date'] = date('Y-m-d');

            }
    	//cek data
    	$check= $this->GpsModel->search_excel($dataexcel);
	    	if (count($check) > 0)
	    	{
		      	$this->GpsModel->import_excel($dataexcel);
		      	// set pesan
		      	$this->session->set_flashdata('info', 'inserting data success');
	  		}else{
	  			$this->session->set_flashdata('info', 'error');
	  		}
  		}
  		redirect('gps/gps_list');
  	}
	/////////////////////////////////////////////////////////////// End Import Excel ////////////////////////////////////////////////////////////////////////////////

	/////////////////////////////////////////////////////////////// Start Export Excel //////////////////////////////////////////////////////////////////////////////
	public function excel()
    {
    	$ambil_akun = $this->M_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
		if($stat==1){//superadmin
			//$data['sql1'] = $this->GpsModel->getGps()->result_object();
	        $data['sql1'] = $this->GpsModel->getGps()->result_object();
    		$this->load->view('superAdmin-modul/gps/excel_view', $data);
		}elseif ($stat==2) {//admin
			$data['sql1'] = $this->GpsModel->getGps()->result_object();
    		$this->load->view('admin-modul/gps/excel_view', $data);
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
    }
	//////////////////////////////////////////////////////////////// End Export Excel //////////////////////////////////////////////////////////////////////////////
}
