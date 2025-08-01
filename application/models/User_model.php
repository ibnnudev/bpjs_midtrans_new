<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
	public function register($data)
	{
		return $this->db->insert('users', $data);
	}

	public function get_user($email)
	{
		return $this->db->get_where('users', ['email' => $email])->row_array();
	}

	// Ambil semua user
	public function get_all_users()
	{
		return $this->db->get('users')->result_array();
	}

	// Ambil user berdasarkan ID
	public function get_user_by_id($id)
	{
		return $this->db->get_where('users', ['id' => $id])->row_array();
	}

	// Tambah user baru
	public function insert_user($data)
	{
		return $this->db->insert('users', $data);
	}

	// Edit user berdasarkan ID
	public function update_user($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('users', $data);
	}

	// Hapus user berdasarkan ID
	public function delete_user($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('users');
	}

	public function get_user_by_token($token)
	{
		return $this->db->get_where('users', ['email_verification_token' => $token])->row_array();
	}

	public function verify_email($id)
	{
		$this->db->where('id', $id);
		$this->db->update('users', [
			'status' => 'aktif',
			'email_verified_at' => date('Y-m-d H:i:s'),
			'email_verification_token' => null
		]);
	}
}
