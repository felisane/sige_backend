<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caixa extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Venda_model');
    }

    public function nova_venda()
    {
        $this->load->view('nova_venda');
    }

    public function registrar_venda()
    {
        $venda = [
            'data'       => $this->input->post('data'),
            'cliente'    => $this->input->post('cliente'),
            'produto'    => $this->input->post('produto'),
            'descricao'  => $this->input->post('descricao'),
            'quantidade' => $this->input->post('quantidade'),
            'valor'      => $this->input->post('valor')
        ];

        if ($this->Venda_model->inserir($venda)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function fluxo()
    {
        $data['vendas'] = $this->Venda_model->todas();
        $this->load->view('fluxo_caixa', $data);
    }
}
