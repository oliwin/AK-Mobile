<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjectPrototypeFields extends Model
{

  protected $table = "object_prototype_fields";

  protected $hidden = ["updated_at", "created_at"];

  public function name(){
     return $this->hasOne("App\PrototypeFields", "id", "field_id");
  }
}
