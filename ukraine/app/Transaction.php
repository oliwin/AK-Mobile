<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{

    protected $fillable = ['client_id', 'region_center_id', 'region_id', "doctor_id"];

    protected $dates = ["created_at"];

    public function clients(){

        return $this->hasMany('App\ResultTestFiles', 'transaction_id', 'transaction_id');
    }

    public function clientDetails(){

      return $this->belongsTo('App\Client', 'client_id', 'unique_code');
    }

    public function results(){

        return $this->hasMany('App\ResultTest', 'transaction_id', 'transaction_id');
    }



}
