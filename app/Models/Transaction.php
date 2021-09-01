<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Transaction extends Model
{
    protected $casts = [
        'id' => 'string',
    ];
    protected $primaryKey = "id";
    protected $guarded = ['id','created_at'];
    public $incrementing = false;

    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public static function createNew(
        $paymentBy, $paymentType,
        $paymentFor, $reference,
        $transactionId, $amount,
        $status, $quantity){
        $new = self::updateOrCreate([
            "payment_by"=>$paymentBy,
            "payment_type"=>$paymentType,
            "payment_for"=>$paymentFor,
            "reference"=>$reference,
        ],[
            "transaction_id"=>$transactionId,
        "amount"=>$amount,
        "status"=>$status,
            'quantity'=> $quantity
        ]);

    }

    public function detail(){
        return[
            'transaction_id'=> $this->transaction_id,
            'payment_by'=> $this->getUser($this->payment_by),
            'payment_type'=> $this->payment_type,
            'amount'=> $this->amount,
            'payment_for'=> $this->getPaymentFor($this->payment_type, $this->payment_for),
            'quantity'=> $this->quantity,
            'created'=>$this->created_at
        ];
    }

    public function getUser($userId){
        $user = User::find($userId);
        if ($user == null)
            return $userId;
        return $user->detail();
    }
    public function getPaymentFor($paymentType, $paymentFor){
        if ($paymentType =='school_capacity'){
            $school = School::where('id', $paymentFor)->first();
            return ($school == null) ? [] : $school->schema();
        }elseif($paymentType =='test_result'){
            $testResult = TestResult::where('session_id', $paymentFor)->first();
            return ($testResult == null) ? [] : $testResult->getResult($paymentFor);
        }
    }

}
