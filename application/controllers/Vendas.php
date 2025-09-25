<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendas extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Venda_model');
    }

    public function index()
    {
        $data['vendas'] = $this->Venda_model->todas();
        $data['is_admin'] = $this->session->userdata('level') === '1';
        $this->load->view('vendas', $data);
    }

    public function apagar($id)
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

        $resultado = $this->Venda_model->remover((int) $id);

        switch ($resultado) {
            case 'deleted':
                $response = ['status' => 'success', 'message' => 'Venda apagada com sucesso.'];
                break;
            case 'not_found':
                $this->output->set_status_header(404);
                $response = ['status' => 'error', 'message' => 'Venda não encontrada.'];
                break;
            default:
                $this->output->set_status_header(500);
                $response = ['status' => 'error', 'message' => 'Não foi possível apagar a venda.'];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
