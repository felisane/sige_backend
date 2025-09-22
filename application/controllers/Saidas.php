<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saidas extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Saida_model');
    }

    public function index()
    {
        $data['saidas'] = $this->Saida_model->all();
        $data['is_admin'] = $this->session->userdata('level') === '1';
        $this->load->view('saidas', $data);
    }

    public function nova()
    {
        $this->load->view('nova_saida');
    }

    public function salvar()
    {
        $saida = [
            'data' => $this->input->post('data'),
            'descricao' => $this->input->post('descricao'),
            'valor' => $this->input->post('valor'),
            'forma_pagamento' => $this->input->post('forma_pagamento'),
            'status' => 'pendente'
        ];

        if ($this->Saida_model->insert($saida)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'success',
                    'message' => 'Saída registrada e aguardando confirmação do administrador.'
                ]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Não foi possível registrar a saída.'
                ]));
        }
    }

    public function confirmar($id)
    {
        if ($this->session->userdata('level') !== '1') {
            $this->output
                ->set_status_header(403)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Acesso não autorizado.'
                ]));
            return;
        }

        if ($this->input->method() !== 'post') {
            $this->output
                ->set_status_header(405)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Método não permitido.'
                ]));
            return;
        }

        $usuario = $this->session->userdata('username');
        if (empty($usuario)) {
            $usuario = 'admin';
        }

        $resultado = $this->Saida_model->confirmar((int) $id, $usuario);

        switch ($resultado) {
            case 'confirmed':
                $response = ['status' => 'success', 'message' => 'Saída confirmada com sucesso.'];
                break;
            case 'already':
                $response = ['status' => 'info', 'message' => 'Esta saída já foi confirmada.'];
                break;
            case 'not_found':
                $response = ['status' => 'error', 'message' => 'Saída não encontrada.'];
                break;
            default:
                $response = ['status' => 'error', 'message' => 'Não foi possível confirmar a saída.'];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
