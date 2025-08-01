<?php

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        // Cek apakah user sudah login
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }

        // Periksa apakah IP dan User-Agent masih sama
        if (
            $this->session->userdata('ip_address') !== $this->input->ip_address() ||
            $this->session->userdata('user_agent') !== $this->input->user_agent()
        ) {

            // Jika berbeda, logout otomatis
            $this->session->sess_destroy();
            redirect('auth/login');
        }
    }
}
