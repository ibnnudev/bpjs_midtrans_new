<?php

class Faskes_model extends CI_Model
{
    public function get_all()
    {
        return $this->db->get('faskes')->result();
    }

    public function insert($data)
    {
        return $this->db->insert('faskes', $data);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('faskes', ['id' => $id])->row();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('faskes', $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete('faskes');
    }
}
