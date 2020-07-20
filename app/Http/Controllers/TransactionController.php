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

        if ($request->has('borrower_id')){
            $data = array();

            $transaction = Transaction::with('loans', 'loans.items')
                ->where('borrower_id', $request->borrower_id)
                ->where('status', 'LISTING')
                ->first();

            if (!$transaction) {
                $response['not_found'] = true;
                return response()->json($response, 200);
            }

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

        return $transaction;
    }

    /** Show specific data */
    public function show($id) {
        $data = array();

        $transaction = Transaction::with('loans', 'loans.items')
            ->where('id', $id)
            ->where(function($q){
                $q->where('status', 'WAITING')
                    ->orWhere('status', 'APPOINTMENT')
                    ->orWhere('status', 'BORROWED');
            })
            ->first();

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

    /** Show specific list data */
    public function showList(Request $request, $id) {
        switch ($request->person) {
            case 'STATUS_LEND':
                $transaction = Transaction::where('owner_id', $id)
                    ->where(function($q){
                        $q->where('status', 'WAITING')
                            ->orWhere('status', 'APPOINTMENT')
                            ->orWhere('status', 'BORROWED');
                    })
                ->first();

                if (!$transaction) {
                    $response['notFound'] = true;
                    return response()->json($response, 200);
                }
                
                return $transaction; 

            case 'STATUS_BORROW':
                $transaction = Transaction::where('borrower_id', $id)
                    ->where(function($q){
                        $q->where('status', 'WAITING')
                            ->orWhere('status', 'APPOINTMENT')
                            ->orWhere('status', 'BORROWED');
                    })
                ->first();

                if (!$transaction) {
                    $response['notFound'] = true;
                    return response()->json($response, 200);
                }

                return $transaction;
            
            default:
                return 0;
                break;
        }
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
        $transaction->location_name = '-';
        $transaction->map_lat = '-';
        $transaction->map_long = '-';
        $transaction->map_note = '-';
        $transaction->owner_accepted = '-';
        $transaction->borrower_accepted = '-';

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
            $transaction->location_name = $request->location_name;
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

    /** Update to borrowed */
    public function updateToBorrowed(Request $request, $id) {
        $transaction = Transaction::find($id);

        switch ($request->owner_status) {
            case 'OWNER':
                $transaction->owner_accepted = 'ACCEPTED';
                $transaction->save();
                break;

            case 'BORROWER':
                $transaction->borrower_accepted = 'ACCEPTED';
                $transaction->save();
                break;

            default:
                break;
        }

        if (strcmp($transaction->owner_accepted, 'ACCEPTED') == 0 && 
            strcmp($transaction->borrower_accepted, 'ACCEPTED') == 0) {
                
            $transaction->status = 'BORROWED';
            $transaction->save();

            $response = 'Updated to borrowed';
            return response()->json($response, 200);
        }else {
            $response = 'Both owner and borrower must be send confirmation.';
            return response()->json($response, 200);
        }
    }

    /** Update to returned */
    public function updateToReturned(Request $request, $id) {
        $transaction = Transaction::find($id);

        switch ($request->owner_status) {
            case 'OWNER':
                $transaction->owner_accepted = 'RETURNED';
                $transaction->save();
                break;

            case 'BORROWER':
                $transaction->borrower_accepted = 'RETURNED';
                $transaction->save();
                break;

            default:
                break;
        }

        if (strcmp($transaction->owner_accepted, 'RETURNED') == 0 && 
            strcmp($transaction->borrower_accepted, 'RETURNED') == 0) {
                
            $transaction->status = 'RETURNED';
            $transaction->save();

            $response = 'Items was returned';
            return response()->json($response, 200);
        }else {
            $response = 'Both owner and borrower must be send confirmation.';
            return response()->json($response, 200);
        }
    }

    /** Destroy data */
    public function destroy($id) {
        Transaction::destroy($id);
    }
}