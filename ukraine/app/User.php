<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'payer', 'instructor', 'city', 'fio_manager', 'tax_type', 'job_position_manager', 'phone_manager', 'post_index', 'phone', 'address', 'short_name', 'doctor', 'email_work', 'bank', 'IPN', 'bill', 'region', 'type_account'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'IPN', 'bill'
    ];

    public function settings()
    {
        return $this->hasOne('App\Settings');
    }
}
