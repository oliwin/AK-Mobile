<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\AvailableScope;

class PrototypeFields extends Model
{
    public $table = "fields";

    protected $hidden = ["updated_at", "created_at"];

    protected static function boot()
     {
         parent::boot();

         static::addGlobalScope(new AvailableScope);
     }


    public function prototypes(){
      return $this->hasMany("App\FieldsInPrototype", "id", "field_id");
    }

    public function scopeVisibility($query, $params)
       {
           if(isset($params["visibility"])){
             return $query->where('visibility', $params["visibility"]);
           }
       }
}
