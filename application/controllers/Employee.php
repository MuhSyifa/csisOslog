<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['EmployeeModel','m_login']);
        $this->load->helper(['url','html','form']);
        $this->load->database();
        $this->load->library(['form_validation','session']);
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

    public function employee_list()
    {
        $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
        $data = array(
            'user'  => $ambil_akun,
            );

        $stat = $this->session->userdata('lvl');
        if($stat==1){//admin
            $data['employee'] = $this->EmployeeModel->view()->result();
            $data['content'] = 'superAdmin-modul/employee/employee';
            $this->load->view('superAdmin-modul/template', $data);
        }elseif($stat==2){ //user
            $data['employee'] = $this->EmployeeModel->view()->result();
            $data['content'] = 'admin-modul/employee/employee';
            $this->load->view('admin-modul/template',$data);
        }else{
            $data['employee'] = $this->EmployeeModel->view()->result();
            $data['content'] = 'user-modul/employee/employee';
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

        if($this->input->post('emp_code') == '')
        {
            $data['inputerror'][] = 'emp_code';
            $data['error_string'][] = 'Employee Code is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('emp_name') == '')
        {
            $data['inputerror'][] = 'emp_name';
            $data['error_string'][] = 'Employee Name is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('emp_birthdate') == '')
        {
            $data['inputerror'][] = 'emp_birthdate';
            $data['error_string'][] = 'Employee Birthdate is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('emp_position') == '')
        {
            $data['inputerror'][] = 'emp_position';
            $data['error_string'][] = 'Please select Employee Position';
            $data['status'] = FALSE;
        }

        if($this->input->post('emp_department') == '')
        {
            $data['inputerror'][] = 'emp_department';
            $data['error_string'][] = 'Please select Employee Department';
            $data['status'] = FALSE;
        }

        if($this->input->post('emp_note') == '')
        {
            $data['inputerror'][] = 'emp_note';
            $data['error_string'][] = 'Keterangan is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
    /////////////////////////////////////////////////////////////////// End Validate Form ///////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////// Start Proses Save Vendor ///////////////////////////////////////////////////////////////
    public function ajax_add()
    {
        $emp_code = $this->input->post('emp_code');
        
        $query = $this->db->get_where('employee', array(
                    'emp_code' => $emp_code
                ));

        $count = $query->num_rows();

        if($count === 0)
        {
            $this->_validate();
            
            $data = array(
                    'emp_code' => $this->input->post('emp_code'),
                    'emp_name' => $this->input->post('emp_name'),
                    'emp_birthdate' => $this->input->post('emp_birthdate'),
                    'pos_id' => $this->input->post('emp_position'),
                    'dep_id' => $this->input->post('emp_department'),
                    'emp_note' => $this->input->post('emp_note'),
                    'emp_insert' => date('Y-m-d H:i:s'),
                    'emp_update' => date('Y-m-d H:i:s'),
                    'emp_user' => $_SESSION['uname']
                );

            $this->EmployeeModel->insert_data($data);
            
            echo json_encode(array("status" => TRUE));
        }
        else
        {
            echo json_encode(array("validate_status" => TRUE));
        }
    }
    /////////////////////////////////////////////////////////////////// End Proses Save Vendor ///////////////////////////////////////////////////////////////

    public function ajax_edit($id)
    {
        $data = $this->db->get_where('employee',array('emp_id' => $id))->row();
        echo json_encode($data);
    }

    public function ajax_update()
    {
        $this->_validate();
        
        $id = $this->input->post('id');

        $data = array(
                    'emp_code' => $this->input->post('emp_code'),
                    'emp_name' => $this->input->post('emp_name'),
                    'emp_birthdate' => $this->input->post('emp_birthdate'),
                    'pos_id' => $this->input->post('emp_position'),
                    'emp_id' => $this->input->post('emp_department'),
                    'emp_note' => $this->input->post('emp_note'),
                    'emp_update' => date('Y-m-d H:i:s'),
                    'emp_user' => $_SESSION['uname']
                );
        
        $this->db->where('emp_id', $id);
        $this->db->update('employee', $data);
        
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_detail($id)
    {
        //$data = $this->db->get_where('gsm',array('gsm_id' => $id))->row();
        /*$data = $this->db->query("SELECT department.dep_id, department.dep_name,
                                     position.pos_id, position.pos_name,
                                    employees.emp_id, employees.emp_code, employees.emp_name, employees.emp_birthdate, employees.emp_position,
                                    employees.emp_department, employees.emp_note, employees.emp_insert, employees.emp_update, employees.emp_user,
                                    FROM employees
                                    JOIN department
                                    ON employees.emp_department=department.dep_id,
                                    JOIN position
                                    ON employees.emp_position=position.pos_id
                                    WHERE emp_id='$id' ")->row();*/
        $data = $this->db->query("SELECT employees.emp_id, employees.emp_code, employees.emp_name, employees.emp_birthdate, employees.emp_position,
                                    employees.emp_department, employees.emp_note, employees.emp_insert, employees.emp_update, employees.emp_user, 
                               (SELECT department.dep_name FROM public.department WHERE department.dep_id = employees.gps_cond_id),
                               (SELECT position.pos_name FROM public.position WHERE position.pos_id = employees.gps_stat_id),
                                FROM employees WHERE emp_id='$id' order by emp_id DESC ")->row();
        echo json_encode($data);
    }

    public function ajax_delete($id)
    {
        $this->EmployeeModel->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    public function add()
    {
        $this->form_validation->set_rules('emp_code', 'Employee Code', 'required');
        $this->form_validation->set_rules('emp_name', 'Employee Name', 'required');
        $this->form_validation->set_rules('emp_birthdate', 'Employee Birthdate', 'required');
        $this->form_validation->set_rules('emp_position', 'Employee Position', 'required');
        $this->form_validation->set_rules('emp_department', 'Employee Department', 'required');
        $this->form_validation->set_rules('emp_note', 'Employee Keterangan', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            //$this->load->view('gallery/add_image');

            $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
            $data = array(
                'user'  => $ambil_akun,
                );

            $stat = $this->session->userdata('lvl');
            if($stat==1){//admin
                $data['employee'] = $this->EmployeeModel->all()->result();
                $data['content'] = 'superAdmin-modul/employee/employee';
                $this->load->view('superAdmin-modul/template', $data);
            }elseif($stat==2){ //user
                $data['employee'] = $this->EmployeeModel->all()->result();
                $data['content'] = 'admin-modul/employee/employee';
                $this->load->view('admin-modul/template',$data);
            }else{
                $data['employee'] = $this->EmployeeModel->all()->result();
                $data['content'] = 'user-modul/employee/employee';
                $this->load->view('user-modul/template',$data);
            }
        }
        else
        {

            /* Start Uploading File */
            $config =   [
                            'upload_path'   => './images/',
                            'allowed_types' => 'gif|jpg|png',
                            'max_size'      => 100,
                            'max_width'     => 1024,
                            'max_height'    => 768
                        ];

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload())
            {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Insert failed. Please check your file, only .xls file allowed.</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
                redirect('employee/employee_list');
            }
            else
            {
                $file = $this->upload->data();
                $data = [
                                'emp_photo'             => 'images/' . $file['file_name'],
                                'emp_code'       => $this->input->post('emp_code'),
                                'emp_name'   => $this->input->post('emp_name'),
                                'emp_birthdate' => $this->input->post('emp_birthdate'),
                                'emp_position' => $this->input->post('emp_position'),
                                'emp_department' => $this->input->post('emp_department'),
                                'emp_note' => $this->input->post('emp_note'),
                            ];
                $this->EmployeeModel->create($data);
                $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil disimpan!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>'); 
                redirect('employee/employee_list','refresh');
            }
        }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('emp_code', 'Employee Code', 'required');
        $this->form_validation->set_rules('emp_name', 'Employee Name', 'required');
        $this->form_validation->set_rules('emp_birthdate', 'Employee Birthdate', 'required');
        $this->form_validation->set_rules('emp_position', 'Employee Position', 'required');
        $this->form_validation->set_rules('emp_department', 'Employee Department', 'required');
        $this->form_validation->set_rules('emp_note', 'Employee Keterangan', 'required');
        //$this->form_validation->set_rules($rules);
        $image = $this->EmployeeModel->find($id)->row();

        if ($this->form_validation->run() == FALSE)
        {
           // $this->load->view('gallery/edit_image',['image'=>$image]);

            $ambil_akun = $this->m_login->ambil_user($this->session->userdata('uname'));
            $data = array(
                'user'  => $ambil_akun,
                );

            $stat = $this->session->userdata('lvl');
            if($stat==1){//admin
                //$images['employee'] = $this->db->get_where('employees',array('emp_id' => $id))->row();
                $images['image'] = $image;
                $images['content'] = 'superAdmin-modul/employee/form_edit';
                $this->load->view('superAdmin-modul/template', $images);
            }elseif($stat==2){ //user
                $images['employee'] = $this->db->get_where('employees',array('emp_id' => $id))->row();
                $images['content'] = 'admin-modul/employee/employee';
                $this->load->view('admin-modul/template', $images);
            }else{
                $images['employee'] = $this->db->get_where('employees',array('emp_id' => $id))->row();
                $images['content'] = 'user-modul/employee/employee';
                $this->load->view('user-modul/template', $images);
            }
        }
        else
        {
            if(isset($_FILES["userfile"]["name"]))
            {
                /* Start Uploading File */
                $config =   [
                                'upload_path'   => './images/',
                                'allowed_types' => 'gif|jpg|png',
                                'max_size'      => 100,
                                'max_width'     => 1024,
                                'max_height'    => 768
                            ];

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload())
                {
                        $error = array('error' => $this->upload->display_errors());
                        //$this->load->view('gallery/edit_image',['image'=>$image,'error'=>$error]);
                        $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Insert failed. Please check your file, only .xls file allowed.</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');
                        redirect('employee/employee_list');
                }
                else
                {
                        //$file = $this->upload->data();
                        //$data['file'] = 'images/' . $file['file_name'];
                        //unlink($image->file);

                        $image = $this->EmployeeModel->find($id)->row();
                        $file = $this->upload->data();
                        $data['emp_photo'] = 'images/' . $file['file_name'];
                        unlink($image->emp_photo);
                }
            }

            /*$data['caption']      = set_value('caption');
            $data['description']    = set_value('description');
            
            $this->Gallery_model->update($id,$data);
            $this->session->set_flashdata('message','New image has been updated..');
            redirect('gallery');*/

            $data['emp_code'] = set_value('emp_code');
            $data['emp_name'] = set_value('emp_name');
            $data['emp_birthdate'] = set_value('emp_birthdate');
            $data['emp_position'] = set_value('emp_position');
            $data['emp_department'] = set_value('emp_department');
            $data['emp_note'] = set_value('emp_note');

            $this->EmployeeModel->update($id,$data);
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil diupdate!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>'); 
            redirect('employee/employee_list','refresh');
        }
    }


    public function delete($id)
    {
        $this->EmployeeModel->delete($id);
        $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Data berhasil dihapus!!...</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>'); 
        redirect('employee/employee_list','refresh');
    }
}
