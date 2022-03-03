<?php

use Phinx\Db\Adapter\MysqlAdapter;

class OrganizationsPeoplesMigration extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('organizations_peoples', [
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
            ->addColumn('organizations_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'id',
            ])
            ->addColumn('peoples_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'organizations_id',
            ])
            ->addColumn('created_at', 'datetime', [
                'null' => false,
                'after' => 'peoples_id',
            ])
            ->addColumn('is_deleted', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => '3',
                'after' => 'created_at',
            ])
            ->addIndex(['peoples_id'], [
                'name' => 'organizations_peoples_peoples_FK',
                'unique' => false,
            ])
            ->addIndex(['organizations_id'], [
                'name' => 'organizations_peoples_organizations_FK',
                'unique' => false,
            ])
            ->addForeignKey(
                'peoples_id',
                'peoples',
                'id',
                ['constraint' => 'organizations_peoples_peoples_FK'],
                ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION']
            )
            ->addForeignKey(
                'organizations_id',
                'organizations',
                'id',
                ['constraint' => 'organizations_peoples_organizations_FK'],
                ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION']
            )
            ->create();
    }
}
