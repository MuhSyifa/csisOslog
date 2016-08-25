<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->library(array('form_validation','Excel_reader'));
		$this->load->model(array('OrderModel','m_login'));
		$this->load->database();
		$this->auth->cek_auth();
	}

	public function order_list()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['order'] = $this->OrderModel->getOrder()->result_object();
            //$data['data']	= $this->OrderModel->get()->result_object();
            $data['content'] = 'superAdmin-modul/order/order';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['order'] = $this->OrderModel->getOrder()->result_object();
            $data['content'] = 'admin-modul/order/order';
            $this->load->view('admin-modul/template',$data);
        }elseif($stat==3){
            $data['order'] = $this->OrderModel->getOrder()->result_object();
            $data['content'] = 'user-modul/order/order';
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
			$data['content'] = 'superAdmin-modul/order/order_detail';
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
			$data['content'] = 'admin-modul/order/order_detail';
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
			$data['content'] = 'user-modul/order/order_detail';
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
            //$data = $this->db->get_where('customer',array('cust_id' => $id, 'cust_type_id'=>'2'))->row();
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

    /////////////////////////////////////////////////////////////////// Start Validate Form ///////////////////////////////////////////////////////////////
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('order_type_number') == '')
        {
            $data['inputerror'][] = 'order_type_number';
            $data['error_string'][] = 'Please Choose Number Type';
            $data['status'] = FALSE;
        }

        if($this->input->post('order_number') == '')
        {
            $data['inputerror'][] = 'order_number';
            $data['error_string'][] = 'Number BAST/SPK is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('cust_id') == '')
        {
            $data['inputerror'][] = 'cust_id';
            $data['error_string'][] = 'Please Select Customer';
            $data['status'] = FALSE;
        }

        if($this->input->post('emp_id') == '')
        {
            $data['inputerror'][] = 'emp_id';
            $data['error_string'][] = 'Please select Employee';
            $data['status'] = FALSE;
        }

        if($this->input->post('order_date') == '')
        {
            $data['inputerror'][] = 'order_date';
            $data['error_string'][] = 'Tanggal Install is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('order_location') == '')
        {
            $data['inputerror'][] = 'order_location';
            $data['error_string'][] = 'Location Install is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('order_veh_name') == '')
        {
            $data['inputerror'][] = 'order_veh_name';
            $data['error_string'][] = 'Vehicle Name is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('order_veh_num_police') == '')
        {
            $data['inputerror'][] = 'order_veh_num_police';
            $data['error_string'][] = 'Vehicle Number Police is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('order_veh_num_flank') == '')
        {
            $data['inputerror'][] = 'order_veh_num_flank';
            $data['error_string'][] = 'Vehicle NUmber Lambung is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('order_veh_remarks') == '')
        {
            $data['inputerror'][] = 'order_veh_remarks';
            $data['error_string'][] = 'Vehicle Remarks is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('gps_id') == '')
        {
            $data['inputerror'][] = 'gps_id';
            $data['error_string'][] = 'Please Select GPS';
            $data['status'] = FALSE;
        }

        if($this->input->post('gsm_id') == '')
        {
            $data['inputerror'][] = 'gsm_id';
            $data['error_string'][] = 'Please Select GSM Active';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
    /////////////////////////////////////////////////////////////////// End Validate Form ///////////////////////////////////////////////////////////////

    public function ajax_po_install()
    {
        // Insert Vehicle
			$datas = array(
					'veh_name' => $this->input->post('order_veh_name_edit'),
					'veh_number_police' => $this->input->post('order_veh_num_police_edit'),
					'veh_number_flank' => $this->input->post('order_veh_num_flank_edit'),
					'veh_install_date' => $this->input->post('order_date_edit'),
					'veh_status' => 'Installed',
					'veh_qty' => '1',
					'veh_install_type_business' => '1',
					'veh_remarks' => $this->input->post('order_veh_remarks_edit'),
					'gsm_id' => $this->input->post('gsm_id_edit'),
					'gps_id' => $this->input->post('gps_id_edit'),
					'veh_insert' => date('Y-m-d H:i:s'),
					'veh_update' => date('Y-m-d H:i:s'),
					'veh_user' => $_SESSION['name']
				);		

			$this->db->insert('vehicles', $datas);

			$this->db->select_max('veh_id');
			$query = $this->db->get('vehicles');
			if ($query->num_rows() > 0) {
					$row = $query->row();
					$lastVehId = $row->veh_id;
					$newId = $lastVehId + 1;
					// echo $newId;
				}

			// Insert Order
			$order = array(
					'order_type_number' => $this->input->post('order_type_number_edit'),
					'order_number' => $this->input->post('order_number_edit'),
					'cust_id' => $this->input->post('cust_id_edit'),
					'emp_id' => $this->input->post('emp_id_edit'),
					'order_date' => $this->input->post('order_date_edit'),
					'order_location' => $this->input->post('order_location_edit'),
					//'order_status' => 'Success',
					'order_qty' => '1',
					'order_insert' => date('Y-m-d H:i:s'),
					'order_update' => date('Y-m-d H:i:s'),
					'order_user' => $_SESSION['name']
				);
			
			$this->db->insert('orders', $order);

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
					'gsm_id' => $this->input->post('gsm_id_edit'),
					'gps_id' => $this->input->post('gps_id_edit'),
					'veh_id' => $lastVehId,
					'odet_work_date' => $this->input->post('order_date_edit'),
					'odet_qty' => '1',
					'odet_status' => 'Installed',
					'odet_insert' => date('Y-m-d H:i:s'),
					'odet_update' => date('Y-m-d H:i:s'),
					'odet_user' => $_SESSION['name']
				); 
			$this->db->insert('order_details', $orderDetail);
				
			
			//update status gsm received to installed
			$gsm = $this->input->post('gsm_id_edit');
			$objectgsm = array('status' => 'Installed');

			$this->db->where('gsm_id', $gsm);
			$this->db->update('gsm', $objectgsm);

			
			//update status gps received to installed
			$gps = $this->input->post('gps_id_edit');
			$objectgps = array('status' => 'Installed');

			$this->db->where('gps_id', $gps);
			$this->db->update('gps', $objectgps);

        if ($this->db->affected_rows()) 
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('order/order_list');
        }
        else
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data Gagal disimpan!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('order/order_list');   
        }
    }

    public function ajax_trial_install()
	{
		// Insert Vehicle
		$datas = array(
				'veh_name' => $this->input->post('order_veh_name_edit'),
				'veh_number_police' => $this->input->post('order_veh_num_police_edit'),
				'veh_number_flank' => $this->input->post('order_veh_num_flank_edit'),
				'veh_install_date' => $this->input->post('order_date_edit'),
				'veh_status' => 'Installed',
				'veh_qty' => '1',
				'veh_install_type_business' => '2',
				'veh_expiry_date' => $this->input->post('order_veh_expiry_date_edit'),
				'veh_remarks' => $this->input->post('order_veh_remarks_edit'),
				'gsm_id' => $this->input->post('gsm_id_edit'),
				'gps_id' => $this->input->post('gps_id_edit'),
				'veh_insert' => date('Y-m-d H:i:s'),
				'veh_update' => date('Y-m-d H:i:s'),
				'veh_user' => $_SESSION['name']
		);		

		$this->db->insert('vehicles', $datas);

		$this->db->select_max('veh_id');
		$query = $this->db->get('vehicles');
		
		if ($query->num_rows() > 0) 
		{
			$row = $query->row();
			$lastVehId = $row->veh_id;
			$newId = $lastVehId + 1;
			// echo $newId;
		}
			
		//Insert Order
		$order = array(
				'order_type_number' => $this->input->post('order_type_number_edit1'),
				'order_number' => $this->input->post('order_number_edit1'),
				'cust_id' => $this->input->post('cust_id_edit'),
				'emp_id' => $this->input->post('emp_id_edit'),
				'order_date' => $this->input->post('order_date_edit'),
				'order_location' => $this->input->post('order_location_edit'),
				//'order_status' => 'Success',
				'order_qty' => '1',
				'order_insert' => date('Y-m-d H:i:s'),
				'order_update' => date('Y-m-d H:i:s'),
				'order_user' => $_SESSION['name']
		);

		$this->db->insert('orders', $order);

		$this->db->select_max('order_id');
		$query = $this->db->get('orders');
		
		if ($query->num_rows() > 0) 
		{
			$row = $query->row();
			$lastId = $row->order_id;
			$newOrderId = $lastId + 1;
			// echo $newId;
		}
			
		// Insert Order Detail
		$orderDetail = array(
				'order_id' => $lastId,
				'gsm_id' => $this->input->post('gsm_id_edit'),
				'gps_id' => $this->input->post('gps_id_edit'),
				'veh_id' => $lastVehId,
				'odet_work_date' => $this->input->post('order_date_edit'),
				'odet_qty' => '1',
				'odet_status' => 'Installed',
				'odet_insert' => date('Y-m-d H:i:s'),
				'odet_update' => date('Y-m-d H:i:s'),
				'odet_user' => $_SESSION['name']
		); 
		
		$this->db->insert('order_details', $orderDetail);
				
			
		//update status gsm received to installed
		$gsm = $this->input->post('gsm_id_edit');

		$objectgsm = array('status' => 'Installed');
		
		$this->db->where('gsm_id', $gsm);
		$this->db->update('gsm', $objectgsm);

		//update status gps received to installed
		$gps = $this->input->post('gps_id_edit');

		$objectgps = array('status' => 'Installed');
		
		$this->db->where('gps_id', $gps);
		$this->db->update('gps', $objectgps);

		//update status gps received to installed
		/*$gps = $this->input->post('veh_id');
		
		$objectgps = array('veh_status' => 'Installed');

		$this->db->where('veh_id', $gps);
		$this->db->update('vehicles', $objectgps);*/

		//echo json_encode(array("status" => TRUE));

		if ($this->db->affected_rows()) 
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('order/order_list');
        }
        else
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data Gagal disimpan!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('order/order_list');   
        }
	}

	public function ajax_detail($id)
	{
		$data = $this->db->query("SELECT order_details.odet_id, orders.order_type_number, 
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
			if($tipe==1)
            {
				$data['content'] = 'superAdmin-modul/order/form_add';
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
            	$data['content'] = 'superAdmin-modul/order/form_add_trial';
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
				$data['content'] = 'admin-modul/order/form_add';
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
				$this->load->view('admin-modul/template', $data);
			}
			elseif($tipe==2)
            {
            	$data['content'] = 'admin-modul/order/form_add_trial';
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
				$this->load->view('admin-modul/template', $data);
            }
		}elseif ($stat==3) {//user
			if($tipe==1)
            {
				$data['content'] = 'admin-modul/order/form_add';
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
				$this->load->view('admin-modul/template', $data);
			}
			elseif($tipe==2)
            {
            	$data['content'] = 'admin-modul/order/form_add_trial';
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
				$this->load->view('admin-modul/template', $data);
            }
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}		
	}*/

	public function process_order_install()
	{		
		// Insert Vehicle
		
		$datas = array(
				'veh_name' => $this->input->post('order_veh_name'),
				'veh_number_police' => $this->input->post('order_veh_num_police'),
				'veh_number_flank' => $this->input->post('order_veh_num_flank'),
				'veh_install_date' => $this->input->post('order_date'),
				'veh_status' => 'Installed',
				'veh_qty' => '1',
				'veh_install_type_business' => '1',
				'veh_remarks' => $this->input->post('order_veh_remarks'),
				'gsm_id' => $this->input->post('gsm_id'),
				'gps_id' => $this->input->post('gps_id'),
				'veh_insert' => date('Y-m-d H:i:s'),
				'veh_update' => date('Y-m-d H:i:s'),
				'veh_user' => $_SESSION['name']
		);		

		$this->db->insert('vehicles', $datas);

		$this->db->select_max('veh_id');
		$query = $this->db->get('vehicles');
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$lastVehId = $row->veh_id;
			$newId = $lastVehId + 1;
			// echo $newId;
		}

		// Insert Order
		
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
				'veh_id' => $lastVehId,
				'odet_work_date' => $this->input->post('order_date'),
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

		//echo json_encode(array("status" => TRUE));

		if ($this->db->affected_rows()) 
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('order/order_list');
        }
        else
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data Gagal disimpan!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('order/order_list');   
        }		
	}

	public function process_order_install_trial()
	{
		// Insert Vehicle
		$datas = array(
				'veh_name' => $this->input->post('order_veh_name'),
				'veh_number_police' => $this->input->post('order_veh_num_police'),
				'veh_number_flank' => $this->input->post('order_veh_num_flank'),
				'veh_install_date' => $this->input->post('order_date'),
				'veh_status' => 'Installed',
				'veh_qty' => '1',
				'veh_install_type_business' => '2',
				'veh_expiry_date' => $this->input->post('order_veh_expiry_date'),
				'veh_remarks' => $this->input->post('order_veh_remarks'),
				'gsm_id' => $this->input->post('gsm_id'),
				'gps_id' => $this->input->post('gps_id'),
				'veh_insert' => date('Y-m-d H:i:s'),
				'veh_update' => date('Y-m-d H:i:s'),
				'veh_user' => $_SESSION['name']
		);		

		$this->db->insert('vehicles', $datas);

		$this->db->select_max('veh_id');
		$query = $this->db->get('vehicles');
		
		if ($query->num_rows() > 0) 
		{
			$row = $query->row();
			$lastVehId = $row->veh_id;
			$newId = $lastVehId + 1;
			// echo $newId;
		}
			
		//Insert Order
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
		
		if ($query->num_rows() > 0) 
		{
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
				'veh_id' => $lastVehId,
				'odet_work_date' => $this->input->post('order_date'),
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

		//echo json_encode(array("status" => TRUE));

		if ($this->db->affected_rows()) 
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('order/order_list');
        }
        else
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data Gagal disimpan!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('order/order_list');   
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
			//$data['sql1'] = $this->GpsModel->getGps()->result_object();
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

	public function uninstall_list()
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
	}

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

	public function ajax_uninstall_detail($id)
	{
		$data = $this->db->query("SELECT order_details.odet_id, order_details.odet_work_by, orders.order_type_number, 
									orders.order_number, orders.order_date, 
									customer.cust_code, employee.emp_name,orders.order_location, 
									gps.gps_id, gps.gps_imei_number, gsm.gsm_id, gsm.gsm_number, vehicles.veh_number_police,
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
									WHERE odet_status = 'Uninstalled' AND odet_id='$id' ")->row();
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
			$data['content'] = 'superAdmin-modul/order/form_uninstall';
			$data['data']	= $this->db->get_where('order_details',array('odet_id' => $id))->row();
			$this->load->view('superAdmin-modul/template', $data);
		}elseif ($stat==2) {//admin
			$data['content'] = 'admin-modul/order/form_uninstall';
			$data['data']	= $this->db->get_where('order_details',array('odet_id' => $id))->row();
			$this->load->view('admin-modul/template', $data);
		}elseif ($stat==3) {//user
			$data['content'] = 'user-modul/order/form_uninstall';
			$data['data']	= $this->db->get_where('order_details',array('odet_id' => $id))->row();
			$this->load->view('user-modul/template', $data);
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
	}*/

	public function process_order_uninstall()
	{
		$odet_id = $this->input->post('id');
		$odet = array(
				'odet_work_date' => $this->input->post('uninstall_date'),
				'odet_work_by' => $this->input->post('uninstall_by'),
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
                    'gsm_cond_id' => $this->input->post('gsm_cond_id'),
                    'status' => 'Uninstalled'
                     );
        $this->db->where('gsm_id', $gsm_id);
        $this->db->update('gsm', $gsm);

        $gps_id = $this->input->post('gps_id');
        $gps = array(
                    'gps_uninstall_date' => $this->input->post('uninstall_date'),
                    'gps_uninstall_by' => $this->input->post('uninstall_by'),
                    'gps_cond_id' => $this->input->post('gps_cond_id'),
                    'status' => 'Uninstalled'
                    );
        $this->db->where('gps_id', $gps_id);
        $this->db->update('gps', $gps);

        if ($this->db->affected_rows()) 
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil diuninstall!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('order/uninstall_list');
        }
        else
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data Gagal diuninstall!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('order/uninstall_list');   
        }
	}

	public function excel_order_uninstall()
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
	}
}

/* End of file Order.php */
/* Location: ./application/controllers/Order.php */