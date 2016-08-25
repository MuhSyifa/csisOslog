<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('GpsTypeModel','GsmModel','GpsModel','m_login','GpsDetailModel'));
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation','Excel_reader'));
		$this->auth->cek_auth(); //ngambil auth dari library	
	}

	public function index()
	{		
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');

		if ($stat==1) {
			//Bagian Super Admin
			//$data['gps'] = $this->GpsModel->getGpsForPie()->result_object();
			$data['gpsStock'] = $this->GpsModel->getGpsForPies()->result_object();
			$data['gpsInstalled'] = $this->GpsDetailModel->getDetailInstall()->result_object();
			$data['content'] = 'superAdmin-modul/dashboard_admin';
			$this->load->view('superAdmin-modul/template', $data);
		} elseif ($stat==2) {
			//Bagian Admin
			//$data['gps'] = $this->GpsModel->getGpsForPie()->result_object();
			$data['gpsStock'] = $this->GpsModel->getGpsForPies()->result_object();
			$data['gpsInstalled'] = $this->GpsDetailModel->getDetailInstall()->result_object();
			$data['content'] = 'admin-modul/dashboard_admin';
			$this->load->view('admin-modul/template', $data);
		} elseif ($stat==3) {
			//Bagian User
			//$data['gps'] = $this->GpsModel->getGpsForPie()->result_object();
			$data['gpsStock'] = $this->GpsModel->getGpsForPies()->result_object();
			$data['gpsInstalled'] = $this->GpsDetailModel->getDetailInstall()->result_object();
			$data['content'] = 'user-modul/dashboard/dashboard_user';
			$this->load->view('user-modul/template',$data);
		} else {
			$this->session->sess_destroy();
			redirect('login','refresh');
		}

	}

	public function gsm()
	{		
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');

		if ($stat==1) {
			//Bagian Super Admin
			$data['gsmStock'] = $this->GpsModel->getGsmForPies()->result_object();
			//$data['gpsInstalled'] = $this->GpsDetailModel->getDetailInstall()->result_object();
			$data['content'] = 'superAdmin-modul/dashboard_gsm';
			$this->load->view('superAdmin-modul/template', $data);
		} elseif ($stat==2) {
			//Bagian Admin
			//$data['gps'] = $this->GpsModel->getGpsForPie()->result_object();
			$data['gpsStock'] = $this->GpsModel->getGpsForPies()->result_object();
			$data['gpsInstalled'] = $this->GpsDetailModel->getDetailInstall()->result_object();
			$data['content'] = 'admin-modul/dashboard_admin';
			$this->load->view('admin-modul/template', $data);
		} elseif ($stat==3) {
			//Bagian User
			//$data['gps'] = $this->GpsModel->getGpsForPie()->result_object();
			$data['gpsStock'] = $this->GpsModel->getGpsForPies()->result_object();
			$data['gpsInstalled'] = $this->GpsDetailModel->getDetailInstall()->result_object();
			$data['content'] = 'user-modul/dashboard/dashboard_user';
			$this->load->view('user-modul/template',$data);
		} else {
			$this->session->sess_destroy();
			redirect('login','refresh');
		}
	}

	public function changepwd()
	{
		$this->form_validation->set_rules('opassword','Old Password','required');
		$this->form_validation->set_rules('npassword','New Password','required');
		$this->form_validation->set_rules('cpassword','Confirm Password','required');

		if($this->form_validation->run()!= true)
		{
			$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
			$data = array(
				'user'	=> $ambil_akun,
				);
			$stat = $this->session->userdata('lvl');
			if($stat==1){//admin
				//$data['gps'] = $this->GpsTypeModel->getGpsType();
				$data['content'] = 'superAdmin-modul/change';
				$this->load->view('superAdmin-modul/template', $data);
			}elseif($stat==2){ //user
				//$data['gps'] = $this->GpsTypeModel->getGpsType();
				$data['content'] = 'admin-modul/change';
				$this->load->view('admin-modul/template',$data);
			}else{
				//$data['gps'] = $this->GpsTypeModel->getGpsType();
				$data['content'] = 'user-modul/change';
				$this->load->view('user-modul/template',$data);
			} 
		}
	}

	public function change() // we will load models here to check with database
	{
		$this->form_validation->set_rules('opassword','Old Password','required');
		$this->form_validation->set_rules('npassword','New Password','required');
		$this->form_validation->set_rules('cpassword','Confirm Password','required');

		if($this->form_validation->run()!= true)
		{

			$sql = $this->db->select("*")->from("users")->where("user_username",$this->session->userdata('uname'))->get();

			foreach ($sql->result() as $my_info) {

			$db_password = $my_info->user_password;
			$db_id = $my_info->user_id;
			}

			if(md5($this->input->post("opassword")) == $db_password){

			$fixed_pw = md5($this->input->post("npassword"));
			$update = $this->db->query("Update users SET user_password='$fixed_pw' WHERE user_id='$db_id'")or die(pg_result_error());
			redirect('dashboard/logout');

			}else
			$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Password Gagal Diganti</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
			redirect('dashboard/changepwd');
		}
		else
		{
			$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Password Gagal Diganti, Silahkan isi kembali dengan benar</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
			redirect('dashboard/changepwd');
		}
	}

	public function login()
	{
		$session = $this->session->userdata('isLogin');
    	if($session == FALSE)
    	{
      		$this->load->view('login_form');
    	}else
    	{
      		redirect('dashboard');
    	}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login','refresh');
	}
}