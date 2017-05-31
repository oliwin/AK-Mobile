<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ClientWork extends Model
{
    protected $table = "client_work_type";
    protected $fillable = ["id_user", "type"];
}
