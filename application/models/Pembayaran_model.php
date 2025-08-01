<?php
class Pembayaran_model extends CI_Model
{
	public function get_all()
	{
		$user_id = $this->session->userdata('user_id');
		$role = $this->session->userdata('role');

		$this->db->select('pembayaran_bpjs.*, kepesertaan_bpjs.nama, kelas_bpjs.nama_kelas, kelas_bpjs.harga');
		$this->db->from('pembayaran_bpjs');
		$this->db->join('kepesertaan_bpjs', 'kepesertaan_bpjs.id = pembayaran_bpjs.kepesertaan_id');
		$this->db->join('kelas_bpjs', 'kelas_bpjs.id = kepesertaan_bpjs.kelas_id');

		if ($role === 'pengguna') {
			$this->db->where('kepesertaan_bpjs.user_id', $user_id);
		}

		return $this->db->get()->result();
	}

	public function tunggakan()
	{
		$this->db->select('
			kepesertaan_bpjs.*,
			faskes.nama_faskes,
			kelas_bpjs.*,
			MAX(CASE WHEN pembayaran_bpjs.tipe_pembayaran = "iuran" THEN pembayaran_bpjs.bulan ELSE NULL END) AS terakhir_bayar,
			MAX(CASE WHEN pembayaran_bpjs.tipe_pembayaran = "registrasi" THEN pembayaran_bpjs.bulan ELSE NULL END) AS status_regis,
			MAX(pembayaran_bpjs.status_kepesertaan) AS status_kepesertaan
		');

		$this->db->from('kepesertaan_bpjs');
		$this->db->join('faskes', 'faskes.id = kepesertaan_bpjs.faskes_id', 'left');
		$this->db->join('kelas_bpjs', 'kelas_bpjs.id = kepesertaan_bpjs.kelas_id', 'left');
		$this->db->join('pembayaran_bpjs', 'pembayaran_bpjs.kepesertaan_id = kepesertaan_bpjs.id', 'left');
		$this->db->group_by('kepesertaan_bpjs.id');

		$query = $this->db->get();
		return $query->result();
	}



	public function insert($data)
	{
		return $this->db->insert('pembayaran_bpjs', $data);
	}

	public function get_by_kepesertaan($kepesertaan_id)
	{
		return $this->db->get_where('pembayaran_bpjs', ['kepesertaan_id' => $kepesertaan_id])->result();
	}

	public function get_by_id($id)
	{
		return $this->db->select('pembayaran_bpjs.*, kepesertaan_bpjs.nama')
			->from('pembayaran_bpjs')
			->join('kepesertaan_bpjs', 'kepesertaan_bpjs.id=pembayaran_bpjs.kepesertaan_id')
			->where('pembayaran_bpjs.id', $id)
			->get()->row();
	}
	public function update_status($id, $status)
	{
		return $this->db->where('id', $id)->update('pembayaran_bpjs', ['status' => $status]);
	}
	public function update($id, $data)
	{
		return $this->db->where('id', $id)->update('pembayaran_bpjs', $data);
	}
	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('pembayaran_bpjs');
	}
}
