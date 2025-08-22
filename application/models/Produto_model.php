<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produto_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function inserir($data) {
        return $this->db->insert('produtos', $data);
    }

    public function todos() {
        return $this->db->get('produtos')->result();
    }

    public function apagar($id) {
        return $this->db->delete('produtos', ['id' => $id]);
    }

    public function buscar($id) {
        return $this->db->get_where('produtos', ['id' => $id])->row();
    }

    public function atualizar($id, $data) {
        return $this->db->update('produtos', $data, ['id' => $id]);
    }
}
