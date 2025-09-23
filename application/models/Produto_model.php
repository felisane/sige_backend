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

    public function fora_de_estoque() {
        return $this->db
            ->where('estoque <=', 0)
            ->order_by('nome', 'ASC')
            ->get('produtos')
            ->result();
    }

    public function mais_vendidos($limite = 5) {
        $resultados = $this->db
            ->select('produtos.id, produtos.nome, produtos.categoria, produtos.preco, produtos.estoque, produtos.imagem, COALESCE(SUM(vendas.quantidade), 0) AS total_vendido', false)
            ->from('produtos')
            ->join('vendas', 'vendas.produto = produtos.nome', 'left')
            ->group_by('produtos.id')
            ->order_by('total_vendido', 'DESC')
            ->get()
            ->result();

        $resultados = array_values(array_filter($resultados, function ($produto) {
            return (int) $produto->total_vendido > 0;
        }));

        if ($limite !== NULL) {
            $resultados = array_slice($resultados, 0, (int) $limite);
        }

        return $resultados;
    }

    public function buscar_por_nome($nome) {
        return $this->db->get_where('produtos', ['nome' => $nome])->row();
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
