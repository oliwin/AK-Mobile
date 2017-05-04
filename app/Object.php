<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\AvailableScope;

class Object extends Model
{

  protected $hidden = ["updated_at", "created_at"];

  protected static function boot()
   {
       parent::boot();

       static::addGlobalScope(new AvailableScope);
   }


  public function prototypes()
 {
     return $this->belongsToMany('App\Prototype', 'object_prototype', 'object_id');
 }

 public function scopeActive($query)
    {
        return $query->where('available', 1);
    }

}
