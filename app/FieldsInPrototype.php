<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldsInPrototype extends Model
{
  public $timestamps = false;

  protected $table = "fields_prototype";

  protected $fillable =  ['prototype_id', 'field_id'];

  protected $hidden = ["updated_at", "created_at", "id", "field_id", "prototype_id"];

  public function prototypes(){
     return $this->belongsToMany("App\Prototype");
  }

  public function properties(){
     return $this->belongsTo("App\PrototypeFields", "field_id", "id");
  }

  public function name(){
    return $this->belongsTo("App\PrototypeName", "prototype_id", "id");
  }

  public function fieldname(){
    return $this->belongsTo("App\PrototypeFields", "object_id", "id");
  }

  public function field_details(){
    return $this->belongsTo("App\PrototypeFields", "field_id", "id");
  }
}
