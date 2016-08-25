<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form'));
		$this->load->library('form_validation');
		$this->load->model(array('InstallModel','m_login'));
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

	public function install_form()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
		if($stat==1){//superadmin
			$data['install'] = $this->InstallModel->getInstall()->result_object();
			$data['content'] = 'superAdmin-modul/install/install';
			$this->load->view('superAdmin-modul/template', $data);
		}elseif ($stat==2) {//admin
			$data['install'] = $this->InstallModel->getInstall()->result_object();
			$data['content'] = 'admin-modul/install/install';
			$this->load->view('admin-modul/template', $data);
		}elseif ($stat==3) {//user
			$data['install'] = $this->InstallModel->getInstall()->result_object();
			$data['content'] = 'user-modul/install/install';
			$this->load->view('user-modul/template', $data);
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}		
	}

	public function install_gps_list()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
		if($stat==1){//superadmin
			$data['install_gps'] = $this->InstallModel->getDetailGps()->result_object();
			$data['content'] = 'superAdmin-modul/install/install_gps';
			$this->load->view('superAdmin-modul/template', $data);
		}elseif ($stat==2) {//admin
			$data['install_gps'] = $this->InstallModel->getDetailGps()->result_object();
			$data['content'] = 'admin-modul/install/install_gps';
			$this->load->view('admin-modul/template', $data);
		}elseif ($stat==3) {//user
			$data['install_gps'] = $this->InstallModel->getDetailGps()->result_object();
			$data['content'] = 'user-modul/install/install_gps';
			$this->load->view('user-modul/template', $data);
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}		
	}

	public function install_gsm_list()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
		if($stat==1){//superadmin
			$data['install_gsm'] = $this->InstallModel->getDetailGsm()->result_object();
			$data['content'] = 'superAdmin-modul/install/install_gsm';
			$this->load->view('superAdmin-modul/template', $data);
		}elseif ($stat==2) {//admin
			$data['install_gsm'] = $this->InstallModel->getDetailGsm()->result_object();
			$data['content'] = 'admin-modul/install/install_gsm';
			$this->load->view('admin-modul/template', $data);
		}elseif ($stat==3) {//user
			$data['install_gsm'] = $this->InstallModel->getDetailGsm()->result_object();
			$data['content'] = 'user-modul/install/install_gsm';
			$this->load->view('user-modul/template', $data);
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}		
	}

	public function process_install()
	{
		$h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');
        $j = date('Y-m-d');

		$datas = array(
				'veh_name' => $this->input->post('ins_veh_name'),
				'veh_type' => $this->input->post('ins_veh_type'),
				'veh_number_police' => $this->input->post('ins_veh_num_police'),
				'veh_number_flank' => $this->input->post('ins_veh_number'),
				'veh_install_date' => $j,
				'veh_status' => 'Installed',
				'veh_qty' => '1',
				'veh_insert' => $i,
				'veh_update' => $i,
				'veh_user' => $h
			);

		$this->InstallModel->insert_vehicle($datas);

		$this->db->select_max('veh_id');
		$query = $this->db->get('vehicles');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$lastId = $row->veh_id;
			$newId = $lastId + 1;
			// echo $newId;
		}

		
		//$this->InstallModel->get_vehicle;		
		
		$data = array(
				'ins_type_number' => $this->input->post('ins_type_number'),
				'ins_number' => $this->input->post('ins_number'),
				'cust_id' => $this->input->post('cust_id'),
				'gsm_id' => $this->input->post('gsm_id'),
				'gps_id' => $this->input->post('gps_id'),
				'veh_id' => $lastId,
				'emp_id' => $this->input->post('emp_id'),				
				'ins_location' => $this->input->post('ins_location'),
				'ins_date' => $this->input->post('ins_date'),
				'ins_status' => 'Installed',
				'ins_insert' => $i,
				'ins_update' => $i,
				'ins_user' => $h
			);
		$this->InstallModel->insert_data($data);

		$id = $this->input->post('gsm_id');
		$object = array(
					'status' => 'Installed'
					 );
		$this->db->where('gsm_id', $id);
		$this->db->update('gsm', $object);

		$id_gps = $this->input->post('gps_id');
		$object1 = array(
					'status' => 'Installed'
					);
		$this->db->where('gps_id', $id_gps);
		$this->db->update('gps', $object1);

		if ($this->db->affected_rows()) 
		{
			$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
			redirect('install/install_form');
		}
		else
		{
			$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data Gagal disimpan!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
			redirect('install/install_form');	
		}
	}

	public function read($id)
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
		if($stat==1){//superadmin
			$data['content'] = 'superAdmin-modul/install/install_read';
			$data['data']	= $this->db->get_where('installs',array('ins_id' => $id))->row();
			$this->load->view('superAdmin-modul/template', $data);
		}elseif ($stat==2) {//admin
			$data['content'] = 'admin-modul/install/install_read';
			$data['data']	= $this->db->get_where('installs',array('ins_id' => $id))->row();
			$this->load->view('admin-modul/template', $data);
		}elseif ($stat==3) {//user
			$data['content'] = 'user-modul/install/install_read';
			$data['data']	= $this->db->get_where('installs',array('ins_id' => $id))->row();
			$this->load->view('user-modul/template', $data);
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}		
		// $data['data'] = $this->GpsModel->getDetailData($id)->row();	
	}

	public function update($id)
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
		if($stat==1){//superadmin
			$data['content'] = 'superAdmin-modul/install/form_edit';
			$data['data']	= $this->db->get_where('installs',array('ins_id' => $id))->row();
			$this->load->view('superAdmin-modul/template', $data);
		}elseif ($stat==2) {//admin
			$data['content'] = 'admin-modul/install/form_edit';
			$data['data']	= $this->db->get_where('installs',array('ins_id' => $id))->row();
			$this->load->view('admin-modul/template', $data);
		}elseif ($stat==3) {//user
			$data['content'] = 'user-modul/install/form_edit';
			$data['data']	= $this->db->get_where('installs',array('ins_id' => $id))->row();
			$this->load->view('user-modul/template', $data);
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
	}

	public function uninstall($id)
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
		if($stat==1){//superadmin
			$data['content'] = 'superAdmin-modul/install/form_uninstall';
			$data['data']	= $this->db->get_where('installs',array('ins_id' => $id))->row();
			$this->load->view('superAdmin-modul/template', $data);
		}elseif ($stat==2) {//admin
			$data['content'] = 'admin-modul/install/form_uninstall';
			$data['data']	= $this->db->get_where('installs',array('ins_id' => $id))->row();
			$this->load->view('admin-modul/template', $data);
		}elseif ($stat==3) {//user
			$data['content'] = 'user-modul/install/form_uninstall';
			$data['data']	= $this->db->get_where('installs',array('ins_id' => $id))->row();
			$this->load->view('user-modul/template', $data);
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
	}

	public function process_uninstall()
	{
		
		$id = $this->input->post('gsm_id');
        $h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');
        $j = date('Y-m-d');
		
        $object = array(
                    'gsm_uninstall_date' => $this->input->post('uninstall_date'),
                    'gsm_uninstall_by' => $this->input->post('uninstall_by'),
                    'status' => 'Uninstall'
                     );
        $this->db->where('gsm_id', $id);
        $this->db->update('gsm', $object);

        $gps_id = $this->input->post('gps_id');
        $object1 = array(
                    'gps_uninstall_date' => $this->input->post('uninstall_date'),
                    'gps_uninstall_by' => $this->input->post('uninstall_by'),
                    'status' => 'Uninstall'
                    );
        $this->db->where('gps_id', $gps_id);
        $this->db->update('gps', $object1);

        $ins_id = $this->input->post('ins_id');
        $object2 = array(
                    'ins_status' => 'Uninstall',
                    'ins_update' => $i,
                    'ins_user' => $h
                    );
        $this->db->where('ins_id', $ins_id);
        $this->db->update('installs', $object2);

        $veh_id = $this->input->post('veh_id');
        $object3 = array(
                    'veh_status' => 'Uninstall',
                    'veh_uninstall_date' => $j
                    );
        $this->db->where('veh_id', $veh_id);
        $this->db->update('vehicles', $object3);

        if ($this->db->affected_rows()) 
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil diuninstall!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('install/install_form');
        }
        else
        {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data Gagal diuninstall!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
            redirect('install/install_form');   
        }
	}
}

/* End of file Install.php */
/* Location: ./application/controllers/Install.php */