<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_login'); //memasukkan file model m_login.php ke dalam controller
        $this->load->helper('form');
		$this->load->library('form_validation');
    }
    
    public function index()
    {
        $session = $this->session->userdata('isLogin'); //mengabil dari session apakah sudah login atau belum
        if($session == FALSE) //jika session false maka akan menampilkan halaman login
        {
            $this->load->view('login_form');
        }else //jika session true maka di redirect ke halaman dashboard
        {
            redirect('dashboard');
        }
    }

    public function do_login()
    {
        $username = $this->input->post("uname");
        $password = $this->input->post("pass");
        
        $cek = $this->m_login->cek_user($username,md5($password)); //melakukan persamaan data dengan database
        if(count($cek) == 1){ //cek data berdasarkan username & pass
            foreach ($cek as $cek) {
                $level = $cek['user_level']; //mengambil data(level/hak akses) dari database
                $nameuser = $cek['user_name'];
            }
            $this->session->set_userdata(array(
                'isLogin'   => TRUE, //set data telah login
                'uname'  => $username, //set session username
                'lvl'      => $level, //set session hak akses
                'name'     => $nameuser,
            ));
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Selamat Datang '. $_SESSION['name'].'</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>');    
            redirect('dashboard','refresh');  //redirect ke halaman dashboard
        }else{ //jika data tidak ada yng sama dengan database
            echo "<script>alert('Gagal Login!')</script>";
            redirect('login','refresh');
        }
        
    }
}