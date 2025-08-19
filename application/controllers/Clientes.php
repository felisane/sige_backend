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

    public function editar()
    {
        $this->load->view('editar');
    }
}
