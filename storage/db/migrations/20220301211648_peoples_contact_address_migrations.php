<?php

use Phinx\Db\Adapter\MysqlAdapter;

class PeoplesContactAddressMigrations extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('peoples_address', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_520_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('peoples_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'id',
            ])
            ->addColumn('address', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_520_ci',
                'encoding' => 'utf8mb4',
                'after' => 'peoples_id',
            ])
            ->addColumn('address_2', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_520_ci',
                'encoding' => 'utf8mb4',
                'after' => 'address',
            ])
            ->addColumn('city', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_520_ci',
                'encoding' => 'utf8mb4',
                'after' => 'address_2',
            ])
            ->addColumn('state', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_520_ci',
                'encoding' => 'utf8mb4',
                'after' => 'city',
            ])
            ->addColumn('zip', 'string', [
                'null' => true,
                'limit' => 50,
                'collation' => 'utf8mb4_unicode_520_ci',
                'encoding' => 'utf8mb4',
                'after' => 'state',
            ])
            ->addColumn('is_default', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'zip',
            ])
            ->addColumn('countries_id', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'is_default',
            ])
            ->addColumn('created_at', 'datetime', [
                'null' => false,
                'after' => 'countries_id',
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
            ->addIndex(['peoples_id'], [
                'name' => 'peoples_address_peoples_FK',
                'unique' => false,
            ])
            ->addForeignKey(
                'peoples_id',
                'peoples',
                'id',
                ['constraint' => 'peoples_address_peoples_FK'],
                ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION']
            )
            ->create();
        $this->table('leads_rotations_agents', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_520_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->changeColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->save();
        $this->table('contacts_types', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_520_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('companies_id', 'integer', [
                'null' => false,
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
                'collation' => 'utf8mb4_unicode_520_ci',
                'encoding' => 'utf8mb4',
                'after' => 'users_id',
            ])
            ->addColumn('icon', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_520_ci',
                'encoding' => 'utf8mb4',
                'after' => 'name',
            ])
            ->addColumn('created_at', 'datetime', [
                'null' => false,
                'after' => 'icon',
            ])
            ->addColumn('updated_at', 'datetime', [
                'null' => true,
                'after' => 'created_at',
            ])
            ->addColumn('is_deleted', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => '3',
                'after' => 'updated_at',
            ])
            ->create();
        $this->table('peoples_contacts', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_520_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('contacts_types_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'id',
            ])
            ->addColumn('peoples_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'contacts_types_id',
            ])
            ->addColumn('value', 'string', [
                'null' => true,
                'limit' => 255,
                'collation' => 'utf8mb4_unicode_520_ci',
                'encoding' => 'utf8mb4',
                'after' => 'peoples_id',
            ])
            ->addColumn('weight', 'integer', [
                'null' => true,
                'limit' => MysqlAdapter::INT_SMALL,
                'after' => 'value',
            ])
            ->addColumn('created_at', 'datetime', [
                'null' => false,
                'after' => 'weight',
            ])
            ->addColumn('updated_at', 'datetime', [
                'null' => true,
                'after' => 'created_at',
            ])
            ->addColumn('is_deleted', 'integer', [
                'null' => false,
                'default' => '0',
                'limit' => '3',
                'after' => 'updated_at',
            ])
            ->addIndex(['peoples_id'], [
                'name' => 'peoples_contacts_peoples_FK',
                'unique' => false,
            ])
            ->addIndex(['contacts_types_id'], [
                'name' => 'peoples_contacts_contacts_type_FK',
                'unique' => false,
            ])
            ->addForeignKey(
                'peoples_id',
                'peoples',
                'id',
                ['constraint' => 'peoples_contacts_peoples_FK'],
                ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION']
            )
            ->addForeignKey(
                'contacts_types_id',
                'contacts_types',
                'id',
                ['constraint' => 'peoples_contacts_contacts_type_FK'],
                ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION']
            )
            ->create();
    }
}
