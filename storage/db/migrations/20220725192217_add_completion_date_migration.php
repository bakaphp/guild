<?php


class AddCompletionDateMigration extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('activities', [
            'id' => false,
            'primary_key' => ['id'],
            'engine' => 'InnoDB',
            'encoding' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_520_ci',
            'comment' => '',
            'row_format' => 'DYNAMIC',
        ])
            ->addColumn('completed_date', 'datetime', [
                'null' => true,
                'after' => 'end_date',
            ])
            ->save();
    }
}
