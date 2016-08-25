<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library('form_validation','Excel_reader');
		$this->load->model(array('DepartmentModel', 'm_login'));
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

    /////////////////////////////////////////////////////////////////// Start List Data Department ///////////////////////////////////////////////////////////////
	public function department_list()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['department'] = $this->DepartmentModel->getData()->result_object();
            $data['content'] = 'superAdmin-modul/department/department';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['department'] = $this->DepartmentModel->getData()->result_object();
            $data['content'] = 'admin-modul/department/department';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['department'] = $this->DepartmentModel->getData()->result_object();
            $data['content'] = 'user-modul/department/department';
            $this->load->view('user-modul/template',$data);
        }
	}
    /////////////////////////////////////////////////////////////////// End List Data Department ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Validate Form ///////////////////////////////////////////////////////////////
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('dep_name') == '')
        {
            $data['inputerror'][] = 'dep_name';
            $data['error_string'][] = 'Department name is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
    /////////////////////////////////////////////////////////////////// End Validate Form ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Proses Save Department ///////////////////////////////////////////////////////////////
	public function ajax_add()
	{
		$this->_validate();

        $h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');

        $data = array(
					'dep_name' => $this->input->post('dep_name'),
                    'dep_insert' => $i,
                    'dep_update' => $i,
                    'dep_user' => $h
				);
		$this->DepartmentModel->insert_data($data);
        echo json_encode(array("status" => TRUE));
	}
    /////////////////////////////////////////////////////////////////// End Proses Save Department ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Get Edit Department ///////////////////////////////////////////////////////////////
    public function ajax_edit($id)
    {
        $data = $this->db->get_where('employees_department',array('dep_id' => $id))->row();
        echo json_encode($data);
    }
    /////////////////////////////////////////////////////////////////// End Get Edit Department ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Proses Update Department ///////////////////////////////////////////////////////////////
	public function ajax_update()
    {
        $this->_validate();

        $id = $this->input->post('id');
        $data = array(
                'dep_name' => $this->input->post('dep_name'),
                'dep_update' => date('Y-m-d H:i:s'),
                'dep_user' => $_SESSION['name']
            );
        
        $this->db->where('dep_id', $id);
        $this->db->update('employees_department', $data);
        echo json_encode(array("status" => TRUE));
    }
    /////////////////////////////////////////////////////////////////// End Proses Update Department ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Proses Delete Department ///////////////////////////////////////////////////////////////
    public function ajax_delete($id)
    {
        $this->DepartmentModel->delete_data($id);
        echo json_encode(array("status" => TRUE));
    }
    /////////////////////////////////////////////////////////////////// End Proses Delete Department ///////////////////////////////////////////////////////////////    
}

/* End of file Customer.php */
/* Location: ./application/controllers/Customer.php */