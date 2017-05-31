<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Taverage extends Model
{
    protected $table = "t_avg";
    protected $fillable = ["T", "avg", "type"];
}
