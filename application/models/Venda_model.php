<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venda_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function inserir($data) {
        $this->db->trans_start();

        $this->db->insert('vendas', $data);

        $quantidade = (int) $data['quantidade'];
        $this->db->set('estoque', 'estoque - ' . $quantidade, false);
        $this->db->where('nome', $data['produto']);
        $this->db->update('produtos');

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function todas() {
        return $this->db->order_by('data', 'DESC')->get('vendas')->result();
    }
}
