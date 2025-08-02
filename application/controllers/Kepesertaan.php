<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Kepesertaan extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Kepesertaan_model');
		$this->load->library('form_validation');
		$this->load->library('session');
	}

	public function index()
	{
		$data['content'] = 'kepesertaan/index';
		$data['kepesertaan'] = $this->Kepesertaan_model->get_all();
		$this->load->view('template/layout', $data);
	}

	public function create()
	{
		$data['content'] = 'kepesertaan/create';
		$data['faskes'] = $this->db->get('faskes')->result();
		$data['kelas'] = $this->db->get('kelas_bpjs')->result();
		$data['users'] = $this->db->get('users')->result();
		$this->load->view('template/layout', $data);
	}

	public function store()
	{
		if ($_POST) {
			$this->form_validation->set_rules('nik', 'NIK', 'required|callback_check_duplicate_nik');
			$this->form_validation->set_rules('no_kartu', 'No Kartu', 'required|callback_check_duplicate_no_kartu');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|callback_valid_tanggal_lahir');
			$this->form_validation->set_rules('foto_ktp', 'Foto KTP', 'callback_validate_foto_ktp');

			if ($this->form_validation->run() == FALSE) {
				$data['error'] = validation_errors();
				$data['faskes'] = $this->db->get('faskes')->result();
				$data['kelas'] = $this->db->get('kelas_bpjs')->result();
				$data['users'] = $this->db->get('users')->result();
				$this->load->view('kepesertaan/create', $data);
			} else {
				$data = $this->input->post();
				$data['foto_ktp'] = $this->upload_foto_ktp();

				if (!$data['foto_ktp']) {
					$data['error'] = 'Gagal mengupload foto KTP.';
					$this->load->view('kepesertaan/create', $data);
					return;
				}

				// penting 1:
				$data['status_aktif'] = 'Tidak Aktif';
				$this->Kepesertaan_model->insert($data);
				redirect('kepesertaan');
			}
		} else {
			redirect('kepesertaan/create');
		}
	}


	public function edit($id)
	{
		$data['content'] = 'kepesertaan/edit';
		$data['kepesertaan'] = $this->Kepesertaan_model->get_by_id($id);
		$data['faskes'] = $this->db->get('faskes')->result();
		$data['kelas'] = $this->db->get('kelas_bpjs')->result();
		$data['users'] = $this->db->get('users')->result();
		$this->load->view('template/layout', $data);
	}

	public function update($id)
	{
		if ($_POST) {
			$config['upload_path']   = './uploads/ktp/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size']      = 2048;
			$config['encrypt_name']  = TRUE;

			$this->load->library('upload', $config);

			$data = $this->input->post();
			$foto_lama = $data['foto_ktp_lama'] ?? null;

			// Hapus 'foto_ktp_lama' dari array supaya tidak masuk ke UPDATE query
			unset($data['foto_ktp_lama']);

			if (!empty($_FILES['foto_ktp']['name'])) {
				if ($this->upload->do_upload('foto_ktp')) {
					$upload_data = $this->upload->data();
					$data['foto_ktp'] = $upload_data['file_name'];

					// Hapus file lama
					if ($foto_lama && file_exists('./uploads/ktp/' . $foto_lama)) {
						unlink('./uploads/ktp/' . $foto_lama);
					}
				} else {
					$data['error'] = $this->upload->display_errors();
					$data['peserta'] = $this->Kepesertaan_model->get_by_id($id);
					$this->load->view('kepesertaan/edit', $data);
					return;
				}
			} else {
				// Jika tidak upload foto baru, pakai foto lama
				$data['foto_ktp'] = $foto_lama;
			}

			$this->Kepesertaan_model->update($id, $data);
			redirect('kepesertaan');
		} else {
			$data['peserta'] = $this->Kepesertaan_model->get_by_id($id);
			$this->load->view('kepesertaan/edit', $data);
		}
	}


	public function delete($id)
	{
		$this->Kepesertaan_model->delete($id);
		$this->session->set_flashdata('message', 'Data berhasil dihapus!');
		redirect('kepesertaan');
	}

	public function show($id)
	{
		$data['kepesertaan'] = $this->Kepesertaan_model->get_by_id($id);
		$data['faskes'] = $this->db->get_where('faskes', ['id' => $data['kepesertaan']->faskes_id])->row();
		$data['kelas'] = $this->db->get_where('kelas_bpjs', ['id' => $data['kepesertaan']->kelas_id])->row();
		$data['pembayaran'] = $this->db->get_where('pembayaran_bpjs', ['kepesertaan_id' => $id])->row();
		$datetime = $data['kepesertaan']->tanggal_daftar;
		$data['bulan'] = date('F', strtotime($datetime));
		$data['content'] = 'kepesertaan/show';
		$this->load->view('template/layout', $data);
	}

	public function export_keaktifan_pdf($kepesertaan_id)
	{
		if (!$this->session->userdata('username')) {
			redirect('auth/login');
		}

		$kepesertaan = $this->db->get_where('kepesertaan_bpjs', ['id' => $kepesertaan_id])->row();
		$faskes = $this->db->get_where('faskes', ['id' => $kepesertaan->faskes_id])->row();
		$kelas = $this->db->get_where('kelas_bpjs', ['id' => $kepesertaan->kelas_id])->row();

		if (!$kepesertaan) {
			show_error('Data kepesertaan tidak ditemukan!', 404);
		}

		$status_kepesertaan = $this->db->select('status_kepesertaan')
			->from('pembayaran_bpjs')
			->where('kepesertaan_id', $kepesertaan_id)
			->where('tipe_pembayaran', 'registrasi')
			->order_by('id', 'DESC')
			->limit(1)
			->get()
			->row();

		$status_aktif = $status_kepesertaan ? ucfirst($status_kepesertaan->status_kepesertaan) : 'Tidak Aktif';

		$html = $this->load->view('pdf/export_keaktifan', [
			'kepesertaan' => $kepesertaan,
			'faskes' => $faskes,
			'kelas' => $kelas,
			'status_aktif' => $status_aktif
		], true);

		$options = new Options();
		$options->set('defaultFont', 'Arial');
		$options->set('isHtml5ParserEnabled', true);

		$dompdf = new Dompdf($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();

		$dompdf->stream("Keaktifan_Kepesertaan_BPJS_" . $kepesertaan->id . ".pdf", ["Attachment" => true]);
	}

	// ==================== HELPER METHODS ====================

	private function upload_foto_ktp()
	{
		if (!isset($_FILES['foto_ktp']) || $_FILES['foto_ktp']['error'] == UPLOAD_ERR_NO_FILE) {
			return null; // Tidak ada file yang diupload
		}

		if ($_FILES['foto_ktp']['error'] !== UPLOAD_ERR_OK) {
			$upload_errors = [
				UPLOAD_ERR_INI_SIZE => 'File terlalu besar (php.ini)',
				UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (form)',
				UPLOAD_ERR_PARTIAL => 'File hanya terupload sebagian',
				UPLOAD_ERR_NO_FILE => 'Tidak ada file yang diupload',
				UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary tidak ada',
				UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file',
				UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh ekstensi'
			];

			$error_msg = $upload_errors[$_FILES['foto_ktp']['error']] ?? 'Error tidak diketahui';
			$this->session->set_flashdata('error', 'Upload error: ' . $error_msg);
			return false;
		}

		$upload_path = FCPATH . 'uploads/ktp/';
		if (!is_dir($upload_path)) {
			if (!mkdir($upload_path, 0755, true)) {
				$this->session->set_flashdata('error', 'Gagal membuat folder upload');
				return false;
			}
		}

		if (!is_writable($upload_path)) {
			$this->session->set_flashdata('error', 'Folder upload tidak bisa ditulis');
			return false;
		}

		$config = [
			'upload_path' => $upload_path,
			'allowed_types' => 'jpg|jpeg|png|gif',
			'max_size' => 2048, // 2MB
			'file_name' => 'ktp_' . time() . '_' . rand(1000, 9999),
			'overwrite' => false,
			'remove_spaces' => true
		];

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('foto_ktp')) {
			$this->session->set_flashdata('error', 'Upload gagal: ' . $this->upload->display_errors('', ''));
			return false;
		}

		$upload_data = $this->upload->data();
		return $upload_data['file_name'];
	}

	private function delete_uploaded_file($filename)
	{
		$file_path = FCPATH . 'uploads/ktp/' . $filename;
		if (file_exists($file_path)) {
			unlink($file_path);
		}
	}

	// ==================== VALIDATION CALLBACKS ====================

	public function valid_tanggal_lahir($tanggal)
	{
		$today = new DateTime();
		$inputDate = new DateTime($tanggal);
		$maxUsia = $today->modify('-50 years');

		if ($inputDate > new DateTime()) {
			$this->form_validation->set_message('valid_tanggal_lahir', 'Tanggal lahir tidak boleh di masa depan.');
			return false;
		} elseif ($inputDate < $maxUsia) {
			$this->form_validation->set_message('valid_tanggal_lahir', 'Tanggal lahir tidak valid. Usia maksimal yang diperbolehkan adalah 50 tahun.');
			return false;
		}

		return true;
	}

	public function validate_foto_ktp()
	{
		if (!isset($_FILES['foto_ktp']) || $_FILES['foto_ktp']['error'] == UPLOAD_ERR_NO_FILE) {
			// Tidak ada file yang diupload, validasi hanya jika update dan tidak wajib
			return true;
		}

		// Cek tipe file
		$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
		$file_type = $_FILES['foto_ktp']['type'];

		if (!in_array($file_type, $allowed_types)) {
			$this->form_validation->set_message('validate_foto_ktp', 'Format file harus JPG, PNG, atau GIF.');
			return false;
		}

		// Cek ukuran file (max 2MB)
		if ($_FILES['foto_ktp']['size'] > 2097152) {
			$this->form_validation->set_message('validate_foto_ktp', 'Ukuran file maksimal 2MB.');
			return false;
		}

		return true;
	}

	public function check_duplicate_nik($nik)
	{
		if ($this->Kepesertaan_model->check_duplicate_nik($nik)) {
			$this->form_validation->set_message('check_duplicate_nik', 'NIK sudah terdaftar');
			return false;
		}
		return true;
	}

	public function check_duplicate_no_kartu($no_kartu)
	{
		if ($this->Kepesertaan_model->check_duplicate_no_kartu($no_kartu)) {
			$this->form_validation->set_message('check_duplicate_no_kartu', 'No KK sudah terdaftar');
			return false;
		}
		return true;
	}

	public function check_duplicate_nik_update($nik, $id)
	{
		if ($this->Kepesertaan_model->check_duplicate_nik($nik, $id)) {
			$this->form_validation->set_message('check_duplicate_nik_update', 'NIK sudah terdaftar');
			return false;
		}
		return true;
	}

	public function check_duplicate_no_kartu_update($no_kartu, $id)
	{
		if ($this->Kepesertaan_model->check_duplicate_no_kartu($no_kartu, $id)) {
			$this->form_validation->set_message('check_duplicate_no_kartu_update', 'No KK sudah terdaftar');
			return false;
		}
		return true;
	}

	public function update_status($id, $status)
	{
		if ($status == 'aktif') {
			$status_kepesertaan = 'Aktif';
			$status = 'lunas';
		} elseif ($status == 'nonaktif') {
			$status_kepesertaan = 'Tidak Aktif';
			$status = 'gagal';
		} elseif ($status == 'menunggu') {
			$status_kepesertaan = 'Menunggu Aktivasi';
			$status = 'review';
		}

		$this->db->where('id', $id);
		$this->db->update('kepesertaan_bpjs', ['status_aktif' => $status_kepesertaan]);
		// Update status kepesertaan di tabel pembayaran_bpjs
		$this->db->where('kepesertaan_id', $id);
		$this->db->update('pembayaran_bpjs', [
			'status_kepesertaan' => $status_kepesertaan,
			'status' => $status
		]);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('message', 'Status kepesertaan berhasil diupdate!');
		} else {
			$this->session->set_flashdata('error', 'Gagal mengupdate status kepesertaan.');
		}

		redirect('kepesertaan');
	}
}
