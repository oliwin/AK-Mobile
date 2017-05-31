<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ResultTest extends Model
{
    protected $table = "result_test";
    protected $fillable = [
        "client_id",
        "transaction_id",
        "category",
        "Z",
        "O",
        "type_work"
    ];

    public function client(){

        return $this->belongsTo('App\Client', 'client_id', 'unique_code');
    }

    public function transaction(){

		return $this->hasOne('App\Transaction', 'transaction_id', 'transaction_id');
	}
}
