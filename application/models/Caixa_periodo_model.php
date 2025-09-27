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
            'total_dinheiro' => '0.00',
            'total_pos' => '0.00',
            'total_transferencias' => '0.00',
            'observacoes' => null,
            'confirmacao_responsavel' => 0,
        ];

        if ($this->db->insert('caixa_periodos', $dados)) {
            return $this->obter($this->db->insert_id());
        }

        return false;
    }

    public function fechar($usuario, array $dados = [])
    {
        $periodo = $this->periodo_atual();

        if (!$periodo) {
            return [
                'success' => false,
                'status_code' => 400,
                'message' => 'Não há período de caixa em aberto para ser fechado.',
            ];
        }

        $requeridos = ['dinheiro', 'pos', 'transferencias'];
        foreach ($requeridos as $campo) {
            if (!array_key_exists($campo, $dados)) {
                return [
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Os dados de fechamento estão incompletos.',
                ];
            }
        }

        $confirmado = filter_var($dados['confirmacao'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if ($confirmado !== true) {
            return [
                'success' => false,
                'status_code' => 400,
                'message' => 'A confirmação do responsável é obrigatória para fechar o caixa.',
            ];
        }

        $atualizacao = [
            'fechamento' => date('Y-m-d H:i:s'),
            'usuario_fechamento' => $usuario,
            'total_dinheiro' => isset($dados['dinheiro']) ? (float) $dados['dinheiro'] : 0,
            'total_pos' => isset($dados['pos']) ? (float) $dados['pos'] : 0,
            'total_transferencias' => isset($dados['transferencias']) ? (float) $dados['transferencias'] : 0,
            'observacoes' => isset($dados['observacoes']) ? $dados['observacoes'] : null,
            'confirmacao_responsavel' => $confirmado ? 1 : 0,
        ];

        $this->db->where('id', $periodo->id);

        if ($this->db->update('caixa_periodos', $atualizacao)) {
            return [
                'success' => true,
                'status_code' => 200,
                'periodo' => $this->obter($periodo->id),
            ];
        }

        return [
            'success' => false,
            'status_code' => 500,
            'message' => 'Não foi possível atualizar o período de caixa.',
        ];
    }

    public function obter($id)
    {
        return $this->db->get_where('caixa_periodos', ['id' => $id])->row();
    }
}
