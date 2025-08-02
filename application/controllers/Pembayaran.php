<?php

use Midtrans\Snap;


require_once FCPATH . 'vendor/autoload.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pembayaran_model');
		$this->load->model('Kepesertaan_model');


		\Midtrans\Config::$serverKey = 'SB-Mid-server-Q1RhZpU6nZec2QiPfGCtGyFn';
		\Midtrans\Config::$isProduction = false;
		\Midtrans\Config::$isSanitized = true;
		\Midtrans\Config::$is3ds = true;
	}

	public function index()
	{
		$data['pembayaran'] = $this->Pembayaran_model->get_all();

		$this->load->view('template/layout', [
			'content' => 'pembayaran/index',
			'pembayaran' => $data['pembayaran']
		]);
	}

	public function pilih_metode($kepesertaan_id)
	{
		$data['kepesertaan_id'] = $kepesertaan_id;

		$rowPembayaran = $this->db->select('pembayaran_bpjs.*')
			->from('pembayaran_bpjs')
			->where('kepesertaan_id', $kepesertaan_id)
			->where("tipe_pembayaran like '%registrasi%'")
			->get()->row();

		// Ambil tanggal_daftar dari tabel kepesertaan_bpjs untuk perbandingan
		$rowKepesertaan = $this->db->select('tanggal_daftar')
			->from('kepesertaan_bpjs')
			->where('id', $kepesertaan_id)
			->get()->row();

		// Cek apakah tanggal_daftar berada di bulan dan tahun yang sama dengan sekarang
		$bulan_registrasi = new DateTime(date('Y-m-01', strtotime($rowKepesertaan->tanggal_daftar)));
		$bulan_sekarang = new DateTime(date('Y-m-01')); // ambil bulan sekarang


		// Bandingkan bulan dan tahun
		$same_month_year = ($bulan_registrasi == $bulan_sekarang);

		// Cek jika bulan tanggal_daftar lebih besar dari bulan sekarang
		$after_current_month = ($bulan_registrasi > $bulan_sekarang);

		$data['after_current_month'] = $after_current_month;
		$data['same_month_year'] = $same_month_year;
		$data['content'] = 'pembayaran/pilih_metode';
		$data['pembayaran'] = $rowPembayaran;

		$this->load->view('template/layout', $data);
	}

	public function get_midtrans_token()
	{
		header('Content-Type: application/json');

		try {
			// Ambil data JSON dari request
			$data = json_decode(file_get_contents("php://input"), true);

			if (!$data || !isset($data['kepesertaan_id'], $data['tipe_pembayaran'])) {
				throw new Exception('Parameter tidak lengkap');
			}

			$kepesertaan_id = $data['kepesertaan_id'];
			$tipe_pembayaran = $data['tipe_pembayaran'];

			// Log pesan untuk memulai proses
			log_message('debug', 'Proses pembayaran dimulai untuk kepesertaan ID: ' . $kepesertaan_id . ', Tipe Pembayaran: ' . $tipe_pembayaran);

			// Ambil data kepesertaan dan harga kelas
			$kepesertaan = $this->db->select('kepesertaan_bpjs.*, kelas_bpjs.harga AS harga_kelas')
				->from('kepesertaan_bpjs')
				->join('kelas_bpjs', 'kelas_bpjs.id = kepesertaan_bpjs.kelas_id', 'left')
				->where('kepesertaan_bpjs.id', $kepesertaan_id)
				->get()
				->row();

			if (!$kepesertaan) {
				throw new Exception('Data kepesertaan tidak ditemukan.');
			}

			$harga_kelas = (float) $kepesertaan->harga_kelas;
			if ($harga_kelas <= 0) {
				throw new Exception('Harga kelas tidak valid.');
			}

			// Menggunakan DateTime untuk tanggal registrasi
			$bulan_registrasi = new DateTime(date('Y-m-01', strtotime($kepesertaan->tanggal_daftar)));
			$bulan_sekarang = new DateTime(date('Y-m-01')); // ambil bulan sekarang
			$amount = 0;

			// Log untuk tanggal registrasi dan bulan sekarang
			log_message('debug', 'Tanggal Registrasi: ' . $bulan_registrasi->format('Y-m'));
			log_message('debug', 'Bulan Sekarang: ' . $bulan_sekarang->format('Y-m'));

			if ($tipe_pembayaran === 'registrasi') {
				// Iuran registrasi dihitung 2 bulan
				$amount = $harga_kelas * 2;
				log_message('debug', 'Tipe Pembayaran Registrasi, Total Iuran: ' . $amount);
			} elseif ($tipe_pembayaran === 'iuran') {

				// Cegah iuran dibayar pada bulan registrasi
				$bulan_mulai_iuran = (clone $bulan_registrasi)->modify('+1 month');


				// Ambil pembayaran iuran terakhir (status berhasil)
				$last_payment = $this->db->select('bulan')
					->from('pembayaran_bpjs')
					->where('kepesertaan_id', $kepesertaan_id)
					->where('tipe_pembayaran', 'iuran')
					->where('status', 'lunas')
					->order_by('bulan', 'DESC')
					->limit(1)
					->get()
					->row();

				if (!$last_payment) {
					// Belum pernah bayar iuran, mulai dari 1 bulan setelah registrasi
					$start_date = (clone $bulan_registrasi)->modify('+1 month');
					if ($bulan_sekarang < $bulan_mulai_iuran) {
						$start_date = (clone $bulan_registrasi);
					}
					log_message('debug', 'Belum ada pembayaran sebelumnya, mulai iuran dari bulan: ' . $start_date->format('Y-m'));
				} else {
					$start_date = DateTime::createFromFormat('m-Y', $last_payment->bulan);
					if (!$start_date) {
						throw new Exception('Format bulan terakhir tidak valid.');
					}
					$start_date->modify('+1 month'); // bayar bulan berikutnya


					log_message('debug', 'Pembayaran terakhir ditemukan pada bulan: ' . $start_date->format('Y-m'));
				}

				// Hitung selisih bulan
				$tunggakan = $this->hitung_selisih_bulan($start_date, $bulan_sekarang);

				// Log untuk hasil selisih bulan
				log_message('debug', 'Tunggakan dihitung: ' . $tunggakan);

				// Tambahkan 1 untuk memastikan bulan pertama dihitung
				$tunggakan += 1;

				if ($tunggakan <= 0) {
					throw new Exception('Tidak ada tunggakan iuran.');
				}

				// Log untuk total iuran yang dihitung
				$amount = $harga_kelas * $tunggakan;
				log_message('debug', 'Jumlah bulan iuran: ' . $tunggakan . ', Total iuran yang dihitung: ' . $amount);
			} else {
				throw new Exception('Tipe pembayaran tidak dikenali.');
			}

			// Buat transaksi Midtrans
			$order_id = 'INV-' . time();
			$transaction = [
				'transaction_details' => [
					'order_id' => $order_id,
					'gross_amount' => $amount,
				],
				'customer_details' => [
					'first_name' => $kepesertaan->nama,
					'email' => 'user@example.com',
					'phone' => '08123456789',
				],
				'callbacks' => [
					'finish' => base_url('pembayaran')
				]
			];

			$snapToken = Snap::getSnapToken($transaction);

			// Simpan transaksi ke database
			$this->db->insert('pembayaran_bpjs', [
				'kepesertaan_id' => $kepesertaan_id,
				'order_id' => $order_id,
				'tipe_pembayaran' => $tipe_pembayaran,
				'bulan' => date('m-Y'),
				'jumlah_bayar' => $amount,
				'status' => 'pending',
				'snap_token' => $snapToken
			]);

			// Log transaksi yang berhasil
			log_message('debug', 'Transaksi berhasil, Snap Token: ' . $snapToken);

			echo json_encode(['token' => $snapToken]);
		} catch (Exception $e) {
			// Simpan ke log error
			log_message('error', 'MIDTRANS ERROR: ' . $e->getMessage());

			// Kembalikan pesan error sebagai JSON
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
		}
		exit;
	}

	private function hitung_selisih_bulan($from, $to)
	{
		// Membuat DateTime objek dari kedua parameter
		$from = new DateTime($from->format('Y-m-01')); // Mengatur ke awal bulan
		$to = new DateTime($to->format('Y-m-01'));     // Mengatur ke awal bulan

		// Menghitung selisih bulan
		$diff = $from->diff($to);
		$selisih_bulan = ($diff->y * 12) + $diff->m;

		// Menambahkan 1 bulan jika tanggal "to" sudah lewat tanggal dari bulan yang dihitung
		if ($to > $from) {
			$selisih_bulan += 1;
		}

		// Log untuk melihat hasil selisih bulan
		log_message('debug', 'Selisih bulan antara ' . $from->format('Y-m') . ' dan ' . $to->format('Y-m') . ': ' . $selisih_bulan);

		return $selisih_bulan;
	}

	public function process_payment()
	{
		$json = file_get_contents("php://input");
		file_put_contents('midtrans_callback.log', $json . PHP_EOL, FILE_APPEND); // Log untuk debug

		$result = json_decode($json, true);

		if (!$result) {
			log_message('error', 'Invalid Midtrans Callback');
			return;
		}

		$order_id = $result['order_id'];
		$status_code = $result['status_code'];
		$payment_type = $result['payment_type'] ?? 'unknown';

		// Mapping status Midtrans ke status di database
		$status = 'pending';
		$status_kepesertaan = 'Tidak Aktif';

		if ($status_code == '200') {
			// menunggu review dari admin untuk aktivasi
			$status = 'review';
			$status_kepesertaan = 'Menunggu Aktivasi';
		} elseif ($status_code == '202') {
			$status = 'gagal';
		}

		// Update status pembayaran dan kepesertaan di database
		$this->db->where('order_id', $order_id)->update('pembayaran_bpjs', [
			'status' => $status,
			'status_kepesertaan' => $status_kepesertaan,
			'metode_pembayaran' => $payment_type
		]);

		log_message('info', "Payment Updated: $order_id | Status: $status | Kepesertaan: $status_kepesertaan");
	}


	public function hapus($id)
	{
		$pembayaran = $this->Pembayaran_model->get_by_id($id);

		if (!$pembayaran) {
			show_404();
		}

		// Hapus bukti pembayaran jika ada
		if (!empty($pembayaran->bukti_pembayaran)) {
			$file_path = './uploads/bukti_pembayaran/' . $pembayaran->bukti_pembayaran;
			if (file_exists($file_path)) {
				unlink($file_path); // Hapus file dari folder
			}
		}

		// Hapus data pembayaran dari database
		$this->Pembayaran_model->delete($id);

		$this->session->set_flashdata('success', 'Pembayaran berhasil dihapus.');
		redirect('pembayaran');
	}

	public function show($id)
	{
		$pembayaran = $this->Pembayaran_model->get_by_id($id);
		if (!$pembayaran) {
			show_404();
		}

		$data['pembayaran'] = $pembayaran;
		$data['content'] = 'pembayaran/show';
		$this->load->view('template/layout', $data);
	}

	public function get_existing_midtrans_token()
	{
		header('Content-Type: application/json');

		$data = json_decode(file_get_contents("php://input"), true);
		$order_id = $data['order_id'] ?? null;

		if (!$order_id) {
			echo json_encode(['error' => 'Order ID tidak ditemukan']);
			return;
		}

		// Ambil token Snap dari database
		$pembayaran = $this->db->select('snap_token')
			->from('pembayaran_bpjs')
			->where('order_id', $order_id)
			->get()
			->row();

		if (!$pembayaran || empty($pembayaran->snap_token)) {
			echo json_encode(['error' => 'Token tidak ditemukan']);
			return;
		}

		echo json_encode(['token' => $pembayaran->snap_token]);
	}
}
