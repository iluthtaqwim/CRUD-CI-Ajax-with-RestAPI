<?php

class Kelas_model extends CI_Model
{

    function getAll()
    {
        return $this->db->get('kelas')->result_array();
    }

    function get_kls($id_kelas = null)
    {
        if ($id_kelas === null) {

            return  $this->db->get('kelas')->result_array();
        } else {
            return $this->db->get_where('kelas', ['id_kelas' => $id_kelas])->result_array();
        }
    }

    function getKelas($id_kelas)
    {
        $this->db->where('id_kelas', $id_kelas);
        return $this->db->get('kelas')->result_array();
    }

    function add($params)
    {
        $this->db->insert('kelas', $params);
        return $this->db->insert_id();
    }

    function updateKelas($id_kelas, $params)
    {
        $this->db->where('id_kelas', $id_kelas);
        return $this->db->update('kelas', $params);
    }

    function delete($id_kelas)
    {
        $this->db->where('id_kelas', $id_kelas);

        return $this->db->delete('kelas');
    }
}
