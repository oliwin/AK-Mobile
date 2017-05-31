<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class EventsModel extends Model
{
    protected $table = "events";
    protected $fillable = ["value"];
}
