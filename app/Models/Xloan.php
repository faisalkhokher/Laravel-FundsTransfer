<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWalletFloat;
use Bavix\Wallet\Interfaces\WalletFloat;

class Xloan extends Model implements Wallet , WalletFloat
{
    use HasWalletFloat;
    protected $guarded = [];

    /**
     * Get the user that owns the Xloan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function x_user()
    {
        return $this->belongsTo(User::class ,'user_id');
    }
    public function lyn_user()
    {
        return $this->belongsTo(User::class ,'lyn_id');
    }
    
}
