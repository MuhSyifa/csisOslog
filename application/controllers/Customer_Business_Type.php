<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_Business_Type extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library('form_validation','Excel_reader');
		$this->load->model(array('CustomerBusinessModel', 'm_login'));
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

	public function customer_business_type_list()
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['customer_business'] = $this->CustomerBusinessModel->getData()->result_object();
            $data['content'] = 'superAdmin-modul/customer_business/customer_business';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['customer_business'] = $this->CustomerBusinessModel->getData()->result_object();
            $data['content'] = 'admin-modul/customer_business/customer_business';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['customer_business'] = $this->CustomerBusinessModel->getData()->result_object();
            $data['content'] = 'user-modul/customer_business/customer_business';
            $this->load->view('user-modul/template',$data);
        }
	}

    /////////////////////////////////////////////////////////////////// Start Validate Form ///////////////////////////////////////////////////////////////
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('cust_business_name') == '')
        {
            $data['inputerror'][] = 'cust_business_name';
            $data['error_string'][] = 'Business Type Name is required';
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
                    'cust_business_type_name' => $this->input->post('cust_business_name'),
                    'cust_business_type_insert' => $i,
                    'cust_business_type_update' => $i,
                    'cust_business_type_user' => $h
                );

        $this->CustomerBusinessModel->insert_data($data);
        echo json_encode(array("status" => TRUE));
    }
    /////////////////////////////////////////////////////////////////// End Proses Save Department ///////////////////////////////////////////////////////////////

    /*public function process_insert()
	{
		$h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');

        $data = array(
					'cust_business_type_name' => $this->input->post('cust_business_name'),
                    'cust_business_type_insert' => $i,
                    'cust_business_type_update' => $i,
                    'cust_business_type_user' => $h
				);
		$this->CustomerBusinessModel->insert_data($data);
		$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');	
		redirect('customer_business_type/customer_business_type_list','refresh');
	}

	public function process_insert1()
	{
		$h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');

        $data = array(
					'cust_business_type_name' => $this->input->post('cust_business_name'),
                    'cust_business_type_insert' => $i,
                    'cust_business_type_update' => $i,
                    'cust_business_type_user' => $h
				);
		$this->CustomerBusinessModel->insert_data($data);
		$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');	
		redirect('customer/customer_list','refresh');
	}*/

	public function ajax_edit($id)
    {
        $data = $this->db->get_where('customer_business_type',array('cust_business_type_id' => $id))->row();
        echo json_encode($data);
    }

    public function ajax_update()
    {
        $this->_validate();
        
        $id = $this->input->post('id');
        $data = array(
                'cust_business_type_name' => $this->input->post('cust_business_name'),
                'cust_business_type_update' => date('Y-m-d H:i:s'),
                'cust_business_type_user' => $_SESSION['name']
            );
        
        $this->db->where('cust_business_type_id', $id);
        $this->db->update('customer_business_type', $data);
        
        echo json_encode(array("status" => TRUE));
    }

    /////////////////////////////////////////////////////////////////// Start Proses Delete Customer Business Type ///////////////////////////////////////////////////////////////
    public function ajax_delete($id)
    {
        $this->CustomerBusinessModel->delete_data($id);
        echo json_encode(array("status" => TRUE));
    }
    /////////////////////////////////////////////////////////////////// End Proses Delete Customer Business Type ///////////////////////////////////////////////////////////////

	/*public function update($id)
	{
		$ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
		$data = array(
			'user'	=> $ambil_akun,
			);

		$stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['data']	= $this->db->get_where('customer_business_type',array('cust_business_type_id' => $id))->row();
            $data['content'] = 'superAdmin-modul/customer_business/form_edit';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['data']	= $this->db->get_where('customer_business_type',array('cust_business_type_id' => $id))->row();
            $data['content'] = 'admin-modul/customer_business/form_edit';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['data']	= $this->db->get_where('customer_business_type',array('cust_business_type_id' => $id))->row();
            $data['content'] = 'user-modul/customer_business/form_edit';
            $this->load->view('user-modul/template',$data);
        }
	}

	public function process_update()
	{
		$id['cust_business_type_id'] = $this->input->post('cust_business_type_id');
        $h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');
		
        $data = array(
					'cust_business_type_name' => $this->input->post('cust_business_name'),
                    'cust_business_type_update' => $i,
                    'cust_business_type_user' =>$h
				);
		$this->CustomerBusinessModel->update_data($data,$id);
		$this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil diupdate!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');	
		redirect('customer_business_type/customer_business_type_list');
	}

	public function process_delete($id)
	{
		$this->CustomerBusinessModel->delete_data($id);
		$this->session->set_flashdata('info', '<div class="alert alert-info"><strong>Data berhasil dihapus!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
		redirect('customer_business_type/customer_business_type_list');
	}*/
}

/* End of file Customer.php */
/* Location: ./application/controllers/Customer.php */