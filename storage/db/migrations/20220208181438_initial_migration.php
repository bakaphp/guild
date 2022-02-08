<?php

use Phinx\Db\Adapter\MysqlAdapter;

class InitialMigration extends Phinx\Migration\AbstractMigration
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
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('apps_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'id',
            ])
            ->addColumn('uuid', 'string', [
                'null' => false,
                'default' => '',
                'limit' => 50,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'apps_id',
            ])
            ->addColumn('users_id', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'uuid',
            ])
            ->addColumn('companies_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'users_id',
            ])
            ->addColumn('companies_branches_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'companies_id',
            ])
            ->addColumn('leads_receivers_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'companies_branches_id',
            ])
            ->addColumn('leads_owner_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'leads_receivers_id',
            ])
            ->addColumn('leads_status_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'leads_owner_id',
            ])
            ->addColumn('pipeline_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'leads_status_id',
            ])
            ->addColumn('pipeline_stage_id', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_BIG,
                'after' => 'pipeline_id',
            ])
            ->addColumn('people_id', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_BIG,
                'after' => 'pipeline_stage_id',
            ])
            ->addColumn('organization_id', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'people_id',
            ])
            ->addColumn('leads_types_id', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'organization_id',
            ])
            ->addColumn('leads_sources_id', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'leads_types_id',
            ])
            ->addColumn('status', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'leads_sources_id',
            ])
            ->addColumn('reason_lost', 'text', [
                'null' => true,
                'limit' => 65535,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'status',
            ])
            ->addColumn('title', 'string', [
                'null' => false,
                'default' => '0',
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'reason_lost',
            ])
            ->addColumn('description', 'text', [
                'null' => true,
                'limit' => MysqlAdapter::TEXT_LONG,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'title',
            ])
            ->addColumn('is_duplicated', 'boolean', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'description',
            ])
            ->addColumn('created_at', 'datetime', [
                'null' => false,
                'after' => 'is_duplicated',
            ])
            ->addColumn('updated_at', 'datetime', [
                'null' => true,
                'after' => 'created_at',
            ])
            ->addColumn('is_deleted', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'updated_at',
            ])
            ->create();
        $this->table('rotations', [
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
            ->addColumn('companies_id', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'id',
            ])
            ->addColumn('users_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'companies_id',
            ])
            ->addColumn('name', 'string', [
                'null' => false,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'users_id',
            ])
            ->addColumn('slug', 'string', [
                'null' => false,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'name',
            ])
            ->addColumn('created_at', 'datetime', [
                'null' => false,
                'after' => 'slug',
            ])
            ->addColumn('updated_at', 'datetime', [
                'null' => true,
                'after' => 'created_at',
            ])
            ->addColumn('is_deleted', 'integer', [
                'null' => true,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'updated_at',
            ])
            ->create();
        $this->table('organizations', [
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
            ->addColumn('uuid', 'string', [
                'null' => false,
                'default' => '',
                'limit' => 36,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'id',
            ])
            ->addColumn('companies_id', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'uuid',
            ])
            ->addColumn('users_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'companies_id',
            ])
            ->addColumn('name', 'string', [
                'null' => false,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'users_id',
            ])
            ->addColumn('slug', 'string', [
                'null' => false,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'name',
            ])
            ->addColumn('address', 'text', [
                'null' => true,
                'limit' => 65535,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'slug',
            ])
            ->addColumn('created_at', 'datetime', [
                'null' => false,
                'after' => 'address',
            ])
            ->addColumn('updated_at', 'datetime', [
                'null' => true,
                'after' => 'created_at',
            ])
            ->addColumn('is_deleted', 'integer', [
                'null' => true,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'updated_at',
            ])
            ->create();
        $this->table('pipelines', [
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
            ->addColumn('companies_id', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'id',
            ])
            ->addColumn('entity_namespace', 'char', [
                'null' => false,
                'limit' => 50,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'companies_id',
            ])
            ->addColumn('users_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'entity_namespace',
            ])
            ->addColumn('name', 'string', [
                'null' => false,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'users_id',
            ])
            ->addColumn('slug', 'string', [
                'null' => false,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'name',
            ])
            ->addColumn('weight', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_SMALL,
                'after' => 'slug',
            ])
            ->addColumn('created_at', 'datetime', [
                'null' => false,
                'after' => 'weight',
            ])
            ->addColumn('updated_at', 'datetime', [
                'null' => true,
                'after' => 'created_at',
            ])
            ->addColumn('is_default', 'integer', [
                'null' => true,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'updated_at',
            ])
            ->addColumn('is_deleted', 'integer', [
                'null' => true,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'is_default',
            ])
            ->create();
        $this->table('peoples', [
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
            ->addColumn('uuid', 'string', [
                'null' => false,
                'limit' => 36,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'id',
            ])
            ->addColumn('companies_id', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'uuid',
            ])
            ->addColumn('users_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'companies_id',
            ])
            ->addColumn('name', 'string', [
                'null' => false,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'users_id',
            ])
            ->addColumn('created_at', 'datetime', [
                'null' => false,
                'after' => 'name',
            ])
            ->addColumn('updated_at', 'datetime', [
                'null' => true,
                'after' => 'created_at',
            ])
            ->addColumn('is_deleted', 'integer', [
                'null' => true,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'updated_at',
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
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('apps_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'id',
            ])
            ->addColumn('companies_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'apps_id',
            ])
            ->addColumn('leads_id', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'companies_id',
            ])
            ->addColumn('uuid', 'char', [
                'null' => false,
                'limit' => 36,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'leads_id',
            ])
            ->addColumn('title', 'string', [
                'null' => false,
                'limit' => 64,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'uuid',
            ])
            ->addColumn('slug', 'string', [
                'null' => false,
                'limit' => 32,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'title',
            ])
            ->addColumn('description', 'text', [
                'null' => false,
                'limit' => MysqlAdapter::TEXT_LONG,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'slug',
            ])
            ->addColumn('start_date', 'datetime', [
                'null' => false,
                'after' => 'description',
            ])
            ->addColumn('end_date', 'datetime', [
                'null' => false,
                'after' => 'start_date',
            ])
            ->addColumn('activity_type_id', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'end_date',
            ])
            ->addColumn('is_completed', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'activity_type_id',
            ])
            ->addColumn('created_at', 'datetime', [
                'null' => false,
                'after' => 'is_completed',
            ])
            ->addColumn('updated_at', 'datetime', [
                'null' => true,
                'after' => 'created_at',
            ])
            ->addColumn('is_deleted', 'integer', [
                'null' => true,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'updated_at',
            ])
            ->create();
    }
}
