<?php

use Phinx\Db\Adapter\MysqlAdapter;

class PipelinesStageMigration extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('pipelines_stages', [
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
            ->addColumn('pipelines_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'id',
            ])
            ->addColumn('name', 'string', [
                'null' => false,
                'limit' => 64,
                'collation' => 'utf8mb4_unicode_520_nopad_ci',
                'encoding' => 'utf8mb4',
                'after' => 'pipelines_id',
            ])
            ->addColumn('has_rotting_days', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'name',
            ])
            ->addColumn('rotting_days', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'has_rotting_days',
            ])
            ->addColumn('weight', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_SMALL,
                'after' => 'rotting_days',
            ])
            ->addColumn('created_at', 'datetime', [
                'null' => false,
                'after' => 'weight',
            ])
            ->addColumn('updated_at', 'datetime', [
                'null' => true,
                'default' => null,
                'after' => 'created_at',
            ])
            ->addColumn('is_deleted', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'updated_at',
            ])
            ->addIndex(['pipelines_id'], [
                'name' => 'FK_pipelines_stages_pipeline',
                'unique' => false,
            ])
            ->create();
    }
}
