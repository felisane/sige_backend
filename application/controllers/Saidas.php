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
            'valor' => $this->input->post('valor')
        ];

        if ($this->Saida_model->insert($saida)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success']));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error']));
        }
    }
}
