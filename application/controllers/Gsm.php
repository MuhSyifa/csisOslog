<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gsm extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('VendorModel', 'GsmModel', 'Excel_model', 'm_login'));
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation','Excel_reader','email'));
		$this->auth->cek_auth();
	}

	public function index()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
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

	///////////////////////////////////////////////////// Start Export Excel ///////////////////////////////////////////////////////////////
	public function excelfiles() 
	{
        $this->load->library(array('excel/Biffwriter', 'excel/Format', 'excel/OLEwriter',
        							'excel/Parser', 'excel/Workbook', 'excel/Worksheet'));
        
        $data['data']    = $this->GsmModel->tampil()->result_object();        
        $this->load->view('rptexcel/excelfiles',$data);
    }

    public function excel_active() 
    {
    	$this->load->library(array('excel/Biffwriter', 'excel/Format', 'excel/OLEwriter',
        							'excel/Parser', 'excel/Workbook', 'excel/Worksheet'));
        
        $data['data']    = $this->GsmModel->gsmActive()->result_object();        
        $this->load->view('rptexcel/excelfiles2',$data);
    }

    public function excel_disable() 
    {
        $this->load->library(array('excel/Biffwriter', 'excel/Format', 'excel/OLEwriter',
        							'excel/Parser', 'excel/Workbook', 'excel/Worksheet'));
        
        $data['data']    = $this->GsmModel->gsmDisable()->result_object();        
        $this->load->view('rptexcel/excelfiles3',$data);
    }
	///////////////////////////////////////////////////// End Export Excel ///////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////// Start Import Excel /////////////////////////////////////////////////////////////
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
            $data = $this->excel_reader->sheets[0];
            $dataexcel = Array();
            for ($i = 1; $i <= $data['numRows']; $i++) {
               	if($data['cells'][$i][1] == '') break;
               	$dataexcel[$i-1]['gsm_number'] = $data['cells'][$i][1];
               	$dataexcel[$i-1]['gsm_imsi_number'] = $data['cells'][$i][2];
               	$dataexcel[$i-1]['gsm_iccid_number'] = $data['cells'][$i][3];

            }
    	//cek data
    	$check= $this->GsmModel->search_excel($dataexcel);
    	if (count($check) >= 0)
    	{
	      	$this->GsmModel->import_excel($dataexcel);
	      	// set pesan
	      	$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Importing Data Success</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
	  		}else{
	  		$this->session->set_flashdata('info', '<div class="alert alert-danger"><strong>Importing Data Success</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
	  			
	  		}
  		}
  		redirect('gsm/gsm_list');
  	}
	///////////////////////////////////////////////////// End Import Excel /////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////// Send to Email ///////////////////////////////////////////////////////////////
  	public function email_form()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['content'] = 'superAdmin-modul/gsm/email';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['content'] = 'admin-modul/gsm/email';
            $this->load->view('admin-modul/template',$data);
        }elseif($stat==3){
            $data['content'] = 'user-modul/gsm/email';
            $this->load->view('user-modul/template',$data);
        }else{ //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
	}

	public function email()
	{
		$email = $this->input->post('email');
		$nama = $this->input->post('nama');
		$subjek = $this->input->post('subjek');
		$pesan = $this->input->post('pesan');
	    $url = $_SERVER['HTTP_REFERER'];
	    
	     $config = Array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'ssl://smtp.googlemail.com',
		  'smtp_port' => 465,
		  'smtp_user' => 'buatapapun3@gmail.com', // change it to yours
		  'smtp_pass' => '15Juli1993', // change it to yours
		  'mailtype' => 'html',
		  'charset' => 'iso-8859-1',
		  'wordwrap' => TRUE
		);
	    
	    $this->load->library('email', $config);
	    $this->email->set_newline("\r\n");
	    $this->email->from($email, $nama);
	    $this->email->to($email); //email tujuan. Isikan dengan emailmu!
	    $this->email->subject($subjek);
	    $this->email->message($pesan);
	    
	    if($this->email->send())
	    {
	      $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Email Berhasil Dikirim!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
				redirect('gsm/email_form');
	    }
	    else
	    {
	      show_error($this->email->print_debugger());
	    }	
	}
	///////////////////////////////////////////////////////////////// End Email /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////// Start Input GSM Card Receive /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function ajax_add()
    {
        $gsm_number = $this->input->post('gsm_number');
        
        $query = $this->db->get_where('gsm', array(
                    'gsm_number' => $gsm_number
                ));

        $count = $query->num_rows();

        if($count === 0)
        {
            $this->_validate();

            $data = array(
					'gsm_number' => $gsm_number,
					'gsm_imsi_number' => $this->input->post('gsm_imsi_number'),
					'gsm_iccid_number' => $this->input->post('gsm_iccid_number'),
					'vendor_id' => $this->input->post('vendor_id'),
					'gsm_cond_id' => $this->input->post('gsm_cond_id'),
					'gsm_received_date' => $this->input->post('gsm_received_date'),
					'gsm_received_by' => $this->input->post('gsm_received_by'),
					'status' => 'Received',
					'gsm_insert' => date('Y-m-d H:i:s'),
					'gsm_update' => date('Y-m-d H:i:s'),
					'gsm_user' => $_SESSION['name']
				);
			$this->GsmModel->insert_data($data);
            
            echo json_encode(array("status" => TRUE));
        }
        else
        {
            echo json_encode(array("validate_status" => TRUE));
        }
    }
	///////////////////////////////////////////////////////////////// End Input GSM Card Receive /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
    /////////////////////////////////////////////////////////////////// Start Validate Form ///////////////////////////////////////////////////////////////
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('gsm_number') == '')
        {
            $data['inputerror'][] = 'gsm_number';
            $data['error_string'][] = 'Number GSM is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('gsm_imsi_number') == '')
        {
            $data['inputerror'][] = 'gsm_imsi_number';
            $data['error_string'][] = 'Number IMSI GSM is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('gsm_iccid_number') == '')
        {
            $data['inputerror'][] = 'gsm_iccid_number';
            $data['error_string'][] = 'Number ICCID GSM is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('vendor_id') == '')
        {
            $data['inputerror'][] = 'vendor_id';
            $data['error_string'][] = 'Please select Vendor';
            $data['status'] = FALSE;
        }

        if($this->input->post('gsm_cond_id') == '')
        {
            $data['inputerror'][] = 'gsm_cond_id';
            $data['error_string'][] = 'Please select Condition';
            $data['status'] = FALSE;
        }

        if($this->input->post('gsm_received_date') == '')
        {
            $data['inputerror'][] = 'gsm_received_date';
            $data['error_string'][] = 'GSM Received Date is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('gsm_received_by') == '')
        {
            $data['inputerror'][] = 'gsm_received_by';
            $data['error_string'][] = 'GSM Received By is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
    /////////////////////////////////////////////////////////////////// End Validate Form ///////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////// List Data GSM Card Receive /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function gsm_list()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['data']    = $this->GsmModel->tampil()->result_object();
            $data['content'] = 'superAdmin-modul/gsm/gsm';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['data']    = $this->GsmModel->tampil()->result_object();
            $data['content'] = 'admin-modul/gsm/gsm';
            $this->load->view('admin-modul/template',$data);
        }elseif($stat==3){
            $data['data']    = $this->GsmModel->tampil()->result_object();
            $data['content'] = 'user-modul/gsm/gsm';
            $this->load->view('user-modul/template',$data);
        }else{ //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
	}
	///////////////////////////////////////////////////////////////// End List Data GSM Card Receive /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////// Start Edit GSM Card /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function ajax_edit($id)
	{
		$data = $this->db->query("SELECT vendor.vendor_id, vendor.vendor_name, vendor.vendor_type,
									gsm.gsm_id, gsm.gsm_number, gsm.gsm_imsi_number, gsm.gsm_iccid_number, gsm.vendor_id,
									gsm.gsm_cond_id, gsm.gsm_received_by, gsm.gsm_received_date, gsm.gsm_activated_by, gsm.gsm_activated_date,
									gsm.gsm_install_by, gsm.gsm_install_date, gsm.gsm_uninstall_by, gsm.gsm_uninstall_date, gsm.gsm_disable_by, gsm.gsm_disable_date,
									gsm.status, gsm.gsm_insert, gsm.gsm_update, gsm.gsm_user 
									FROM gsm
									JOIN vendor
									ON gsm.vendor_id=vendor.vendor_id
									WHERE status='Received' AND gsm_id='$id' ")->row();
		echo json_encode($data);
	}
	///////////////////////////////////////////////////////////////// End Edit GSM Card /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////// Start Proses Update GSM Card /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function ajax_update()
	{
		$this->_validate();

		$id = $this->input->post('id');
		$data = array(
				'gsm_number' => $this->input->post('gsm_number'),
				'gsm_imsi_number' => $this->input->post('gsm_imsi_number'),
				'gsm_iccid_number' => $this->input->post('gsm_iccid_number'),
				'vendor_id' => $this->input->post('vendor_id'),
				'gsm_cond_id' => $this->input->post('gsm_cond_id'),
				'gsm_received_date' => $this->input->post('gsm_received_date'),
				'gsm_received_by' => $this->input->post('gsm_received_by'),
				'gsm_update' => date('Y-m-d H:i:s'),
				'gsm_user' => $_SESSION['name']
			);
		
		$this->db->where('gsm_id', $id);
		$this->db->update('gsm', $data);

		echo json_encode(array("status" => TRUE));
	}
	///////////////////////////////////////////////////////////////// End Proses Update GSM Card /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////// Start Get GSM Card Activated /////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	public function ajax_active($id)
	{
		$data = $this->db->get_where('gsm',array('gsm_id' => $id))->row();
		echo json_encode($data);
	}
	///////////////////////////////////////////////////////////////// End Get GSM Card Activated /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////// Start Proses Activated GSM Card /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function ajax_active_proses()
	{
		//$this->_validate();
		
		$id = $this->input->post('id');
		$data = array(
				'gsm_activated_date' => $this->input->post('gsm_activated_date'),
				'gsm_activated_by' => $this->input->post('gsm_activated_by'),
				'status' => 'Activated',
				'gsm_update' => date('Y-m-d H:i:s'),
				'gsm_user' => $_SESSION['name']
			);
		
		$this->db->where('gsm_id', $id);
		$this->db->update('gsm', $data);
		
		//echo json_encode(array("status" => TRUE));

		if ($this->db->affected_rows()) 
		{
			$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>GSM Sudah Berhasil Diaktifasi!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
			redirect('gsm/gsm_active_list');
		}
		else
		{
			$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>GSM Gagal Diaktifasi</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
			redirect('gsm/gsm_list');	
		}
	}
	///////////////////////////////////////////////////////////////// End Proses Activated GSM Card /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////// Start Detail GSM Card Receive /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function ajax_detail($id)
	{
		//$data = $this->db->get_where('gsm',array('gsm_id' => $id))->row();
		$data = $this->db->query("SELECT vendor.vendor_id, vendor.vendor_name, vendor.vendor_type,
									gsm.gsm_id, gsm.gsm_number, gsm.gsm_imsi_number, gsm.gsm_iccid_number, gsm.vendor_id,
									gsm.gsm_cond_id, gsm.gsm_received_by, gsm.gsm_received_date, gsm.gsm_activated_by, gsm.gsm_activated_date,
									gsm.gsm_install_by, gsm.gsm_install_date, gsm.gsm_uninstall_by, gsm.gsm_uninstall_date, gsm.gsm_disable_by, gsm.gsm_disable_date,
									gsm.status, gsm.gsm_insert, gsm.gsm_update, gsm.gsm_user 
									FROM gsm
									JOIN vendor
									ON gsm.vendor_id=vendor.vendor_id
									WHERE status='Received' AND gsm_id='$id' ")->row();
		echo json_encode($data);
	}
	///////////////////////////////////////////////////////////////// End Detail GSM Card Receive /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////// Start Detail GSM Card Activated /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function ajax_detail_active($id)
	{
		//$data = $this->db->get_where('gsm',array('gsm_id' => $id))->row();
		$data = $this->db->query("SELECT vendor.vendor_id, vendor.vendor_name, vendor.vendor_type,
									gsm.gsm_id, gsm.gsm_number, gsm.gsm_imsi_number, gsm.gsm_iccid_number, gsm.vendor_id,
									gsm.gsm_cond_id, gsm.gsm_received_by, gsm.gsm_received_date, gsm.gsm_activated_by, gsm.gsm_activated_date,
									gsm.gsm_install_by, gsm.gsm_install_date, gsm.gsm_uninstall_by, gsm.gsm_uninstall_date, gsm.gsm_disable_by, gsm.gsm_disable_date,
									gsm.status, gsm.gsm_insert, gsm.gsm_update, gsm.gsm_user 
									FROM gsm
									JOIN vendor
									ON gsm.vendor_id=vendor.vendor_id
									WHERE status='Activated' AND gsm_id='$id' ")->row();
		echo json_encode($data);
	}
	///////////////////////////////////////////////////////////////// End Detail GSM Card Activated /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////// Start Proses Activated Selected GSM Card /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function activeAll()
	{	
			if ($this->input->post('activate')) 
			{
			 	$linksCount = count($this->input->post('check_id'));
				$data = [];
				if($linksCount){
					for($i=0; $i<$linksCount; $i++){
						echo $i.' : ';
						echo $this->input->post('check_id')[$i].' - ';
						$data[$i]['gsm_id'] = $this->input->post('check_id')[$i];
						$data[$i]['gsm_activated_by'] = $_SESSION['uname'];
						$data[$i]['gsm_activated_date'] = date("Y-m-d");
						$data[$i]['status'] = 'Activated';
					}
				
					if($this->db->update_batch('gsm', $data, 'gsm_id')){
						$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Sudah Berhasil di Aktivasi!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
						redirect('gsm/gsm_list');
					}else
					{
						$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Gagal di Aktivasi</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
						redirect('gsm/gsm_list');	
					}		    
				}
			}
			elseif ($this->input->post('send'))
			{
			  	$linksCount = count($this->input->post('check_id'));
				$data = [];
				if($linksCount){
					for($i=0; $i<$linksCount; $i++){
						$datas['gsm_id'][$i] = $this->input->post('check_id')[$i];
						$dgms_id = $datas['gsm_id'][$i];
						$datas['get_data'][$i]	= $this->db->query("SELECT * from gsm WHERE gsm_id in ($dgms_id) ")->row();
						$datas['content'] = 'superAdmin-modul/gsm/email_edit';

						/*$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
						$data = array(
							'user'	=> $ambil_akun,
							);

						$stat = $this->session->userdata('lvl');
				        if($stat==1){//admin
				            $datas['content'] = 'superAdmin-modul/gsm/email_edit';
				        }elseif($stat==2){ //user
				            $datas['content'] = 'gsm/email_edit';
				        }else{
				            $datas['content'] = 'user-modul/gsm/email_edit';
				        }*/
					}
					$this->load->view('admin-modul/template', $datas);		    
				}
			}
			else
			{
				redirect('gsm/gsm_list');
			}
	}
	///////////////////////////////////////////////////////////////// End Proses Activated Selected GSM Card /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////// Start List GSM Card Active /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function gsm_active_list()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['data']    = $this->GsmModel->gsmActive()->result_object();
            $data['content'] = 'superAdmin-modul/gsm/gsm_active';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['data']    = $this->GsmModel->gsmActive()->result_object();
            $data['content'] = 'admin-modul/gsm/gsm_active';
            $this->load->view('admin-modul/template',$data);
        }elseif($stat==3){
            $data['data']    = $this->GsmModel->gsmActive()->result_object();
            $data['content'] = 'user-modul/gsm/gsm_active';
            $this->load->view('user-modul/template',$data);
        }else{ //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
	}
	///////////////////////////////////////////////////////////////// End List GSM Card Active /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////// Start List GSM Card Disable /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function gsm_disable_list()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
	    if($stat==1){//admin
	        $data['data']    = $this->GsmModel->gsmDisable()->result_object();
	        $data['content'] = 'superAdmin-modul/gsm/gsm_disable';
	        $this->load->view('superAdmin-modul/template', $data);
	    }elseif($stat==2){ //user
	        $data['data']    = $this->GsmModel->gsmDisable()->result_object();
	        $data['content'] = 'admin-modul/gsm/gsm_disable';
	        $this->load->view('admin-modul/template',$data);
	    }elseif($stat==3){
	        $data['data']    = $this->GsmModel->gsmDisable()->result_object();
	        $data['content'] = 'user-modul/gsm/gsm_disable';
	        $this->load->view('user-modul/template',$data);
	    }else{ //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
	}
	///////////////////////////////////////////////////////////////// End List GSM Card Disable /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////// Start Get GSM Card Disable /////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	public function ajax_disable($id)
	{
		$data = $this->db->get_where('gsm',array('gsm_id' => $id))->row();
		echo json_encode($data);
	}
	///////////////////////////////////////////////////////////////// End Get GSM Card Disable /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////// Start Proses Disable GSM Card /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function ajax_disable_proses()
	{
		//$this->_validate();
		$id = $this->input->post('id');
		$data = array(
				'gsm_disable_date' => $this->input->post('gsm_disable_date'),
				'gsm_disable_by' => $this->input->post('gsm_disable_by'),
				'status' => 'Disable',
				'gsm_update' => date('Y-m-d H:i:s'),
				'gsm_user' => $_SESSION['name']
			);
		
		$this->db->where('gsm_id', $id);
		$this->db->update('gsm', $data);
		//echo json_encode(array("status" => TRUE));

		if ($this->db->affected_rows()) 
		{
			$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>GSM Sudah Berhasil Dinonaktifkan!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
			redirect('gsm/gsm_disable_list');
		}
		else
		{
			$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>GSM Gagal Dinonaktifkan!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
			redirect('gsm/gsm_active_list');	
		}
	}
	///////////////////////////////////////////////////////////////// End Proses Disable GSM Card /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////////////////////////////////////////// Start Detail GSM Card Disable /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function ajax_detail_disable($id)
	{
		//$data = $this->db->get_where('gsm',array('gsm_id' => $id))->row();
		$data = $this->db->query("SELECT vendor.vendor_id, vendor.vendor_name, vendor.vendor_type,
									gsm.gsm_id, gsm.gsm_number, gsm.gsm_imsi_number, gsm.gsm_iccid_number, gsm.vendor_id,
									gsm.gsm_cond_id, gsm.gsm_received_by, gsm.gsm_received_date, gsm.gsm_activated_by, gsm.gsm_activated_date,
									gsm.gsm_install_by, gsm.gsm_install_date, gsm.gsm_uninstall_by, gsm.gsm_uninstall_date, gsm.gsm_disable_by, gsm.gsm_disable_date,
									gsm.status, gsm.gsm_insert, gsm.gsm_update, gsm.gsm_user 
									FROM gsm
									JOIN vendor
									ON gsm.vendor_id=vendor.vendor_id
									WHERE status='Disable' AND gsm_id='$id' ")->row();
		echo json_encode($data);
	}
	///////////////////////////////////////////////////////////////// End Detail GSM Card Disable /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/////////////////////////////////////////////////////////////////// Start Proses Delete GSM ///////////////////////////////////////////////////////////////
    public function ajax_delete($id)
    {
        $this->GsmModel->delete($id);
        echo json_encode(array("status" => TRUE));
    }
    /////////////////////////////////////////////////////////////////// End Proses Delete GSM ///////////////////////////////////////////////////////////////

    public function gsm_dashboard()
    {
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['vendorStock']    = $this->GsmModel->vendorDashboard()->result_object();
            $data['data']    = $this->GsmModel->tampil()->result_object();
            $data['content'] = 'superAdmin-modul/gsm/gsm_dashboard';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['vendorStock']    = $this->VendorModel->vendorDashboard()->result_object();
            $data['data']    = $this->GsmModel->tampil()->result_object();
            $data['content'] = 'admin-modul/gsm/gsm_dashboard';
            $this->load->view('admin-modul/template',$data);
        }elseif($stat==3){
            $data['activeStock']    = $this->GsmModel->activeDashboard()->result_object();
            $data['nonactiveStock']    = $this->GsmModel->nonactiveDashboard()->result_object();
           	$data['data']    = $this->GsmModel->tampil()->result_object();
            $data['content'] = 'user-modul/gsm/gsm_dashboard';
            $this->load->view('user-modul/template',$data);
        }else{ //user
            $this->session->sess_destroy();
            redirect('login','refresh');
        }
    }

    public function gsm_active_dashboard()
    {
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['vendorStock']    = $this->GsmModel->vendorDashboard()->result_object();
            $data['data']    = $this->GsmModel->tampil()->result_object();
            $data['content'] = 'superAdmin-modul/gsm/gsm_dashboard';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['vendorStock']    = $this->VendorModel->vendorDashboard()->result_object();
            $data['data']    = $this->GsmModel->tampil()->result_object();
            $data['content'] = 'admin-modul/gsm/gsm_dashboard';
            $this->load->view('admin-modul/template',$data);
        }elseif($stat==3){
            $data['gsmActiveStock']    = $this->GsmModel->gsmActiveDashboard()->result_object();
            $data['gsmNonactiveStock']    = $this->GsmModel->gsmNonactiveDashboard()->result_object();
           	$data['data']    = $this->GsmModel->gsmActive()->result_object();
            $data['content'] = 'user-modul/gsm/gsm_active_dashboard';
            $this->load->view('user-modul/template',$data);
        }else{ //user
            $this->session->sess_destroy();
            redirect('login','refresh');
        }
    }

    public function gsm_disable_dashboard()
    {
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['vendorStock']    = $this->GsmModel->vendorDashboard()->result_object();
            $data['data']    = $this->GsmModel->tampil()->result_object();
            $data['content'] = 'superAdmin-modul/gsm/gsm_dashboard';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['vendorStock']    = $this->VendorModel->vendorDashboard()->result_object();
            $data['data']    = $this->GsmModel->tampil()->result_object();
            $data['content'] = 'admin-modul/gsm/gsm_dashboard';
            $this->load->view('admin-modul/template',$data);
        }elseif($stat==3){
            $data['disableActiveStock']    = $this->GsmModel->disableActiveDashboard()->result_object();
            $data['disableNonactiveStock']    = $this->GsmModel->disableNonactiveDashboard()->result_object();
           	$data['data']    = $this->GsmModel->gsmDisable()->result_object();
            $data['content'] = 'user-modul/gsm/gsm_disable_dashboard';
            $this->load->view('user-modul/template',$data);
        }else{ //user
            $this->session->sess_destroy();
            redirect('login','refresh');
        }
    }
}