<?php

use Phinx\Db\Adapter\MysqlAdapter;

class LeadsUpdatedMigrations extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('leads', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->changeColumn('pipeline_stage_id', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_BIG,
                'after' => 'leads_status_id',
            ])
            ->changeColumn('people_id', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_BIG,
                'after' => 'pipeline_stage_id',
            ])
            ->changeColumn('organization_id', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'people_id',
            ])
            ->changeColumn('leads_types_id', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'organization_id',
            ])
            ->changeColumn('leads_sources_id', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'leads_types_id',
            ])
            ->changeColumn('status', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'leads_sources_id',
            ])
            ->changeColumn('reason_lost', 'text', [
                'null' => true,
                'default' => null,
                'limit' => 65535,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'status',
            ])
            ->changeColumn('title', 'string', [
                'null' => false,
                'default' => '0',
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'reason_lost',
            ])
            ->changeColumn('description', 'text', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::TEXT_LONG,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'title',
            ])
            ->changeColumn('is_duplicated', 'boolean', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'description',
            ])
            ->changeColumn('created_at', 'datetime', [
                'null' => false,
                'after' => 'is_duplicated',
            ])
            ->changeColumn('updated_at', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'created_at',
            ])
            ->changeColumn('is_deleted', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'updated_at',
            ])
            ->removeColumn('pipeline_id')
            ->save();
    }
}
