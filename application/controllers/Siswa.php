<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('logged_in') != true) {
			redirect('auth', 'refresh');
		}
		$this->load->helper(array('form', 'url'));
		$this->load->model('Siswa_model', 'siswa');
		$this->load->model('Kelas_model', 'kelas');
	}


	public function index()
	{

		$data['kelas'] = $this->kelas->getAll();
		$data['siswa'] = $this->siswa->getAll();
		$this->load->view('head_dt');
		$this->load->view('crud/index', $data);
	}



	function create()
	{

		$siswa = array(
			'nis' => $this->input->post('nis'),
			'nama' => $this->input->post('nama'),
			'tgl_lahir' => $this->input->post('tgl'),
			'alamat' => $this->input->post('alamat'),
			'password' => $this->input->post(md5('password'))
		);



		if (isset($_POST['submit'])) {

			$data['siswa'] = $this->siswa->add($siswa);
			redirect('siswa/index');
		}
	}


	function update_siswa()
	{
		$siswa = array(
			'nis' => $this->input->post('nis'),
			'nama' => $this->input->post('nama'),
			'tgl_lahir' => $this->input->post('tgl'),
			'alamat' => $this->input->post('alamat'),
			'password' => md5($this->input->post('password'))
		);

		$this->siswa->update($this->input->post('hidden_id'), $siswa);
		$respone = array(
			'status' => true,
			'lokasi' => base_url() . "index.php/siswa",
		);
		echo json_encode($respone);
	}

	function update()
	{
		$id_siswa = $this->input->post('id');
		$siswa = array(
			'nis' => $this->input->post('nis'),
			'nama' => $this->input->post('nama'),
			'tgl_lahir' => $this->input->post('tgl'),
			'alamat' => $this->input->post('alamat'),
			'password' => $this->input->post('password')
		);
		if ($this->input->post('action') == 'fetch_single') {

			$result = $this->siswa->getFetch($id_siswa);
			echo json_encode($result);
		}



		if ($this->input->post('action') == 'update') {


			$this->siswa->update($id_siswa, $siswa);

			$respone = array(

				'status' => true,
				'lokasi' => base_url() . 'index.php/siswa'
			);
			echo json_encode($respone);
		}
	}

	function delete($id_siswa)
	{

		$this->siswa->delete($id_siswa);
		redirect('siswa/index');
	}



	// controller kelas

	function addKelas()
	{
		$params = array(
			'tingkat' => $this->input->post('tingkat'),
			'ruang' => $this->input->post('ruang'),
			'jumlah_siswa' => $this->input->post('jml')
		);
		if (isset($_POST['submit'])) {

			$data['kelas'] = $this->kelas->add($params);
			redirect('siswa/index');
		}
	}

	function updateKls()
	{
		$id_kelas = $this->input->post('id');
		$params = array(

			'tingkat' => $this->input->post('tingkat'),
			'ruang' => $this->input->post('ruang'),
			'jumlah_siswa' => $this->input->post('jml')
		);

		$this->kelas->updateKelas($this->input->post('hidden_id_kls'), $params);
		$respone = array(

			'status' => true,
			'lokasi' => base_url() . 'index.php/siswa'
		);
		echo json_encode($respone);
	}

	function updateKelas()
	{

		$id_kelas = $this->input->post('id');
		$params = array(

			'tingkat' => $this->input->post('tingkat'),
			'ruang' => $this->input->post('ruang'),
			'jumlah_siswa' => $this->input->post('jml')
		);
		if ($this->input->post('action') == 'fetch') {

			$result = $this->kelas->get_kls($id_kelas);
			echo json_encode($result);
			exit;
		}


		if ($this->input->post('action') == 'update') {


			$respone = array(

				'status' => true,
				'lokasi' => base_url() . 'index.php/siswa'
			);
			echo json_encode($respone);
		}
	}

	function deleteKelas($id_kelas)
	{

		$this->kelas->delete($id_kelas);
		redirect('siswa/');
	}
}
