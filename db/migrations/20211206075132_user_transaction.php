<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserTransaction extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        // membuat primary key user_transaction 
        $table = $this->table('user_transaction', ['id' => 'references_id']);

        // membuat kolom tabel user_transaction
        $table->addColumn('invoice_id', 'string', ['limit' => 20])
            ->addColumn('item_name', 'string', ['limit' => 50])
            ->addColumn('merchant_id', 'integer', ['limit' => 4])
            ->addColumn('amount', 'integer', ['limit' => 4])
            ->addColumn('payment_type', 'string', ['limit' => 20])
            ->addColumn('customer_name', 'string', ['limit' => 50])
            ->addColumn('number_va', 'string', ['limit' => 20])
            ->addColumn('status', 'string', ['limit' => 20])
            ->addColumn('created', 'datetime')
            ->addColumn('updated', 'datetime')
            ->create();
    }
}