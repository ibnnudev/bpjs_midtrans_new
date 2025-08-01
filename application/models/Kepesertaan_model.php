<?php
class Kepesertaan_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function insert($data)
	{
		$this->db->insert('kepesertaan_bpjs', $data);

		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			// Dapatkan error database
			$error = $this->db->error();
			log_message('error', 'Database error: ' . $error['message']);
			return false;
		}
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('kepesertaan_bpjs', $data);
	}

	public function get_all()
	{
		$this->db->select('kepesertaan_bpjs.*, faskes.nama_faskes, kelas_bpjs.nama_kelas, users.name as user_name');
		$this->db->from('kepesertaan_bpjs');
		$this->db->join('faskes', 'faskes.id = kepesertaan_bpjs.faskes_id', 'left');
		$this->db->join('kelas_bpjs', 'kelas_bpjs.id = kepesertaan_bpjs.kelas_id', 'left');
		$this->db->join('users', 'users.id = kepesertaan_bpjs.user_id', 'left');
		$this->db->order_by('kepesertaan_bpjs.id', 'DESC');
		return $this->db->get()->result();
	}

	public function get_by_id($id)
	{
		$this->db->select('kepesertaan_bpjs.*, faskes.nama_faskes, kelas_bpjs.nama_kelas, users.name as user_name');
		$this->db->from('kepesertaan_bpjs');
		$this->db->join('faskes', 'faskes.id = kepesertaan_bpjs.faskes_id', 'left');
		$this->db->join('kelas_bpjs', 'kelas_bpjs.id = kepesertaan_bpjs.kelas_id', 'left');
		$this->db->join('users', 'users.id = kepesertaan_bpjs.user_id', 'left');
		$this->db->where('kepesertaan_bpjs.id', $id);
		return $this->db->get()->row();
	}

	public function delete($id)
	{
		// Ambil data untuk menghapus file foto jika ada
		$existing_data = $this->get_by_id($id);

		$result = $this->db->delete('kepesertaan_bpjs', ['id' => $id]);

		if ($result && $existing_data && $existing_data->foto_ktp) {
			// Hapus file foto jika delete berhasil
			$file_path = FCPATH . 'uploads/ktp/' . $existing_data->foto_ktp;
			if (file_exists($file_path)) {
				unlink($file_path);
			}
		}

		return $result;
	}

	public function check_duplicate_nik($nik, $exclude_id = null)
	{
		$this->db->where('nik', $nik);
		if ($exclude_id) {
			$this->db->where('id !=', $exclude_id);
		}
		return $this->db->get('kepesertaan_bpjs')->num_rows() > 0;
	}

	public function check_duplicate_no_kartu($no_kartu, $exclude_id = null)
	{
		$this->db->where('no_kartu', $no_kartu);
		if ($exclude_id) {
			$this->db->where('id !=', $exclude_id);
		}
		return $this->db->get('kepesertaan_bpjs')->num_rows() > 0;
	}
}
