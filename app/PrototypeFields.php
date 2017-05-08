<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrototypeFields extends Model
{
    public $table = "fields";

    protected $hidden = ["updated_at", "created_at", "only_numbers", "visibility", "available"];

    /* Use this if value field was saves as NULL
    public function getValueAttribute()
{
   return $this->value ? $this->value : $this->default;
}*/


public function prototype(){
   return $this->belongsToMany("App\Prototype", "id", "prototype_id");
}

    public function prototypes(){
      return $this->hasMany("App\FieldsInPrototype", "field_id", "id");
    }

    public function scopeVisibility($query, $params)
       {
           if(isset($params["visibility"])){
             return $query->where('visibility', $params["visibility"]);
           }
       }
}
