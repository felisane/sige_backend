<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_categorias extends CI_Migration {
    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('categorias');

        $categorias = [];
        for ($i = 1; $i <= 5; $i++) {
            $categorias[] = ['nome' => 'Categoria ' . $i];
        }
        $this->db->insert_batch('categorias', $categorias);
    }

    public function down()
    {
        $this->dbforge->drop_table('categorias');
    }
}
