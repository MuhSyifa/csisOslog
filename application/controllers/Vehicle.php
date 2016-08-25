<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library('form_validation','Excel_reader');
		$this->load->model(array('VehicleModel', 'm_login'));
		$this->auth->cek_auth();
	}

	public function index()
	{
		$ambil_akun = $this->M_login->ambil_user($this->session->userdata('uname'));
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

	public function vehicle_excel() 
    {
        $this->load->library(array('excel/Biffwriter', 'excel/Format', 'excel/OLEwriter',
                                    'excel/Parser', 'excel/Workbook', 'excel/Worksheet'));
        
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['vehicle'] = $this->VehicleModel->getData()->result_object();
            $this->load->view('superAdmin-modul/vehicle/vehicle_excel',$data);
        }elseif($stat==2){ //user
            $data['vehicle'] = $this->VehicleModel->getData()->result_object();
            $this->load->view('admin-modul/vehicle/vehicle_excel',$data);
        }else{
            $data['vehicle'] = $this->VehicleModel->getData()->result_object();
            $this->load->view('user-modul/vehicle/vehicle_excel',$data);
        }
    }

    public function vehicle_uninstall_excel()
    {
        $this->load->library(array('excel/Biffwriter', 'excel/Format', 'excel/OLEwriter',
                                    'excel/Parser', 'excel/Workbook', 'excel/Worksheet'));

        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user' => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){
            $data['vehicleUn'] = $this->VehicleModel->getDataUn()->result_object();
            $this->load->view('superAdmin-modul/vehicle/vehicle_excel_uninstall',$data);
        }elseif($stat==2){ //user
            $data['vehicleUn'] = $this->VehicleModel->getDataUn()->result_object();
            $this->load->view('admin-modul/vehicle/vehicle_excel_uninstall',$data);
        }else{
            $data['vehicleUn'] = $this->VehicleModel->getDataUn()->result_object();
            $this->load->view('user-modul/vehicle/vehicle_excel_uninstall',$data);
        }
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
               	$dataexcel[$i-1]['veh_name'] = $data['cells'][$i][1];
               	$dataexcel[$i-1]['veh_type'] = $data['cells'][$i][2];
            }
    	//cek data
    	$check= $this->VehicleModel->search_excel($dataexcel);
    	if (count($check) > 0)
    	{
	      	$this->VehicleModel->import_excel($dataexcel);
	      	// set pesan
	      	$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Importing Data Success</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
	  		}
  		}
  		redirect('vehicle/vehicle_list');
  	}
  	/* End Import Excel */

	public function vehicle_list()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['vehicle'] = $this->VehicleModel->getData()->result_object();
            $data['vehicleUn'] = $this->VehicleModel->getDataUn()->result_object();
            $data['content'] = 'superAdmin-modul/vehicle/vehicle';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['vehicle'] = $this->VehicleModel->getData()->result_object();
            $data['vehicleUn'] = $this->VehicleModel->getDataUn()->result_object();
            $data['content'] = 'admin-modul/vehicle/vehicle';
            $this->load->view('admin-modul/template',$data);
        }elseif($stat==3){
            $data['vehicle'] = $this->VehicleModel->getData()->result_object();
            $data['vehicleUn'] = $this->VehicleModel->getDataUn()->result_object();
            $data['content'] = 'user-modul/vehicle/vehicle';
            $this->load->view('user-modul/template',$data);
        }else{ //user
            $this->session->sess_destroy();
            redirect('login','refresh');
        }
	}

	public function process_insert()
	{
		$h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');

        $data = array(
					'veh_name' => $this->input->post('veh_name'),
					'veh_type' => $this->input->post('veh_type'),
                    'veh_insert' => $i,
                    'veh_update' => $i,
                    'veh_user' => $h
				);
		$this->VehicleModel->insert_data($data);
		$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');	
		redirect('vehicle/vehicle_list','refresh');
	}

    public function detail($id)
    {
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );
        $stat = $this->session->userdata('lvl');
        if($stat==1){//superadmin
            $data['data']   = $this->db->get_where('vehicles',array('veh_id' => $id))->row();
            $data['content'] = 'superAdmin-modul/vehicle/vehicle_detail';
            $this->load->view('superAdmin-modul/template', $data);       
        }elseif ($stat==2) {//admin
            $data['data']   = $this->db->get_where('vehicles',array('veh_id' => $id))->row();
            $data['content'] = 'superAdmin-modul/vehicle/vehicle_detail';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif ($stat==3) {//user
            $data['data']   = $this->db->get_where('vehicles',array('veh_id' => $id))->row();
            $data['content'] = 'superAdmin-modul/vehicle/vehicle_detail';
            $this->load->view('superAdmin-modul/template', $data);
        }else { //user
            $this->session->sess_destroy();
            redirect('login','refresh');
        }        
    }

/////////////////////////////////////////////////////////////////// Start Get Detail GPS Received ///////////////////////////////////////////////////////////////
    public function ajax_detail($id)
    {
        $data = $this->db->get_where('vehicles',array('veh_id' => $id))->row();
        echo json_encode($data);
    }
/////////////////////////////////////////////////////////////////// End Get Detail GPS Received ///////////////////////////////////////////////////////////////

	public function update($id)
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['data']	= $this->db->get_where('vehicles',array('veh_id' => $id))->row();
            $data['content'] = 'superAdmin-modul/vehicle/form_edit';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['data']	= $this->db->get_where('vehicles',array('veh_id' => $id))->row();
            $data['content'] = 'admin-modul/vehicle/form_edit';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['data']	= $this->db->get_where('vehicles',array('veh_id' => $id))->row();
            $data['content'] = 'user-modul/vehicle/form_edit';
            $this->load->view('user-modul/template',$data);
        }
	}

	public function process_update()
	{
		$id['veh_id'] = $this->input->post('veh_id');
        $h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');
		
        $data = array(
					'veh_name' => $this->input->post('veh_name'),
					'veh_type' => $this->input->post('veh_type'),
                    'veh_update' => $i,
                    'veh_user' =>$h
				);
		$this->VehicleModel->update_data($data,$id);
		$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil diupdate!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');	
		redirect('vehicle/vehicle_list');
	}

	public function process_delete($id)
	{
		$this->VehicleModel->delete_data($id);
		$this->session->set_flashdata('info', '<div class="alert alert-info"><strong>Data berhasil dihapus!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
		redirect('vehicle/vehicle_list');
	}
}

/* End of file Customer.php */
/* Location: ./application/controllers/Customer.php */