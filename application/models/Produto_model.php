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
}
