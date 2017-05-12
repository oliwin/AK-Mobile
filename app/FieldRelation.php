<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldRelation extends Model
{
    protected $table = "field_relation";

    public function name(){
       return $this->hasOne("App\PrototypeFields", "id", "field_id");
    }
}
