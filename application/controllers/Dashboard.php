<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Dashboard extends MY_Controller
{
    public function index()
    {
        $data['content'] = 'dashboard/index';
        $this->load->view('template/layout', $data);
    }

    public function download_bukti()
    {
        // Cek apakah pengguna sudah login
        if (!$this->session->userdata('username')) {
            redirect('auth/login'); // Redirect ke login jika belum login
        }

        // Ambil data pengguna yang login
        $user = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row();

        // Jika tidak ditemukan, tampilkan error
        if (!$user) {
            show_error('Data pengguna tidak ditemukan!', 404);
        }

        // Data yang akan dimasukkan ke PDF
        $html = '
        <h2 style="text-align:center;">Bukti Pendaftaran BPJS</h2>
        <hr>
        <p>Nama: <b>' . $user->name . '</b></p>
        <p>Email: <b>' . $user->email . '</b></p>
        <p>Username: <b>' . $user->username . '</b></p>
        <p>Tanggal Pendaftaran: <b>' . date('d-m-Y', strtotime($user->created_at)) . '</b></p>
        <p>Status: <b>' . ucfirst($user->role) . '</b></p>
        <br>
        <p style="text-align:center;">Terima kasih telah melakukan pendaftaran.</p>';

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');

        // Inisialisasi Dompdf
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Unduh file PDF
        $dompdf->stream("Bukti_Pendaftaran.pdf", ["Attachment" => true]);
    }
}
