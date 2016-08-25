<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Excel_model');
		$this->load->library('excel_reader');
	}
	public function index()
	{
		$data['content'] = 'content';
		$this->load->view('template',$data);
	}

	public function import()
 	{
       	if ($this->input->post('submit'))
       	{   
			$this->do_upload();
       	// $this->load->view('chapter', $data);
		}
	  	else
	  	{
	   	$this->load->view('excel');
	  	}
 	}

	public function do_upload()
	{
    	$config['upload_path'] = './temp_upload/';
    	$config['allowed_types'] = 'xls';
                
    	$this->load->library('upload', $config);

     	if ( ! $this->upload->do_upload())
     	{
            $data = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('msg_excel', 'Insert failed. Please check your file, only .xls file allowed.');
     	}
     	else
     	{
            $data = array('error' => false);
            $upload_data = $this->upload->data();

            $this->load->library('excel_reader');
            $this->excel_reader->setOutputEncoding('CP1251');

            $file =  $upload_data['full_path'];
            $this->excel_reader->read($file);
            error_reporting(E_ALL ^ E_NOTICE);

            // Sheet 1
            $data = $this->excel_reader->sheets[0] ;
            $dataexcel = Array();
            for ($i = 1; $i <= $data['numRows']; $i++) {
               	if($data['cells'][$i][1] == '') break;
               	$dataexcel[$i-1]['gsm_number'] = $data['cells'][$i][1];
               	$dataexcel[$i-1]['gsm_imsi_number'] = $data['cells'][$i][2];
               	$dataexcel[$i-1]['gsm_iccid_number'] = $data['cells'][$i][3];
            	$dataexcel[$i-1]['gsm_received_by'] = $data['cells'][$i][4];
            }
    	//cek data
    	$check= $this->Excel_model->search_chapter($dataexcel);
    	if (count($check) > 0)
    	{
	      	$this->Excel_model->insert_chapter($dataexcel);
	      	// set pesan
	      	$this->session->set_flashdata('msg_excel', 'inserting data success');
	  		}
  		}
  		redirect('welcome/import');
  	}
}
