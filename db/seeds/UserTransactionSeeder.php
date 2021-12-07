<?php


use Phinx\Seed\AbstractSeed;

class UserTransactionSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create('id_ID');
        // list of payment type 
        $payment_type = ['credit_card', 'virtual_account'];
        // list of item
        $item_name = ['laptop', 'mouse', 'keyboard', 'speaker aktif', 'cpu', 'ram 8 gb', 'hdd external'];
        // list of status 
        $status = ['pending', 'paid', 'failed'];

        $data = [];
        for ($i = 0; $i < 20; $i++) {
            // membuat tipe pembayaran random 
            $payment_type_exe =  $payment_type[rand(0, 1)];

            // membuat invoice berdasarkan date 
            $date = $faker->date($format = 'Y-m-d  H:i:s', $max = 'now');
            $invoice = 'inv/' . date('m', strtotime($date)) . '/' . date('Y', strtotime($date)) . '/' . $i;

            // kondisi jika payment typenya virtual_account, maka dibikin number_va secara random
            if ($payment_type_exe == 'virtual_account') {
                $virtual_account = rand(1111111111, 9999999999);
            } else {
                $virtual_account = '-';
            }

            $data[] = [
                'invoice_id'    => $invoice,
                'item_name'     => $item_name[rand(0, 6)],
                'merchant_id'   => rand(1, 10),
                'amount'        => rand(1, 10),
                'payment_type'  => $payment_type_exe,
                'customer_name' => $faker->name,
                'number_va'     => $virtual_account,
                'status'        => $status[rand(0, 2)],
                'created'       => $date,
                'updated'       => $date,
            ];
        }

        $this->table('user_transaction')->insert($data)->saveData();
    }
}