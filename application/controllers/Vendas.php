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
        $this->load->view('vendas', $data);
    }
}
