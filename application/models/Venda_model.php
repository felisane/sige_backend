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
        $venda_id = $this->db->insert_id();

        $quantidade = (int) $data['quantidade'];
        $this->db->set('estoque', 'estoque - ' . $quantidade, false);
        $this->db->where('nome', $data['produto']);
        $this->db->update('produtos');

        $this->db->trans_complete();
        return $this->db->trans_status() ? $venda_id : false;
    }

    public function todas() {
        return $this->db
            ->select('vendas.*, produtos.nome AS produto_nome')
            ->from('vendas')
            ->join('produtos', 'produtos.id = vendas.produto', 'left')
            ->order_by('data', 'DESC')
            ->get()
            ->result();
    }

    public function por_cliente($cliente)
    {
        return $this->db
            ->order_by('data', 'DESC')
            ->get_where('vendas', ['cliente' => $cliente])
            ->result_array();
    }
}
