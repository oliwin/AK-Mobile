<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldsInPrototype extends Model
{
  public $timestamps = false;

  protected $fillable =  ['prototype_id', 'field_id'];

  protected $hidden = ["updated_at", "created_at", "id", "field_id", "prototype_id"];

  protected $table = "fields_prototype";

  public function prototypes(){
     return $this->belongsToMany("App\Prototype");
  }

  public function properties(){
     return $this->belongsTo("App\PrototypeFields", "field_id", "id");
  }
}
