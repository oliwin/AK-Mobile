<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    protected $table = "conclusion";
    protected $fillable = ["conclusion", "category_id", "type_work"];
}
