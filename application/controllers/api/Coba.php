<?php

require APPPATH . 'libraries/REST_Controller.php';

require APPPATH . 'libraries/Format.php';

class Coba extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Siswa_model', 'siswa');
    }

    function index_get()
    {
        $id_siswa = $this->get('id');


        if ($id_siswa === null) {

            $data = $this->siswa->getSiswa();
        } else {
            $data = $this->siswa->getSiswa($id_siswa);
        }

        if ($data) {
            $this->response([
                'status' => true,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => true,
                'message' => 'ID tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

        echo json_encode($data);
    }

    function delete_post()
    {

        $id_siswa = $this->post('id');

        if ($id_siswa === null) {
            $this->response([
                'status' => false,
                'message' => 'Delete tidak berjalan',
                'lokasi' => base_url() . "crud",
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $data = $this->siswa->delete($id_siswa);
            if ($data > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'DELETED',
                    'lokasi' => base_url() . "crud",
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'ID not found',
                    'lokasi' => base_url() . "crud",
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }

        echo json_encode($data);
    }

    function index_post()
    {
        $siswa = array(
            'nis' => $this->input->post('nis'),
            'nama' => $this->input->post('nama'),
            'tgl_lahir' => $this->input->post('tgl'),
            'alamat' => $this->input->post('alamat'),
            'password' => md5($this->input->post('password'))

        );

        if ($this->siswa->add($siswa) > 0) {

            $this->response([
                'status' => true,
                'message' => 'Siswa has been created',
                'lokasi' => base_url() . "crud",
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Siswa not created'
            ], REST_Controller::HTTP_FAILED_DEPENDENCY);
        }
    }

    function update_post()
    {


        $siswa = array(
            'nis' => $this->post('nis'),
            'nama' => $this->post('nama'),
            'tgl_lahir' => $this->post('tgl'),
            'alamat' => $this->post('alamat'),
            'password' => md5($this->post('password'))

        );

        $data = $this->siswa->update($this->input->post('hidden_id'), $siswa);
        if ($data > 0) {
            $this->response([
                'status' => true,
                'message' => 'Siswa has been modified',
                'lokasi' => base_url() . "crud",

            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Siswa not Moddified'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        echo json_encode($data);
    }
}
