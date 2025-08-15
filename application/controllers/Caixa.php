<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caixa extends CI_Controller {
    public function nova_venda()
    {
        $this->load->view('nova_venda');
    }

    public function fluxo()
    {
        $this->load->view('fluxo_caixa');
    }
}
