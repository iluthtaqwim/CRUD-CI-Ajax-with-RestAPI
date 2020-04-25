<?php

class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url'); //you can autoload this functions by configuring autoload.php in config directory  
        $this->load->library('session');
        $this->load->model('Login_model', 'login');
    }

    function index()
    {
        if ($this->session->userdata('logged_in') == true) {
            redirect('crud', 'refresh');
        }
        $this->load->view('auth/login');
    }

    function login()
    {

        $nis = $this->input->post('nis');
        $pass = md5($this->input->post('password'));
        $cek = $this->login->do_login($nis, $pass);
        if (!empty($this->input->post('nis'))) {
            if ($cek) {

                $data = array(
                    'nis' => $nis,
                    'logged_in' => true,
                );

                $this->session->set_userdata($data);
                $respone = array(
                    'status' => true,
                    'lokasi' => base_url() . "crud",
                );
                echo json_encode($respone);
            } else {
                $respone = array(
                    'status'    => false,
                    'msg'       => 'Maaf, username atau password yang anda masukkan salah.',
                );
                echo json_encode($respone);
                // $this->session->set_flashdata('gagal login', 'Maaf, username atau password yang anda masukkan salah.');
                // $this->load->view('auth/login');
                // return false;
            }
        } else {
            $respone = array(
                'status'    => false,
                'msg'       => 'error.',
            );
            echo json_encode($respone);
        }
    }
    function logout()
    {
        unset($_SESSION['logged_in']);
        redirect('auth', 'refresh');
        exit;
    }
}
