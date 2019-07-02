<?php

use Phinx\Migration\AbstractMigration;

class DirectionMigration extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('direction', ['id' => false, 'primary_key' => 'id']);
        $table
            ->addColumn('id', 'string', ['limit' => '255'])
            ->addColumn('address', 'text')
            ->addColumn('link', 'string', ['limit' => '255'])
            ->create()
        ;
    }

    public function down()
    {
        $table = $this->table('direction');

        if ($table) {
            $table
                ->drop()
                ->save()
            ;
        }
    }
}