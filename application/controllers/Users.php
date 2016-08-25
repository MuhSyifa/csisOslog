<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form'));
        $this->load->library('form_validation');
		$this->load->model(array('UsersModel', 'm_login'));
		$this->auth->cek_auth();
	}
	//view data
	public function index()
	{
		$ambil_akun = $this->M_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);
		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            //$data['gps'] = $this->GpsTypeModel->getGpsType();
            $data['content'] = 'superAdmin-modul/dashboard_admin';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            //$data['gps'] = $this->GpsTypeModel->getGpsType();
            $data['content'] = 'admin-modul/dashboard_admin';
            $this->load->view('admin-modul/template',$data);
        }else{
            //$data['gps'] = $this->GpsTypeModel->getGpsType();
            $data['content'] = 'user-modul/dashboard/dashboard_user';
            $this->load->view('user-modul/template',$data);
        }

	}

	public function user_list()
	{
		//$data['users'] = $this->UsersModel->getData()->result_object();
		//$data['content'] = 'users/users';
		//$this->load->view('template', $data);

		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['users'] = $this->UsersModel->getData()->result_object();
            $data['content'] = 'superAdmin-modul/users/users';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['users'] = $this->UsersModel->getData()->result_object();
            $data['content'] = 'admin-modul/users/users';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['users'] = $this->UsersModel->getData()->result_object();
            $data['content'] = 'user-modul/users/users';
            $this->load->view('user-modul/template',$data);
        }
	}
	//insert data
	public function process_insert()
	{
		$h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');

		$data = array('user_username' => $this->input->post('user_username'),
					'user_password' => md5($this->input->post('user_password')),
					'user_name' => $this->input->post('user_name'),
					'user_level' => $this->input->post('user_level'),
					'user_insert' => $i,
					'user_update' => $i,
					'user_user' => $h 
					);
		$this->UsersModel->insert_data($data);
		$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');	
		redirect('users/user_list'); //,'refresh's
	}
	//update data form
	public function update($id)
	{
		//$data['data'] = $this->UsersModel->getDetailData($id)->row();
		//
		//$data['content'] = 'users/form_edit';
		//$data['data']	= $this->db->get_where('users',array('user_id' => $id))->row();
		//$this->load->view('template',$data);

		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['data']	= $this->db->get_where('users',array('user_id' => $id))->row();
            $data['content'] = 'superAdmin-modul/users/form_edit';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['data']	= $this->db->get_where('users',array('user_id' => $id))->row();
            $data['content'] = 'admin-modul/users/form_edit';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['data']	= $this->db->get_where('users',array('user_id' => $id))->row();
            $data['content'] = 'user-modul/users/form_edit';
            $this->load->view('user-modul/template',$data);
        }
	}
 	//update process
	public function process_update()
	{
		$id['user_id'] = $this->input->post('user_id');
		$h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');

		$data = array('user_username' => $this->input->post('user_username') ,
					'user_password' => md5($this->input->post('user_password')),
					'user_name' => $this->input->post('user_name'),
					'user_level' => $this->input->post('user_level'),
					'user_update' => $i,
					'user_user' => $h 
					);
		$this->UsersModel->update_data($data,$id);
		$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil diupdate!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');	
		redirect('users/user_list');
	}

	public function process_delete($id)
	{
		$this->UsersModel->delete_data($id);
		$this->session->set_flashdata('info', '<div class="alert alert-info"><strong>Data berhasil dihapus!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
		redirect('users/user_list');
	}

}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */