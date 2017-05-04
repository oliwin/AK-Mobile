<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldsInPrototype extends Model
{
  public $timestamps = false;

  protected $hidden = ["updated_at", "created_at"];

  protected $table = "fields_prototype";
}
