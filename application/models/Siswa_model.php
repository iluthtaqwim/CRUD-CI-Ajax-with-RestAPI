<?php

class Siswa_model extends CI_Model
{

    function getSiswa($id_siswa = null)
    {
        if ($id_siswa === null) {
            return  $this->db->get('siswa')->result_array();
        } else {
            return $this->db->get_where('siswa', ['id_siswa' => $id_siswa])->result_array();
        }
    }
    // function getFetch($id_siswa)
    // {
    //     $this->db->where('id_siswa', $id_siswa);
    //     return $this->db->get('siswa')->row();
    // }

    function add($siswa)
    {

        $this->db->insert('siswa', $siswa);

        return $this->db->insert_id();
    }

    function update($id_siswa, $siswa)
    {
        return $this->db->update('siswa', $siswa, ['id_siswa' => $id_siswa]);
    }

    function delete($id_siswa)
    {
        $this->db->where('id_siswa', $id_siswa);
        return $this->db->delete('siswa');
    }

    function updatePass($id_siswa, $pass)
    {
        $this->db->where('id_siswa', $id_siswa);
        return $this->db->update('login', $pass);
    }
}
