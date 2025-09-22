<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saida_model extends CI_Model {
    protected $table = 'saidas';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function all($status = null)
    {
        $this->db->order_by('data', 'DESC');
        if ($status !== null) {
            $this->db->where('status', $status);
        }

        return $this->db->get($this->table)->result();
    }

    public function find($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert(array $data)
    {
        if (!isset($data['status'])) {
            $data['status'] = 'pendente';
        }

        return $this->db->insert($this->table, $data);
    }

    public function confirmar($id, $usuario)
    {
        $saida = $this->find($id);

        if (!$saida) {
            return 'not_found';
        }

        if ($saida->status === 'confirmada') {
            return 'already';
        }

        $atualizado = $this->db
            ->where('id', $id)
            ->update($this->table, [
                'status' => 'confirmada',
                'confirmado_por' => $usuario,
                'confirmado_em' => date('Y-m-d H:i:s'),
            ]);

        if (!$atualizado) {
            return 'error';
        }

        return 'confirmed';
    }
}
