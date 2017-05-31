<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Http\Scopes\RegionalScope;


class Client extends Model
{
    protected $table = "clients";
    protected $dates = ["created_at"];
    protected $fillable = [
        "name",
        "secondname",
        "family",
        "datebirth",
        "sex",
        "profession",
        "patronymic",
        "code",
        "address_office",
        "type_work",
        "factory_name",
        "factory_edrpou",
        "factory_departament",
        "status_pass",
        "payment_type",
        "unique_code"
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RegionalScope());
    }

    public function results()
    {
        return $this->hasOne('App\ResultTest', 'client_id', 'unique_code');
    }

    public function types()
    {
        return $this->hasMany('App\ClientWork', 'id_user', 'id');
    }

    public function transaction(){
      return $this->hasOne('App\Transaction', 'client_id', 'unique_code');
    }

    public function typeWork()
    {

        return $this->hasOne('App\Work', 'id', 'type_work');
    }

}
