<?php

namespace App\Helpers;

use Carbon\Carbon;

use Auth;

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Config;


class Helper
{

  public static function diffDateDays($date_f){

    $created = new Carbon($date_f);
    $now = Carbon::now();

    $difference = ($created->diff($now)->days < 1)
    ? 'сегодня'
    : $created->diffForHumans($now). ' дней назад';

    return $difference;
  }
}
