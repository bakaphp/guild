<?php

use Phinx\Db\Adapter\MysqlAdapter;

class UpdateMigrationsActivities extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('activities_types', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->changeColumn('name', 'string', [
                'null' => false,
                'limit' => 150,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'companies_id',
            ])
            ->changeColumn('description', 'text', [
                'null' => true,
                'limit' => 65535,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'name',
            ])
            ->save();
        $this->table('activities', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->changeColumn('apps_id', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'id',
            ])
            ->save();
    }
}
