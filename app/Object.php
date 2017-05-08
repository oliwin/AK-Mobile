<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
#use App\Scopes\AvailableScope;

class Object extends Model
{

  protected $hidden = ["updated_at", "created_at", "visibility", "available"];

  protected $fillable =  ['name', 'available', 'visibility', 'category_id'];

  public function prototypes()
 {
     return $this->belongsToMany('App\Prototype', 'object_prototype', 'object_id');
 }

 public function category(){
   return $this->hasOne('App\FieldCategoriesValues');
 }

 public function scopeActive($query)
    {
        return $query->where('available', 1);
    }

  ## API ##

  public function _prototypes()
 {
     return $this->belongsTo('App\Prototype', 'id', 'object_id'); // object_prototype - table
 }

}
