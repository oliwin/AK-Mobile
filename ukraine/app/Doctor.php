<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Doctor extends Model
{

    protected $fillable = ["user_id", "region_id", "name", "phone", "email", "note", "password"];

    public function details()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function region(){
      return $this->hasOne('App\Region', 'id', 'region_id');
    }
}
