<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWalletFloat;
use Bavix\Wallet\Interfaces\WalletFloat;

class Loan extends Model implements Wallet , WalletFloat
{
    use HasWalletFloat;
    
    protected $guarded = [];
}
