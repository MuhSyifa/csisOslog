<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GpsDetail extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library('form_validation');
		$this->load->model(array('GpsDetailModel', 'm_login'));
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
			$data['content'] = 'superAdmin-modul/dashboard/dashboard_super';
			$this->load->view('superAdmin-modul/template', $data);
		}elseif ($stat==2) {//admin
			$data['gps'] = $this->GpsTypeModel->getGpsType();
			$data['content'] = 'admin-modul/dashboard/dashboard_admin';
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

	public function gps_detail_lists()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
		if($stat==1){//superadmin
			$data['gpsDetails'] = $this->GpsDetailModel->getDetail()->result_object();
			$data['gpsDetailInstalls'] = $this->GpsDetailModel->getDetailInstall()->result_object();
			$data['gpsDetailUninstalls'] = $this->GpsDetailModel->getDetailUninstall()->result_object();
			$data['content'] = 'superAdmin-modul/gpsDetail/gps_detail';
			$this->load->view('superAdmin-modul/template', $data);
		}elseif ($stat==2) {//admin
			$data['gpsDetails'] = $this->GpsDetailModel->getDetail()->result_object();
			$data['gpsDetailInstalls'] = $this->GpsDetailModel->getDetailInstall()->result_object();
			$data['gpsDetailUninstalls'] = $this->GpsDetailModel->getDetailUninstall()->result_object();
			$data['content'] = 'admin-modul/gpsDetail/gps_detail';
			$this->load->view('admin-modul/template', $data);
		}elseif ($stat==3) {//user
			$data['gpsDetails'] = $this->GpsDetailModel->getDetail()->result_object();
			$data['gpsDetailInstalls'] = $this->GpsDetailModel->getDetailInstall()->result_object();
			$data['gpsDetailUninstalls'] = $this->GpsDetailModel->getDetailUninstall()->result_object();
			$data['content'] = 'user-modul/gpsDetail/gps_detail';
			$this->load->view('user-modul/template', $data);		
		}else { //user
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
	}

	public function process_insert()
	{
		$object = array(
					'gps_type_id' => $this->input->post('gps_type_id'),
					'gps_id' => $this->input->post('gps_id'),
					'gps_cond_id' => $this->input->post('gps_cond_id'),
					'gps_stat_id' => $this->input->post('gps_stat_id'),
					'gps_det_qty' => $this->input->post('gps_det_qty'),
					'gps_det_insert' => date('Y-m-d H:i:s'),
					'gps_det_update' => date('Y-m-d H:i:s'),
					'gps_det_user' => $_SESSION['name']
				);
		$this->GpsDetailModel->insert_data($object);
		$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');	
		redirect('gpsDetail/gps_detail_list','refresh');
	}

	public function update($id)
	{
		// $data['data'] = $this->GpsDetailModel->getDetailData($id)->row();
		$data['content'] = 'superAdmin-modul/gpsDetail/form_edit';
		$data['data']	= $this->db->get_where('gps_details',array('gps_det_id' => $id))->row();
		$this->load->view('superAdmin-modul/template', $data);
	}

	public function process_update()
	{
		$id['gps_det_id'] = $this->input->post('gps_det_id');
		$object = array(
					'gps_type_id' => $this->input->post('gps_type_id'),
					'gps_id' => $this->input->post('gps_id'),
					'gps_cond_id' => $this->input->post('gps_cond_id'),
					'gps_stat_id' => $this->input->post('gps_stat_id'),
					'gps_det_qty' => $this->input->post('gps_det_qty'),
					'gps_det_update' => date('Y-m-d H:i:s'),
					'gps_det_user' => $_SESSION['name']
				);
		$this->GpsDetailModel->update_data($object, $id);
		$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil diupdate!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');	
		redirect('gpsDetail/gps_detail_list');
	}

	public function process_delete($id)
	{
		$this->GpsDetailModel->delete_data($id);
		$this->session->set_flashdata('info', '<div class="alert alert-info"><strong>Data berhasil dihapus!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
		redirect('gpsDetail/gps_detail_list');
	}

}

/* End of file GpsDetail.php */
/* Location: ./application/controllers/GpsDetail.php */