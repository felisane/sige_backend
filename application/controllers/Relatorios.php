<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorios extends CI_Controller {
    public function vendas()
    {
        $this->load->model('Venda_model');
        $data['vendas'] = $this->Venda_model->todas();
        $this->load->view('relatorios_vendas', $data);
    }

    public function caixa()
    {
        $this->load->view('relatorios_caixa');
    }

    public function fiscais()
    {
        $this->load->view('relatorios_fiscais');
    }

    public function estoque()
    {
        $this->load->view('relatorios_estoque');
    }
}
