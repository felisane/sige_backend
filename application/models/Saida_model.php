<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saida_model extends CI_Model {
    protected $table = 'saidas';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function all()
    {
        return $this->db->order_by('data', 'DESC')->get($this->table)->result();
    }

    public function insert(array $data)
    {
        return $this->db->insert($this->table, $data);
    }
}
