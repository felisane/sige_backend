<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caixa_periodo_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function periodo_atual()
    {
        return $this->db
            ->order_by('abertura', 'DESC')
            ->where('fechamento IS NULL', null, false)
            ->get('caixa_periodos', 1)
            ->row();
    }

    public function todos()
    {
        return $this->db
            ->order_by('abertura', 'DESC')
            ->get('caixa_periodos')
            ->result();
    }

    public function abrir($usuario)
    {
        if ($this->periodo_atual()) {
            return false;
        }

        $dados = [
            'abertura' => date('Y-m-d H:i:s'),
            'usuario_abertura' => $usuario,
        ];

        if ($this->db->insert('caixa_periodos', $dados)) {
            return $this->obter($this->db->insert_id());
        }

        return false;
    }

    public function fechar($usuario)
    {
        $periodo = $this->periodo_atual();

        if (!$periodo) {
            return false;
        }

        $dados = [
            'fechamento' => date('Y-m-d H:i:s'),
            'usuario_fechamento' => $usuario,
        ];

        $this->db->where('id', $periodo->id);

        if ($this->db->update('caixa_periodos', $dados)) {
            return $this->obter($periodo->id);
        }

        return false;
    }

    public function obter($id)
    {
        return $this->db->get_where('caixa_periodos', ['id' => $id])->row();
    }
}
