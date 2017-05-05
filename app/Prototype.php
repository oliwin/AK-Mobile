<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\AvailableScope;

class Prototype extends Model
{

protected $hidden = ["updated_at", "created_at", "pivot", "value", "default"];

 public function fields(){
    return $this->hasMany("App\FieldsInPrototype");
 }


 public function objects(){
   return $this->belongsToMany("App\Object", "object_prototype", "prototype_id", "object_id");
 }

 public function scopeVisibility($query, $params)
    {
        if(isset($params["visibility"])){
          return $query->where('visibility', $params["visibility"]);
        }
    }

    ## API ##

    public function parameters(){
       return $this->hasMany("App\FieldsInPrototype");
    }

    public function fields_api(){
       return $this->hasMany("App\PrototypeFields")->where("available", 1);
    }
}
