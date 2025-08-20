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
            'nome'     => $this->input->post('nome'),
            'telefone' => $this->input->post('telefone'),
            'endereco' => $this->input->post('endereco'),
        ];

        $success = $this->Cliente_model->insert($dados);

        $this->output
            ->set_content_type('application/json')
            ->set_status_header($success ? 201 : 500)
            ->set_output(json_encode(['status' => $success ? 'success' : 'error']));
    }

    public function apagar($id)
    {
        $this->load->model('Cliente_model');
        $success = $this->Cliente_model->delete($id);

        $this->output
            ->set_content_type('application/json')
            ->set_status_header($success ? 200 : 500)
            ->set_output(json_encode(['status' => $success ? 'success' : 'error']));
    }

    public function editar()
    {
        $this->load->view('editar');
    }
}
