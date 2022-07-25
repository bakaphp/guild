<?php

use Phinx\Db\Adapter\MysqlAdapter;

class ActivitiesStatusMigration extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('activities_status', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('name', 'string', [
                'null' => false,
                'default' => '',
                'limit' => 50,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'id',
            ])
            ->addColumn('companies_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'name',
            ])
            ->addColumn('is_default', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'companies_id',
            ])
            ->addColumn('created_at', 'datetime', [
                'null' => false,
                'after' => 'is_default',
            ])
            ->addColumn('is_deleted', 'integer', [
                'null' => false,
                'limit' => '3',
                'after' => 'created_at',
            ])
            ->create();
        $this->table('activities', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('activities_status_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'end_date',
            ])
            ->changeColumn('activity_type_id', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'activities_status_id',
            ])
            ->removeColumn('is_completed')
            ->save();
    }
}
