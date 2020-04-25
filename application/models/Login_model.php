<?php

class Login_model extends CI_Model
{

    function do_login($nis, $pass)
    {
        $this->db->where('nis', $nis);
        $this->db->where('password', $pass);
        $query = $this->db->get('siswa');

        return $query->row();
    }

    public function isLoggedIn()
    {
        $terlogin = $this->session->userdata('logged_in');
        if (!isset($terlogin) || $terlogin !== true) {
            redirect('/');
            exit;
        }
    }
}
