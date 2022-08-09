<?php

use Phinx\Db\Adapter\MysqlAdapter;

class RemoveKeyTempMigration extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('activities', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->save();
    }
}
