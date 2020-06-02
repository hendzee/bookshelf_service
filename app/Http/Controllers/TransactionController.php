<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\TransactionDetails;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /** Get all data */
    public function index(Request $request) {
        $transaction = Transaction::all();

        return $transaction;
    }

    /** Show specific data */
    public function show($id) {
        $transaction = Transaction::find($id);

        return $transaction;
    }

    /** Store data */
    public function store(Request $request) {
        $transaction = new Transaction;

        $transaction->owner_id = $request->owner_id;
        $transaction->borrower_id = $request->borrower_id;
        $transaction->status = $request = $request->status;
        $transaction->map_lat = $request->map_lat;
        $transaction->map_long = $request->map_long;
        $transaction->map_note = $request->map_note;
        $transaction->active_date = $request->active_date;
        $transaction->expired_date = $request->expired_date;

        $transaction->save();

        /** Save detail data */
        $transactionDetails = $request->transaction_details;

        if (!empty($transactionDetails)) {
            $saveData = [];
            
            foreach ($transactionDetails as $detail) {
                $newDetail = new TransactionDetails;
                $newDetail->item_id = $detail['item_id'];

                array_push($saveData, $newDetail);
            }

            $transaction->transactionDetails->saveMany($saveData);
        }

        return $request;
    }

    /** Update data */
    public function update(Request $request, $id) {
        $transaction = Transaction::find($id);

        $transaction->owner_id = $request->owner_id;
        $transaction->borrower_id = $request->borrower_id;
        $transaction->status = $request = $request->status;
        $transaction->map_lat = $request->map_lat;
        $transaction->map_long = $request->map_long;
        $transaction->map_note = $request->map_note;
        $transaction->active_date = $request->active_date;
        $transaction->expired_date = $request->expired_date;

        $transaction->save();

        return $request;
    }

    /** Destroy data */
    public function destroy($id) {
        Transaction::destroy($id);
    }
}