<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venda_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function inserir($data) {
        return $this->db->insert('vendas', $data);
    }

    public function todas() {
        return $this->db->order_by('data', 'DESC')->get('vendas')->result();
    }
}
