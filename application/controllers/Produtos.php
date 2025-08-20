<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Produto_model');
        $this->load->model('Categoria_model');
    }

    public function lista()
    {
        $data['produtos'] = $this->Produto_model->todos();
        $this->load->view('lista_produtos', $data);
    }

    public function adicionar()
    {
        $data['categorias'] = $this->Categoria_model->todas();
        $this->load->view('adicionar_produto', $data);
    }

    public function salvar()
    {
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size']      = 2048;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('imagem')) {
            echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
            return;
        }

        $file_data = $this->upload->data();
        $produto = [
            'nome'      => $this->input->post('nome'),
            'categoria' => $this->input->post('categoria'),
            'preco'     => $this->input->post('preco'),
            'estoque'   => $this->input->post('estoque'),
            'descricao' => $this->input->post('descricao'),
            'imagem'    => $file_data['file_name']
        ];

        if ($this->Produto_model->inserir($produto)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function editar($id = NULL)
    {
        $this->load->view('editar_produto');
    }
}
