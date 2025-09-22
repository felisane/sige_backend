<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caixa extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Venda_model');
        $this->load->model('Saida_model');
        $this->load->model('Cliente_model');
        $this->load->model('Produto_model');
    }

    public function nova_venda()
    {
        $this->load->view('nova_venda');
    }

    public function registrar_venda()
    {
        $cliente_nome = $this->input->post('cliente');
        $cliente = $this->Cliente_model->get_by_nome($cliente_nome);
        $produtos = $this->input->post('produtos');
        $quantidades = $this->input->post('quantidades');
        $valores = $this->input->post('valores');
        $data_venda = $this->input->post('data');
        $forma_pagamento = $this->input->post('forma_pagamento');

        if (!$cliente || !is_array($produtos)) {
            echo json_encode(['status' => 'error', 'message' => 'Cliente ou produtos inválidos']);
            return;
        }

        $vendas = [];
        foreach ($produtos as $i => $produto_nome) {
            $produto = $this->Produto_model->buscar_por_nome($produto_nome);
            if (!$produto) {
                continue;
            }
            $venda = [
                'data'       => $data_venda,
                'cliente'    => $cliente['nome'],
                'produto'    => $produto->nome,
                'quantidade' => isset($quantidades[$i]) ? $quantidades[$i] : 0,
                'valor'      => isset($valores[$i]) ? $valores[$i] : 0,
                'forma_pagamento' => $forma_pagamento
            ];
            $id = $this->Venda_model->inserir($venda);
            if ($id) {
                $venda['id'] = $id;
                $vendas[] = $venda;
            }
        }

        if (!empty($vendas)) {
            echo json_encode([
                'status' => 'success',
                'cliente' => $cliente['nome'],
                'data' => $data_venda,
                'forma_pagamento' => $forma_pagamento,
                'vendas' => $vendas
            ]);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function fluxo()
    {
        $data['vendas'] = $this->Venda_model->todas();
        $data['saidas'] = $this->Saida_model->all('confirmada');
        $this->load->view('fluxo_caixa', $data);
    }
}
