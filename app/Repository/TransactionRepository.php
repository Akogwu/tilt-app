<?php


namespace App\Repository;


use App\Models\Transaction;

class TransactionRepository
{
    public function transactionHistory($payerId, $type){
        $data = [];
        if ($type =='school'){
            $transactions = Transaction::where([['payment_for', $payerId],['payment_type','school_capacity']])->get();
            $data = $transactions->map(function ($transaction){
                return  $transaction->detail();
            });
        }
        if ($type == 'user'){
            $transactions = Transaction::where('payment_by', $payerId)->get();
            $data = $transactions->map(function ($transaction){
                return  $transaction->detail();
            });
        }
        return (['total_amount'=>$transactions->sum('amount'), 'data'=> $data]);
    }
}
