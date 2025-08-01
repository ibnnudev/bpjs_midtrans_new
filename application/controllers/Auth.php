<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
	}

	public function login()
	{
		$this->load->view('auth/login');
	}

	public function register()
	{
		$this->load->view('auth/register');
	}

	public function process_register()
	{
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();

		$this->form_validation->set_rules('name', 'Nama Lengkap', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect('auth/register');
		} else {
			$token = bin2hex(random_bytes(32));
			$email = $this->input->post('email');

			$data = [
				'name' => $this->input->post('name'),
				'username' => $this->input->post('username'),
				'email' => $email,
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'role' => 'pengguna',
				'status' => 'menunggu_aktivasi',
				'email_verification_token' => $token
			];

			$this->db->insert('users', $data);

			$this->send_verification_email($email, $token);

			$this->session->set_flashdata('success', 'Registrasi berhasil. Silakan cek email untuk verifikasi.');
			redirect('auth/login');
		}
	}


	public function process_login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->User_model->get_user($email);

		if ($user && password_verify($password, $user['password'])) {
			if ($user['status'] !== 'aktif') {
				$this->session->set_flashdata('error', 'Akun Anda belum aktif. Silakan verifikasi email.');
				redirect('auth/login');
				return;
			}

			$session_data = [
				'user_id'   => $user['id'],
				'email'     => $user['email'],
				'username'  => $user['username'],
				'role'      => $user['role'],
				'ip_address' => $this->input->ip_address(),
				'user_agent' => $this->input->user_agent()
			];

			$this->session->set_userdata($session_data);
			redirect('dashboard/index');
		} else {
			$this->session->set_flashdata('error', 'Email atau Password salah.');
			redirect('auth/login');
		}
	}


	public function logout()
	{
		$this->session->unset_userdata(['user_id', 'email', 'username', 'role']);
		$this->session->sess_destroy();
		redirect('auth/login');
	}

	private function send_verification_email($email, $token)
	{
		$verification_link = base_url("auth/verify_email?token=" . $token);

		$message = "
        <html>
        <body>
            <h2>Verifikasi Email</h2>
            <p>Silakan klik link berikut:</p>
            <a href='{$verification_link}'>Verifikasi Email</a>
        </body>
        </html>
    ";

		$this->load->library('email');
		$this->email->from('no-reply@yourdomain.com', 'Admin');
		$this->email->to($email);
		$this->email->subject('Verifikasi Email');
		$this->email->message($message);
		$this->email->set_mailtype('html');

		if (!$this->email->send()) {
			log_message('error', 'Gagal kirim email: ' . $this->email->print_debugger());
		}
	}



	public function verify_email()
	{
		$token = $this->input->get('token');

		$user = $this->User_model->get_user_by_token($token);

		if ($user) {
			$this->User_model->verify_email($user['id']);
			$this->session->set_flashdata('success', 'Email berhasil diverifikasi. Silakan login.');
			redirect('auth/login');
		} else {
			$this->session->set_flashdata('error', 'Token tidak valid atau sudah digunakan.');
			redirect('auth/login');
		}
	}
}
