<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Loan;
use App\User;
use Illuminate\Http\Request;
use Throwable;

class TransactionController extends Controller
{
    /** Get all data */
    public function index(Request $request) {
        $transaction = Transaction::all();

        return $transaction;
    }

    /** Show specific data */
    public function show($id) {
        $data = array();

        $transaction = Transaction::with('loans', 'loans.items')
            ->find($id);

        $getOwner = User::find($transaction->owner_id);
        $owner = $getOwner->first_name . ' ' . $getOwner->last_name;
        $ownerRating = $getOwner->rating;
        
        $getBorrower = User::find($transaction->borrower_id);
        $borrower = $getBorrower->first_name . ' ' . $getBorrower->last_name;
        $borrowerRating = $getBorrower->rating;

        $data['transaction'] = $transaction;
        $data['user'] = [
            'owner_name' => $owner,
            'owner_rating' => $ownerRating,
            'borrower_name' => $borrower,
            'borrower_rating' => $borrowerRating
        ];
        
        return $data;
    }

    /** Store data */
    public function store(Request $request) {
        $listStatus = $this->checkListingStatus($request->borrower_id);
        
        if ($listStatus == 1) {
            return $this->addListing($request);
        }else {
            $availableStatus = $this->checkAvailableBorrow($request->borrower_id);

            if ($availableStatus == 1) {
                $response['message'] = 'Item Not Available';
                return response()->json($response, 500);
            }else {
                return $this->addListingFirstTime($request);
            }
        }
    }

    /** Check listing status */
    public function checkListingStatus($id) {
        $transaction = Transaction::where('borrower_id', $id)
            ->where('status', 'LISTING')
            ->get();
        
        if (count ($transaction) > 0) {
            // There are already exists
            return 1;
        }else {
            // There are not exist
            return 0;
        }
    }

    /** Cheking available user to borrow itam */
    public function checkAvailableBorrow($id) {
        $transaction = Transaction::where('borrower_id', $id)
            ->where(function($q){
                $q->where('status', 'WAITING')
                ->orWhere('status', 'APPOINTMENT')
                ->orWhere('status', 'BORROWED');
            })
            ->get();
        
        if (count ($transaction) > 0) {
            // There are already exists
            return 1;
        }else {
            // There are not exist
            return 0;
        }
    }

    /** Add item for first time */
    public function addListingFirstTime($request){
        $transaction = new Transaction;

        $transaction->owner_id = $request->owner_id;
        $transaction->borrower_id = $request->borrower_id;
        $transaction->status = 'LISTING';
        $transaction->map_lat = '-';
        $transaction->map_long = '-';
        $transaction->map_note = '-';
        $transaction->active_date = '2020-10-10';
        $transaction->expired_date = '2020-10-10';

        $transaction->save();

       
        $loan = new Loan;
        $loan->item_id = $request->item_id;

        $transaction->loans()->save($loan);

        return $transaction;
    }

    /** Add item when listing */
    public function addListing($request) {
        $ownerInfo = Transaction::where('borrower_id', $request->borrower_id)
            ->where('status', 'LISTING')
            ->first();

        if ($request->owner_id == $ownerInfo->owner_id) {
            $loan = new Loan;

            try {
                $loan->transaction_id = $ownerInfo->id;
                $loan->item_id = $request->item_id;
                $loan->save();

                return $request;
            } catch (Throwable $th) {
                $response['message'] = 'Redundant book';
                return response()->json($response, 500);
            }
        }else{
            $response['message'] = 'You have another transaction';
            return response()->json($response, 500);
        }
    }

    /** Update data to waiting*/
    public function updateToWaiting($id) {
        $transaction = Transaction::find($id);

        $transaction->status = 'WAITING';

        $transaction->save();

        return $id;
    }

    /** Update data to handover */
    public function updateToAppointment($id) {
        $transaction = Transaction::find($id);

        $transaction->status = 'APPOINTMENT';

        $transaction->save();

        return $id;
    }

    /** Update data to cancel */
    public function updateToCancel($id) {
        $transaction = Transaction::find($id);

        $transaction->status = 'CANCEL';

        $transaction->save();

        return $id;
    }

    /** Update map */
    public function updateMap(Request $request, $id) {
        try {
            $transaction = Transaction::find($id);
            $transaction->map_lat = $request->map_lat;
            $transaction->map_long = $request->map_long;
            $transaction->map_note = $request->map_note;
            $transaction->save();

            return $transaction;
        } catch (Throwable $th) {
            $response['message'] = 'Failed to update map';
            return response()->json($response, 500);
        }
    }

    /** Destroy data */
    public function destroy($id) {
        Transaction::destroy($id);
    }
}