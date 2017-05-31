<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Tdeviation extends Model
{
    protected $table = "t_deviation";
    protected $fillable = ["T", "avg", "type"];
}
