<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\AvailableScope;

class Prototype extends Model
{

  protected $hidden = ["updated_at", "created_at"];

  protected static function boot()
   {
       parent::boot();

       static::addGlobalScope(new AvailableScope);
   }

 public function fields(){
    return $this->hasMany("App\PrototypeFields");
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

}
