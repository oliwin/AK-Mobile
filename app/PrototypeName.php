<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrototypeName extends Model
{
    protected $table = "prototypes";

    public function objects()
    {
        return $this->hasMany("App\Object", "prototype_id", "id");
    }

}
