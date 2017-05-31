<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ResultTestFiles extends Model
{
    protected $table = "result_test_files";
    protected $dates = ["created_at"];
    protected $fillable = [
        "transaction_id",
        "file",
        "status",
        "client_id"
    ];

    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id', 'unique_code');
    }

    public function results()
    {
        return $this->belongsTo('App\ResultTest', 'transaction_id', 'transaction_id');
    }
}
