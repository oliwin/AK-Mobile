<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Work extends Model
{
    protected $table = "work_types";
    protected $fillable = ["name", "description"];
}
