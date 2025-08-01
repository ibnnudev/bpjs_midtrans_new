<?php

use Midtrans\Snap;


require_once FCPATH . 'vendor/autoload.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Tunggakan extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pembayaran_model');
		$this->load->model('Kepesertaan_model');
	}

	public function index()
	{
		$data['tunggakan'] = $this->Pembayaran_model->tunggakan();
		$this->load->view('template/layout', [
			'content' => 'tunggakan/index',
			'tunggakan' => $data['tunggakan']
		]);
	}
}
