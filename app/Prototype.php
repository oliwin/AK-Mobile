<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\AvailableScope;

class Prototype extends Model
{

  protected $table = "object_prototype";

protected $hidden = ["updated_at", "created_at", "pivot", "value", "default", "id", "object_id"];

 public function fields(){
    return $this->hasMany("App\FieldsInPrototype");
 }
 public function name(){
   return $this->hasOne("App\PrototypeName", "id", "prototype_id");
 }


 public function objects(){
   return $this->hasMany("App\Object", "id", "object_id");
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

    public function properties(){
       return $this->hasMany("App\ObjectPrototypeFields", "prototype_id", "prototype_id");
    }
}
