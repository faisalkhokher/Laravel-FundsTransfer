<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Bavix\Wallet\Interfaces\Wallet;
use Spatie\Permission\Traits\HasRoles;
use Bavix\Wallet\Traits\HasWalletFloat;

use Bavix\Wallet\Interfaces\WalletFloat;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Wallet , WalletFloat , MustVerifyEmail
{
    use Notifiable;
    use HasRoles;
    use HasApiTokens;
    use HasWalletFloat;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','uuid', 'address', 'gender', 'longitude', 'latitude', 'phone', 'device_token', 'provider_id', 'avatar', 'provider', 'access_token','phone','license_image','social_code','swiss_code','company_name', 'stripe_customer_id', 'stripe_account_id', 'bank_account_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class , 'issuer_id' , 'id');
    }

    public function xfriend()
    {
        return $this->belongsToMany(User::class, 'user_xuser', 'user_id' , 'xfriend_id');
    }
}
