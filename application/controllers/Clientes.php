<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

    public function lista()
    {
        $clientes = [
            ['id' => 1, 'nome' => 'João Silva', 'email' => 'joao@example.com'],
            ['id' => 2, 'nome' => 'Maria Souza', 'email' => 'maria@example.com'],
            ['id' => 3, 'nome' => 'Carlos Pereira', 'email' => 'carlos@example.com'],
        ];

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
