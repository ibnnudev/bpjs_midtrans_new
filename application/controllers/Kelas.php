<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kelas_model');
    }

    public function index()
    {
        $data['content'] = 'kelas/index'; // Menentukan view utama
        $data['kelas_bpjs'] = $this->Kelas_model->get_all(); // Ambil data kepesertaan
        $this->load->view('template/layout', $data);
    }

    public function create()
    {
        $data['content'] = 'kelas/create';
        $this->load->view('template/layout', $data);
    }

    public function store()
    {
        $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required');
        $this->form_validation->set_rules('harga', 'Harga Kelas', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('kelas/create'); // Kembali ke form jika validasi gagal
        } else {
            $data = [
                'nama_kelas' => $this->input->post('nama_kelas'),
                'harga' => $this->input->post('harga')
            ];

            if ($this->input->post('id')) {
                $this->Kelas_model->update($this->input->post('id'), $data);
                $this->session->set_flashdata('message', 'Data Kelas berhasil diperbarui!');
            } else {
                $this->Kelas_model->insert($data);
                $this->session->set_flashdata('message', 'Data Kelas berhasil ditambahkan!');
            }

            redirect('kelas');
        }
    }
    public function edit($id)
    {
        $data['kelas_bpjs'] = $this->Kelas_model->get_by_id($id);
        $data['content'] = 'kelas/edit';
        $this->load->view('template/layout', $data);
    }

    public function update($id)
    {
        $this->form_validation->set_rules('nama_kelas', 'Nama kelas', 'required');
        $this->form_validation->set_rules('harga', 'harga', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $data = [
                'nama_kelas' => $this->input->post('nama_kelas'),
                'harga' => $this->input->post('harga'),
            ];
            $this->Kelas_model->update($id, $data);
            $this->session->set_flashdata('message', 'Data Kelas berhasil diperbarui!');
            redirect('kelas');
        }
    }


    public function delete($id)
    {
        $this->Kelas_model->delete($id);
        redirect('kelas');
    }
}
