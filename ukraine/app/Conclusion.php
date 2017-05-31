<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Conclusion extends Model
{
    protected $table = "conclusion";
    protected $fillable = ["type_work", "category", "conclusion"];
    public $timestamps = false;
}
