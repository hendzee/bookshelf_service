<?php

use App\Transaction;
use App\TransactionDetail;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transaction = new Transaction;

        $transaction->owner_id = 1;
        $transaction->borrower_id = 2;
        $transaction->status = 'WAITING';
        $transaction->map_lat = '4.942820743';
        $transaction->map_long = '4.81020710';
        $transaction->map_note = 'Front of AL-Big mosque';
        $transaction->active_date = '2020-03-10';
        $transaction->expired_date = '2020-03-11';
        $transaction->save();

        /** Save detail iteem - start */
        $saveData = [];
        
        for ($i=0; $i<3; $i++) {
            $detail = new TransactionDetail;
            $detail->item_id = $i + 1;

            array_push($saveData, $detail);
        }
        /** Save detail iteem - end */

        $transaction->transactionDetails()->saveMany($saveData);
    }
}
