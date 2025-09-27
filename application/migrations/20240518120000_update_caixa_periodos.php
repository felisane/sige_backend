<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update_caixa_periodos extends CI_Migration {
    public function up()
    {
        $this->load->dbforge();

        $decimalColumn = [
            'type' => 'DECIMAL',
            'constraint' => '15,2',
            'null' => FALSE,
            'default' => '0.00',
        ];

        foreach (['total_dinheiro', 'total_pos', 'total_transferencias'] as $campo) {
            if ($this->db->field_exists($campo, 'caixa_periodos')) {
                $this->dbforge->modify_column('caixa_periodos', [
                    $campo => $decimalColumn,
                ]);
            } else {
                $this->dbforge->add_column('caixa_periodos', [
                    $campo => $decimalColumn,
                ]);
            }
        }

        $observacoesColumn = [
            'type' => 'TEXT',
            'null' => TRUE,
        ];

        if ($this->db->field_exists('observacoes_fechamento', 'caixa_periodos')) {
            $this->dbforge->modify_column('caixa_periodos', [
                'observacoes_fechamento' => array_merge($observacoesColumn, ['name' => 'observacoes']),
            ]);
        } elseif (!$this->db->field_exists('observacoes', 'caixa_periodos')) {
            $this->dbforge->add_column('caixa_periodos', [
                'observacoes' => $observacoesColumn,
            ]);
        } else {
            $this->dbforge->modify_column('caixa_periodos', [
                'observacoes' => $observacoesColumn,
            ]);
        }

        $booleanColumn = [
            'type' => 'TINYINT',
            'constraint' => 1,
            'null' => FALSE,
            'default' => 0,
        ];

        if ($this->db->field_exists('confirmacao_responsavel', 'caixa_periodos')) {
            $this->dbforge->modify_column('caixa_periodos', [
                'confirmacao_responsavel' => $booleanColumn,
            ]);
        } else {
            $this->dbforge->add_column('caixa_periodos', [
                'confirmacao_responsavel' => $booleanColumn,
            ]);
        }

        $this->db->set('total_dinheiro', 0)
            ->where('total_dinheiro IS NULL', null, false)
            ->update('caixa_periodos');
        $this->db->set('total_pos', 0)
            ->where('total_pos IS NULL', null, false)
            ->update('caixa_periodos');
        $this->db->set('total_transferencias', 0)
            ->where('total_transferencias IS NULL', null, false)
            ->update('caixa_periodos');
        $this->db->set('confirmacao_responsavel', 0)
            ->where('confirmacao_responsavel IS NULL', null, false)
            ->update('caixa_periodos');
    }

    public function down()
    {
        $this->load->dbforge();

        $decimalNullable = [
            'type' => 'DECIMAL',
            'constraint' => '15,2',
            'null' => TRUE,
            'default' => NULL,
        ];

        foreach (['total_dinheiro', 'total_pos', 'total_transferencias'] as $campo) {
            if ($this->db->field_exists($campo, 'caixa_periodos')) {
                $this->dbforge->modify_column('caixa_periodos', [
                    $campo => $decimalNullable,
                ]);
            }
        }

        if ($this->db->field_exists('observacoes', 'caixa_periodos')) {
            $this->dbforge->modify_column('caixa_periodos', [
                'observacoes' => [
                    'name' => 'observacoes_fechamento',
                    'type' => 'TEXT',
                    'null' => TRUE,
                ],
            ]);
        }

        if ($this->db->field_exists('confirmacao_responsavel', 'caixa_periodos')) {
            $this->dbforge->modify_column('caixa_periodos', [
                'confirmacao_responsavel' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'null' => TRUE,
                    'default' => NULL,
                ],
            ]);
        }
    }
}
