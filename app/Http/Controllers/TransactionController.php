<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Mail\TestResultPaymentMail;
use App\Models\School;
use App\Models\SchoolAdmin;
use App\Models\Settings;
use App\Models\TestResult;
use App\Models\Transaction;
use App\Models\transactionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    public function schoolCapacityPayment($schoolId, $capacity){
        //TODO get amount from settings
        $user = Auth::user();
        $data = [
          'amount'=>Settings::getValue('INDIVIDUAL_STUDENT_FLAT_RATE'),
          'type'=>'school_capacity',
          'description'=>'Increase school capacity',
            'quantity'=>$capacity,
            'payment_type'=>'school_capacity',
            'payment_for'=>$schoolId,
            'reference_num'=>$this->generateRefNumber(),
            'user_id'=>Auth::id(),
            'first_name'=> Auth::user()->first_name,
            'last_name'=> Auth::user()->last_name,
        ];
        try {
            //save to db
            Transaction::createNew($data['user_id'], $data['payment_type'], $data['payment_for'], $data['reference_num'], null, $data['amount'], false, $data['quantity']);

        }catch (\Exception $exception){
            Log::error($exception->getMessage());
        }

        return view('pages.transaction.payment', compact('user','data'));
    }

    public function makePayment($sessionId){
        $user = Auth::user();
        $data = [
          'amount'=>Settings::getValue('PRIVATE_LEARNER_FLAT_RATE'),
          'type'=>'result',
          'description'=>'Tilt Test Result',
            'quantity'=>1,
            'payment_type'=>'test_result',
            'payment_for'=>$sessionId,
            'reference_num'=>$this->generateRefNumber(),
            'user_id'=>Auth::id(),
            'first_name'=> Auth::user()->first_name,
            'last_name'=> Auth::user()->last_name,
        ];
        try {
            //save to db
            Transaction::createNew($data['user_id'], $data['payment_type'], $data['payment_for'], $data['reference_num'], null, $data['amount'], false, $data['quantity']);

        }catch (\Exception $exception){
            Log::error($exception->getMessage());
        }

        return view('pages.transaction.payment', compact('user','data'));
    }

    public function getAll(Request $request){
        $transactions = Transaction::orderBy('created_at','desc');
        $sum = $transactions->sum('amount');
        $row = $request->query('row') ?? 10;
        if ($request->query('filter_by')) {
            $filterBy = trim($request->query('filter_by'));
            $transactions->where('payment_type', $filterBy);
        }
        if ($request->query('payment_for')) {
            $paymentFor = trim($request->query('payment_for'));
            $transactions->where('payment_for', $paymentFor);
        }
        return TransactionResource::collection($transactions->paginate(10))->additional(['total_amount' => [
            'amount' => $sum,
        ]]);
    }

    public function confirmPayment(){
        $transactionId = \request()->input('trans');
        $reference = \request()->input('ref');
        $data = array();
        $user = Auth::user();


        $transaction  = Transaction::where('reference', $reference)->first();
        if (is_null($transaction)){
            $data=[
              'redirect'=>null,
                'success'=>false,
            ];
            return view('pages.transaction.confirm-payment', compact('user','data'));
        }

        if ($transaction){

            if ($transaction->payment_type == 'test_result'){
                TestResult::where('session_id', $transaction->payment_for)->update(['payment_status'=>true]);
                $data=[
                    'link'=>route('pages.result', [$transaction->payment_for,'check-report']),
                    'success'=>true,
                    'ref'=>$reference,
                    'text'=>'View result'
                ];

            }elseif ($transaction->payment_type == 'school_capacity'){
                $data=[
                    'link'=>route('result.getResult', $transaction->payment_for),
                    'success'=>true,
                    'ref'=>$reference,
                    'text'=>'go back to dashboard'
                ];
            }else{
                abort(400);
            }

            $transaction->update(['status'=>true]);
            return view('pages.transaction.confirm-payment', compact('user','data'));
        }
    }

    public function callBackHook(Request $request){
        //logs all transactions received from paystack

        transactionLog::create(['log'=>$request->all()]);
        $data = $request->data;
        $status = $data['status'];
        $quantity=0;
        $paymentFor ="";

        if ($status == 'success'){
            $customFields = $data['metadata']['custom_fields'];
            //return $customFields;
            //convert to Naira
            $amount = $data['requested_amount']/100;
            $reference = $data['reference'];
            $transactionId = $data['id'];
            foreach ($customFields as $customField){
                if ($customField['variable_name']=="payment_type")
                    $paymentType = $customField['value'];
                if ($customField['variable_name']=="payment_for")
                    $paymentFor = $customField['value'];
                if ($customField['variable_name']=="user_id")
                    $userId = $customField['value'];
                if ($customField['variable_name']=="quantity")
                    $quantity = $customField['value'];
            }

            try {
                //for school capacity
                if ($paymentType == 'school_capacity'){
                    School::where('id', $paymentFor)->increment('school_capacity', $quantity);
                }elseif ($paymentType == 'test_result'){
                    //get test field, then update to payment
                    TestResult::where('session_id', $paymentFor)->update(['payment_status'=>true]);
                    //send download link to email
                    try {
                        $email = $data['customer']['email'];
                        Mail::to($email)->send(new TestResultPaymentMail("", env('FRONTEND_URL').'results/'.$paymentFor));
                    }catch (\Exception $exception){
                        Log::error('TransactionController', ['callBackHook'=>$exception->getMessage()]);
                    }
                }else{
                    //do nothing
                }
                Transaction::createNew($userId, $paymentType, $paymentFor, $reference, $transactionId, $amount, true, $quantity);

            }catch (\Exception $exception){
                Log::error('Transaction', ['error'=>$exception->getMessage()]);
                return response()->json(['message'=>$exception->getMessage()], 400);
            }

        }

        return response()->json(['message'=>'successful'], 200);
    }
    public function school($schoolId){
        return $this->transactionHistory($schoolId, 'school');
    }
    public function user($userId){
        return $this->transactionHistory($userId, 'user');
    }

    protected function transactionHistory($payerId, $type=null){
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
        return response()->json(['total_amount'=>$transactions->sum('amount'), 'data'=> $data], 200);
    }

    protected function generateRefNumber() {
        $number = mt_rand(1000000000, 9999999999); // better than rand()

        // call the same function if the barcode exists already
        if ($this->refNumberExists($number)) {
            return $this->generateRefNumber();
        }

        // otherwise, it's valid and can be used
        return $number;
    }

    protected function refNumberExists($number) {

        return Transaction::where('reference', $number)->exists();
    }

}
