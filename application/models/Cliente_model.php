<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function all() {
        return $this->db->get('clientes')->result_array();
    }
}
