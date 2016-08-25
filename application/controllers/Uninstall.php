<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uninstall extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library('form_validation','Excel_reader');
		$this->load->model(array('UninstallModel', 'm_login'));
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

	public function uninstall_gps_list()
	{

		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['uninstall_gps'] = $this->UninstallModel->getGpsList()->result_object();
            $data['content'] = 'superAdmin-modul/uninstall/uninstall_gps';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['uninstall_gps'] = $this->UninstallModel->getGpsList()->result_object();
            $data['content'] = 'admin-modul/uninstall/uninstall_gps';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['uninstall_gps'] = $this->UninstallModel->getGpsList()->result_object();
            $data['content'] = 'user-modul/uninstall/uninstall_gps';
            $this->load->view('user-modul/template',$data);
        }
	}

    public function uninstall_gps_excel() 
    {
        $this->load->library(array('excel/Biffwriter', 'excel/Format', 'excel/OLEwriter',
                                    'excel/Parser', 'excel/Workbook', 'excel/Worksheet'));
        
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['uninstall_gps'] = $this->UninstallModel->getGpsList()->result_object();
            $this->load->view('superAdmin-modul/uninstall/uninstall_gps_excel',$data);
        }elseif($stat==2){ //user
            $data['uninstall_gps'] = $this->UninstallModel->getGpsList()->result_object();
            $this->load->view('admin-modul/uninstall/uninstall_gps_excel',$data);
        }else{
            $data['uninstall_gps'] = $this->UninstallModel->getGpsList()->result_object();
            $this->load->view('user-modul/uninstall/uninstall_gps_excel',$data);
        }
    }

    public function uninstall_gsm_excel() 
    {
        $this->load->library(array('excel/Biffwriter', 'excel/Format', 'excel/OLEwriter',
                                    'excel/Parser', 'excel/Workbook', 'excel/Worksheet'));
        
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['uninstall_gsm'] = $this->UninstallModel->getGsmList()->result_object();
            $this->load->view('superAdmin-modul/uninstall/uninstall_gsm_excel',$data);
        }elseif($stat==2){ //user
            $data['uninstall_gsm'] = $this->UninstallModel->getGsmList()->result_object();
            $this->load->view('admin-modul/uninstall/uninstall_gsm_excel',$data);
        }else{
            $data['uninstall_gsm'] = $this->UninstallModel->getGsmList()->result_object();
            $this->load->view('user-modul/uninstall/uninstall_gsm_excel',$data);
        }
    }

    public function read($id)
    {
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );
        $stat = $this->session->userdata('lvl');
        if($stat==1){//superadmin
            $data['content'] = 'superAdmin-modul/uninstall/gps_read';
            $data['data']   = $this->db->get_where('gps',array('gps_id' => $id))->row();
            $this->load->view('superAdmin-modul/template', $data);
        }elseif ($stat==2) {//admin
            $data['content'] = 'admin-modul/uninstall/gps_read';
            $data['data']   = $this->db->get_where('gps',array('gps_id' => $id))->row();
            $this->load->view('admin-modul/template', $data);
        }elseif ($stat==3) {//user
            $data['content'] = 'user-modul/uninstall/gps_read';
            $data['data']   = $this->db->get_where('gps',array('gps_id' => $id))->row();
            $this->load->view('user-modul/template', $data);
        }else { //user
            $this->session->sess_destroy();
            redirect('login','refresh');
        }       
        // $data['data'] = $this->GpsModel->getDetailData($id)->row();
        
    }

    public function read_gsm($id)
    {
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );
        $stat = $this->session->userdata('lvl');
        if($stat==1){//superadmin
            $data['content'] = 'superAdmin-modul/uninstall/gsm_read';
            $data['data']   = $this->db->get_where('gsm',array('gsm_id' => $id))->row();
            $this->load->view('superAdmin-modul/template', $data);
        }elseif ($stat==2) {//admin
            $data['content'] = 'admin-modul/uninstall/gsm_read';
            $data['data']   = $this->db->get_where('gsm',array('gsm_id' => $id))->row();
            $this->load->view('admin-modul/template', $data);
        }elseif ($stat==3) {//user
            $data['content'] = 'user-modul/uninstall/gsm_read';
            $data['data']   = $this->db->get_where('gsm',array('gsm_id' => $id))->row();
            $this->load->view('user-modul/template', $data);
        }else { //user
            $this->session->sess_destroy();
            redirect('login','refresh');
        }       
        // $data['data'] = $this->GpsModel->getDetailData($id)->row();
        
    }

    public function uninstall_gsm_list()
    {

        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['uninstall_gsm'] = $this->UninstallModel->getDetailGsm()->result_object();
            $data['content'] = 'superAdmin-modul/uninstall/uninstall_gsm';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['uninstall_gsm'] = $this->UninstallModel->getDetailGsm()->result_object();
            $data['content'] = 'admin-modul/uninstall/uninstall_gsm';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['uninstall_gsm'] = $this->UninstallModel->getDetailGsm()->result_object();
            $data['content'] = 'user-modul/uninstall/uninstall_gsm';
            $this->load->view('user-modul/template',$data);
        }
    }
}

/* End of file Customer.php */
/* Location: ./application/controllers/Customer.php */