<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos extends CI_Controller {
    public function lista()
    {
        $this->load->view('lista_produtos');
    }

    public function adicionar()
    {
        $this->load->view('adicionar_produto');
    }

    public function editar()
    {
        $this->load->view('editar_produto');
    }
}
