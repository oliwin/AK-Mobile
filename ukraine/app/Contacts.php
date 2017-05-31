<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Contacts extends Model
{
    protected $table = "users_contacts";
    protected $fillable = ["name", "user_id"];
    public $timestamps = false;
}
