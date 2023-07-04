<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRecord extends Model
{
    use HasFactory;
    protected $fillable = [
         'transacton_id', 'flw_ref' , 'last_four_digit' , 'tx_ref' , 'amount' , 'app_fee' , 'customer_id', 'status', 'currency', 'card_type', 'payment_responce'
    ];
}
