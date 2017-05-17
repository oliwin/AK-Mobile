<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Object extends Model
{

    protected $hidden = ["updated_at", "created_at", "visibility", "available"];

    protected $fillable = ['name', 'available', 'visibility', 'category_id', 'prototype_id'];

    public function prototypes()
    {
        return $this->hasone('App\PrototypeName', 'id', 'prototype_id');
    }

    public function scopeActive($query)
    {
        return $query->where('available', 1);
    }

    ## API ##

    public function prototypez()
    {

        return $this->belongsTo('App\Prototype', 'id', 'object_id'); // object_prototype - table
    }

    public function fields()
    {
        return $this->hasMany("App\FieldsInPrototype", "id", "objet_id");
    }

    public function parameters()
    {
        return $this->hasMany("App\ObjectPrototypeFields", "object_id", "id");
    }

}
