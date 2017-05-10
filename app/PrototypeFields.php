<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrototypeFields extends Model
{
    public $table = "fields";

    protected $hidden = ["updated_at", "created_at", "only_numbers", "visibility", "available"];

    public function prototype(){
       return $this->hasMany("App\FieldsInPrototype", "field_id", "id");
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
