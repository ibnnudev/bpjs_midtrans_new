<?php

class Kelas_model extends CI_Model
{
    public function get_all()
    {
        return $this->db->get('kelas_bpjs')->result();
    }

    public function insert($data)
    {
        return $this->db->insert('kelas_bpjs', $data);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('kelas_bpjs', ['id' => $id])->row();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('kelas_bpjs', $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete('kelas_bpjs');
    }
}
