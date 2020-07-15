<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Loan;
use App\Transaction;

class LoanController extends Controller
{
    public function destroy($id) {
        $loanData = Loan::where('id', $id)->first();

        try {
            $loanData = Loan::where('id', $id)->first();
            $transactionId = Loan::where('id', $id)
                ->first()
                ->transaction_id;
            
            if ($loanData) {
                Loan::destroy($id);
            }
    
            $loanItemAmount = Loan::where('transaction_id', $transactionId)
                ->count();
    
            if ($loanItemAmount < 1) {
                Transaction::destroy($transactionId);
            }

            $response['message'] = 'Delete complete.';
            return response()->json($response, 200);

        } catch (Throwable $th) {
            $response['message'] = 'Book not found.';
            return response()->json($response, 500);
        }
    }
}
