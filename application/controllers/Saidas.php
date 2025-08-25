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
}
