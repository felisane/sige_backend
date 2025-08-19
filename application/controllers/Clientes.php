<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

    public function lista()
    {
        $this->load->model('Cliente_model');
        $clientes = $this->Cliente_model->get_all();

        $this->load->view('lista_clientes', ['dataVar' => ['clientes' => $clientes]]);
    }

    public function cadastrar()
    {
        $this->load->view('cadastrar');
    }

    public function salvar()
    {
        $this->load->model('Cliente_model');
        $dados = [
            'nome' => $this->input->post('nome'),
            'endereco' => $this->input->post('endereco'),
            'telefone' => $this->input->post('telefone'),
        ];

        $success = $this->Cliente_model->insert($dados);

        $status = $success ? 'success' : 'error';
        $status_code = $success ? 201 : 500;

        $this->output
            ->set_content_type('application/json')
            ->set_status_header($status_code)
            ->set_output(json_encode(['status' => $status]));
    }

    public function editar()
    {
        $this->load->view('editar');
    }
}
