
<?php

require APPPATH . 'libraries/REST_Controller.php';

require APPPATH . 'libraries/Format.php';

class Kelas extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Kelas_model', 'kelas');
    }

    function index_get()
    {
        $id_kelas = $this->get('id_kls');

        if ($id_kelas === null) {
            $data = $this->kelas->get_kls();
        } else {
            $data = $this->kelas->get_kls($id_kelas);
        }

        if ($data) {
            $this->response([
                'status' => true,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        echo json_encode($data);
    }

    function index_post()
    {

        $params = array(

            'tingkat' => $this->input->post('tingkat'),
            'ruang' => $this->input->post('ruang'),
            'jumlah_siswa' => $this->input->post('jml')
        );


        if ($this->kelas->add($params) > 0) {

            $this->response([
                'status' => true,
                'message' => 'Kelas has been created',
                'lokasi' => base_url() . "crud/kelas",
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kelas not created'
            ], REST_Controller::HTTP_FAILED_DEPENDENCY);
        }
    }

    function update_post()
    {

        $params = array(

            'tingkat' => $this->input->post('tingkat'),
            'ruang' => $this->input->post('ruang'),
            'jumlah_siswa' => $this->input->post('jml')
        );

        $data = $this->kelas->updateKelas($this->input->post('hidden_id_kls'), $params);
        if ($data > 0) {
            $this->response([
                'status' => true,
                'message' => 'kelas has been modified',
                'lokasi' => base_url() . "crud/kelas",

            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kelas not Moddified'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        echo json_encode($data);
    }

    public function delete_post()
    {

        $id_kelas = $this->post('id');

        if ($id_kelas === 0) {
            $this->response([
                'status' => false,
                'message' => 'Delete tidak berjalan',
                'lokasi' => base_url() . "crud/kelas",
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $data = $this->kelas->delete($id_kelas);
            if ($data) {
                $this->response([
                    'status' => true,
                    'message' => 'DELETED',
                    'lokasi' => base_url() . "crud/kelas",
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'ID not found',
                    'lokasi' => base_url() . "crud/kelas",
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }

        echo json_encode($data);
    }
}
