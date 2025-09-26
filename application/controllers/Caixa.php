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
        $this->load->model('Caixa_periodo_model');
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

        if (!$this->is_valid_non_future_date($data_venda)) {
            echo json_encode(['status' => 'error', 'message' => 'A data da venda não pode ser futura.']);
            return;
        }

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

    public function periodos()
    {
        $periodos = array_map(function ($periodo) {
            return $this->formatar_periodo($periodo);
        }, $this->Caixa_periodo_model->todos());

        $periodo_atual = $this->Caixa_periodo_model->periodo_atual();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'periodo_atual' => $periodo_atual ? $this->formatar_periodo($periodo_atual) : null,
                'periodos' => $periodos,
            ]));
    }

    public function abrir_periodo()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $this->output->set_content_type('application/json');

        if ($this->Caixa_periodo_model->periodo_atual()) {
            $this->output
                ->set_status_header(409)
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Já existe um período de caixa em aberto.',
                ]));
            return;
        }

        $periodo = $this->Caixa_periodo_model->abrir($this->obter_usuario_atual());

        if (!$periodo) {
            $this->output
                ->set_status_header(500)
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Não foi possível abrir o caixa.',
                ]));
            return;
        }

        $this->output->set_output(json_encode([
            'status' => 'success',
            'periodo' => $this->formatar_periodo($periodo),
        ]));
    }

    public function fechar_periodo()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $this->output->set_content_type('application/json');

        $periodo = $this->Caixa_periodo_model->fechar($this->obter_usuario_atual());

        if (!$periodo) {
            $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Não há período de caixa em aberto para ser fechado.',
                ]));
            return;
        }

        $this->output->set_output(json_encode([
            'status' => 'success',
            'periodo' => $this->formatar_periodo($periodo),
        ]));
    }

    private function formatar_periodo($periodo)
    {
        if (!$periodo) {
            return null;
        }

        return [
            'id' => (int) $periodo->id,
            'abertura' => $periodo->abertura,
            'fechamento' => $periodo->fechamento,
            'abertura_formatada' => $this->formatar_data_hora($periodo->abertura),
            'fechamento_formatado' => $periodo->fechamento ? $this->formatar_data_hora($periodo->fechamento) : null,
            'usuario_abertura' => $periodo->usuario_abertura,
            'usuario_fechamento' => $periodo->usuario_fechamento,
        ];
    }

    private function formatar_data_hora($valor)
    {
        if (!$valor) {
            return null;
        }

        try {
            $date = new DateTime($valor);
            return $date->format('d/m/Y H:i');
        } catch (Exception $e) {
            return date('d/m/Y H:i', strtotime($valor));
        }
    }

    private function obter_usuario_atual()
    {
        $usuario = $this->session->userdata('username');
        return $usuario ? $usuario : 'Sistema';
    }
}
