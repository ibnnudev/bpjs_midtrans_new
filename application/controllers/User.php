<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->library('session');
		$this->load->helper('url');

		// Cek apakah user sudah login
		if (!$this->session->userdata('user_id')) {
			redirect('auth/login');
		}

		// Cek apakah user adalah admin
		if ($this->session->userdata('role') !== 'admin') {
			redirect('dashboard/index');
		}
	}

	public function index()
	{
		$data['content'] = 'user/index'; // Menentukan view utama
		$data['users'] = $this->User_model->get_all_users();
		$this->load->view('template/layout', $data);
	}

	public function create()
	{
		$data['content'] = 'user/create';
		$this->load->view('template/layout', $data);
	}

	public function insert()
	{
		$data = [
			'name'     => $this->input->post('name'),
			'username' => $this->input->post('username'),
			'email'    => $this->input->post('email'),
			'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
			'role'     => $this->input->post('role'),
			'status'   => 'aktif'
		];

		$this->User_model->insert_user($data);
		redirect('user');
	}

	public function edit($id)
	{
		$data['user'] = $this->User_model->get_user_by_id($id);
		$data['content'] = 'user/edit';
		$this->load->view('template/layout', $data);
	}

	public function update($id)
	{
		$data = [
			'name'     => $this->input->post('name'),
			'username' => $this->input->post('username'),
			'email'    => $this->input->post('email'),
			'role'     => $this->input->post('role')
		];

		$this->User_model->update_user($id, $data);
		redirect('user');
	}

	public function delete($id)
	{
		$this->User_model->delete_user($id);
		redirect('user');
	}
}
