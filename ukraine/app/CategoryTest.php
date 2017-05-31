<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CategoryTest extends Model
{
    protected $table = "category_test";
    protected $fillable = ["test_id", "category_id"];


    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'category');
    }
}
