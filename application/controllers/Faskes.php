<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faskes extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Faskes_model');
    }

    public function index()
    {
        $data['content'] = 'faskes/index'; // Menentukan view utama
        $data['faskes'] = $this->Faskes_model->get_all(); // Ambil data kepesertaan
        $this->load->view('template/layout', $data);
    }

    public function create()
    {
        $data['content'] = 'faskes/create';
        $this->load->view('template/layout', $data);
    }

    public function store()
    {
        $this->form_validation->set_rules('nama_faskes', 'Nama Faskes', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('telepon', 'No HP', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('faskes/create'); // Kembali ke form jika validasi gagal
        } else {
            $data = [
                'nama_faskes' => $this->input->post('nama_faskes'),
                'alamat' => $this->input->post('alamat'),
                'telepon' => $this->input->post('telepon')
            ];

            if ($this->input->post('id')) {
                $this->Faskes_model->update($this->input->post('id'), $data);
                $this->session->set_flashdata('message', 'Data faskes berhasil diperbarui!');
            } else {
                $this->Faskes_model->insert($data);
                $this->session->set_flashdata('message', 'Data faskes berhasil ditambahkan!');
            }

            redirect('faskes');
        }
    }


    public function edit($id)
    {
        $data['faskes'] = $this->Faskes_model->get_by_id($id);
        $data['content'] = 'faskes/edit';
        $this->load->view('template/layout', $data);
    }

    public function update($id)
    {
        $this->form_validation->set_rules('nama_faskes', 'Nama Faskes', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('telepon', 'No HP', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $data = [
                'nama_faskes' => $this->input->post('nama_faskes'),
                'alamat' => $this->input->post('alamat'),
                'telepon' => $this->input->post('telepon')
            ];
            $this->Faskes_model->update($id, $data);
            $this->session->set_flashdata('message', 'Data faskes berhasil diperbarui!');
            redirect('faskes');
        }
    }


    public function delete($id)
    {
        $this->Faskes_model->delete($id);
        redirect('faskes');
    }
    public function seed()
{
    $puskesmas_list = [
        'Puskesmas Bagelen',
        'Puskesmas Banyuurip',
        'Puskesmas Bayan',
        'Puskesmas Bruno',
        'Puskesmas Bener',
        'Puskesmas Butuh',
        'Puskesmas Gebang',
        'Puskesmas Grabag',
        'Puskesmas Kaligesing',
        'Puskesmas Kemiri',
        'Puskesmas Kutoarjo',
        'Puskesmas Loano',
        'Puskesmas Ngombol',
        'Puskesmas Pituruh',
        'Puskesmas Purwodadi',
        'Puskesmas Purworejo',
        'Puskesmas Kaligesing 2',
        'Puskesmas Bayan 2'
    ];

    foreach ($puskesmas_list as $nama) {
        // Cek apakah faskes sudah ada
        $this->db->where('nama_faskes', $nama);
        $existing = $this->db->get('faskes')->row();

        if (!$existing) {
            $data = [
                'nama_faskes' => $nama,
                'alamat' => '-',
                'telepon' => '-'
            ];
            $this->Faskes_model->insert($data);
        }
    }

    $this->session->set_flashdata('message', 'Import berhasil! Semua Puskesmas telah ditambahkan.');
    redirect('faskes');
}

}
