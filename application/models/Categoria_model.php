<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function todas() {
        return $this->db->get('categorias')->result();
    }
}
