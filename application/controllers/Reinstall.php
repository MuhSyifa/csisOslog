<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reinstall extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->library(array('form_validation','Excel_reader'));
		$this->load->model(array('ReinstallModel','m_login'));
		$this->load->database();
		$this->auth->cek_auth();
	}

	public function reinstall_list()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['reinstall'] = $this->ReinstallModel->getReinstall()->result_object();
            $data['content'] = 'superAdmin-modul/reinstall/reinstall';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['reinstall'] = $this->ReinstallModel->getReinstall()->result_object();
            $data['content'] = 'admin-modul/reinstall/reinstall';
            $this->load->view('admin-modul/template',$data);
        }elseif($stat==3){
            $data['reinstall'] = $this->ReinstallModel->getReinstall()->result_object();
            $data['content'] = 'user-modul/reinstall/reinstall';
            $this->load->view('user-modul/template',$data);
        }else{ //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
	}

	/*public function read($id)
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
		if($stat==1){//superadmin
			$data['content'] = 'superAdmin-modul/reinstall/reinstall_detail';
			$data['data'] 	 = $this->db->query("SELECT order_details.odet_id,orders.order_type_number, 
									orders.order_number, orders.order_date, 
									customer.cust_code, employees.emp_name,orders.order_location, 
									gps.gps_imei_number,  gsm.gsm_number, vehicles.veh_number_police,
									vehicles.veh_name, vehicles.veh_install_type_business, vehicles.veh_expiry_date, 
									odet_work_date, odet_status, odet_insert, odet_update, odet_user
									FROM order_details
									JOIN orders
									ON order_details.order_id=orders.order_id
									JOIN gps
									ON order_details.gps_id=gps.gps_id
									JOIN gsm
									ON order_details.gsm_id=gsm.gsm_id
									JOIN vehicles
									ON order_details.veh_id=vehicles.veh_id
									JOIN customer
									ON orders.cust_id=customer.cust_id
									JOIN employees
									ON orders.emp_id=employees.emp_id
									WHERE odet_status = 'Installed' AND odet_id='$id' ")->row();
			$this->load->view('superAdmin-modul/template', $data);
		}elseif ($stat==2) {//admin
			$data['content'] = 'admin-modul/reinstall/reinstall_detail';
			$data['data'] 	 = $this->db->query("SELECT order_details.odet_id,orders.order_type_number, 
									orders.order_number, orders.order_date, 
									customer.cust_code, employees.emp_name,orders.order_location, 
									gps.gps_imei_number,  gsm.gsm_number, vehicles.veh_number_police,
									vehicles.veh_name, vehicles.veh_install_type_business, vehicles.veh_expiry_date,
									odet_work_date, odet_status, odet_insert, odet_update, odet_user
									FROM order_details
									JOIN orders
									ON order_details.order_id=orders.order_id
									JOIN gps
									ON order_details.gps_id=gps.gps_id
									JOIN gsm
									ON order_details.gsm_id=gsm.gsm_id
									JOIN vehicles
									ON order_details.veh_id=vehicles.veh_id
									JOIN customer
									ON orders.cust_id=customer.cust_id
									JOIN employees
									ON orders.emp_id=employees.emp_id
									WHERE odet_status = 'Installed' AND odet_id='$id' ")->row();
			$this->load->view('admin-modul/template', $data);
		}elseif ($stat==3) {//user
			$data['content'] = 'user-modul/reinstall/reinstall_detail';
			$data['data'] 	 = $this->db->query("SELECT order_details.odet_id,orders.order_type_number, 
									orders.order_number, orders.order_date, 
									customer.cust_code, employees.emp_name,orders.order_location, 
									gps.gps_imei_number,  gsm.gsm_number, vehicles.veh_number_police,
									vehicles.veh_name, vehicles.veh_install_type_business, vehicles.veh_expiry_date,
									odet_work_date, odet_status, odet_insert, odet_update, odet_user
									FROM order_details
									JOIN orders
									ON order_details.order_id=orders.order_id
									JOIN gps
									ON order_details.gps_id=gps.gps_id
									JOIN gsm
									ON order_details.gsm_id=gsm.gsm_id
									JOIN vehicles
									ON order_details.veh_id=vehicles.veh_id
									JOIN customer
									ON orders.cust_id=customer.cust_id
									JOIN employees
									ON orders.emp_id=employees.emp_id
									WHERE odet_status = 'Installed' AND odet_id='$id' ")->row();
			$this->load->view('user-modul/template', $data);
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
	}*/

	public function ajax_detail($id)
	{
		$data = $this->db->query("SELECT order_details.odet_id,orders.order_type_number, 
									orders.order_number, orders.order_date, 
									customer.cust_code, employee.emp_name,orders.order_location, 
									gps.gps_imei_number,  gsm.gsm_number, vehicles.veh_number_police,
									vehicles.veh_name, vehicles.veh_install_type_business, vehicles.veh_expiry_date,
									odet_work_date, odet_status, odet_insert, odet_update, odet_user
									FROM order_details
									JOIN orders
									ON order_details.order_id=orders.order_id
									JOIN gps
									ON order_details.gps_id=gps.gps_id
									JOIN gsm
									ON order_details.gsm_id=gsm.gsm_id
									JOIN vehicles
									ON order_details.veh_id=vehicles.veh_id
									JOIN customer
									ON orders.cust_id=customer.cust_id
									JOIN employee
									ON orders.emp_id=employee.emp_id
									WHERE odet_status = 'Installed' AND odet_id='$id' ")->row();
		echo json_encode($data);
	}

	/*public function add($id,$tipe)
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
		if($stat==1){//superadmin
			//$tipe = $this->db->query("SELECT * FROM vehicles where veh_install_type_business='Fixed Installation' ")->result_array();
			//$type = $tipe;
			if($tipe==1)
            {
				$data['content'] = 'superAdmin-modul/reinstall/form_add';
				$data['data']   = $this->db->query("SELECT order_details.odet_id,orders.order_type_number, 
										orders.order_number, orders.order_date, 
										customer.cust_code, employees.emp_name,orders.order_location, 
										gps.gps_imei_number,  gsm.gsm_number, vehicles.veh_number_police, vehicles.veh_install_type_business, 
										odet_work_date, odet_status
										FROM order_details
										JOIN orders
										ON order_details.order_id=orders.order_id
										JOIN gps
										ON order_details.gps_id=gps.gps_id
										JOIN gsm
										ON order_details.gsm_id=gsm.gsm_id
										JOIN vehicles
										ON order_details.veh_id=vehicles.veh_id
										JOIN customer
										ON orders.cust_id=customer.cust_id
										JOIN employees
										ON orders.emp_id=employees.emp_id
										WHERE odet_status = 'Installed' AND odet_id='$id' ")->row();
				//$data['data']	= $this->db->get_where('orders',array('order_id' => $id))->row();
				$this->load->view('superAdmin-modul/template', $data);
			}
			elseif($tipe==2)
            {
            	$data['content'] = 'superAdmin-modul/reinstall/form_add_trial';
				$data['data']   = $this->db->query("SELECT order_details.odet_id,orders.order_type_number, 
										orders.order_number, orders.order_date, 
										customer.cust_code, employees.emp_name,orders.order_location, 
										gps.gps_imei_number,  gsm.gsm_number, vehicles.veh_number_police, vehicles.veh_install_type_business, 
										odet_work_date, odet_status
										FROM order_details
										JOIN orders
										ON order_details.order_id=orders.order_id
										JOIN gps
										ON order_details.gps_id=gps.gps_id
										JOIN gsm
										ON order_details.gsm_id=gsm.gsm_id
										JOIN vehicles
										ON order_details.veh_id=vehicles.veh_id
										JOIN customer
										ON orders.cust_id=customer.cust_id
										JOIN employees
										ON orders.emp_id=employees.emp_id
										WHERE odet_status = 'Installed' AND odet_id='$id' ")->row();
				//$data['data']	= $this->db->get_where('orders',array('order_id' => $id))->row();
				$this->load->view('superAdmin-modul/template', $data);	
            }
		}elseif ($stat==2) {//admin
			if($tipe==1)
            {
				$data['content'] = 'admin-modul/reinstall/form_add';
				$data['data']   = $this->db->query("SELECT order_details.odet_id,orders.order_type_number, 
										orders.order_number, orders.order_date, 
										customer.cust_code, employees.emp_name,orders.order_location, 
										gps.gps_imei_number,  gsm.gsm_number, vehicles.veh_number_police, vehicles.veh_install_type_business, 
										odet_work_date, odet_status
										FROM order_details
										JOIN orders
										ON order_details.order_id=orders.order_id
										JOIN gps
										ON order_details.gps_id=gps.gps_id
										JOIN gsm
										ON order_details.gsm_id=gsm.gsm_id
										JOIN vehicles
										ON order_details.veh_id=vehicles.veh_id
										JOIN customer
										ON orders.cust_id=customer.cust_id
										JOIN employees
										ON orders.emp_id=employees.emp_id
										WHERE odet_status = 'Installed' AND odet_id='$id' ")->row();
				//$data['data']	= $this->db->get_where('orders',array('order_id' => $id))->row();
				$this->load->view('admin-modul/template', $data);
			}
			elseif($tipe==2)
            {
            	$data['content'] = 'admin-modul/reinstall/form_add_trial';
				$data['data']   = $this->db->query("SELECT order_details.odet_id,orders.order_type_number, 
										orders.order_number, orders.order_date, 
										customer.cust_code, employees.emp_name,orders.order_location, 
										gps.gps_imei_number,  gsm.gsm_number, vehicles.veh_number_police, vehicles.veh_install_type_business, 
										odet_work_date, odet_status
										FROM order_details
										JOIN orders
										ON order_details.order_id=orders.order_id
										JOIN gps
										ON order_details.gps_id=gps.gps_id
										JOIN gsm
										ON order_details.gsm_id=gsm.gsm_id
										JOIN vehicles
										ON order_details.veh_id=vehicles.veh_id
										JOIN customer
										ON orders.cust_id=customer.cust_id
										JOIN employees
										ON orders.emp_id=employees.emp_id
										WHERE odet_status = 'Installed' AND odet_id='$id' ")->row();
				//$data['data']	= $this->db->get_where('orders',array('order_id' => $id))->row();
				$this->load->view('admin-modul/template', $data);	
            }
		}elseif ($stat==3) {//user
			if($tipe==1)
            {
				$data['content'] = 'user-modul/reinstall/form_add';
				$data['data']   = $this->db->query("SELECT order_details.odet_id,orders.order_type_number, 
										orders.order_number, orders.order_date, 
										customer.cust_code, employees.emp_name,orders.order_location, 
										gps.gps_imei_number,  gsm.gsm_number, vehicles.veh_number_police, vehicles.veh_install_type_business, 
										odet_work_date, odet_status
										FROM order_details
										JOIN orders
										ON order_details.order_id=orders.order_id
										JOIN gps
										ON order_details.gps_id=gps.gps_id
										JOIN gsm
										ON order_details.gsm_id=gsm.gsm_id
										JOIN vehicles
										ON order_details.veh_id=vehicles.veh_id
										JOIN customer
										ON orders.cust_id=customer.cust_id
										JOIN employees
										ON orders.emp_id=employees.emp_id
										WHERE odet_status = 'Installed' AND odet_id='$id' ")->row();
				//$data['data']	= $this->db->get_where('orders',array('order_id' => $id))->row();
				$this->load->view('user-modul/template', $data);
			}
			elseif($tipe==2)
            {
            	$data['content'] = 'user-modul/reinstall/form_add_trial';
				$data['data']   = $this->db->query("SELECT order_details.odet_id,orders.order_type_number, 
										orders.order_number, orders.order_date, 
										customer.cust_code, employees.emp_name,orders.order_location, 
										gps.gps_imei_number,  gsm.gsm_number, vehicles.veh_number_police, vehicles.veh_install_type_business, 
										odet_work_date, odet_status
										FROM order_details
										JOIN orders
										ON order_details.order_id=orders.order_id
										JOIN gps
										ON order_details.gps_id=gps.gps_id
										JOIN gsm
										ON order_details.gsm_id=gsm.gsm_id
										JOIN vehicles
										ON order_details.veh_id=vehicles.veh_id
										JOIN customer
										ON orders.cust_id=customer.cust_id
										JOIN employees
										ON orders.emp_id=employees.emp_id
										WHERE odet_status = 'Installed' AND odet_id='$id' ")->row();
				//$data['data']	= $this->db->get_where('orders',array('order_id' => $id))->row();
				$this->load->view('user-modul/template', $data);	
            }
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}		
	}*/

	public function ajax_add($id,$type)
    {
        if($type==1)
        {
            $data = $this->db->query("SELECT order_details.odet_id,orders.order_type_number, 
										orders.order_number, orders.order_date, 
										customer.cust_code, employee.emp_name,orders.order_location, 
										gps.gps_imei_number,  gsm.gsm_number, vehicles.veh_number_police, vehicles.veh_install_type_business, 
										odet_work_date, odet_status
										FROM order_details
										JOIN orders
										ON order_details.order_id=orders.order_id
										JOIN gps
										ON order_details.gps_id=gps.gps_id
										JOIN gsm
										ON order_details.gsm_id=gsm.gsm_id
										JOIN vehicles
										ON order_details.veh_id=vehicles.veh_id
										JOIN customer
										ON orders.cust_id=customer.cust_id
										JOIN employee
										ON orders.emp_id=employee.emp_id
										WHERE odet_status = 'Installed' AND odet_id='$id' ")->row();
            echo json_encode($data);
        }
        elseif($type==2)
        {
            $data = $this->db->query("SELECT order_details.odet_id,orders.order_type_number, 
										orders.order_number, orders.order_date, 
										customer.cust_code, employee.emp_name,orders.order_location, 
										gps.gps_imei_number,  gsm.gsm_number, vehicles.veh_number_police, vehicles.veh_install_type_business, 
										odet_work_date, odet_status
										FROM order_details
										JOIN orders
										ON order_details.order_id=orders.order_id
										JOIN gps
										ON order_details.gps_id=gps.gps_id
										JOIN gsm
										ON order_details.gsm_id=gsm.gsm_id
										JOIN vehicles
										ON order_details.veh_id=vehicles.veh_id
										JOIN customer
										ON orders.cust_id=customer.cust_id
										JOIN employee
										ON orders.emp_id=employee.emp_id
										WHERE odet_status = 'Installed' AND odet_id='$id' ")->row();
            echo json_encode($data);    
        }       
    }

	public function process_order_install()
	{	
		// Insert in Order
		$order = array(
				'order_type_number' => $this->input->post('order_type_number'),
				'order_number' => $this->input->post('order_number'),
				'cust_id' => $this->input->post('cust_id'),
				'emp_id' => $this->input->post('emp_id'),
				'order_date' => $this->input->post('order_date'),
				'order_location' => $this->input->post('order_location'),
				//'order_status' => 'Success',
				'order_qty' => '1',
				'order_insert' => date('Y-m-d H:i:s'),
				'order_update' => date('Y-m-d H:i:s'),
				'order_user' => $_SESSION['name']
		);
		$this->db->insert('orders', $order);
		
		$this->db->select_max('order_id');
		$query = $this->db->get('orders');
		
		// GET id Desc In Order
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$lastId = $row->order_id;
			$newOrderId = $lastId + 1;
			// echo $newId;
		}
		
		// Insert In Order Detail
		$orderDetail = array(
				'order_id' => $lastId,
				'gsm_id' => $this->input->post('gsm_id'),
				'gps_id' => $this->input->post('gps_id'),
				'veh_id' => $this->input->post('veh_id'),
				'odet_work_date' => $this->input->post('order_date'),
				'odet_work_by' => $this->input->post('emp_id'),
				'odet_qty' => '1',
				'odet_status' => 'Installed',
				'odet_insert' => date('Y-m-d H:i:s'),
				'odet_update' => date('Y-m-d H:i:s'),
				'odet_user' => $_SESSION['name']
		); 
		
		$this->db->insert('order_details', $orderDetail);
				
		//update status gsm received to installed
		$gsm = $this->input->post('gsm_id');

		$objectgsm = array('status' => 'Installed');

		$this->db->where('gsm_id', $gsm);
		$this->db->update('gsm', $objectgsm);

		//update status gps received to installed
		$gps = $this->input->post('gps_id');

		$objectgps = array('status' => 'Installed');

		$this->db->where('gps_id', $gps);
		$this->db->update('gps', $objectgps);

		//update status gps received to installed
		$veh = $this->input->post('veh_id');
		
		$objectveh = array('veh_status' => 'Installed',
							'veh_install_date' => $this->input->post('order_date'),
							'veh_install_type_business' => '1'
						);

		$this->db->where('veh_id', $veh);
		$this->db->update('vehicles', $objectveh);		

		//echo json_encode(array("status" => TRUE));

		if ($this->db->affected_rows()) 
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('reinstall/reinstall_list');
        }
        else
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data Gagal disimpan!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('reinstall/reinstall_list');   
        }
	}

	public function process_order_install_trial()
	{
		// Insert to Order
		$order = array(
				'order_type_number' => $this->input->post('order_type_number'),
				'order_number' => $this->input->post('order_number'),
				'cust_id' => $this->input->post('cust_id'),
				'emp_id' => $this->input->post('emp_id'),
				'order_date' => $this->input->post('order_date'),
				'order_location' => $this->input->post('order_location'),
				'order_qty' => '1',
				'order_insert' => date('Y-m-d H:i:s'),
				'order_update' => date('Y-m-d H:i:s'),
				'order_user' => $_SESSION['name']
		);

		$this->db->insert('orders', $order);

		// Get Id Desc In Order
		$this->db->select_max('order_id');
		$query = $this->db->get('orders');
		
		if ($query->num_rows() > 0) {
		
			$row = $query->row();
			$lastId = $row->order_id;
			$newOrderId = $lastId + 1;
			// echo $newId;
		}

		// Insert Order Detail
		$orderDetail = array(
				'order_id' => $lastId,
				'gsm_id' => $this->input->post('gsm_id'),
				'gps_id' => $this->input->post('gps_id'),
				'veh_id' => $this->input->post('veh_id'),
				'odet_work_date' => $this->input->post('order_date'),
				'odet_work_by' => $this->input->post('emp_id'),
				'odet_qty' => '1',
				'odet_status' => 'Installed',
				'odet_insert' => date('Y-m-d H:i:s'),
				'odet_update' => date('Y-m-d H:i:s'),
				'odet_user' => $_SESSION['name']
		);

		$this->db->insert('order_details', $orderDetail);
				
		//update status gsm received to installed
		$gsm = $this->input->post('gsm_id');
		
		$objectgsm = array('status' => 'Installed');

		$this->db->where('gsm_id', $gsm);
		$this->db->update('gsm', $objectgsm);

		//update status gps received to installed
		$gps = $this->input->post('gps_id');

		$objectgps = array('status' => 'Installed');

		$this->db->where('gps_id', $gps);
		$this->db->update('gps', $objectgps);

		//update status gps received to installed
		$veh = $this->input->post('veh_id');

		$objectveh = array('veh_status' => 'Installed',
							'veh_install_date' => $this->input->post('order_date'),
							'veh_install_type_business' => '2',
							'veh_expiry_date' => $this->input->post('order_veh_expiry_date')
						);

		$this->db->where('veh_id', $veh);
		$this->db->update('vehicles', $objectveh);	

		//echo json_encode(array("status" => TRUE));

		if ($this->db->affected_rows()) 
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('reinstall/reinstall_list');
        }
        else
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data Gagal disimpan!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('reinstall/reinstall_list');   
        }			
	}

	public function excel_order_install()
	{
		$ambil_akun = $this->M_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
		if($stat==1){//superadmin
	        $data['sql1'] = $this->OrderModel->getInstall()->result_object();
    		$this->load->view('superAdmin-modul/order/excel_export_install', $data);
		}elseif ($stat==2) {//admin
			$data['sql1'] = $this->OrderModel->getInstall()->result_object();
    		$this->load->view('admin-modul/order/excel_export_install', $data);
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
	}
##################################################################################################################
//Uninstalled
##################################################################################################################

	/*public function uninstall_list()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['uninstall'] = $this->OrderModel->getUninstall()->result_object();
            $data['content'] = 'superAdmin-modul/order/uninstall_list';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['uninstall'] = $this->OrderModel->getUninstall()->result_object();
            $data['content'] = 'admin-modul/order/uninstall_list';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['uninstall'] = $this->OrderModel->getUninstall()->result_object();
            $data['content'] = 'user-modul/order/uninstall_list';
            $this->load->view('user-modul/template',$data);
        }
	}*/

	/*public function uninstall_read($id)
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
		if($stat==1){//superadmin
			$data['content'] = 'superAdmin-modul/order/uninstall_read';
			$data['data']	= $this->db->get_where('order_details',array('odet_id' => $id))->row();
			$this->load->view('superAdmin-modul/template', $data);
		}elseif ($stat==2) {//admin
			$data['content'] = 'admin-modul/order/uninstall_read';
			$data['data']	= $this->db->get_where('order_details',array('odet_id' => $id))->row();
			$this->load->view('admin-modul/template', $data);
		}elseif ($stat==3) {//user
			$data['content'] = 'user-modul/order/uninstall_read';
			$data['data']	= $this->db->get_where('order_details',array('odet_id' => $id))->row();
			$this->load->view('user-modul/template', $data);
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
	}*/

	public function ajax_uninstall($id)
	{
		$data = $this->db->query("SELECT order_details.odet_id, order_details.odet_work_by, orders.order_type_number, 
									orders.order_number, orders.order_date, 
									customer.cust_code, employee.emp_name,orders.order_location, 
									gps.gps_id, gps.gps_imei_number, gps.gps_cond_id, gsm.gsm_id, gsm.gsm_number, gsm.gsm_cond_id, vehicles.veh_number_police,
									vehicles.veh_id, vehicles.veh_name, vehicles.veh_install_type_business, vehicles.veh_expiry_date,
									odet_work_date, odet_status, odet_insert, odet_update, odet_user, odet_work_by
									FROM order_details
									JOIN orders
									ON order_details.order_id=orders.order_id
									JOIN gps
									ON order_details.gps_id=gps.gps_id
									JOIN gsm
									ON order_details.gsm_id=gsm.gsm_id
									JOIN vehicles
									ON order_details.veh_id=vehicles.veh_id
									JOIN customer
									ON orders.cust_id=customer.cust_id
									JOIN employee
									ON orders.emp_id=employee.emp_id
									WHERE odet_status = 'Installed' AND odet_id='$id' ")->row();
		echo json_encode($data);
	}

	/*public function uninstall($id)
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
		if($stat==1){//superadmin
			$data['content'] = 'superAdmin-modul/reinstall/form_uninstall';
			$data['data']	= $this->db->get_where('order_details',array('odet_id' => $id))->row();
			$this->load->view('superAdmin-modul/template', $data);
		}elseif ($stat==2) {//admin
			$data['content'] = 'admin-modul/reinstall/form_uninstall';
			$data['data']	= $this->db->get_where('order_details',array('odet_id' => $id))->row();
			$this->load->view('admin-modul/template', $data);
		}elseif ($stat==3) {//user
			$data['content'] = 'user-modul/reinstall/form_uninstall';
			$data['data']	= $this->db->get_where('order_details',array('odet_id' => $id))->row();
			$this->load->view('user-modul/template', $data);
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
	}*/

	public function process_order_uninstall()
	{
		$odet_id = $this->input->post('odet_id');
		$odet = array(
				'odet_uninstall_date' => $this->input->post('uninstall_date'),
				'odet_status' => 'Uninstalled'
			);
		$this->db->where('odet_id', $odet_id);
		$this->db->update('order_details', $odet);

		$veh_id = $this->input->post('veh_id');
		$veh = array(
				'veh_uninstall_date' => $this->input->post('uninstall_date'),
				'veh_status' => 'Uninstalled'
			);
		$this->db->where('veh_id', $veh_id);
		$this->db->update('vehicles', $veh);

		$gsm_id = $this->input->post('gsm_id');
        $gsm = array(
                    'gsm_uninstall_date' => $this->input->post('uninstall_date'),
                    'gsm_uninstall_by' => $this->input->post('uninstall_by'),
                    'status' => 'Uninstalled'
                     );
        $this->db->where('gsm_id', $gsm_id);
        $this->db->update('gsm', $gsm);

        $gps_id = $this->input->post('gps_id');
        $gps = array(
                    'gps_uninstall_date' => $this->input->post('uninstall_date'),
                    'gps_uninstall_by' => $this->input->post('uninstall_by'),
                    'status' => 'Uninstalled'
                    );
        $this->db->where('gps_id', $gps_id);
        $this->db->update('gps', $gps);

        if ($this->db->affected_rows()) 
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil diuninstall!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('reinstall/uninstall_list');
        }
        else
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data Gagal diuninstall!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('reinstall/install_list');   
        }
	}

	/*public function excel_order_uninstall()
	{
		$ambil_akun = $this->M_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
		if($stat==1){//superadmin
			//$data['sql1'] = $this->GpsModel->getGps()->result_object();
	        $data['sql1'] = $this->OrderModel->getUninstall()->result_object();
    		$this->load->view('superAdmin-modul/order/excel_export_uninstall', $data);
		}elseif ($stat==2) {//admin
			$data['sql1'] = $this->OrderModel->getUninstall()->result_object();
    		$this->load->view('admin-modul/order/excel_export_uninstall', $data);
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
	}*/
}

/* End of file Order.php */
/* Location: ./application/controllers/Order.php */