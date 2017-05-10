<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjectPrototypeFields extends Model
{

  public $timestamps = false;

  protected $table = "object_prototype_fields";

  protected $hidden = ["updated_at", "created_at"];

  public function name(){
     return $this->hasOne("App\PrototypeFields", "id", "field_id");
  }

  public function object_name(){
     return $this->belongsTo("App\Object", "object_id", "id");
  }
}
